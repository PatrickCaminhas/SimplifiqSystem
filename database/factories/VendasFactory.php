<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendas>
 */
class VendasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => 1,
            'data_venda' => $this->faker->date(),
            'valor_total' => $this->faker->randomFloat(2, 0, 1000),
            'metodo_pagamento' => $this->faker->randomElement(['Dinheiro', 'Cartão de crédito', 'Cartão de débito', 'Pix']),
            'crediario' => 0,
        ];
    }
}
