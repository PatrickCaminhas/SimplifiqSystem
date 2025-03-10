<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\metaService;
use App\Models\Metas;
use App\Models\MetasProgresso;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

class MetaServiceTest extends TestCase
{
    use RefreshDatabase, InteractsWithDatabase;
    use RefreshDatabase;

    protected $metaService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->metaService = new metaService();
        // Definindo uma data fixa para os testes
        Carbon::setTestNow('2025-02-26');
    }

    public function testCadastrarProgressoAtualizaMetaECriaHistorico()
    {
        // Cria uma meta
        $meta = Metas::create([
            'valor' => 1000,
            'valor_atual' => 900,
            'ending_at' => Carbon::now()->addDays(5)->toDateString(),
            'estado' => 'Pendente'
        ]);

        $dados = (object)[
            'meta_id' => $meta->id,
            'valor'   => 200
        ];

        $this->metaService->cadastrarProgresso($dados);

        $meta->refresh();
        // Verifica se o valor atual foi incrementado
        $this->assertEquals(1100, $meta->valor_atual);

        // Se o valor ultrapassar o limite e a meta ainda estiver pendente, deve mudar para 'Cumprida'
        if ($meta->valor_atual > $meta->valor && $meta->ending_at > Carbon::now()->toDateString()) {
            $this->assertEquals('Cumprida', $meta->estado);
        }

        // Verifica se o histórico foi registrado
        $this->assertDatabaseHas('metas_progresso', [
            'meta_id' => $meta->id,
            'valor'   => 200,
        ]);
    }

    public function testBuscarMetasEmAbertoRetornaApenasMetasAbertas()
    {
        // Cria três metas com diferentes estados
        $meta1 = Metas::create([
            'valor' => 1000,
            'valor_atual' => 500,
            'ending_at' => Carbon::now()->addDays(5)->toDateString(),
            'estado' => 'Pendente'
        ]);
        $meta2 = Metas::create([
            'valor' => 2000,
            'valor_atual' => 2000,
            'ending_at' => Carbon::now()->addDays(5)->toDateString(),
            'estado' => 'Cumprida'
        ]);
        $meta3 = Metas::create([
            'valor' => 3000,
            'valor_atual' => 3000,
            'ending_at' => Carbon::now()->addDays(5)->toDateString(),
            'estado' => 'Finalizada'
        ]);

        $metasAbertas = $this->metaService->buscarMetasEmAberto();
        $this->assertCount(2, $metasAbertas);
        $this->assertTrue($metasAbertas->contains('id', $meta1->id));
        $this->assertTrue($metasAbertas->contains('id', $meta2->id));
    }

    public function testCadastrarProgressoEmTodasMetasAbertas()
    {
        // Cria duas metas em aberto
        $meta1 = Metas::create([
            'valor' => 1000,
            'valor_atual' => 500,
            'ending_at' => Carbon::now()->addDays(5)->toDateString(),
            'estado' => 'Pendente'
        ]);
        $meta2 = Metas::create([
            'valor' => 2000,
            'valor_atual' => 1500,
            'ending_at' => Carbon::now()->addDays(5)->toDateString(),
            'estado' => 'Pendente'
        ]);

        $valor = 300;
        $this->metaService->cadastrarProgressoEmTodasMetasAbertas($valor);

        $meta1->refresh();
        $meta2->refresh();
        $this->assertEquals(800, $meta1->valor_atual);
        $this->assertEquals(1800, $meta2->valor_atual);
        // Cada meta deverá ter um registro no histórico
        $this->assertDatabaseCount('metas_progresso', 2);
    }

    public function testRemoverProgressoAtualizaMetaECriaHistoricoNegativo()
    {
        $meta = Metas::create([
            'valor' => 1000,
            'valor_atual' => 800,
            'ending_at' => Carbon::now()->addDays(5)->toDateString(),
            'estado' => 'Cumprida'
        ]);

        $dados = (object)[
            'meta_id' => $meta->id,
            'valor'   => 200
        ];

        $this->metaService->removerProgresso($dados);

        $meta->refresh();
        $this->assertEquals(600, $meta->valor_atual);
        // Se o valor atual ficar abaixo do limite, o estado deve voltar para 'Pendente'
        if ($meta->valor_atual < $meta->valor && $meta->estado == 'Cumprida') {
            $this->assertEquals('Pendente', $meta->estado);
        }
        $this->assertDatabaseHas('metas_progresso', [
            'meta_id' => $meta->id,
            'valor'   => -200,
        ]);
    }

    public function testRemoverProgressoEmTodasMetasAbertas()
    {
        $meta1 = Metas::create([
            'valor' => 1000,
            'valor_atual' => 800,
            'ending_at' => Carbon::now()->addDays(5)->toDateString(),
            'estado' => 'Cumprida'
        ]);
        $meta2 = Metas::create([
            'valor' => 2000,
            'valor_atual' => 1500,
            'ending_at' => Carbon::now()->addDays(5)->toDateString(),
            'estado' => 'Pendente'
        ]);

        $valor = 200;
        $this->metaService->removerProgressoEmTodasMetasAbertas($valor);

        $meta1->refresh();
        $meta2->refresh();
        $this->assertEquals(600, $meta1->valor_atual);
        $this->assertEquals(1300, $meta2->valor_atual);
        $this->assertDatabaseCount('metas_progresso', 2);
    }

    public function testVerificarSeExisteMetaCriaNovaMetaSeNaoExistir()
    {
        $ultimoDiaMes = Carbon::now()->endOfMonth()->toDateString();
        $this->assertFalse(Metas::whereDate('ending_at', $ultimoDiaMes)->exists());

        $this->metaService->verificarSeExisteMeta();

        $this->assertTrue(Metas::whereDate('ending_at', $ultimoDiaMes)->exists());
    }
}
