<?php

namespace App\Http\Controllers;

use App\Models\Tarefas;
use Illuminate\Http\Request;
use App\Models\Servicos;
use App\Models\Funcionarios;
use App\Models\ServicosTipo;

class ServicosController extends Controller
{
    //
    public function createRead()
    {
        $servicos = Servicos::all();
        return view('sistema.servicos.servicos', ['servicos' => $servicos],['page'=>'servicos']);
    }
    public function createStoreServico(){
        $tipos_servico = ServicosTipo::all();
        return view('sistema.servicos.servicosCadastro', ['page' => 'servicos'], ['tipos_servico' => $tipos_servico]);
    }
    public function createStoreTarefas(Request $request){
        $servico =  Servicos::find($request->id);
        $funcionarios = Funcionarios::all();
        return view('sistema.servicos.tarefasCadastro',['servico_id' => $request->id], ['funcionarios'=> $funcionarios],['page'=>'servicos']);
    }

    public function createTipoRead()
    {
        return view('sistema.servicos.cadastroTipoServicos', ['page'=> 'servicos']);
    }


    public function storeTipo(Request $request){
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

    public function store(Request $request){
        $servicos = new Servicos();
        $servicos->nome = request()->input('nome');
        $servicos->nome_cliente = request()->input('nome_cliente');
        $servicos->identificacao_cliente = request()->input('identificacao_cliente');
        $servicos->tipo_cliente = request()->input('tipo_cliente');
        $servicos->valor= request()->input('valor');
        $servicos->tipo_servico = request()->input('tipo_servico');
        $servicos->data_inicio = request()->input('data_inicio');
        $servicos->data_fim = request()->input('data_fim');
        $servicos->estado = 'Pendente';
        $servicos->descricao = request()->input('descricao');
        $servicos->save();
        return redirect()->route('servicos.read');

    }

    public function storeTarefas(){
        $tarefas = new Tarefas();
    }
}
