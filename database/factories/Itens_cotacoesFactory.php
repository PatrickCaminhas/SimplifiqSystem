<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Itens_cotacoes>
 */
class Itens_cotacoesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_cotacao' => CotacoesFactory::new()->create()->id,
            'produto_id' => ProdutosFactory::new()->create()->id,
            'preco' => $this->faker->randomFloat(2, 1, 1000),
            'fornecedor_id' => FornecedoresFactory::new()->create()->id,

        ];
    }
}
