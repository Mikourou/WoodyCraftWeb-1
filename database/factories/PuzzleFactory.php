<?php

namespace Database\Factories;

use App\Models\Category; // Importer le modèle Category pour créer des relations
use App\Models\Puzzle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Puzzle>
 */
class PuzzleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Puzzle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->word,
            'description' => $this->faker->sentence,
            'path_image' => $this->faker->imageUrl(640, 480, 'puzzle', true),
            'prix' => $this->faker->randomFloat(2, 1, 100),           
            'categorie_id' => Category::factory(), // Crée une catégorie associée
        ];
    }
}
