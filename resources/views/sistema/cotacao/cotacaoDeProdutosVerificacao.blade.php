@extends('layouts.padrao')
@section('conteudo')
    <div class="col-md-10 col-sm-12 container mt-4 mb-4 bg-light text-dark">
        <div class="row">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-start" style="overflow: auto;">
                        <a href="@yield('voltar', '/cotacoes')" class="btn @include('partials.buttomCollor') text-center""> <i
                                class="bi bi-arrow-return-left"></i> Voltar</a>

                        <div class=text-center>
                            <h4 class="display-6">Verificação de valores </h4>
                            <h5>Cotação de Produtos #{{ $cotacao->id }} Data:
                                {{ \Carbon\Carbon::parse($cotacao->data_cotacao)->format('d/m/Y') }}</h5>
                        </div>
                        <form method="POST" action="">
                            @csrf

                            <table class="table rounded table-bordered border @include('partials.borderCollor') border-2 table-white">
                                <thead>
                                    <tr class="text-light">
                                        <th scope="col">Produto</th>
                                        <th scope="col">Fornecedor</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">Preço unitário</th>
                                        <th scope="col">Preço total</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($itens as $item_cotacao)
                                        <tr>
                                            <td>
                                                <span>{{ $item_cotacao->produto->nome }}
                                                    {{ $item_cotacao->produto->modelo }}
                                                    {{ $item_cotacao->produto->marca }}</span>
                                            </td>
                                            <td>
                                                <span>{{ $item_cotacao->fornecedor->nome }}</span>
                                            <td>
                                                <div class="btn-group">

                                                    <input type="number" name="produtos[]" class="form-control @include('partials.borderCollor')"
                                                        min="0" step="1">
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <span>R$ {{ number_format($item_cotacao->preco, 2, ',', '.') }}</span>
                                            <td class="text-break fw-medium text-end">
                                                <span id="totalProduto{{ $item_cotacao->id }}">R$ 0,00</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center mt-2 mb-4">
                                <label class="fw-bold">Total da cotação: </label><span id="totalCotacao"> R$ 0,00</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputsQuantidade = document.querySelectorAll('input[name="produtos[]"]');
            const totalCotacaoSpan = document.getElementById("totalCotacao");

            function atualizarTotais() {
                let totalCotacao = 0;

                inputsQuantidade.forEach(input => {
                    const row = input.closest("tr"); // Obtém a linha da tabela
                    const precoUnitario = parseFloat(row.querySelector("td:nth-child(4) span").textContent
                        .replace("R$", "").replace(",", ".").trim()); // Obtém o preço unitário
                    let quantidade = parseInt(input.value) || 0; // Converte para inteiro e impede NaN
                    quantidade = Math.max(0, quantidade); // Garante que a quantidade nunca seja negativa

                    input.value = quantidade; // Atualiza o campo para garantir que só tenha inteiros

                    const totalProduto = precoUnitario * quantidade; // Calcula o total do produto

                    // Atualiza o total do produto na tabela
                    const totalProdutoSpan = row.querySelector("td:nth-child(5) span");
                    totalProdutoSpan.textContent = `R$ ${totalProduto.toFixed(2).replace(".", ",")}`;

                    // Soma ao total da cotação
                    totalCotacao += totalProduto;
                });

                // Atualiza o total da cotação
                totalCotacaoSpan.textContent = ` R$ ${totalCotacao.toFixed(2).replace(".", ",")}`;
            }

            // Adiciona evento de input para recalcular sempre que houver mudança na quantidade
            inputsQuantidade.forEach(input => {
                input.addEventListener("input", atualizarTotais);
            });
        });
    </script>
@endpush
