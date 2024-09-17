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

<body class="bg-black bg-gradient">
    <!-- Menu superior -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success sticky-top  ">
        <div class="container-fluid">
            <!-- Botão de menu offcanvas -->
            <button class="navbar-dark btn @include('partials.buttomCollor') text-light " type="button" data-bs-toggle="offcanvas"
                data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
                <span class=" navbar-toggler-icon "></span>
            </button>
            <!-- Nome da aplicação -->
            <a href="/dashboard"><span class="navbar-brand mx-auto text-light " style="font-family: 'Quicksand', sans-serif;"><b>Simplifiq
                    System</b></span> </a>
            <!-- Botão para offcanvas de notificações -->
            <button class="btn @include('partials.buttomCollor') border border-light " type="button" data-bs-toggle="offcanvas"
                data-bs-target="#notificacoesOffcanvas" aria-controls="notificacoesOffcanvas">
                Notificações
            </button>
        </div>
    </nav>


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
                    <a class="nav-link active" aria-current="page" href="/dashboard">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cadastroproduto')}}">Cadastro de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route(' cadastroFornecedor')}}">Cadastro de fornecedor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cotacaoprodutos">Cotação de produtos</a>
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


    <div class="offcanvas offcanvas-end navbar-dark" tabindex="-1" id="notificacoesOffcanvas"
        aria-labelledby="notificacoesOffcanvasLabel" data-bs-theme="dark">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="notificacoesOffcanvasLabel">Notificações</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Conteúdo das notificações aqui -->
            <div class="row">
                <div class="col-12">
                    <div class="card mt-1">
                        <div class="card-body">
                            <p class="figure-caption">Usuario: Sistema</p>
                            <p id="date_time" class="figure-caption"> 17/05/2024 13:27 </p>
                            <p class="card-text">Sistema ficará fora do ar e passará por atualizações no dia 21/05/2024 às 20:00, backup automatico do sistema será feito às 19:00 do dia 21/05/2024. </p>
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
            <div class="mt-2">
                <a href="/notificacoes" class="btn @include('partials.buttomCollor')">Ver todas</a>
            </div>
        </div>
        <!-- Você pode usar qualquer componente Bootstrap ou elementos personalizados -->
    </div>
    </div>

    <div class="container mt-5 col-lg-6 col-md-8 col-sm-12 col-lg-6 col-md-8 col-sm-12">
        <div class="row">
            <div class="col-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lucro e despesas dos ultimos 6 meses</h5>
                        <img src="{{ global_asset('img/Screenshot_1.png') }}" alt="Descrição da Imagem" class="img-fluid">

                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ultimas atividades</h5>
                        <table class="table table-light  border table-dorder table-hover">
                            <thead class="table-group-divider">
                                <tr class="">
                                    <th class=" ">Atividade</th>
                                    <th class="">Usuário</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider ">
                                <tr class="">
                                    <th class="">Produto cadastrado</th>
                                    <th class="">João</th>
                                </tr>
                                <tr class="">
                                    <th class="">Produto cadastrado</th>
                                    <th class="">Maria</th>
                                </tr>
                            </tbody>
                        </table>
                        <a href="ultimasatividades" class="btn @include('partials.buttomCollor')">Ver todas</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Features Section -->
    <div class="container mt-5 col-lg-6 col-md-8 col-sm-12 mb-4">
        <div class="row">
            <div class="col-4">
                <div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Enviar mensagem</h5>
                        <p class="card-text">Envie uma mensagem para um funcionario, todos os funcionarios ou para um fornecedor cadastrado no sistema.</p>
                       <!-- <a href="/enviarmensagem" class="btn btn-primary">Enviar mensagem</a> -->
                       <button type="button" class="btn @include('partials.buttomCollor')" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Enviar mensagem
                      </button>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Enviar mensagem</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-secondary-subtle">

            <form action="/dashboard" method="GET" class="row g-3">

                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Destinatário</label>
                    <select class="form-select" aria-label="Default select example">
                        <option selected disabled>Selecione o destinatário</option>
                        <optgroup label="Funcionarios">
                            <option value="1">Usuário 1</option>
                            <option value="2">Usuário 2</option>
                            <option value="3">Usuário 3</option>
                        </optgroup>
                        <optgroup label="Todos os Funcionarios">
                            <option value="4">Todos os Funcionarios</option>
                        <optgroup label="Fornecedores">
                            <option value="1">Fornecedor 1</option>
                            <option value="2">Fornecedor 2</option>
                            <option value="3">Fornecedor 3</option>
                        </optgroup>

                    </select>
                </div>
                <div class="col-6">
                    <label for="exampleFormControlInput1" class="form-label">Assunto</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Assunto">
                </div>
                <div class="col-12">
                    <label for="exampleFormControlTextarea1" class="form-label">Mensagem</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>




        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Enviar</button>
        </div>
            </form>
      </div>

    </div>
  </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mensagens recebidas</h5>
                        <p class="card-text">Acesse a sua caixa de mensagens recebidas.</p>
                        <a href="#" class="btn @include('partials.buttomCollor')">Acesse</a>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fornecedores x Pedidos</h5>
                        <img src="{{ global_asset('img/Screenshot_2.png') }}" alt="Descrição da Imagem" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
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
    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
