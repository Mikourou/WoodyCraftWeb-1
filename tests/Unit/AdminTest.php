<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Order;
use App\Models\Login;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase; // Pour réinitialiser la base de données entre chaque test

    /** @test */
    public function admin_can_validate_a_customer_order()
    {
        // Création de l'utilisateur avec le rôle admin
        $admin = User::factory()->create();

        // Création de la connexion associée à l'admin
        $login = Login::factory()->create([
            'user_id' => $admin->id, // Si la table login a une clé étrangère vers user
            'role' => 'admin',
        ]);

        // Création d'une commande test
        $order = Order::factory()->create([
            'statut_commande' => '0', // statut initial
        ]);

        // Simuler un admin qui met à jour le statut de la commande
        $response = $this->actingAs($admin)->put(route('admin.update'), [
            'order_id' => $order->id,
            'statut_commande' => '1',
        ]);

        // Vérifier que le statut de la commande est bien mis à jour en base de données
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'statut_commande' => '1',
        ]);

        // Vérifier la redirection et le message de session
        $response->assertRedirect(route('admin.index'))
                 ->assertSessionHas('message', 'Commande mise à jour avec succès');
    }

    /** @test */
    public function admin_cannot_validate_a_corrupt_order()
    {
        $admin = User::factory()->create();
        $login = Login::factory()->create([
            'user_id' => $admin->id,
            'role' => 'admin',
        ]);

        // Création d'une commande avec un montant négatif (exemple de corruption)
        $order = Order::factory()->create([
            'total_prix' => -1000,  // Montant négatif
            'statut_commande' => '0', // Statut initial
        ]);

        // L'admin tente de mettre à jour la commande
        $response = $this->actingAs($admin)->put(route('admin.update'), [
            'order_id' => $order->id,
            'statut_commande' => '1',  // Tentative de mise à jour
        ]);

        // Vérifier que la commande N'A PAS été mise à jour
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'statut_commande' => '0',  // La commande doit rester avec le statut 0
        ]);

        // Vérifier que l'admin reçoit un message d'erreur
        $response->assertRedirect(route('admin.index'))
                ->assertSessionHas('error', 'Commande invalide, mise à jour refusée.');
    }

}
