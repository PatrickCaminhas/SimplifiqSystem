<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Itens_Venda>
 */
class Itens_VendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $venda =    \App\Models\Vendas::factory()->create();
        $produto =  \App\Models\Produtos::factory()->create();
        $valor_unitario = $produto->preco_venda;
        $quantidade = $this->faker->numberBetween(1,10);
        return [
            'venda_id' => $venda,
            'produto_id' => $produto,
            'quantidade' => $quantidade,
            'preco_unitario' => $valor_unitario,
            'subtotal' => $valor_unitario * $quantidade
        ];
    }
}
