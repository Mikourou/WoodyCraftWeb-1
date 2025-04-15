<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use PDF;

class PDFController extends Controller
{
    public function generatePDF()
    {
        try {
            // Récupérer l'utilisateur connecté
            $user = Auth::user();

            // Récupérer uniquement la dernière commande de l'utilisateur
            $order = Order::where('user_id', $user->id)->latest()->first();

            // Charger la vue HTML pour la commande
            $html = view('pdf.view', ['order' => $order])->render();

            // Validation de l'HTML avec libxml
            libxml_use_internal_errors(true);
            $doc = new \DOMDocument();
            $doc->loadHTML($html);
            $errors = libxml_get_errors();

            if (!empty($errors)) {
                // Si des erreurs sont trouvées, on retourne un message d'erreur
                $errorMessage = 'Erreur dans le HTML :';
                foreach ($errors as $error) {
                    $errorMessage .= ' ' . $error->message;
                }
                libxml_clear_errors();
                return response()->json(['error' => $errorMessage], 400);
            }

            // Si le HTML est valide, générer le PDF
            $pdf = PDF::loadHTML($html);
            return $pdf->download('facture.pdf');
        } catch (\Exception $e) {
            // Gérer l'exception
            return response()->json(['error' => 'Erreur lors de la génération du PDF: ' . $e->getMessage()], 500);
        }
    }
}
