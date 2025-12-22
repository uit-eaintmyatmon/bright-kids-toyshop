<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Status;
use App\Models\Toy;
use App\Models\ToyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    // Allowed image mime types for security
    private const ALLOWED_IMAGE_TYPES = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png', 
        'image/gif' => 'gif',
        'image/webp' => 'webp'
    ];
    private const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB

    public function index()
    {
        return view('admin.import');
    }

    public function store(Request $request)
    {
        $request->validate(['json' => 'required|string']);
        $items = json_decode($request->json, true);

        if (!is_array($items)) {
            return back()->withErrors(['json' => 'Invalid JSON'])->withInput();
        }

        // Cache lookup tables
        $categories = Category::pluck('id', 'slug')->toArray();
        $statuses = Status::pluck('id', 'slug')->toArray();
        $locations = Location::pluck('id', 'slug')->toArray();
        
        // Get default status (In Stock)
        $defaultStatusId = Status::where('slug', 'in-stock')->first()?->id;
        $defaultLocationId = Location::where('slug', 'warehouse')->first()?->id;

        $imported = 0;
        $imageErrors = [];

        foreach ($items as $index => $item) {
            // Try to match category, status, location by slug or name
            $categoryId = $this->findId($item, 'category', $categories);
            $statusId = $this->findId($item, 'status', $statuses) ?? $defaultStatusId;
            $locationId = $this->findId($item, 'location', $locations) ?? $defaultLocationId;

            // Handle legacy single image - can be URL or base64
            $imageUrl = null;
            $imageData = Arr::get($item, 'image') ?? Arr::get($item, 'image_base64');
            $imageUrlFromJson = Arr::get($item, 'image_url');

            if ($imageData) {
                try {
                    $imageUrl = $this->processBase64Image($imageData);
                } catch (\Exception $e) {
                    $imageErrors[] = "Item #{$index}: " . $e->getMessage();
                }
            } elseif ($imageUrlFromJson) {
                $imageUrl = $imageUrlFromJson;
            }

            $toy = Toy::updateOrCreate(
                ['sku' => Arr::get($item, 'sku', strtoupper(Str::random(8)))],
                [
                    'name' => Arr::get($item, 'name', 'Untitled'),
                    'description' => Arr::get($item, 'description'),
                    'price' => (float) Arr::get($item, 'price', 0),
                    'quantity' => (int) Arr::get($item, 'quantity', 0),
                    'category_id' => $categoryId,
                    'status_id' => $statusId,
                    'location_id' => $locationId,
                    'image_url' => $imageUrl,
                    'created_by' => Auth::id(),
                ]
            );

            // Handle multiple images array
            $images = Arr::get($item, 'images', []);
            if (is_array($images) && count($images) > 0) {
                $sortOrder = $toy->images()->max('sort_order') ?? -1;
                $hasPrimary = $toy->images()->where('is_primary', true)->exists();

                foreach ($images as $imgIndex => $imgData) {
                    try {
                        // Support both URL and base64 in images array
                        if (is_string($imgData) && (str_starts_with($imgData, 'http://') || str_starts_with($imgData, 'https://'))) {
                            $imgUrl = $imgData;
                        } elseif (is_array($imgData) && isset($imgData['url'])) {
                            $imgUrl = $imgData['url'];
                        } elseif (is_string($imgData)) {
                            $imgUrl = $this->processBase64Image($imgData);
                        } elseif (is_array($imgData) && isset($imgData['base64'])) {
                            $imgUrl = $this->processBase64Image($imgData['base64']);
                        } else {
                            continue;
                        }

                        $toy->images()->create([
                            'image_url' => $imgUrl,
                            'sort_order' => ++$sortOrder,
                            'is_primary' => !$hasPrimary && $imgIndex === 0,
                        ]);
                        
                        if (!$hasPrimary && $imgIndex === 0) {
                            $hasPrimary = true;
                        }
                    } catch (\Exception $e) {
                        $imageErrors[] = "Item #{$index} image #{$imgIndex}: " . $e->getMessage();
                    }
                }
            }

            $imported++;
        }

        $message = "{$imported} toys imported!";
        if (!empty($imageErrors)) {
            $message .= " (Some images failed: " . implode(', ', array_slice($imageErrors, 0, 3)) . ")";
        }

        return redirect()->route('admin.toys.index')->with('success', $message);
    }

    /**
     * Process a base64 encoded image securely
     */
    private function processBase64Image(string $data): ?string
    {
        // Check if it's a data URL or raw base64
        if (preg_match('/^data:image\/(\w+);base64,/', $data, $matches)) {
            $extension = strtolower($matches[1]);
            $data = substr($data, strpos($data, ',') + 1);
        } else {
            $extension = null;
        }

        // Decode base64
        $decoded = base64_decode($data, true);
        if ($decoded === false) {
            throw new \Exception('Invalid base64 data');
        }

        // Check size
        if (strlen($decoded) > self::MAX_IMAGE_SIZE) {
            throw new \Exception('Image too large (max 5MB)');
        }

        // Detect mime type from actual content
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($decoded);

        if (!array_key_exists($mimeType, self::ALLOWED_IMAGE_TYPES)) {
            throw new \Exception('Invalid image type: ' . $mimeType);
        }

        // Use detected extension or fallback
        $extension = self::ALLOWED_IMAGE_TYPES[$mimeType];

        // Validate it's actually an image by trying to get dimensions
        $imageInfo = @getimagesizefromstring($decoded);
        if ($imageInfo === false) {
            throw new \Exception('Invalid image data');
        }

        // Generate secure filename
        $filename = Str::uuid() . '.' . $extension;
        $path = 'toys/' . $filename;

        // Store the file
        Storage::disk('public')->put($path, $decoded);

        return Storage::url($path);
    }

    private function findId(array $item, string $field, array $lookup): ?int
    {
        $value = Arr::get($item, $field);
        if (!$value) return null;
        
        // Try direct slug match
        $slug = Str::slug($value);
        if (isset($lookup[$slug])) {
            return $lookup[$slug];
        }
        
        // Try lowercase match
        $lowerValue = strtolower($value);
        foreach ($lookup as $key => $id) {
            if (strtolower($key) === $lowerValue) {
                return $id;
            }
        }
        
        return null;
    }
}
