<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'category' => 'professional',
            'institution_or_company' => fake()->company(),
            'designation' => 'Brand Specialist',
            'state' => 'Kaduna',
            'country' => 'Nigeria',
            'status' => 'active',
            'payment_status' => 'paid',
            'qr_code_token' => (string) fake()->uuid(),
            'joined_at' => now()->toDateString(),
        ];
    }
}
