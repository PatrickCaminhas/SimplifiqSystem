<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Simplifiq</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body class=bg-dark>
     <!-- Menu superior -->
     @include('partials.header')







    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title display-6 text-center">PRODUTO {{ ucfirst($produto->nome)}}</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Informações do produto</h5>
                                    <p class="card-text">Nome: {{$produto->id}}</p>
                                    <p class="card-text">Nome: {{$produto->nome}}</p>
                                    <p class="card-text">Categoria: {{$produto->categoria}}</p>
                                    <p class="card-text">Valor Compra: R$ {{$produto->preco_compra}}</p>
                                    <p class="card-text">Ultimo fornecedor: {{$produto->ultimo_fornecedor}}</p>
                                    <p class="card-text">Quantidade: {{$produto->quantidade}}</p>
                                </div>
                                <div class="col-6">
                                    <p class="card-text">Preço: {{$produto->preco_venda}}</p>
                                    <p class="card-text">Descrição: {{$produto->descricao}}</p>
                                    <h5 class="card-title">Ações</h5>
                                    <p href="#" class="btn btn-primary">Editar</p>
                                    <p href="#" class="btn btn-danger">Excluir</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Fácil de Usar</h5>
                                <p class="card-text">
                                    aaa

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Fornecedores por % de produto</h5>
                                <img src="{{ global_asset('img/Screenshot_2.png') }}" alt="Descrição da Imagem" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Proximas contas</h5>
                                <table class="table table-light  border table-dorder table-hover">
                                    <thead class="table-group-divider">
                                        <tr class="">
                                            <th class=" ">Data</th>
                                            <th class="">Conta</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider ">
                                        <tr class="text-danger">
                                            <th class="text-danger">03/05</th>
                                            <th class="text-danger">Energia eletrica</th>
                                        </tr>
                                        <tr class="">
                                            <th class="">11/05</th>
                                            <th class="">Pedido #00077</th>
                                        </tr>
                                        <tr class="">
                                            <th class="">15/05</th>
                                            <th class="">Água e esgoto</th>
                                        </tr>
                                        <tr class="">
                                            <th class="">15/05</th>
                                            <th class="">Pedido #00078</th>
                                        </tr>
                                        <tr class="">
                                            <th class="">19/05</th>
                                            <th class="">Aluguel</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="btn @include('partials.buttomCollor')">Ver todas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5 col-lg-6 col-md-8 col-sm-12 mb-5">
                <div class="row">
                    <div class="col-6">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Variação de custo unitário</h5>
                                <img src="{{ global_asset('img/Screenshot_3.png') }}" alt="Descrição da Imagem"
                                    class="img-fluid">

                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Variação de preço</h5>
                                <img src="{{ global_asset('img/Screenshot_3.png') }}" alt="Descrição da Imagem"
                                    class="img-fluid">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Features Section -->

            <!-- Inclua os arquivos JavaScript do Bootstrap -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
