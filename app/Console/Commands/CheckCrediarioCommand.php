<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Vendas;
use App\Models\Clientes;

class CheckCrediarioCommand extends Command
{
    /**
     * O nome e assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'crediario:check';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Verifica as vendas a crediário e atualiza o status de pagamento dos clientes';

    /**
     * Executa o comando.
     *
     * @return int
     */
    public function handle()
    {
        // Busca todas as vendas com método "Crediário" ou "Crediário(Pago Parcial)"
        $vendas = Vendas::whereIn('metodo_pagamento', ['Crediário', 'Crediário(Pago Parcial)'])->get();

        foreach ($vendas as $venda) {
            // Converte a data da venda para um objeto Carbon
            $dataVenda = Carbon::createFromFormat('Y-m-d', $venda->data_venda);
            // Define a data limite de pagamento: data da venda + 1 mês
            $dataLimite = $dataVenda->copy()->addMonth();

            // Se a data atual for maior que a data limite, o prazo para pagamento expirou
            if (Carbon::today()->gt($dataLimite)) {

                // Se não foi quitada, transfere o valor para a coluna de débitos do cliente
                $cliente = Clientes::find($venda->cliente_id);
                if ($cliente) {
                    // Reduz o valor do crediário e aumenta o débito
                    $cliente->crediario -= $venda->crediario;
                    $cliente->debitos += $venda->crediario;
                    $cliente->save();
                }

            }
        }
        $this->info('Verificação de crediário concluída com sucesso!');
        return 0;
    }
    /**
     * Função para verificar se a venda foi quitada.
     * Aqui você implementa a lógica de verificação conforme seu sistema.
     */

}
