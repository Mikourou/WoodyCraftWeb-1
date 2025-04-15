<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Login extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'email',
        'password',
        'role',
        'user_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function user()
    {
        // fonction qui s'assure que 'user_id' est bien la clé étrangère vers la table users
        return $this->belongsTo(User::class, 'user_id');
    }
}


?>
