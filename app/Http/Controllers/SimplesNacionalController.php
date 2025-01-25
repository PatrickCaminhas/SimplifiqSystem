<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimplesNacional;
use App\Models\Empresa_information;
use App\Models\HistoricoFaturamento; // Add this line to import the Faturamento class
use Stancl\Tenancy\Facades\Tenancy;
use Illuminate\Support\Facades\DB;

class SimplesNacionalController extends Controller
{
    //
    public function create()
    {
        $SimplesNacional = SimplesNacional::all();
        return view("administracao.simplesNacional", ['simplesNacional' => $SimplesNacional], ['page' => 'Empresa']);
    }
    public function createCalculadora(Request $request)
    {
        $page = 'Empresa';
        $tabela_vazia = false;
        if ($request->tamanho_empresa == "mei") {
            $simplesMei = $this->calculateMEI();
            return view("sistema.informativo.calculadoraSimplesNacional", compact('simplesMei', 'page', 'tabela_vazia'));

        }
        if(HistoricoFaturamento::get()->isEmpty()){
            $tabela_vazia = true;
            return view('sistema.informativo.calculadoraSimplesNacional',compact('page','tabela_vazia'))->with('success', 'Não há faturamentos cadastrados.',);
        }

        $informacoes = $this->calculoDASAutomatico();

        return view("sistema.informativo.calculadoraSimplesNacional", compact('informacoes', 'page', 'tabela_vazia'));
    }

    public function calculoDASAutomatico2()
    {
        $empresa = Empresa_information::first();
        $faturamentosDeAteDozeMeses = HistoricoFaturamento::orderBy('ano_mes', 'desc')->take(13)->get();
        $Faturamento = array();
        $Faturamento[0] = 0;
        $Faturamento[1] = $faturamentosDeAteDozeMeses[0]->renda_bruta;
        $Faturamento[2] = $faturamentosDeAteDozeMeses[0]->ano_mes;
        for ($i = 1; $i < count($faturamentosDeAteDozeMeses); $i++) {
            $Faturamento[0] += $faturamentosDeAteDozeMeses[$i]->renda_bruta;
        }
        $Faturamento[3] = $Faturamento[0];
        $Faturamento[4] = $faturamentosDeAteDozeMeses->count() - 1;
        $Faturamento[0] = ($Faturamento[0] / $Faturamento[4]) * 12;
        $Faturamento[5] = $Faturamento[0];
        $Faturamento[0] = $this->calculaDAS($Faturamento[0], $Faturamento[1]);
        return $Faturamento;
    }

    public function calculoDASAutomatico()
    {
        $faturamentosDeAteDozeMeses = HistoricoFaturamento::orderBy('ano_mes', 'desc')->take(13)->get();

        // Inicializa as variáveis
        $faturamentoTotal = 0;
        $ultimoMesFaturamento = 0;
        $ultimoMesAnoMes = '';
        $mediaAnual = 0;
        $quantidadeMeses = 0;  // Para contar quantos meses são utilizados


        // Verifica se a empresa tem menos de 1 ano de atividade
        $empresaTemMenosDeUmAno = $this->empresaTemMenosDeUmAno();
        // Itera sobre os faturamentos
        if ($this->empresaTemMenosDeUmAno() < 12) {
            foreach ($faturamentosDeAteDozeMeses as $index => $faturamento) {
                // Verifica se a empresa tem menos de 1 ano e se o mês é o mês atual
                if ($this->empresaTemMenosDeUmAno() < 12 && $index == 0) {
                    // Não inclui o faturamento do mês atual se a empresa tem menos de 1 ano
                    $ultimoMesFaturamento = $faturamento->renda_bruta;
                    $ultimoMesAnoMes = $faturamento->ano_mes;

                    continue;
                } else {

                    // Inclui o faturamento normalmente
                    $faturamentoTotal += $faturamento->renda_bruta;
                    $quantidadeMeses++;  // Contabiliza o número de meses usados
                }
                // Define o último mês de faturamento
                if ($index == 0) {
                    $ultimoMesFaturamento = $faturamento->renda_bruta;
                    $ultimoMesAnoMes = $faturamento->ano_mes;
                }
            }
        } else {

            foreach ($faturamentosDeAteDozeMeses as $index => $faturamento) {
                // Inclui o faturamento normalmente
                if ($index == 0) {
                    $ultimoMesFaturamento = $faturamento->renda_bruta;
                    $ultimoMesAnoMes = $faturamento->ano_mes;

                }else{

                $faturamentoTotal += $faturamento->renda_bruta;
                $quantidadeMeses++;  // Contabiliza o número de meses usados
                }

            }
        }


            // Calcula a média da receita bruta se a empresa for maior que 1 ano, ou aplica a regra proporcional para empresas com menos de 1 ano
            if ($empresaTemMenosDeUmAno < 12) {
                if ($faturamentosDeAteDozeMeses->count() != 1) {
                    $faturamentosDeAteDozeMeses = $faturamentosDeAteDozeMeses->slice(1)->values();
                }

                $rbt12Proporcional = $this->calculaRbt12Proporcional($faturamentosDeAteDozeMeses);

            } else {
                $rbt12Proporcional = $faturamentoTotal / $quantidadeMeses * 12;
            }

            // Calcula o DAS
            $valorDAS = $this->calculaDAS($rbt12Proporcional, $ultimoMesFaturamento);
            $valoresImpostos= $this->reparticaoImposto($valorDAS,$rbt12Proporcional);
            // Retorna os dados

            return [
                'rbt12' => $rbt12Proporcional,
                'ultimo_mes_faturamento' => $ultimoMesFaturamento,
                'ultimo_mes_ano_mes' => $ultimoMesAnoMes,
                'valor_das' => $valorDAS,
                'quantidade_meses' => $quantidadeMeses,
                'faturamento_total' => $faturamentoTotal,
                'valores_impostos' => $valoresImpostos,
            ];

    }

