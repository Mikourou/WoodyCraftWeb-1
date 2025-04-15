<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Disable Vite compilation by changing asset_url config
        config()->set('app.asset_url', '/');
        config()->set('vite.enabled', false);
    }

    /**
     * Test the show method for a category.
     *
     * @return void
     */
    public function test_it_displays_a_category(): void
    {
        // Créer une catégorie fictive dans la base de données
        $category = Category::factory()->create([
            'libelle' => 'Puzzles',
            'description' => 'Une catégorie dédiée aux puzzles.',
            'path_image' => 'images/puzzles.jpg',
        ]);

        // Effectuer une requête GET pour afficher cette catégorie
        $response = $this->get(route('categories.show', $category->id));

        // Vérifier que la réponse est correcte (200 OK)
        $response->assertStatus(200);

        // Vérifier que les données de la catégorie sont présentes dans la vue
        $response->assertSee($category->libelle);
        $response->assertSee($category->description);
        $response->assertSee($category->path_image);
    }
}
