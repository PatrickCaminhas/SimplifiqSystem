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
    <nav class="navbar navbar-expand-lg navbar-light bg-success sticky-top">
        <div class="container-fluid">
            <!-- Botão de menu offcanvas -->
            <button class="navbar-dark btn btn-success text-light" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Nome da aplicação -->
            <a href="/dashboard"><span class="navbar-brand mx-auto text-light"
                    style="font-family: 'Quicksand', sans-serif;"><b>Simplifiq System</b></span></a>
            <!-- Botão para offcanvas de notificações -->
            <button class="btn btn-success border border-light" type="button" data-bs-toggle="offcanvas"
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
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>

        <div class="offcanvas-body">
            <h6 class="offcanvas-subtitle text-light">
                <p>Bem-vindo,
                    @if (session('administrador'))
                        {{ session('administrador')->nome . ' ' . session('administrador')->sobrenome }}!
                    @endif
                </p>
            </h6>
            <!-- Conteúdo do menu aqui -->
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/dashboard">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cadastroproduto') }}">Cadastro de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cadastrofornecedor') }}">Cadastro de fornecedor</a>
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
                                às 20:00, backup automatico do sistema será feito às 19:00 do dia 21/05/2024.</p>
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
    </div>

    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">
                            <h2 class="text-center">Empresas</h2>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CNPJ</th>
                                        <th>Tamanho da empresa</th>
                                        <th>Tipo de empresa</th>
                                        <th>Telefone</th>
                                        <th>Estado</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($empresas as $empresa)
                                        <tr>
                                            <td>{{ $empresa->nome }}</td>
                                            <td>{{ $empresa->cnpj }}</td>
                                            <td>
                                                @if ($empresa->tamanho_empresa == 'microempresa')
                                                    Micro-empresa
                                                @elseif ($empresa->tamanho_empresa == 'pequenaempresa')
                                                    Pequena-empresa
                                                @elseif ($empresa->tamanho_empresa == 'mei')
                                                    MEI
                                                @endif
                                            </td>
                                            <td>{{ $empresa->tipo_empresa }}</td>
                                            <td>{{ $empresa->telefone }}</td>
                                            <td>{{ $empresa->estado }}</td>
                                            <td>
                                                @if ($empresa->estado == 'inexistente')
                                                    <form method="POST" action="{{ route('criarTenant') }}">
                                                        @csrf
                                                        <input type="hidden" name="nome"
                                                            value="{{ $empresa->nome }}">
                                                        <input type="hidden" name="cnpj"
                                                            value="{{ $empresa->cnpj }}">
                                                        <input type="hidden" name="tamanho_empresa"
                                                            value="{{ $empresa->tamanho_empresa }}">
                                                        <input type="hidden" name="tipo_empresa"
                                                            value="{{ $empresa->tipo_empresa }}">
                                                        <input type="hidden" name="telefone"
                                                            value="{{ $empresa->telefone }}">

                                                        <button type="submit" class="btn btn-primary">
                                                            Criar empresa</button>
                                                    </form>
                                                @elseif ($empresa->estado == 'ativa')
                                                    <a class="btn btn-danger disabled">Desativar</a>
                                                @elseif ($empresa->estado == 'desativada')
                                                    <a class="btn btn-primary disabled">Ativar</a>
                                                @endif

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

    <!-- Inclua os arquivos JavaScript do Bootstrap e DataTables -->
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
                }
            });
        });
    </script>
</body>

</html>
