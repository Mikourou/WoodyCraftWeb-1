<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // Afficher la liste des commandes en attente
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        $articles = json_decode($order->articles, true); // Decode le JSON en tableau associatif
        $donneePuzzle = [
            'id' => $order->id,
            'type_paiement' => $order->type_paiement,
            'date_commande' => $order->date_commande,
            'articles' => $articles,
            'total_prix' => $order->total_prix,
            'methode_paiement' => $order->methode_paiement,
            'statut_commande' => $order->statut_commande,
        ];
        return response()->json($donneePuzzle);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $order->delete();

        return response()->json(['message' => 'Commande supprimée']);
    }

    public function validateOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }
        $order->statut_commande = 1;
        $order->save();
        return response()->json(['message' => 'Commande validée avec succès']);
    }

    public function expedierOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Commande non trouvée'], 404);
        }

        if ($order->statut_commande != 1) {
            return response()->json(['message' => 'La commande doit être validée avant d\'être expédiée'], 400);
        }
    
        $order->statut_commande = 2;
        $order->save();
        
        return response()->json(['message' => 'Commande expédiée avec succès']);
    }
}
