<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metas;
use App\Models\MetasProgresso;

class MetasController extends Controller
{
    //
    public function createRead()
    {
        $metas = Metas::all();
        return view('sistema.metas.metas', ['metas' => $metas]);
    }
    public function createStoreMeta(){
        return view('sistema.metas.metasCadastro');
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
        if($meta->valor_atual> $meta->valor && $meta->ending_at > date('Y-m-d') && $meta->estado == 'Pendente'){
            $meta->estado = 'Cumprida';
        }
        $meta->save();
        return redirect()->route('metas.read');
    }


}
