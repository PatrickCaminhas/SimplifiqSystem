<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Vendas</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')
    <div class=" d-flex align-items-center justify-content-center" style="height: 91vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="text-center">Alterar preço de venda</h2>
                            <form method="POST" action="{{ route('cadastroproduto.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="nomeproduto">Produto: {{$produto->nome . " " . $produto->modelo . " " . $produto->marca }}</label>
                                    <label for="precoAtual">Preço atual: R$ {{$produto->preco_venda}}</label>
                                </div>
                                <div class="form-group">
                                    <label for="medidaproduto">Novo preço</label>
                                    <input type="number" class="form-control" id="medidaproduto" name="medida"
                                        min='1' placeholder="Digite o novo preço">
                                </div>

                                <div class="text-center mt-1">
                                    <button type="submit"
                                        class="btn @include('partials.buttomCollor') text-center">Alterar</button>
                                    <button type="reset"
                                        class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
