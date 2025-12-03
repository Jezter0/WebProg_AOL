<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::factory();
        $category = Category::factory()->create([
            'user_id'=>$userId
        ]);

        return [
            'user_id' => $userId,
            'category_id' => $category->id,
            'amount' => $this->faker->randomFloat(2, 10, 5000),
            'description' => $this->faker->sentence(),
            'date' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
