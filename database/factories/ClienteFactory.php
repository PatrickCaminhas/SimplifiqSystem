<?php

namespace Database\Factories;

use App\Models\Clientes;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Clientes::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'crediario' => 0,

        ];
    }
}
