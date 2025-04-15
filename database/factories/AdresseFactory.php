<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Adresse;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adresse>
 */
class AdresseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deliv_adresse' => fake()->streetAddress(),
            'ville' => fake()->city(),
            'code_postal' => fake()->postcode(),
            'adresse_facturation' => fake()->streetAddress(),
            'user_id' => User::factory(), // Crée un utilisateur lié automatiquement
        ];
    }
}
