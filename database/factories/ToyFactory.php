<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ToyFactory extends Factory
{
    public function definition(): array
    {
        $toyNames = [
            'Spider-Man Figure', 'Batman Action Figure', 'Iron Man Toy', 'Superman Figure', 'Ninja Warrior',
            'Teddy Bear', 'Bunny Plush', 'Princess Doll', 'Baby Doll', 'Unicorn Plush',
            'Race Car', 'Monster Truck', 'RC Helicopter', 'Train Set', 'Fire Truck',
            'LEGO Set', 'Building Blocks', 'Magnetic Tiles', 'Construction Kit', 'Wooden Blocks',
            'Science Kit', 'Math Game', 'Alphabet Puzzle', 'Globe', 'Microscope Set',
            'Soccer Ball', 'Frisbee', 'Jump Rope', 'Kite', 'Water Gun',
            'Board Game', 'Card Game', 'Jigsaw Puzzle', 'Chess Set', 'Memory Game',
            'Paint Set', 'Coloring Book', 'Clay Kit', 'Craft Set', 'Drawing Tablet',
            'Robot Dog', 'Talking Doll', 'RC Drone', 'Kids Tablet', 'Electronic Piano',
        ];
        
        return [
            'name' => $this->faker->randomElement($toyNames) . ' ' . $this->faker->colorName(),
            'sku' => strtoupper(Str::random(3) . '-' . $this->faker->unique()->numberBetween(1000, 9999)),
            'description' => $this->faker->paragraph(2),
            'price' => $this->faker->randomFloat(2, 5, 150),
            'quantity' => $this->faker->numberBetween(0, 100),
            'image_url' => null,
        ];
    }
}
