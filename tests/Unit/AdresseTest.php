<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Adresse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdresseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_the_user_address()
    {
        // Créez un utilisateur fictif
        $user = User::factory()->create();

        // Créez une adresse pour cet utilisateur
        $adresse = Adresse::factory()->create([
            'user_id' => $user->id,
        ]);

        // Connectez l'utilisateur
        $this->actingAs($user);

        // Données de mise à jour
        $updatedData = [
            'deliv_adresse' => 'Nouvelle adresse de livraison',
            'ville' => 'Paris',
            'code_postal' => '75001',
            'adresse_facturation' => 'Adresse de facturation mise à jour',
        ];

        // Simulez la requête pour mettre à jour l'adresse
        $response = $this->put(route('adresse.update', $adresse->id), $updatedData);

        // Vérifiez que la réponse redirige vers la page des adresses
        $response->assertRedirect(route('adresse.index'));

        // Vérifiez que l'adresse a bien été mise à jour dans la base de données
        $this->assertDatabaseHas('delivery_addresses', [
            'id' => $adresse->id,
            'deliv_adresse' => $updatedData['deliv_adresse'],
            'ville' => $updatedData['ville'],
            'code_postal' => $updatedData['code_postal'],
            'adresse_facturation' => $updatedData['adresse_facturation'],
        ]);
    }
 
    public function it_fails_to_update_the_user_address_with_invalid_data()
    {
        // Créez un utilisateur fictif
        $user = User::factory()->create();
    
        // Créez une adresse pour cet utilisateur
        $adresse = Adresse::factory()->create([
            'user_id' => $user->id,
        ]);
    
        // Connectez l'utilisateur
        $this->actingAs($user);
    
        // Données invalides de mise à jour
        $invalidData = [
            'deliv_adresse' => '', // Adresse vide, devrait échouer
            'ville' => '', // Ville vide, devrait échouer
            'code_postal' => 'abc', // Code postal invalide
            'adresse_facturation' => '', // Adresse de facturation vide
        ];
    
        // Simulez la requête pour mettre à jour l'adresse avec des données invalides
        $response = $this->put(route('adresse.update', $adresse->id), $invalidData);
    
        // Vérifiez que la réponse renvoie un statut 302 (redirige avec des erreurs) et non 422
        // En cas de validation échouée, Laravel redirige par défaut vers la page précédente avec les erreurs
        $response->assertStatus(302); // Redirection vers la page précédente avec les erreurs
    
        // Vérifiez que les erreurs sont présentes dans la session
        $response->assertSessionHasErrors([
            'deliv_adresse',
            'ville',
            'code_postal',
            'adresse_facturation',
        ]);
    
        // Vérifiez que l'adresse n'a pas été mise à jour dans la base de données
        $this->assertDatabaseMissing('delivery_addresses', [
            'id' => $adresse->id,
            'deliv_adresse' => $invalidData['deliv_adresse'], // Doit être vide
            'ville' => $invalidData['ville'], // Doit être vide
            'code_postal' => $invalidData['code_postal'], // Doit être invalide
            'adresse_facturation' => $invalidData['adresse_facturation'], // Doit être vide
        ]);
    }
    
}
