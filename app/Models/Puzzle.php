<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puzzle extends Model
{
    use HasFactory;

    // Propriété pour définir les champs assignables en masse
    protected $fillable = [
        'nom',
        'description',
        'path_image',
        'prix',
        'stock',
        'categorie_id',
    ];

    // Récupérer les infos de catégories du puzzle
    public function categorie()
    {
        return $this->belongsTo(Categories::class, 'categorie_id');
    }
}

?>
