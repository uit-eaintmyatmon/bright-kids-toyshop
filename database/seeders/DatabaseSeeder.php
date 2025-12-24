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

        // Create categories (use firstOrCreate to avoid duplicates)
        $categories = [
            ['name' => 'Educational Toys', 'slug' => 'educational', 'color' => 'success', 'sort_order' => 1, 'is_featured' => true, 'icon' => 'bi-puzzle'],
            ['name' => 'Children Books', 'slug' => 'books', 'color' => 'primary', 'sort_order' => 2, 'is_featured' => true, 'icon' => 'bi-book'],
            ['name' => 'Learning Materials', 'slug' => 'learning', 'color' => 'info', 'sort_order' => 3, 'is_featured' => true, 'icon' => 'bi-lightbulb'],
            ['name' => 'Gifts', 'slug' => 'gifts', 'color' => 'danger', 'sort_order' => 4, 'is_featured' => true, 'icon' => 'bi-gift'],
            ['name' => 'Games & Puzzles', 'slug' => 'games', 'color' => 'warning', 'sort_order' => 5],
            ['name' => 'Arts & Crafts', 'slug' => 'arts', 'color' => 'purple', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Create statuses
        $statuses = [
            ['name' => 'In Stock', 'slug' => 'in-stock', 'color' => 'success', 'sort_order' => 1],
            ['name' => 'Low on Stock', 'slug' => 'low-stock', 'color' => 'warning', 'sort_order' => 2],
            ['name' => 'Out of Stock', 'slug' => 'out-of-stock', 'color' => 'danger', 'sort_order' => 3],
            ['name' => 'Pre-Order', 'slug' => 'pre-order', 'color' => 'info', 'sort_order' => 4],
        ];

        foreach ($statuses as $status) {
            Status::firstOrCreate(['slug' => $status['slug']], $status);
        }

        // Create locations
        $locations = [
            ['name' => 'Mandalay Shop', 'slug' => 'mandalay', 'color' => 'success', 'country' => 'Myanmar', 'sort_order' => 1],
            ['name' => 'Warehouse', 'slug' => 'warehouse', 'color' => 'primary', 'country' => 'Myanmar', 'sort_order' => 2],
        ];

        foreach ($locations as $loc) {
            Location::firstOrCreate(['slug' => $loc['slug']], $loc);
        }

        // Create sample toys (only if no toys exist)
        if (Toy::count() === 0) {
            $educational = Category::where('slug', 'educational')->first();
            $books = Category::where('slug', 'books')->first();
            $learning = Category::where('slug', 'learning')->first();
            $gifts = Category::where('slug', 'gifts')->first();
            $inStock = Status::where('slug', 'in-stock')->first();
            $mandalay = Location::where('slug', 'mandalay')->first();

            $sampleToys = [
                ['name' => 'Wooden ABC Blocks', 'description' => 'Colorful wooden alphabet blocks for learning letters', 'price' => 15000, 'category_id' => $educational->id ?? 1],
                ['name' => 'Number Puzzle Set', 'description' => 'Fun number puzzle for counting practice', 'price' => 12000, 'category_id' => $learning->id ?? 1],
                ['name' => 'Animal Picture Book', 'description' => 'Beautiful illustrations of animals from around the world', 'price' => 8000, 'category_id' => $books->id ?? 1],
                ['name' => 'Coloring Book Set', 'description' => 'Set of 5 coloring books with crayons', 'price' => 10000, 'category_id' => $books->id ?? 1],
                ['name' => 'Building Blocks 100pc', 'description' => '100 piece colorful building blocks', 'price' => 25000, 'category_id' => $educational->id ?? 1],
                ['name' => 'Shape Sorter Toy', 'description' => 'Classic shape sorting toy for toddlers', 'price' => 18000, 'category_id' => $learning->id ?? 1],
                ['name' => 'Musical Xylophone', 'description' => 'Colorful xylophone for music learning', 'price' => 20000, 'category_id' => $educational->id ?? 1],
                ['name' => 'Storybook Collection', 'description' => 'Collection of 10 classic children stories', 'price' => 35000, 'category_id' => $books->id ?? 1],
                ['name' => 'Math Flash Cards', 'description' => 'Flash cards for learning basic math', 'price' => 7000, 'category_id' => $learning->id ?? 1],
                ['name' => 'Gift Box - Educational', 'description' => 'Perfect gift set with educational toys', 'price' => 50000, 'category_id' => $gifts->id ?? 1],
                ['name' => 'Dinosaur Figures Set', 'description' => 'Set of 12 realistic dinosaur figures', 'price' => 22000, 'category_id' => $educational->id ?? 1],
                ['name' => 'Memory Card Game', 'description' => 'Fun memory matching game for kids', 'price' => 9000, 'category_id' => $learning->id ?? 1],
            ];

            foreach ($sampleToys as $toy) {
                Toy::create([
                    'name' => $toy['name'],
                    'description' => $toy['description'],
                    'price' => $toy['price'],
                    'category_id' => $toy['category_id'],
                    'status_id' => $inStock->id ?? 1,
                    'location_id' => $mandalay->id ?? 1,
                    'created_by' => $admin->id,
                    'is_active' => true,
                ]);
            }
        }
    }
}
}
