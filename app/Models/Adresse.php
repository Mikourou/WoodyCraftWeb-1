<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;


class Adresse extends Model
{
    use HasFactory;

    protected $table = 'delivery_addresses';

    protected $filliable = [
        'delivery_adresse',
        'ville',
        'code_postal',
    ];

}
