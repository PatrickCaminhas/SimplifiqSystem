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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json">

</head>

<body class="bg-black bg-gradient">
    <!-- Menu superior -->
    <nav
        class="navbar navbar-expand-lg navbar-light
    @if ($padrao_cores == 'vermelho') bg-danger
    @elseif ($padrao_cores == 'verde') bg-success
    @elseif ($padrao_cores == 'amarelo') bg-warning
    @elseif ($padrao_cores == 'azul') bg-primary
    @else bg-primary @endif
     sticky-top  ">




        <div class="container-fluid">
            <!-- Botão de menu offcanvas -->
            <button
                class="navbar-dark btn
            @if ($padrao_cores == 'vermelho') btn-danger
            @elseif ($padrao_cores == 'verde') btn-success
            @elseif ($padrao_cores == 'amarelo') btn-warning
            @elseif ($padrao_cores == 'azul')
            @else bg-primary @endif
             text-light "
                type="button" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
                <span class=" navbar-toggler-icon "></span>
            </button>
            <!-- Nome da aplicação -->
            <a href="/dashboard"><span class="navbar-brand mx-auto text-light "
                    style="font-family: 'Quicksand', sans-serif;"><b>Simplifiq
                        System</b></span> </a>
            <!-- Botão para offcanvas de notificações -->
            <button
                class="btn
            @if ($padrao_cores == 'vermelho') btn-danger text-light border-light
            @elseif ($padrao_cores == 'verde') btn-success text-light border-light
            @elseif ($padrao_cores == 'amarelo') btn-warning text-black border-dark
            @elseif ($padrao_cores == 'azul') btn-primary text-light border-light
            @else bg-primary border-light @endif
            "
                type="button" data-bs-toggle="offcanvas" data-bs-target="#notificacoesOffcanvas"
                aria-controls="notificacoesOffcanvas">
                Notificações
            </button>
        </div>
    </nav>

    <!-- Offcanvas para o menu -->
    <div class="offcanvas offcanvas-start
    @if ($padrao_cores == 'vermelho') bg-danger text-light navbar-dark
    @elseif ($padrao_cores == 'verde') bg-success text-light navbar-dark
    @elseif ($padrao_cores == 'amarelo') bg-warning text-dark
    @elseif ($padrao_cores == 'azul') bg-primary text-light navbar-dark
    @else bg-primary text-light navbar-dark @endif
    "
        data-bs-theme="dark" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
        <div data-bs-theme="dark" class="navbar offcanvas-header">
            <h5 class="offcanvas-title" id="menuOffcanvasLabel">Menu</h5>
            <button type="button" class="btn-close " data-bs-dismiss="offcanvas" aria-label="Fechar"></button>

        </div>

        <div class="offcanvas-body ">
            <h6 class="offcanvas-subtitle">
                <p>Bem-vindo,
                    @if (session('funcionario'))
                        {{ session('funcionario')->nome }}!
                </p>
                @endif
            </h6>
            <!-- Conteúdo do menu aqui -->
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                <li class="nav-item ">
                    <b> <a class="nav-link active" aria-current="page" href="/dashboard">Inicio</a></b>
                </li>

                @if (isset($menu) && $menu == 'Vendas')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cadastroproduto') }}">Cadastro de produto</a>
                    </li>
                @elseif(isset($menu) && $menu == 'Serviços')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cadastroproduto') }}">Cadastro de serviços</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cadastrofornecedor') }}">Cadastro de fornecedor
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cotacaoprodutos">Cotação de produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('produto.listar') }}">Informação de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Informação da empresa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Calculadora empresarial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('configuracoes') }}">Configurações</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
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
                <a href="/notificacoes"
                    class="btn
                @if ($padrao_cores == 'vermelho') btn-danger
                @elseif ($padrao_cores == 'verde') btn-success
                @elseif ($padrao_cores == 'amarelo') btn-warning
                @elseif ($padrao_cores == 'azul') btn-primary
                @else bg-primary @endif
                ">Ver
                    todas</a>
            </div>
        </div>
        <!-- Você pode usar qualquer componente Bootstrap ou elementos personalizados -->
    </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lucro e despesas dos ultimos 6 meses</h5>
                        <img src="{{ global_asset('img/Screenshot_1.png') }}" alt="Descrição da Imagem"
                            class="img-fluid">

                    </div>
                </div>
            </div>
            <div class="col-md-5">
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

                        {{ dump($padrao_cores) }}

                        <a href="ultimasatividades"
                            class="btn
                        @if ($padrao_cores == 'vermelho') btn-danger
                        @elseif ($padrao_cores == 'verde') btn-success
                        @elseif ($padrao_cores == 'amarelo') btn-warning
                        @elseif ($padrao_cores == 'azul') btn-primary
                        @else bg-primary @endif
                        ">Ver
                            todas</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Features Section -->
    <div class="container mt-5 mb-4">

        <div class="row">
            <div class="col-md-4">
                <div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Enviar mensagem</h5>
                            <p class="card-text">Envie uma mensagem para um funcionario, todos os funcionarios ou para
                                um fornecedor cadastrado no sistema.</p>
                            <!-- <a href="/enviarmensagem" class="btn btn-primary">Enviar mensagem</a> -->
                            <button type="button"
                                class="btn
                            @if ($padrao_cores == 'vermelho') btn-danger
                            @elseif ($padrao_cores == 'verde') btn-success
                            @elseif ($padrao_cores == 'amarelo') btn-warning
                            @elseif ($padrao_cores == 'azul') btn-primary
                            @else bg-primary @endif
                            "
                                data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                Enviar mensagem
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Enviar mensagem</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bg-secondary-subtle">

                                            <form action="/dashboard" method="GET" class="row g-3">

                                                <div class="col-md-6">
                                                    <label for="exampleFormControlInput1"
                                                        class="form-label">Destinatário</label>
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
                                                <div class="col-md-6">
                                                    <label for="exampleFormControlInput1"
                                                        class="form-label">Assunto</label>
                                                    <input type="text" class="form-control"
                                                        id="exampleFormControlInput1" placeholder="Assunto">
                                                </div>
                                                <div class="col-12">
                                                    <label for="exampleFormControlTextarea1"
                                                        class="form-label">Mensagem</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>




                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Enviar</button>
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
                            <a href="#"
                                class="btn
                            @if ($padrao_cores == 'vermelho') btn-danger
                            @elseif ($padrao_cores == 'verde') btn-success
                            @elseif ($padrao_cores == 'amarelo') btn-warning
                            @elseif ($padrao_cores == 'azul') btn-primary
                            @else bg-primary @endif
                            ">Acesse</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fornecedores x Pedidos</h5>
                        <img src="{{ global_asset('img/Screenshot_2.png') }}" alt="Descrição da Imagem"
                            class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Proximas contas</h5>
                        <table id="myTable" class="display">
                            <thead>
                                <tr>
                                    <th>Vencimento</th>
                                    <th>Credor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contas as $conta)
                                    @if($conta->estado == 'Pendente' || $conta->estado == 'Vencida')
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}
                                        </td>
                                        <td style="overflow-x: auto;">{{ $conta->credor }}</td>
                                    </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                        <a href="#"
                            class="btn
                        @if ($padrao_cores == 'vermelho') btn-danger
                        @elseif ($padrao_cores == 'verde') btn-success
                        @elseif ($padrao_cores == 'amarelo') btn-warning
                        @elseif ($padrao_cores == 'azul') btn-primary
                        @else bg-primary @endif
                        ">Ver
                            todas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
                "pageLength": 5,
                "lengthChange": false,
            });
        });
    </script>
</body>

</html>
