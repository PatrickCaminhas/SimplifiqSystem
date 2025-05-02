<!DOCTYPE html>
<html lang="pt-br">
@php
    $page = "Cotação Nº". $id_cotacao . " - " . $dataCotacao . " / " . $nomeEmpresa  ;
@endphp
@include('partials.head')


<body class="bg-white">
    <div class=" mt-4 mb-4">
        <div class="row">
            <div class="col-12 text-center">
                <h4 class="display-6">Resultados da Cotação</h4>
                <div class="text-start mt-4">
                    <p><strong>Nome da empresa:</strong> {{ $nomeEmpresa }}</p>
                    <p><strong>Data da cotação:</strong> {{ $dataCotacao}}</p>
                </div>

                <table class="table table-str   iped">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Fornecedor</th>
                            <th>Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cotacoes as $cotacao)
                            <tr>

                                <td>{{ $cotacao->produto->nome . " " . $cotacao->produto->modelo . " " . $cotacao->produto->marca  }}</td>
                                <td>{{ $cotacao->fornecedor->nome }}</td>
                                <td>R$ {{ number_format($cotacao->preco, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
  					<button class="btn btn-dark no-print" onclick="window.print()"><i class="bi bi-floppy-fill"></i>Salvar</button>
                    <a href="{{ route('cotacao.lista') }}" class="btn btn-primary no-print"><i class="bi bi-arrow-return-left"></i>Voltar ao sistema</a>
                </div>
            </div>
        </div>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
