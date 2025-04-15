<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the store method to create an order.
     *
     * @return void
     */
    public function test_store_order()
    {
        // Arrange: Prepare the user and the order using the factory
        $user = User::factory()->create();

        // Act: Perform a POST request to the store route
        $response = $this->post(route('paiement.store'), [
            'type_paiement' => 'Credit Card',
            'date_commande' => now()->toDateString(), // Ensure correct date format
            'articles' => [
                ['id' => 1, 'name' => 'Puzzle 1', 'quantity' => 2],
                ['id' => 2, 'name' => 'Puzzle 2', 'quantity' => 1],
            ],
            'total_prix' => 50.00,
            'methode_paiement' => 'Stripe',
            'statut_commande' => 0,
            'user_id' => $user->id,
        ]);

        // Assert that the articles are correctly stored as a JSON
        $order = Order::latest()->first();
        $this->assertJson($order->articles);

        // Assert that the order's date is correct
        $this->assertEquals(now()->toDateString(), $order->date_commande);

        // Assert that the response was a redirect or success (200 OK)
        $response->assertStatus(200);
    }
}
