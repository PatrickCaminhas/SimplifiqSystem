<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Cotação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col-12 text-center">
                <h4 class="display-6">Resultados da Cotação</h4>
                <div class="text-start mt-4">
                    <p><strong>Nome da empresa:</strong> {{ $nomeEmpresa }}</p>
                    <p><strong>Data da cotação:</strong> {{ $dataCotacao }}</p>
                </div>

                <table class="table table-striped">
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
                                <td>{{ $cotacao->produto->nome }}</td>
                                <td>{{ $cotacao->fornecedor->nome }}</td>
                                <td>R$ {{ number_format($cotacao->preco, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Voltar ao Dashboard</a>
                    <button class="btn btn-dark" onclick="window.print()">Salvar em PDF/Imprimir</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
