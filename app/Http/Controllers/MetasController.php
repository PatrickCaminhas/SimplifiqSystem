<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metas;
use App\Models\MetasProgresso;
use ConsoleTVs\Charts\Facades\Charts;
use Carbon\Carbon;



class MetasController extends Controller
{
    //
    public function createRead()
    {
        $metas = Metas::all();
        return view('sistema.metas.metas', ['metas' => $metas], ['page' => 'metas']);
    }
    public function createStoreMeta()
    {
        return view('sistema.metas.metasCadastro', ['page' => 'metas']);
    }

    public function createInformacoes(Request $Request)
    {
        $meta = Metas::find($Request->input('meta_id'));
        $progressos = MetasProgresso::where('meta_id', $Request->input('meta_id'))->get();
        $informacoes = new \stdClass();
        $informacoes->data_inicial = Carbon::parse($meta->created_at)->format('d/m/Y');
        $informacoes->data_final = Carbon::parse($meta->ending_at)->format('d/m/Y');
        $dataMaisAtual = $this->dataMaisAtual($progressos);
        $diferencaDias = $this->diferencaDias($dataMaisAtual, $meta->ending_at);
        $informacoes->diaComMaiorProgresso = $this->diaComMaiorProgresso($progressos);
        $informacoes->maiorProgresso = $this->maiorProgresso($progressos);
        $informacoes->diaComMenorProgresso = $this->diaComMenorProgresso($progressos);
        $informacoes->menorProgresso = $this->menorProgresso($progressos);

        $informacoes->diferencaDias = $diferencaDias;
        $informacoes->UltimoProgresso = Carbon::parse($dataMaisAtual)->format('d/m/Y');
        $informacoes->porcentagem = $this->porcentagem($meta);
        $informacoes->total = "R$" . $this->valorExcedidoOuFaltante($meta);
        $informacoes->estado = $meta->estado;


        return view('sistema.metas.metasInformacoes', ['meta' => $meta, 'progressos' => $progressos, 'informacoes' => $informacoes], ['page' => 'metas']);
    }

    public function store(Request $request)
    {
        $meta = new Metas();
        $meta->valor = $request->input('valor');
        $meta->valor_atual = 0;
        $meta->ending_at = $request->input('ending_at');
        $meta->estado = 'Pendente';
        $meta->save();
        return redirect()->route('metas.read');
    }

    public function storeProgresso(Request $request)
    {
        $metaProgresso = new MetasProgresso();
        $metaProgresso->meta_id = $request->input('meta_id');
        $metaProgresso->valor = $request->input('valor');
        $metaProgresso->save();
        $meta = Metas::find($request->input('meta_id'));
        $meta->valor_atual += $request->input('valor');
        if ($meta->valor_atual > $meta->valor && $meta->ending_at > date('Y-m-d') && $meta->estado == 'Pendente') {
            $meta->estado = 'Cumprida';
        }
        $meta->save();
        return redirect()->route('metas.read');
    }

    public function diferencaDias($data1, $data2)
    {
        $data1 = Carbon::parse($data1);
        $data2 = Carbon::parse($data2);
        return $data1->diffInDays($data2);
    }
    public function dataMaisAtual($progressos)
    {
        $dataMaisAtual = $progressos->max('created_at');
        return Carbon::parse($dataMaisAtual)->format('d-m-Y');
    }

    public function diaComMaiorProgresso($progressos)
    {
        $progresso = $progressos->where('valor', $this->maiorProgresso($progressos))->first();
        return Carbon::parse($progresso->created_at)->format('d/m/Y');
    }
    public function maiorProgresso($progressos)
    {
        return $progressos->max('valor');
    }

    public function diaComMenorProgresso($progressos)
    {

        $progresso = $progressos->where('valor', $this->menorProgresso($progressos))->first();
        return Carbon::parse($progresso->created_at)->format('d/m/Y');
    }

    public function menorProgresso($progressos)
    {
        return $progressos->min('valor');
    }

    public function valorExcedidoOuFaltante($meta)
    {
        if ($meta->valor_atual > $meta->valor) {
            return number_format($meta->valor_atual - $meta->valor, 2);
        } else {
            return number_format($meta->valor - $meta->valor_atual, 2);
        }
    }
    public function porcentagem($meta)
    {
        $porcentegem = ($meta->valor_atual * 100) / $meta->valor;
        if ($porcentegem > 100) {
            $porcentegem -= 100;
        } else if ($porcentegem < 100) {
            $porcentegem = 100 - $porcentegem;
        }
        if ($porcentegem == 100) {
            $porcentegem = 0;
        }
        return number_format($porcentegem, 2) . "%";
    }

}
