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
    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">
                            <h2 class="text-center">Metas</h2>
                            <p>Deseja cadastar uma nova meta? <a class ="btn btn-primary"
                                    href="{{ route('metas.create') }}">Clique aqui</a></p>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Valor final</th>
                                        <th>Prazo final</th>
                                        <th>Estado</th>
                                        <th>Verificar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($metas as $meta)
                                        <tr>
                                            <td style="overflow-x: auto;">{{ $meta->id }}</td>

                                            <td>{{ $meta->valor }}</td>

                                            <td>{{ \Carbon\Carbon::parse($meta->ending_at)->format('d/m/Y') }}
                                            </td>
                                            <td>{{ $meta->estado }}</td>
                                            <td>
                                                <button type="button" class="btn bg-primary text-light"
                                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    Verificar
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                                    data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    Meta #{{ $meta->id }}</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body bg-secondary-subtle">

                                                                <form action="{{ route('metas.storeProgresso') }}"
                                                                    method="POST" class="row g-3">
                                                                    @csrf
                                                                    <div class="col-md-6">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Criação:</label>
                                                                        <a>{{ \Carbon\Carbon::parse($meta->created_at)->format('d/m/Y') }}</a>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Vencimento:</label>
                                                                        <a>{{ \Carbon\Carbon::parse($meta->ending_at)->format('d/m/Y') }}</a>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Valor final:</p>
                                                                        <a>R$ {{ $meta->valor }}</a>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Valor atual:</p>
                                                                        <a>R$ {{ $meta->valor_atual }}</a>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        @if ($meta->valor_atual >= $meta->valor)
                                                                            <p for="exampleFormControlInput1"
                                                                                class="form-label">Valor excedido:</p>
                                                                            <a>R$
                                                                                {{ $excedido = $meta->valor - $meta->valor_atual }}.00</a>
                                                                        @else
                                                                            <p for="exampleFormControlInput1"
                                                                                class="form-label">Valor faltante:</p>
                                                                            <a>R$
                                                                                {{ $faltante = ($meta->valor_atual - $meta->valor) * -1 }}.00</a>
                                                                        @endif
                                                                    </div>

                                                            </div>
                                                            <div class="modal-body bg-secondary-subtle col-md-12">
                                                                <div class="progress bg-light" role="progressbar"
                                                                    aria-label="Default striped example"
                                                                    aria-valuenow="10" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                    <div class="progress-bar progress-bar-striped
                                                                    @if ($meta->valor_atual >= $meta->valor) bg-success
                                                                    @elseif($meta->estado == 'Não cumprida') bg-danger @endif
                                                                    "
                                                                        style="width:
                                                                    {{ $valor = floor(($meta->valor_atual * 100) / $meta->valor) }}%">
                                                                        {{ $valor }}%
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="modal-footer">
                                                                <div class="col-md-8">
                                                                    <input type="hidden" name="meta_id"
                                                                        value="{{ $meta->id }}">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" class="form-control"
                                                                            name="valor" id="valor"
                                                                            min="1" step="0.01"
                                                                            required @if($meta->estado=='Finalizada' || $meta->estado=='Não cumprida') disabled @endif
                                                                            >
                                                                            <label>
                                                                            Progresso de meta:</label>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary"
                                                                @if($meta->estado=='Finalizada' || $meta->estado=='Não cumprida') disabled @endif
                                                                >
                                                                    Novo progresso</button>

                                                            </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>



                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->

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
            });
        });
    </script>
</body>

</html>
