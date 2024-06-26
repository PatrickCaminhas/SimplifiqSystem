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
    <nav class="navbar navbar-expand-lg navbar-light bg-success sticky-top">
        <div class="container-fluid">
            <!-- Botão de menu offcanvas -->
            <button class="navbar-dark btn btn-success text-light " type="button" data-bs-toggle="offcanvas"
                data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
                <span class=" navbar-toggler-icon "></span>
            </button>
            <!-- Nome da aplicação -->
            <span class="navbar-brand mx-auto text-light " style="font-family: 'Quicksand', sans-serif;"><b>Simplifiq
                    System</b></span>
            <!-- Botão para offcanvas de notificações -->
            <button class="btn btn-success border border-light " type="button" data-bs-toggle="offcanvas"
                data-bs-target="#notificacoesOffcanvas" aria-controls="notificacoesOffcanvas">
                Notificações
            </button>
        </div>
    </nav>

    <!-- Offcanvas para o menu -->
    <div class="offcanvas navbar-dark offcanvas-start bg-success text-light" tabindex="-1" id="menuOffcanvas"
        aria-labelledby="menuOffcanvasLabel">
        <div data-bs-theme="dark" class="offcanvas-header">
            <h5 class="offcanvas-title" id="menuOffcanvasLabel">Menu</h5>
            <button type="button" class="btn-close " data-bs-dismiss="offcanvas" aria-label="Fechar"></button>

        </div>

        <div class="offcanvas-body ">
             <h6 class="offcanvas-subtitle text-light">
                <p>Bem-vindo, 
                @if (session('funcionario'))
                     {{  ucfirst(session('funcionario')->nome)}}!</p>
                @endif
            </h6>
            <!-- Conteúdo do menu aqui -->
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                <li class="nav-item ">
                    <a class="nav-link" href="/dashboard">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadastroproduto')}}">Cadastro de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadastrofornecedor')}}">Cadastro de fornecedor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cotacaoprodutos">Cotação de produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('produto.listar')}}">Informação de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Informação da empresa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Calculadora empresarial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('configuracoes')}}">Configurações</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">Logout</a>
                </li>
                <!-- Adicione mais itens de menu conforme necessário -->
            </ul>
        </div>
    </div>

    <!-- Offcanvas para notificações -->
    <div class="offcanvas offcanvas-end navbar-dark" tabindex="-1" id="notificacoesOffcanvas"
        aria-labelledby="notificacoesOffcanvasLabel" data-bs-theme="dark">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="notificacoesOffcanvasLabel">Notificações</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Conteúdo das notificações aqui -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-1">
                        <div class="card-body">
                            <p class="figure-caption">Usuario: Sistema</p>
                            <p id="date_time" class="figure-caption"> 17/05/2024 13:27 </p>
                            <p class="card-text">Sistema ficará fora do ar e passará por atualizações no dia 21/05/2024
                                às 20:00, backup automatico do sistema será feito às 19:00 do dia 21/05/2024. </p>
                        </div>
                    </div>
                    <div class="card mt-1">
                        <div class="card-body">
                            <p class="figure-caption">Usuario: João</p>
                            <p id="date_time" class="figure-caption"> 10/05/2024 15:03 </p>
                            <p class="card-text">Encerrada parceria com fornecedor Giga Atacado.</p>
                        </div>
                    </div>
                </div>

            </div>
            <div>
                <a href="/notificacoes" class="btn btn-success">Ver todas</a>
            </div>
        </div>
        <!-- Você pode usar qualquer componente Bootstrap ou elementos personalizados -->
    </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title display-6 text-center">PRODUTO {{ ucfirst($produto->nome)}}</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Informações do produto</h5>
                                    <p class="card-text">Nome: {{$produto->id}}</p>
                                    <p class="card-text">Nome: {{$produto->nome}}</p>
                                    <p class="card-text">Categoria: {{$produto->categoria}}</p>
                                    <p class="card-text">Custo: {{$produto->preco_compra}}</p>
                                    <p class="card-text">Ultimo fornecedor: {{$produto->ultimo_fornecedor}}</p>
                                    <p class="card-text">Quantidade: {{$produto->quantidade}}</p>
                                </div>
                                <div class="col-md-6">
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
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Fácil de Usar</h5>
                                <p class="card-text">
                                    aaa
                                    
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Fornecedores por % de produto</h5>
                                <img src="{{ global_asset('img/Screenshot_2.png') }}" alt="Descrição da Imagem" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
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
                                <a href="#" class="btn btn-success">Ver todas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Variação de custo unitário</h5>
                                <img src="{{ global_asset('img/Screenshot_3.png') }}" alt="Descrição da Imagem"
                                    class="img-fluid">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
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
