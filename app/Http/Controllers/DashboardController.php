<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contas; // Import the Contas class

class DashboardController extends Controller
{
    public function index()
    {
        $contas = Contas::all();

        return view('sistema\dashboard', ['contas' => $contas],['page'=>'dashboard']);
    }

    public function cadastros(){

        return view('sistema\cadastrosSistema\cadastros',['page'=> 'cadastros']);
    }

    // Adicione outros métodos conforme necessário
}
