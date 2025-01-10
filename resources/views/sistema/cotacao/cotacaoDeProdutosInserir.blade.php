<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Cotação</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body class="bg-dark">
    <!-- Menu superior -->
    @include('partials.header')
    <div class="container mt-4 mb-4 bg-light text-dark">
        <div class="row">
            <div class="col-12 text-center" style="overflow: auto;">
                <h4 class="display-6">Cotação de Produtos</h4>
                @include('partials.errorAndSuccess')
                <form method="POST" action="{{ route('inserir.cotacao') }}">
                    @csrf
                    <table class="col-12 table table-striped table-hover table-secondary">
                        <thead>
                            <input type="hidden" name="fornecedores" value="{{ json_encode($fornecedores->pluck('id')->toArray()) }}">
                            <input type="hidden" name="produtos" value="{{ json_encode($produtos->pluck('id')->toArray()) }}">
                            
                            <tr class="text-light">
                                <th scope="col">Produto</th>
                                @foreach ($fornecedores as $fornecedor)
                                    <th scope="col-3">{{ $fornecedor->nome }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                                <tr>
                                    <td>
                                        <a>{{ $produto->nome }} {{ $produto->modelo }} {{ $produto->marca }}</a>
                                    </td>
                                    @foreach ($fornecedores as $fornecedor)
                                        <td>
                                            <input type="number" class="form-control"
                                                name="cotacao[{{ $produto->id }}][{{ $fornecedor->id }}]"
                                                step="0.01" placeholder="Digite o preço">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center mt-2 mb-4">
                        <button type="submit" class="btn @include('partials.buttomCollor') text-center">Salvar</button>
                        <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para alterar o ID dos inputs -->

</body>

</html>
