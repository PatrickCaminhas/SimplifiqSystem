<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Clientes;
use App\Models\Vendas;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mudarEstadoVendaCrediario_atualiza_vendas_corretamente()
    {
        $cliente = Clientes::factory()->create(['debitos' => 100]);

        $venda1 = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Crediário',
            'crediario' => 50,
        ]);

        $venda2 = Vendas::factory()->create([
            'cliente_id' => $cliente->id,
            'metodo_pagamento' => 'Crediário',
            'crediario' => 50,
        ]);

        $controller = new \App\Http\Controllers\ClienteController();
        $controller->mudarEstadoVendaCrediario(75, $cliente);

        $this->assertEquals('Crediário(Pago)', $venda1->fresh()->metodo_pagamento);
        $this->assertEquals(0, $venda1->fresh()->crediario);
        $this->assertEquals('Crediário(Pago Parcial)', $venda2->fresh()->metodo_pagamento);
        $this->assertEquals(25, $venda2->fresh()->crediario);
    }
}
