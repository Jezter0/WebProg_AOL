<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $type = $this->faker->randomElement(['income', 'expense']);

        $incomeCategories = ['Freelance', 'Refund', 'Gift'];
        $expenseCategories = ['Healthcare', 'Shopping', 'Education'];

        $name = $type === 'income' 
            ? $this->faker->randomElement($incomeCategories)
            : $this->faker->randomElement($expenseCategories);

        return [
            'user_id' => User::factory(),
            'name' => $name,
            'type' => $type,
        ];
    }
}
