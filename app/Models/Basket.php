<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Puzzle;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'puzzle_id',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class, 'puzzle_id');
    }
}





