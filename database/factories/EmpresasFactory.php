<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresas>
 */
class EmpresasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->company,
            'cnpj' => $this->faker->unique()->numerify('59284409000173'),
            'tamanho_empresa' => $this->faker->randomElement(['Pequena', 'Média', 'Grande']),
            'tipo_empresa' => $this->faker->randomElement(['Comércio', 'Indústria', 'Serviços']),
            'telefone' => $this->faker->phoneNumber,
            'estado' => 'Ativa',

            // Adicione outros campos necessários
        ];
    }
}
