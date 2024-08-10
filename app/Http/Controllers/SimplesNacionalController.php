<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimplesNacional;
use App\Models\Empresa_information;

class SimplesNacionalController extends Controller
{
    //
    public function create()
    {
        $SimplesNacional = SimplesNacional::all();
        return view("administracao.simplesNacional", ['simplesNacional' => $SimplesNacional], ['page' => 'simplesNacional']);
    }
    public function createStore()
    {
        return view("administracao.cadastroSimplesNacional", ['page' => 'simplesNacional']);
    }
    public function createUpdate()
    {
        return view("administracao.simplesNacionalUpdate", ['page' => 'simplesNacional']);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nome_anexo' => 'required|string',
            'faixa_anexo' => 'required|string',
            'receita_bruta_anual_min' => [
                'required',
                'numeric',
                'between:0,4800000.99',
            ],
            'receita_bruta_anual_max' => [
                'required',
                'numeric',
                'between:0,4800000.99',
            ],
            'aliquota' => [
                'required',
                'numeric',
                'between:0,99.99',
            ],
            'deducao' => [
                'required',
                'numeric',
                'between:0,999999.99',
            ],
        ]);

        $verifica = SimplesNacional::where('nome_anexo', $request->input('nome_anexo'))->where('faixa_anexo', $request->input('faixa_anexo'))->first();
        if ($verifica) {
            return redirect()->route('simples.create')->with('error', 'Já existe um anexo com essa faixa cadastrada.');
        }

        $simplesNacional = SimplesNacional::create([
            'nome_anexo' => $request->input('nome_anexo'),
            'faixa_anexo' => $request->input('faixa_anexo'),
            'receita_bruta_anual_min' => $request->input('receita_bruta_anual_min'),
            'receita_bruta_anual_max' => $request->input('receita_bruta_anual_max'),
            'aliquota' => $request->input('aliquota'),
            'deducao' => $request->input('deducao'),
        ]);
        $simplesNacional->save();
        return redirect()->route('simples.create')->with('success', 'Faixa cadastrada com sucesso.');

    }

    public function update(Request $request)
    {
        $request->validate([
            'nome_anexo' => 'required|string',
            'faixa_anexo' => 'required|string',
            'receita_bruta_anual_min' => 'required|numeric|regex:/^\d{1,9}(\.\d{1,2})?$/',
            'receita_bruta_anual_max' => 'required|numeric|regex:/^\d{1,9}(\.\d{1,2})?$/',
            'aliquota' => 'required|numeric|regex:/^\d{1,2}(\.\d{1,2})?$/',
            'deducao' => 'required|numeric|regex:/^\d{1,8}(\.\d{1,2})?$/',
        ]);
        $simplesNacional = SimplesNacional::where('nome_anexo', $request->input('nome_anexo'))
            ->where('faixa_anexo', $request->input('faixa_anexo'))
            ->first();
            if ($simplesNacional) {
                $simplesNacional->receita_bruta_anual_min = $request->input('receita_bruta_anual_min');
                $simplesNacional->receita_bruta_anual_max = $request->input('receita_bruta_anual_max');
                $simplesNacional->aliquota = $request->input('aliquota');
                $simplesNacional->deducao = $request->input('deducao');
                $simplesNacional->save();

                return redirect()->route('simples.create')->with('success', 'Registro atualizado com sucesso!');
            } else {
                return redirect()->route('simples.create')->with('error', 'Registro não encontrado!');
            }
    }

    public function calculate(Request $request)
    {
        $empresa = Empresa_information::first();
        $request->validate([
            'receita_bruta_anual' => 'required|numeric|regex:/^\d{1,9}(\.\d{1,2})?$/',
            'receita_bruta_mes' => 'required|numeric|regex:/^\d{1,9}(\.\d{1,2})?$/',

        ]);
        $simplesNacional = simplesNacional::find($empresa->tipo_empresa); //COLOCAR MAIS DE UM VALOR DE PROCURA, TIPO EMPRESA E RAMO DO MERCADO
        $receita_bruta_anual = $request->receita_bruta_anual;
        $receita_mes = $request->receita_mes;
        if ($empresa->tipo_empresa == "Comercio")////////////////////////////////ALTERAR PARA VALORES DO BANCO DE DADOS
        {
            if ($receita_bruta_anual <= 180000) {
                $aliquota = 4;
                $deducao = 0;
            }////////////////////////////////ALTERAR PARA VALORES DO BANCO DE DADOS
            else if ($receita_bruta_anual >= 180000.01 || $receita_bruta_anual <= 360000) {
                $aliquota = 7.3;
                $deducao = 5940;
            } else if ($receita_bruta_anual >= 360000.01 || $receita_bruta_anual <= 720000) {
                $aliquota = 9.5;
                $deducao = 13860;
            } else if ($receita_bruta_anual >= 720000.01 || $receita_bruta_anual <= 1800000) {
                $aliquota = 10.7;
                $deducao = 22500;
            } else if ($receita_bruta_anual >= 1800000.01 || $receita_bruta_anual <= 3600000) {
                $aliquota = 14.3;
                $deducao = 87300;
            } else {
                $aliquota = 19;
                $deducao = 378000;
            }
        }
        if ($empresa->tipo_empresa == "Industria")////////////////////////////////ALTERAR PARA VALORES DO BANCO DE DADOS
        {
            if ($receita_bruta_anual <= 180000) {
                $aliquota = 4.5;
                $deducao = 0;
            } else if ($receita_bruta_anual >= 180000.01 || $receita_bruta_anual <= 360000) {
                $aliquota = 7.8;
                $deducao = 5940;
            } else if ($receita_bruta_anual >= 360000.01 || $receita_bruta_anual <= 720000) {
                $aliquota = 10;
                $deducao = 13860;
            } else if ($receita_bruta_anual >= 720000.01 || $receita_bruta_anual <= 1800000) {
                $aliquota = 11.2;
                $deducao = 22500;
            } else if ($receita_bruta_anual >= 1800000.01 || $receita_bruta_anual <= 3600000) {
                $aliquota = 14.7;
                $deducao = 85500;
            } else {
                $aliquota = 30;
                $deducao = 720000;
            }
        }
        if ($empresa->tipo_empresa == "Servicos")////////////////////////////////ALTERAR PARA VALORES DO BANCO DE DADOS
        {
            if ($receita_bruta_anual <= 180000) {
                $aliquota = 4.5;
                $deducao = 0;
            } else if ($receita_bruta_anual >= 180000.01 || $receita_bruta_anual <= 360000) {
                $aliquota = 7.8;
                $deducao = 0;
            } else if ($receita_bruta_anual >= 360000.01 || $receita_bruta_anual <= 720000) {
                $aliquota = 10;
                $deducao = 0;
            } else if ($receita_bruta_anual >= 720000.01 || $receita_bruta_anual <= 1800000) {
                $aliquota = 11.2;
                $deducao = 0;
            } else if ($receita_bruta_anual >= 1800000.01 || $receita_bruta_anual <= 3600000) {
                $aliquota = 14.7;
                $deducao = 0;
            } else
                $aliquota = 30;
        }
        ////////////////////////////////ALTERAR PARA VALORES DO BANCO DE DADOS
        $resultado = ((($receita_bruta_anual * ($aliquota / 100)) - $deducao) / $receita_bruta_anual) * $receita_mes;
        return view('administracao.simplesNacional', ['valor' => $resultado]);
    }
}
