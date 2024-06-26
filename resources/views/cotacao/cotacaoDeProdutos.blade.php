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
                     {{ session('funcionario')->nome }}!</p>
                @endif
            </h6>
            <!-- Conteúdo do menu aqui -->
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                <li class="nav-item ">
                    <a class="nav-link" href="/dashboard">Inicio</a>
              
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadastroproduto')}}">Cadastro de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadastrofornecedor')}}">Cadastro de fornecedor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"  href="cotacaoprodutos">Cotação de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('produto.listar')}}">Informação de produto</a>
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

    <div class="container mt-4 mb-4 bg-light text-dark ">
        <div class="row">
            <div class="col-md-12 text-center " style="overflow: auto;">
                <h4 class="display-6">Cotação de Produtos</h4>
                <form method="POST" action="/cotacaoprodutosrevisao" >
                    @csrf
                    <table class="col-md-12 table table-striped table-hover table-secondary ">
                        <thead>
                            <tr class=" text-light">
                                <th scope="col">Produto</th>
                                <th scope="col">Fornecedor 1</th>
                                <th scope="col">Fornecedor 2</th>
                                <th scope="col">Fornecedor 3</th>
                                <th scope="col">Fornecedor 4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mesa de madeira flexivel 70x70 Imbuia</td>
                                <td> <input type="text" class="form-control" id="produto1fornecedor1"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto1fornecedor2"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto1fornecedor3"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto1fornecedor4"
                                        placeholder="Digite o preço"> </td>
                            </tr>
                            <tr>
                                <td>Fogao camping 2 bocas Camper</td>
                                <td> <input type="text" class="form-control" id="produto2fornecedor1"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto2fornecedor2"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto2fornecedor3"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto2fornecedor4"
                                        placeholder="Digite o preço"> </td>
                            </tr>
                            <tr>
                                <td>Guarda-sol 2,5m de diametro</td>
                                <td> <input type="text" class="form-control" id="produto3fornecedor1"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto3fornecedor2"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto3fornecedor3"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto3fornecedor4"
                                        placeholder="Digite o preço"> </td>
                            </tr>
                            <tr>
                                <td>Luminaria Led 12W Everled</td>
                                <td> <input type="text" class="form-control" id="produto4fornecedor1"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto4fornecedor2"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto4fornecedor3"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto4fornecedor4"
                                        placeholder="Digite o preço"> </td>
                            </tr>
                            <tr>
                                <td>Churrasqueira portatil 3 espetos</td>
                                <td> <input type="text" class="form-control" id="produto5fornecedor1"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto5fornecedor2"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto5fornecedor3"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto5fornecedor4"
                                        placeholder="Digite o preço"> </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class= "text-center mt-2 mb-4">
                        <button type="submit" class="btn btn-success text-center">Salvar</button>
                        <button type="reset" class="btn btn-success text-center">Limpar</button>





                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
