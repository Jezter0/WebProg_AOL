<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Salary', 'type' => 'income'],
            ['name' => 'Bonus', 'type' => 'income'],

            ['name' => 'Food', 'type' => 'expense'],
            ['name' => 'Rent', 'type' => 'expense'],
            ['name' => 'Utilities', 'type' => 'expense'],
            ['name' => 'Transport', 'type' => 'expense'],
            ['name' => 'Entertainment', 'type' => 'expense'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate([
                'name' => $cat['name'],
                'type' => $cat['type'],
                'user_id' => null,
            ]);
        }
    }
}
