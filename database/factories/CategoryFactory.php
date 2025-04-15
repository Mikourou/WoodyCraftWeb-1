<?php

namespace Database\Factories;

use App\Models\Category; // Assurez-vous que le modèle s'appelle "Category"
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'libelle' => $this->faker->word,
            'description' => $this->faker->sentence,
            'path_image' => $this->faker->imageUrl(),
        ];
    }
}
