<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Status;
use App\Models\Toy;
use App\Models\ToyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ToyController extends Controller
{
    // Allowed image mime types for security
    private const ALLOWED_IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB

    public function index(Request $request)
    {
        $query = Toy::with(['category', 'status', 'location', 'createdBy', 'images']);

        // Search by name or SKU
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
            );
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        // Filter by location
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        // Filter by user
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by stock
        if ($request->filled('stock')) {
            match($request->stock) {
                'in_stock' => $query->where('quantity', '>', 10),
                'low_stock' => $query->whereBetween('quantity', [1, 10]),
                'out_of_stock' => $query->where('quantity', '<=', 0),
                default => null
            };
        }

        // Sorting
        $sortField = $request->get('sort', 'name');
        $sortDir = $request->get('dir', 'asc');
        $allowedSorts = ['name', 'sku', 'price', 'quantity', 'created_at'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDir === 'desc' ? 'desc' : 'asc');
        }

        $toys = $query->paginate(15)->withQueryString();
        $categories = Category::active()->orderBy('sort_order')->orderBy('name')->get();
        $statuses = Status::active()->orderBy('sort_order')->orderBy('name')->get();
        $locations = Location::active()->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.toys.index', compact('toys', 'categories', 'statuses', 'locations'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('sort_order')->orderBy('name')->get();
        $statuses = Status::active()->orderBy('sort_order')->orderBy('name')->get();
        $locations = Location::active()->orderBy('sort_order')->orderBy('name')->get();
        
        return view('admin.toys.create', compact('categories', 'statuses', 'locations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'sku' => 'required|max:50|unique:toys',
            'category_id' => 'nullable|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'location_id' => 'nullable|exists:locations,id',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'image_url' => 'nullable|url',
        ]);

        // Remove images from data as we handle it separately
        unset($data['images']);

        $data['created_by'] = Auth::id();
        $toy = Toy::create($data);

        // Handle multiple image uploads
        $uploadedCount = 0;
        $debugInfo = [];
        
        $debugInfo['hasFile'] = $request->hasFile('images');
        $debugInfo['allFiles'] = array_keys($request->allFiles());
        
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            $debugInfo['filesCount'] = is_array($files) ? count($files) : 1;
            
            $sortOrder = 0;
            foreach ($request->file('images') as $index => $imageFile) {
                $debugInfo['file_' . $index] = [
                    'valid' => $imageFile->isValid(),
                    'error' => $imageFile->getError(),
                    'size' => $imageFile->getSize(),
                    'mime' => $imageFile->getMimeType(),
                ];
                
                if ($imageFile->isValid()) {
                    try {
                        $imageUrl = $this->uploadImage($imageFile);
                        $debugInfo['file_' . $index]['uploaded_url'] = $imageUrl;
                        
                        $toy->images()->create([
                            'image_url' => $imageUrl,
                            'sort_order' => $sortOrder++,
                            'is_primary' => $index === 0,
                        ]);
                        $uploadedCount++;
                    } catch (\Exception $e) {
                        $debugInfo['file_' . $index]['error_msg'] = $e->getMessage();
                        \Log::error('Image upload failed: ' . $e->getMessage());
                        continue;
                    }
                }
            }
        }
        
        \Log::info('Image upload debug', $debugInfo);
        
        $message = 'Toy created!';
        if ($uploadedCount > 0) {
            $message .= " ({$uploadedCount} images uploaded)";
        }
        
        return redirect()->route('admin.toys.index')->with('success', $message);
    }

    public function edit(Toy $toy)
    {
        $toy->load('images');
        $categories = Category::active()->orderBy('sort_order')->orderBy('name')->get();
        $statuses = Status::active()->orderBy('sort_order')->orderBy('name')->get();
        $locations = Location::active()->orderBy('sort_order')->orderBy('name')->get();
        
        return view('admin.toys.edit', compact('toy', 'categories', 'statuses', 'locations'));
    }

    public function update(Request $request, Toy $toy)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'sku' => 'required|max:50|unique:toys,sku,' . $toy->id,
            'category_id' => 'nullable|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'location_id' => 'nullable|exists:locations,id',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'image_url' => 'nullable|url',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:toy_images,id',
            'primary_image' => 'nullable|integer',
        ]);

        // Handle image deletions
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $toy->images()->find($imageId);
                if ($image) {
                    $this->deleteImage($image->image_url);
                    $image->delete();
                }
            }
        }

        // Handle primary image change
        if ($request->filled('primary_image')) {
            $toy->images()->update(['is_primary' => false]);
            $toy->images()->where('id', $request->primary_image)->update(['is_primary' => true]);
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $maxSortOrder = $toy->images()->max('sort_order') ?? -1;
            $hasPrimary = $toy->images()->where('is_primary', true)->exists();
            
            foreach ($request->file('images') as $index => $imageFile) {
                if ($imageFile->isValid()) {
                    try {
                        $imageUrl = $this->uploadImage($imageFile);
                        $toy->images()->create([
                            'image_url' => $imageUrl,
                            'sort_order' => ++$maxSortOrder,
                            'is_primary' => !$hasPrimary && $index === 0,
                        ]);
                        if (!$hasPrimary && $index === 0) {
                            $hasPrimary = true;
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }
        }

        // Remove extra fields from data
        unset($data['images'], $data['delete_images'], $data['primary_image']);

        $data['updated_by'] = Auth::id();
        $toy->update($data);
        
        return redirect()->route('admin.toys.index')->with('success', 'Toy updated!');
    }

    public function destroy(Toy $toy)
    {
        // Delete all associated images
        foreach ($toy->images as $image) {
            $this->deleteImage($image->image_url);
        }
        // Delete legacy image if exists
        $this->deleteImage($toy->image_url);
        $toy->delete();
        return redirect()->route('admin.toys.index')->with('success', 'Toy deleted!');
    }

    public function updateStatus(Request $request, Toy $toy)
    {
        $toy->update([
            'status_id' => $request->status_id,
            'updated_by' => Auth::id()
        ]);
        return back()->with('success', 'Status updated!');
    }

    /**
     * Securely upload an image file
     */
    private function uploadImage($file): string
    {
        // Validate mime type (double check beyond Laravel validation)
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, self::ALLOWED_IMAGE_TYPES)) {
            throw new \Exception('Invalid image type');
        }

        // Validate file size
        if ($file->getSize() > self::MAX_IMAGE_SIZE) {
            throw new \Exception('Image file too large');
        }

        // Generate secure filename (random name to prevent path traversal)
        $extension = $file->getClientOriginalExtension();
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            $extension = 'jpg'; // Default to jpg if extension is suspicious
        }
        
        $filename = Str::uuid() . '.' . strtolower($extension);
        
        // Store in toys subdirectory
        $path = $file->storeAs('toys', $filename, 'public');
        
        return Storage::url($path);
    }

    /**
     * Delete an image from storage
     */
    private function deleteImage(?string $imageUrl): void
    {
        if (!$imageUrl || !str_contains($imageUrl, '/storage/toys/')) {
            return; // Not a local upload or no image
        }

        $path = str_replace('/storage/', '', $imageUrl);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
