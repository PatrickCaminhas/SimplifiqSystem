<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Simplifiq</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
                        {{ session('funcionario')->nome }}!
                </p>
                @endif
            </h6>
            <!-- Conteúdo do menu aqui -->
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                <li class="nav-item ">
                    <a class="nav-link" href="/dashboard">Inicio</a>

                <li class="nav-item">
                    <a class="nav-link" href="cadastroproduto">Cadastro de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cadastrofornecedor">Cadastro de fornecedor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cotacaoprodutos">Cotação de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Informação de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Informação da empresa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Calculadora empresarial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/configuracaousuario">Configurações</a>
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

    <div class="container mt-5  col-md-6 bg-light text-dark">
        <div class="row">
            <div class=" text-center">
                <h4 class="display-6">Informação de produto</h4>
                <form id="produto-form">
                    @csrf
                    <p class="lead">Aqui você pode visualizar informações detalhadas sobre um produto específico.</p>
                    <label for="produto" class="form-label">Selecione o produto:</label>
                  
                
                    <select class="select2 form-control" id="nome" name="nome"
                        onchange="updateFormAction()">
                        <option selected disabled>Selecione um produto</option>
                        @foreach ($produtos as $produto)
                            <option value="{{$produto->nome}}">{{$produto->nome}} </option>
                        @endforeach
                    </select>
                    <div class="mt-4 mb-4">
                        <button type="submit" class="btn btn-success">Visualizar</button>
                    </div>
                </form>

                <script>
                    function updateFormAction() {
                        const form = document.getElementById('produto-form');
                        const select = document.getElementById('nome');
                        const selectedValue = select.value;
                        form.action = `/informacaoproduto/${selectedValue}`;
                    }
                </script>


            </div>
        </div>
        <script>
            function updateFormAction() {
                const form = document.getElementById('produto-form');
                const select = document.getElementById('nome');
                const selectedValue = select.value;
                form.action = `/informacaoproduto/${selectedValue}`;
            }
            </script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
        <!-- Inclua os arquivos JavaScript do Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
