<?php

namespace App\Http\Controllers;

use App\Models\Tarefas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Servicos;
use App\Models\Funcionarios;
use App\Models\ServicosTipo;
use App\Models\Clientes;
use App\Services\FaturamentoService;
use App\Services\metaService;

class ServicosController extends Controller
{
    //
    protected $faturamentoService;
    protected $metaService;

    public function __construct(FaturamentoService $faturamentoService, MetaService $metaService)
    {
        $this->faturamentoService = $faturamentoService;
        $this->metaService = $metaService;
    }



    public function createRead()
    {
        $servicos = Servicos::all();
        return view('sistema.servicos.servicos', ['servicos' => $servicos], ['page' => 'servicos']);
    }
    public function createStoreServico()
    {
        $tipos_servico = ServicosTipo::all();
        $clientes = Clientes::all();
        return view('sistema.servicos.servicosCadastro', [
            'page' => 'servicos',
            'tipos_servico' => $tipos_servico,
            'clientes' => $clientes
        ]);
    }
    public function createStoreTarefas(Request $request)
    {
        $servico = Servicos::find($request->id);
        $funcionarios = Funcionarios::all();
        return view('sistema.servicos.tarefasCadastro', [
            'servico_id' => $request->id,
            'funcionarios' => $funcionarios,
            'page' => 'servicos'
        ]);
    }

    public function createTipoRead()
    {
        return view('sistema.servicos.cadastroTipoServicos', ['page' => 'servicos']);
    }


    public function storeTipo(Request $request)
    {
        $tipo_servico = new ServicosTipo();
        $tipo_servico->nome = request()->input('nome');
        $tipo_servico->duracao = request()->input('duracao');
        $tipo_servico->materiais = request()->input('materiais');
        $tipo_servico->quantidade_de_funcionarios = request()->input('quantidade_de_funcionarios');
        $tipo_servico->valor_diario = request()->input('valor');
        $tipo_servico->descricao = request()->input('descricao');
        $tipo_servico->save();
        return redirect()->route('servicos.tipo.read');
    }

    public function finalizarServico(Request $request)
    {
        $servico = Servicos::find($request->servico_id);
        $servico->estado = 'Finalizado';
        $servico->save();
        $this->faturamentoService->atualizarFaturamento($servico->valor);
        $this->metaService->cadastrarProgressoEmTodasMetasAbertas($servico->valor);
        return redirect()->route('servicos.read');
    }
    public function cancelarServico(Request $request)
    {
        $servico = Servicos::find($request->servico_id);
        $servico->estado = 'Cancelado';
        $servico->save();
        return redirect()->route('servicos.read');
    }



    public function store(Request $request)
    {
        $servicos = new Servicos();
        $servicos->nome = $request->input('nome');
        $servicos->nome_cliente = $request->input('nome_cliente');
        $servicos->identificacao_cliente = $request->input('identificacao_cliente');
        $servicos->tipo_cliente = $request->input('tipo_cliente');
        $servicos->valor = $request->input('valor');
        $servicos->tipo_servico = $request->input('tipo_servico');

        // Converter a data de início para um objeto Carbon
        $dataInicio = Carbon::parse($request->input('data_inicio'));

        if ($request->input('tipo_prestacao_servico') == 'Dias') {
            $diasServico = $request->input('dias_servico');
            // Adicionar dias, pulando domingos
            for ($i = 0; $i < $diasServico; $i++) {
                $dataInicio->addDay();
                if ($dataInicio->isSunday()) {
                    $dataInicio->addDay(); // Pula o domingo
                }
            }
            $servicos->data_fim = $dataInicio;
        } elseif ($request->input('tipo_prestacao_servico') == 'Horas') {
            $horasServico = $request->input('horas_servico');
            $horasRestantes = $horasServico;

            while ($horasRestantes > 0) {
                // Verifica se é domingo e pula o dia
                if ($dataInicio->isSunday()) {
                    $dataInicio->addDay();
                    continue;
                }

                // Calcula quantas horas restam para completar 8 horas no dia atual
                $horasDia = min($horasRestantes, 8);
                $horasRestantes -= $horasDia;

                // Se ainda houver horas restantes, adiciona mais um dia
                if ($horasRestantes > 0) {
                    $dataInicio->addDay();
                }
            }
            $servicos->data_fim = $dataInicio;
        }

        $servicos->data_inicio = Carbon::parse($request->input('data_inicio'));
        $servicos->estado = 'Pendente';
        $servicos->descricao = $request->input('descricao');
        $servicos->save();

        return redirect()->route('servicos.read');
    }


    public function delete(Request $request)
    {
        $servico = Servicos::find($request->input('id'));
        $servico->delete();
        return redirect()->route('servicos.read');
    }

}
