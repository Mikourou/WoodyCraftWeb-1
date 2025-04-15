<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;


class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index', compact('commande_statut'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id); // Trouver la commande avec l'ID donné
        return view('admin.edit', compact('order')); // Passer l'objet `order` à la vue
    }


    public function update(Request $request)
    {
        // Vérifie que la requête contient bien un statut
        $request->validate([
            'statut_commande' => 'required|in:0,1,2',
        ]);

        // Récupère la commande à partir de l'ID envoyé
        $order = Order::find($request->order_id);

        // Vérifier si la commande existe et si le total_prix est valide (exemple de "corruption")
        if (!$order || $order->total_prix < 0) {
            // Si la commande n'existe pas ou si elle est corrompue (prix négatif), retourner un message d'erreur
            return redirect()->route('admin.index')
                            ->with('error', 'Commande invalide, mise à jour refusée.');
        }


        // Met à jour le statut
        $order->statut_commande = $request->statut_commande;
        $order->save();

        return redirect()->route('admin.index')->with('message', 'Commande mise à jour avec succès');
    }


}
