<?php

namespace App\Http\Controllers;

use App\Models\Tarefas;
use Illuminate\Http\Request;
use App\Models\Servicos;
use App\Models\Funcionarios;
use App\Models\tipo_servico;

class ServicosController extends Controller
{
    //
    public function createRead()
    {
        $servicos = Servicos::all();
        return view('sistema.servicos.servicos', ['servicos' => $servicos],['page'=>'servicos']);
    }
    public function createStoreServico(){
        return view('sistema.servicos.servicosCadastro', ['page' => 'servicos']);
    }
    public function createStoreTarefas(Request $request){
        $servico =  Servicos::find($request->id);
        $funcionarios = Funcionarios::all();
        return view('sistema.servicos.tarefasCadastro',['servico_id' => $request->id], ['funcionarios'=> $funcionarios],['page'=>'servicos']);
    }

    public function createTipoRead()
    {
        return view('cadastrosSistema.cadastroDeServicos', ['page'=> 'servicos']);
    }

    public function storeTipo(){
        $tipo_servico = new tipo_servico();
        $tipo_servico->nome = request()->input('nome');
        $tipo_servico->categoria = request()->input('categoria');
        $tipo_servico->duracao = request()->input('duracao');
        $tipo_servico->materiais_necessarios = request()->input('materiais_necessarios');
        $tipo_servico->quantidade_de_pessoas = request()->input('quantidade_de_pessoas');
        $tipo_servico->valor = request()->input('valor');
        $tipo_servico->descricao = request()->input('descricao');
        $tipo_servico->save();
        return redirect()->route('servicos.read');
    }

    public function store(Request $request){
        $servicos = new Servicos();
        $servicos->nome = request()->input('nome');
        $servicos->nome_cliente = request()->input('nome_cliente');
        $servicos->identificacao_cliente = request()->input('identificacao_cliente');
        $servicos->tipo_cliente = request()->input('tipo_cliente');
        $servicos->valor= request()->input('valor');
        $servicos->tipo_servico = request()->input('tipo_servico');
        $servicos->quantidade_tarefas = 0;
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
