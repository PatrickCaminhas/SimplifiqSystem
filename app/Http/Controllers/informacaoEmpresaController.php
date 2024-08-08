<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa_information;

class informacaoEmpresaController extends Controller
{
    //
    public function createRead()
    {
        $informacaoEmpresa = Empresa_information::first();
        return view('sistema.informativo.informacaoEmpresa', ['informacaoEmpresa' => $informacaoEmpresa],['page'=>'informacaoEmpresa']);
    }
}
