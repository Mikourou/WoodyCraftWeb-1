<?php

namespace Tests\Unit;

use App\Models\Basket;
use App\Models\Puzzle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasketTest extends TestCase
{
    /**
     * Test when the user is logged in.
     *
     * @return void
     */
    public function test_clear_basket_for_logged_in_user()
    {
        // Créer un utilisateur
        $user = User::factory()->create();
        $puzzle = Puzzle::factory()->create();

        // Créer un panier pour l'utilisateur
        Basket::create([
            'user_id' => $user->id,
            'puzzle_id' => $puzzle->id, // Remplacer par un produit réel si nécessaire
            'quantity' => 2
        ]);

        // Agir comme l'utilisateur authentifié
        $response = $this->actingAs($user)->post(route('basket.clear'));

        // Vérifier que les éléments du panier ont été supprimés
        $this->assertDatabaseMissing('baskets', ['user_id' => $user->id]);

        // Vérifier que la redirection est correcte
        $response->assertRedirect(route('basket.index'));
    }

    public function test_add_product_in_basket_for_logged_in_user()
    {
        // Créer un utilisateur
        $user = User::factory()->create();
    
        // Créer un puzzle (produit)
        $puzzle = Puzzle::factory()->create();
    
        // Agir comme l'utilisateur authentifié
        $response = $this->actingAs($user)->post(route('basket.store', $puzzle), [
            'quantity' => 2, // Quantité du produit
        ]);
    
        // Vérifier que le panier a bien été créé pour cet utilisateur dans la base de données
        $this->assertDatabaseHas('baskets', [
            'user_id' => $user->id,
            'puzzle_id' => $puzzle->id,
            'quantity' => 2,
        ]);
    
        // Vérifier la redirection après ajout au panier
        $response->assertRedirect(); // Vérifier que la redirection fonctionne
        $response->assertSessionHas('message', 'Produit ajouté au panier !'); // Vérifier le message flash
    }
    
}
