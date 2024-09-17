<?php
namespace App\Services;

use App\Models\Metas;
use App\Models\MetasProgresso;
class metaService
{
    public function cadastrarProgresso($dados)
    {
        $metaProgresso = new MetasProgresso();
        $metaProgresso->meta_id = $dados->meta_id;
        $metaProgresso->valor = $dados->valor;
        $metaProgresso->save();
        $meta = Metas::find($dados->meta_id);

        $meta->valor_atual += $dados->valor;

        if ($meta->valor_atual > $meta->valor && $meta->ending_at > date('Y-m-d') && $meta->estado == 'Pendente') {
            $meta->estado = 'Cumprida';
        }
        $meta->save();
    }
    public function buscarMetasEmAberto()
    {
        // Busca metas que o estado seja diferente de 'Não cumprida' e 'Finalizada'
        $metasEmAberto = Metas::whereNotIn('estado', ['Não cumprida', 'Finalizada'])->get();

        return $metasEmAberto;
    }

    public function cadastrarProgressoEmTodasMetasAbertas($valor)
    {
        $metas = $this->buscarMetasEmAberto();
        foreach ($metas as $meta) {
            //chamar cadastrarProgresso
            $this->cadastrarProgresso((object)['meta_id' => $meta->id, 'valor' => $valor]);
        }
    }
}
