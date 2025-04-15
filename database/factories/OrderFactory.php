<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'type_paiement' => 'Credit Card',
            'date_commande' => $this->faker->date(),
            'articles' => json_encode([
                ['id' => 1, 'name' => 'Puzzle 1', 'quantity' => 2],
                ['id' => 2, 'name' => 'Puzzle 2', 'quantity' => 1],
            ]),
            'total_prix' => 50.00,
            'methode_paiement' => 'Stripe',
            'user_id' => User::factory(), // Create a user for each order
        ];
    }
}
