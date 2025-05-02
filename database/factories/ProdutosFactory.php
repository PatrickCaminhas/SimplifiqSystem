<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produtos>
 */
class ProdutosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'modelo' => $this->faker->name,
            'marca' => $this->faker->name,
            'unidade_medida' => $this->faker->randomElement(['un', 'kg', 'g', 'l', 'ml']),
            'medida' => $this->faker->randomFloat(2, 0, 1000),
            'descricao' => $this->faker->text,
            'quantidade' => $this->faker->randomNumber(2),
            'ultimo_fornecedor' => $this->faker->name,
            'preco_compra' => $this->faker->randomFloat(2, 0, 50),
            'preco_venda' => $this->faker->randomFloat(2, 71, 100),
            'desconto_maximo' => $this->faker->randomFloat(2, 60, 70),
            'estado' => 'Ativo',
        ];
    }
}
