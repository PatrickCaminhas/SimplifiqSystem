<?php

namespace Database\Factories;

use App\Models\Clientes;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientesFactory extends Factory
{
    protected $model = Clientes::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'cpfOuCnpj' => $this->faker->unique()->numerify('###########'),
            'telefone' => $this->faker->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail,
            'endereco_completo' => $this->faker->address,
            'debitos' => 0,

        ];
    }
}

