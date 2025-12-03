<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $possibleIncome = ['Freelance', 'Investment', 'Commission', 'Refund'];
        $possibleExpense = ['Healthcare', 'Subscriptions', 'Education', 'Pets', 'Hobbies'];

        foreach (User::all() as $user) {
            $randomIncome = fake()->randomElements(
                $possibleIncome,
                rand(0, 2)
            );

            foreach ($randomIncome as $name) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'type' => 'income',
                ]);
            }

            $randomExpense = fake()->randomElements(
                $possibleExpense,
                rand(1, 3)
            );

            foreach ($randomExpense as $name) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'type' => 'expense',
                ]);
            }
        }
    }
}
