<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimplesNacional;
use App\Models\Empresa_information;
use App\Models\HistoricoFaturamento; // Add this line to import the Faturamento class
use Stancl\Tenancy\Facades\Tenancy;

class SimplesNacionalController extends Controller
{
    //
    public function create()
    {
        $SimplesNacional = SimplesNacional::all();
        return view("administracao.simplesNacional", ['simplesNacional' => $SimplesNacional], ['page' => 'empresa']);
    }
    public function createCalculadora(Request $request)
    {
        if($request->tamanho_empresa == "mei"){
            $simplesMei = $this->calculateMEI();
            return view("sistema.informativo.calculadoraSimplesNacional", ['empresa' => 'simplesNacional', 'simplesMei' => $simplesMei]);

        }
        $calculoAutomatico= $this->calculoDASAutomatico();
        return view("sistema.informativo.calculadoraSimplesNacional",['informacoes' => $calculoAutomatico], ['page' => 'empresa']);
    }

    public function calculoDASAutomatico(){
        $empresa = Empresa_information::first();
        $faturamentosDeAteDozeMeses = HistoricoFaturamento::orderBy('ano_mes', 'desc')->take(13)->get();
        $Faturamento = array();
        $Faturamento[0]=0;
        $Faturamento[1]=$faturamentosDeAteDozeMeses[0]->renda_bruta;
        $Faturamento[2]=$faturamentosDeAteDozeMeses[0]->ano_mes;
        for($i= 1; $i < count($faturamentosDeAteDozeMeses); $i++){
            $Faturamento[0] += $faturamentosDeAteDozeMeses[$i]->renda_bruta;
        }
        $Faturamento[3]= $Faturamento[0];
        $Faturamento[4]= $faturamentosDeAteDozeMeses->count()-1;
        $Faturamento[0]= ($Faturamento[0]/$Faturamento[4])*12;
        $Faturamento[5]= $Faturamento[0];
        $Faturamento[0]= $this->calculaDAS($Faturamento[0], $Faturamento[1], $empresa);
        return $Faturamento;
    }
    public function createStore()
    {
        return view("administracao.cadastroSimplesNacional", ['page' => 'empresa']);
    }
    public function createUpdate()
    {
        return view("administracao.simplesNacionalUpdate", ['page' => 'empresa']);
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

    public function calculateMEI(){
        $empresa = Empresa_information::first();
        $cincoPorcentoSalarioMinAtual = 70.6;
        if($empresa->tipo_empresa =="comercio" || $empresa->tipo_empresa =="industria"){
            $resultado= $cincoPorcentoSalarioMinAtual + 1;
        }
        elseif($empresa->tipo_empresa =="servicos"){
            $resultado= $cincoPorcentoSalarioMinAtual + 5;
        }
        else{
            $resultado= $cincoPorcentoSalarioMinAtual + 6;
        }
        return $resultado;
    }

    public function calculaDAS($renda_bruta_anual, $valor_bruto_mes, $empresa)
    {
        // Determina o anexo baseado no tipo da empresa
        $anexo = match ($empresa->tipo_empresa) {
            'comercio' => 1,
            'industria' => 2,
            'servicos' => 3,
            default => null,
        };

        if (is_null($anexo)) {
            return redirect()->route('simples.create.calculadora')->with('error', 'Tipo de empresa inválido!');
        }

        // Obtém as alíquotas e deduções da tabela Simples Nacional
        $simplesNacional = \DB::connection('mysql')
            ->table('simples_nacionals')
            ->where('nome_anexo', $anexo)
            ->where('receita_bruta_anual_min', '<=', $renda_bruta_anual)
            ->where('receita_bruta_anual_max', '>=', $renda_bruta_anual)
            ->first();

        if ($simplesNacional) {
            $aliquota = $simplesNacional->aliquota;
            $deducao = $simplesNacional->deducao;

            // Cálculo do DAS
            $resultado = ((($renda_bruta_anual * ($aliquota / 100)) - $deducao) / $renda_bruta_anual) * $valor_bruto_mes;
            return $resultado;
        } else {
            return "erro";
        }
    }

    public function calculate(Request $request)
    {
        $empresa = Empresa_information::first();

        $request->validate([
            'receita_bruta_anual' => 'required|numeric|regex:/^\d{1,9}(\.\d{1,2})?$/',
            'receita_bruta_mes' => 'required|numeric|regex:/^\d{1,9}(\.\d{1,2})?$/',
        ]);

        $valor_bruto_anual = $request->input('receita_bruta_anual');
        $valor_bruto_mes = $request->input('receita_bruta_mes');
        $resultado = $this->calculaDAS($valor_bruto_anual, $valor_bruto_mes, $empresa);
        if($resultado != "erro"){
            return redirect()->route('simples.create.calculadora')->with('valor', "A previsão de imposto do DAS é de R$".number_format($resultado, 2,',','.'));
        }
        else{
            return redirect()->route('simples.create.calculadora')->with('error', 'Registro não encontrado!');
        }
    }



    public function teste()
    {
        /*
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
        */

    }
}
