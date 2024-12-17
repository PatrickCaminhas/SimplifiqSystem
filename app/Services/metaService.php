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

    public function removerProgresso($dados)
    {
        // Registrar progresso negativo no histórico
        $metaProgresso = new MetasProgresso();
        $metaProgresso->meta_id = $dados->meta_id;
        $metaProgresso->valor = -$dados->valor; // Progresso negativo
        $metaProgresso->save();

        $meta = Metas::find($dados->meta_id);
        if ($meta) {
            $meta->valor_atual -= $dados->valor;

            // Garantir que o valor atual não seja negativo
            if ($meta->valor_atual < 0) {
                $meta->valor_atual = 0;
            }

            // Atualizar estado da meta se necessário
            if ($meta->valor_atual < $meta->valor && $meta->estado == 'Cumprida') {
                $meta->estado = 'Pendente';
            }
            $meta->save();
        }
    }
    public function removerProgressoEmTodasMetasAbertas($valor)
    {
        $metas = $this->buscarMetasEmAberto();
        foreach ($metas as $meta) {
            $this->removerProgresso((object)['meta_id' => $meta->id, 'valor' => $valor]);
        }
    }
}