    public function empresaTemMenosDeUmAno()
    {
        $empresa = Empresa_information::first();
        $dataCriacao = \Carbon\Carbon::parse($empresa->data_de_criacao);
        $dataAtual = \Carbon\Carbon::now();
        $empresaTemMenosDeUmAno = ceil($dataCriacao->diffInMonths($dataAtual));

        return $empresaTemMenosDeUmAno;
    }

    public function calculaRbt12Proporcional($faturamentos)
    {
        $totalFaturamento = 0;
        $quantidadeMeses = count($faturamentos);
        // No primeiro mês, a RBT12 proporcional será a receita do próprio mês de apuração multiplicada por doze
        if ($quantidadeMeses == 1) {
            return $faturamentos[0]->renda_bruta * 12;
        }

        // Nos 11 meses seguintes, a RBT12 proporcional será a média aritmética dos meses anteriores multiplicada por 12
        if ($quantidadeMeses <= 11) {
            $media = 0;
            foreach ($faturamentos as $faturamento) {
                $media += $faturamento->renda_bruta;
            }
            $media /= $quantidadeMeses;
            return $media * 12;
        }

        // Para empresas com 12 meses, a RBT12 é calculada pela regra geral
        return $faturamentos->sum('renda_bruta');
    }

    public function reparticaoImposto($valor_das,$renda_bruta_anual){
        $anexo = "Anexo I";
        $simplesNacional = DB::connection('mysql')
            ->table('simples_nacionals')
            ->where('nome_anexo', $anexo)
            ->where('receita_bruta_anual_min', '<=', $renda_bruta_anual)
            ->where('receita_bruta_anual_max', '>=', $renda_bruta_anual)
            ->first();
        $reparticao = DB::connection('mysql')
            ->table('reparticao_tributos')
            ->where('faixa', $simplesNacional->faixa_anexo)
            ->first();
        $cpp = ($reparticao->cpp/100)*$valor_das;
        $csll = ($reparticao->csll/100)*$valor_das;
        $icms = ($reparticao->icms/100)*$valor_das;
        $irpj = ($reparticao->irpj/100)*$valor_das;
        $cofins = ($reparticao->cofins/100)*$valor_das;
        $pis_pasep = ($reparticao->pis_pasep/100)*$valor_das;

        return [
            'cpp' => $cpp,
            'csll' => $csll,
            'icms' => $icms,
            'irpj' => $irpj,
            'cofins' => $cofins,
            'pis_pasep' => $pis_pasep,
        ];
    }

    public function createStore()
    {
        return view("administracao.cadastroSimplesNacional", ['page' => 'Empresa']);
    }
    public function createUpdate()
    {
        return view("administracao.simplesNacionalUpdate", ['page' => 'Empresa']);
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

    public function calculateMEI()
    {
        $empresa = Empresa_information::first();
        $cincoPorcentoSalarioMinAtual = 70.6;
        if ($empresa->tipo_empresa == "comercio" || $empresa->tipo_empresa == "industria") {
            $resultado = $cincoPorcentoSalarioMinAtual + 1;
        } elseif ($empresa->tipo_empresa == "servicos") {
            $resultado = $cincoPorcentoSalarioMinAtual + 5;
        } else {
            $resultado = $cincoPorcentoSalarioMinAtual + 6;
        }
        return $resultado;
    }

    public function calculaDAS($renda_bruta_anual, $valor_bruto_mes)
    {
        // Determina o anexo baseado no tipo da empresa
        $anexo = "Anexo I";



        if (is_null($anexo)) {
            return redirect()->route('simples.create.calculadora')->with('error', 'Tipo de empresa inválido!');
        }

        // Obtém as alíquotas e deduções da tabela Simples Nacional
        $simplesNacional = DB::connection('mysql')
            ->table('simples_nacionals')
            ->where('nome_anexo', $anexo)
            ->where('receita_bruta_anual_min', '<=', $renda_bruta_anual)
            ->where('receita_bruta_anual_max', '>=', $renda_bruta_anual)
            ->first();

        if ($simplesNacional) {
            $aliquota = $simplesNacional->aliquota;
            $deducao = $simplesNacional->deducao;

            // Cálculo do DAS
            $aliquotaEfetiva = ((($renda_bruta_anual * ($aliquota / 100)) - $deducao) / $renda_bruta_anual);


            $aliquotaEfetiva = round($aliquotaEfetiva, 4);


            $resultado = $aliquotaEfetiva * $valor_bruto_mes;
            return $resultado;
        } else {
            return "erro";
        }
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'receita_bruta_anual' => 'required|numeric|regex:/^\d{1,9}(\.\d{1,2})?$/',
            'receita_bruta_mes' => 'required|numeric|regex:/^\d{1,9}(\.\d{1,2})?$/',
        ]);
        $valor_bruto_anual = $request->input('receita_bruta_anual');
        $valor_bruto_mes = $request->input('receita_bruta_mes');
        $resultado = $this->calculaDAS($valor_bruto_anual, $valor_bruto_mes);
        if ($resultado != "erro") {
            return redirect()->route('simples.create.calculadora')->with('valor', "A previsão de imposto do DAS é de R$" . number_format($resultado, 2, ',', '.'));
        } else {
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
