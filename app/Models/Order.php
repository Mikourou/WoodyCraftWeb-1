<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_paiement',    // Type de paiement
        'date_commande',    // Date de la commande
        'articles',          // Articles commandés (tableau)
        'total_prix',       // Prix total
        'methode_paiement',  // Méthode de paiement
    ];
}
