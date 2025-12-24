<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Status;
use App\Models\Toy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user (use updateOrCreate to avoid duplicates)
        $admin = User::updateOrCreate(
            ['email' => 'admin@toyshop.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Create categories
        $categories = [
            ['name' => 'Action Figures', 'slug' => 'action-figures', 'color' => 'primary', 'sort_order' => 1],
            ['name' => 'Dolls & Plush', 'slug' => 'dolls', 'color' => 'pink', 'sort_order' => 2],
            ['name' => 'Vehicles & RC', 'slug' => 'vehicles', 'color' => 'danger', 'sort_order' => 3],
            ['name' => 'Building & Blocks', 'slug' => 'building', 'color' => 'warning', 'sort_order' => 4],
            ['name' => 'Educational', 'slug' => 'educational', 'color' => 'success', 'sort_order' => 5],
            ['name' => 'Outdoor & Sports', 'slug' => 'outdoor', 'color' => 'info', 'sort_order' => 6],
            ['name' => 'Games & Puzzles', 'slug' => 'games', 'color' => 'secondary', 'sort_order' => 7],
            ['name' => 'Arts & Crafts', 'slug' => 'arts', 'color' => 'purple', 'sort_order' => 8],
            ['name' => 'Electronic Toys', 'slug' => 'electronics', 'color' => 'dark', 'sort_order' => 9],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create statuses
        $statuses = [
            ['name' => 'In Stock', 'slug' => 'in-stock', 'color' => 'success', 'sort_order' => 1],
            ['name' => 'Low on Stock', 'slug' => 'low-stock', 'color' => 'warning', 'sort_order' => 2],
            ['name' => 'Out of Stock', 'slug' => 'out-of-stock', 'color' => 'danger', 'sort_order' => 3],
            ['name' => 'In China', 'slug' => 'in-china', 'color' => 'info', 'sort_order' => 4],
            ['name' => 'In Myanmar', 'slug' => 'in-myanmar', 'color' => 'info', 'sort_order' => 5],
            ['name' => 'Discontinued', 'slug' => 'discontinued', 'color' => 'secondary', 'sort_order' => 6],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }

        // Create locations
        $locations = [
            ['name' => 'Main Warehouse', 'slug' => 'warehouse', 'color' => 'primary', 'country' => 'Local', 'sort_order' => 1],
            ['name' => 'Store Front', 'slug' => 'store', 'color' => 'success', 'country' => 'Local', 'sort_order' => 2],
            ['name' => 'China Supplier', 'slug' => 'china', 'color' => 'danger', 'country' => 'China', 'sort_order' => 3],
            ['name' => 'Myanmar Supplier', 'slug' => 'myanmar', 'color' => 'warning', 'country' => 'Myanmar', 'sort_order' => 4],
        ];

        foreach ($locations as $loc) {
            Location::create($loc);
        }

        // Create sample toys
        $categoryIds = Category::pluck('id')->toArray();
        $statusIds = Status::pluck('id')->toArray();
        $locationIds = Location::pluck('id')->toArray();

        Toy::factory(30)->create([
            'category_id' => fn() => fake()->randomElement($categoryIds),
            'status_id' => fn() => fake()->randomElement($statusIds),
            'location_id' => fn() => fake()->randomElement($locationIds),
            'created_by' => $admin->id,
        ]);
    }
}
