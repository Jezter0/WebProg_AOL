<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        foreach ($users as $user) {
            $expenseCategories = Category::where('user_id', $user->id)
                ->where('type', 'expense')
                ->get();

            foreach ($expenseCategories as $category) {
                Budget::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'category_id' => $category->id,
                        'month' => $currentMonth,
                        'year' => $currentYear,
                    ],
                    [
                        'amount' => fake()->randomFloat(2, 100, 2000),
                    ]
                );
            }
        }
    }
}