<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Funcionarios>
 */
class FuncionariosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numberBetween(100, 5000),
            'nome' => $this->faker->name(),
            'sobrenome' => $this->faker->lastName(),
            'cargo' => 'Administrador',
            'cnpj' => \App\Models\Empresas::factory()->create()->cnpj,
            'email' => $this->faker->unique()->safeEmail(),
            'senha' => Hash::make('senha123'), // Ajuste conforme seus campos
            // Adicione outros campos obrigatórios da sua model Funcionarios
        ];
    }
}
