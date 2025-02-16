<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricoFaturamento;
use Carbon\Carbon;
use App\Services\FaturamentoService;

class FaturamentoController extends Controller
{
    protected $faturamentoService;

    public function __construct(FaturamentoService $faturamentoService)
    {
        $this->faturamentoService = $faturamentoService;
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DE CADASTRO MANUAL DE FATURAMENTO
    // ------------------
    public function create()
    {
        return view('sistema/faturamento/cadastroManualFaturamento', ['page' => 'Empresa']);
    }

    // ------------------
    // FUNÇÃO PARA: RETORNAR VIEW DO HISTÓRICO DE FATURAMENTO
    // PARAMETROS: TODOS OS FATURAMENTOS REGISTRADOS
    // ------------------
    public function read()
    {
        $todosFaturamentos = HistoricoFaturamento::all();
        return view('sistema/faturamento/HistoricoFaturamento', ['faturamentos' => $todosFaturamentos], ['page' => 'Empresa']);
    }

    // ------------------
    // FUNÇÃO PARA: REGISTRAR FATURAMENTO AUTOMÁTICO
    // ------------------
    public function registrarFaturamento()
    {
        // Calcula as vendas do mês atual
        $vendasMesAtual = $this->faturamentoService->calcularVendasDoMesAtual();

        // Atualiza o faturamento com base nas vendas calculadas
        $this->faturamentoService->atualizarFaturamentoMensal($vendasMesAtual);


    }

    // ------------------
    // FUNÇÃO PARA: REGISTRAR FATURAMENTO MANUALMENTE
    // PARAMETROS: REQUEST COM MÊS, ANO E VALOR DO FATURAMENTO
    // ------------------
    public function store(Request $request)
    {
        $request->validate([
            'mes' => 'required|numeric',
            'ano' => 'required|numeric',
            'valor' => 'required|numeric',
        ]);

        $ano_mes = $request->input('ano') . '-' . $request->input('mes');
        $verificaFaturamento = HistoricoFaturamento::where('ano_mes', $ano_mes)->first();

        if ($verificaFaturamento) {
            return redirect('faturamento')->with('error', 'Faturamento já registrado para o mês informado.');
        } else {
            $faturamento = HistoricoFaturamento::create([
                'ano_mes' => $ano_mes,
                'renda_bruta' => $request->input('valor'),
            ]);
        }

        if ($faturamento) {
            return redirect()->back()->with('success', 'Faturamento registrado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao registrar faturamento.');
        }
    }

    // ------------------
    // FUNÇÃO PARA: ATUALIZAR FATURAMENTO
    // PARAMETROS: REQUEST COM ID DO FATURAMENTO E NOVO VALOR
    // ------------------
    public function update(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric',
        ]);

        $verificaFaturamento = HistoricoFaturamento::where('id', $request->faturamento_id)->first();

        if ($verificaFaturamento) {
            $verificaFaturamento->update([
                'renda_bruta' => $request->input('valor'),
            ]);
            return redirect('renda-bruta/exibir')->with('success', 'Faturamento atualizado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Faturamento não registrado para o mês informado.');
        }
    }

    // ------------------
    // FUNÇÃO PARA: EXCLUIR REGISTRO DE FATURAMENTO
    // PARAMETROS: REQUEST COM ID DO FATURAMENTO
    // ------------------
    public function delete(Request $request)
    {
        $faturamento = HistoricoFaturamento::find($request->input('id'));
        if ($faturamento) {
            $faturamento->delete();
            return redirect('renda-bruta/exibir')->with('success', 'Faturamento excluído com sucesso!');
        }
        return redirect()->back()->with('error', 'Faturamento não encontrado.');
    }

    // ------------------
    // FUNÇÃO AUXILIAR: CALCULAR RENDA DOS ÚLTIMOS 12 MESES
    // ------------------
    public function calcularRendaDosUltimos12Meses()
    {
        $mesAtual = Carbon::now()->startOfMonth(); // Pega o início do mês atual

        // Pega os últimos 12 meses
        $rendaUltimos12Meses = HistoricoFaturamento::where('mes', '>=', $mesAtual->subMonths(12)->format('Y-m'))
            ->get();

        return $rendaUltimos12Meses->sum('renda_bruta');
    }

    // ------------------
    // FUNÇÃO AUXILIAR: ATUALIZAR FATURAMENTO MENSAL
    // PARAMETROS: VALOR DAS VENDAS DO MÊS
    // ------------------
    public function atualizarFaturamentoMensal($valor_vendas_mes)
    {
        $mesAtual = Carbon::now()->format('Y-m'); // Exemplo: '2024-08'

        // Verifica se já existe um registro para o mês atual
        $faturamentoExistente = HistoricoFaturamento::where('mes', $mesAtual)->first();

        if (!$faturamentoExistente) {
            // Insere novo registro para o mês atual
            HistoricoFaturamento::create([
                'mes' => $mesAtual,
                'renda_bruta' => $valor_vendas_mes,
            ]);
        }
    }
}
