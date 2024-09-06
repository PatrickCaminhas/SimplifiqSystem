<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contas; // Import the Contas class
use App\Helpers\DespesaHelper;

class DashboardController extends Controller
{
    public function index()
    {
        $contas = Contas::all();
        $despesasPorMes = DespesaHelper::despesasUltimosSeisMeses();

        return view('sistema\dashboard', ['contas' => $contas,'page'=>'dashboard','despesasPorMes' => $despesasPorMes]);
    }

    public function cadastros(){

        return view('sistema\cadastrosSistema\cadastros',['page'=> 'cadastros']);
    }

    // Adicione outros métodos conforme necessário
}
