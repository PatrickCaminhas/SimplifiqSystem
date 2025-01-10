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







    <div class="col-md-8 col-sm-12 container mt-4 mb-4 bg-light text-dark">
        <div class="row">
            <div class="text-center" style="overflow: auto;">
                <h4 class="display-6">Cotação de Produtos</h4>
                @if ($checagem != 'true')
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Atenção!</h4>
                        @if ($checagem == 'produtos')
                            <p>Para realizar uma cotação é necessário ter produtos cadastrados no sistema.</p>
                        @elseif($checagem == 'fornecedores')
                            <p>Para realizar uma cotação é necessário ter fornecedores cadastrados no sistema.</p>
                        @else
                            <p>Para realizar uma cotação é necessário ter produtos e fornecedores cadastrados no
                                sistema.</p>
                        @endif
                    </div>
                @else
                    <form method="POST" action="{{ route('cotacao.produtos.selecionados') }}">
                        @csrf
                        <table class="table table-striped table-hover table-secondary">
                            <thead>
                                <tr class="text-light">
                                    <th scope="col">Estoque</th>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Selecione</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produtos as $produto)
                                    <tr>
                                        <td>
                                            <span>{{ $produto->quantidade }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $produto->nome }} {{ $produto->modelo }}
                                                {{ $produto->marca }}</span>
                                        </td>
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="produtos[]"
                                                value="{{ $produto->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center mt-2 mb-4">
                            <button type="submit" class="btn @include('partials.buttomCollor') text-center">Avançar</button>
                            <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
