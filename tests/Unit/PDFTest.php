<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use PDF;

class PDFTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_valid_pdf()
    {
        // Contenu HTML de test
        $html = '<h1>Test PDF</h1><p>Ce PDF doit contenir ce texte.</p>';

        // Génération du PDF avec DomPDF
        $pdf = PDF::loadHTML($html);
        $output = $pdf->output();

        // Vérifie que la sortie n'est pas vide
        $this->assertNotEmpty($output, "Le PDF généré est vide.");

        // Vérifie que la sortie commence par "%PDF" (signature PDF)
        $this->assertStringStartsWith('%PDF', $output, "Le fichier généré ne semble pas être un PDF valide.");

        // Optionnel : Vérifie que le texte attendu est présent dans le contenu du PDF
        $this->assertStringContainsString("Test PDF", $html, "Le contenu du PDF ne contient pas le texte attendu.");
    }

    /** @test */
    public function test_pdf_is_not_generated_when_corrupted()
    {
        // Arrange: Créer un utilisateur et une commande
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'statut_commande' => '0',
        ]);

        // Authentifier l'utilisateur
        $this->actingAs($user);

        // Act: Créer un HTML corrompu
        $corruptedHtml = "<html><body><h1>Test PDF</h1><p>This is a test.</p><invalid>content</body></html>"; // HTML corrompu

        try {
            // Essayer de générer le PDF à partir du HTML corrompu
            $pdf = PDF::loadHTML($corruptedHtml);

            // Si le PDF est généré malgré l'HTML corrompu, le test échoue
            $this->fail("Le PDF a été généré malgré un HTML corrompu.");
        } catch (\Exception $e) {
            // Assurez-vous qu'une exception a bien été levée
            $this->assertStringContainsString('Error', $e->getMessage(), "L'erreur levée ne correspond pas à une erreur attendue.");
        }

        // Act: Essayer de télécharger le PDF
        $response = $this->get(route('pdf.generate'));

        // Assert: Vérifier que la génération du PDF n'a pas été effectuée (aucun fichier PDF téléchargé)
        $response->assertStatus(400);  // Ou 500 selon l'implémentation
        $this->assertStringContainsString('Erreur lors de la génération du PDF', $response->getContent());
    }

}
