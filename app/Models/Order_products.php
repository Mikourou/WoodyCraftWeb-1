<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_paiement',
        'date_commande',
        'articles',
        'total_prix',
        'methode_paiement',
        'statut_commande',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
