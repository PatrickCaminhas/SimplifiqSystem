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
    <nav class="navbar navbar-expand-lg navbar-light bg-primary sticky-top">
        <div class="container-fluid">
            <!-- Botão de menu offcanvas -->
            <button class="navbar-dark btn btn-primary text-light " type="button" data-bs-toggle="offcanvas"
                data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
                <span class=" navbar-toggler-icon "></span>
            </button>
            <!-- Nome da aplicação -->
            <span class="navbar-brand mx-auto text-light " style="font-family: 'Quicksand', sans-serif;"><b>Simplifiq
                    System</b></span>
            <!-- Botão para offcanvas de notificações -->
            <button class="btn btn-primary border border-light " type="button" data-bs-toggle="offcanvas"
                data-bs-target="#notificacoesOffcanvas" aria-controls="notificacoesOffcanvas">
                Notificações
            </button>
        </div>
    </nav>

    <!-- Offcanvas para o menu -->
    <div class="offcanvas navbar-dark offcanvas-start bg-primary text-light" tabindex="-1" id="menuOffcanvas"
        aria-labelledby="menuOffcanvasLabel">
        <div data-bs-theme="dark" class="offcanvas-header">
            <h5 class="offcanvas-title" id="menuOffcanvasLabel">Menu</h5>
            <button type="button" class="btn-close " data-bs-dismiss="offcanvas" aria-label="Fechar"></button>

        </div>

        <div class="offcanvas-body ">
            <h6 class="offcanvas-subtitle text-light">Bem vindo, $USER!</h6>
            <!-- Conteúdo do menu aqui -->
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                <li class="nav-item ">
                    <a class="nav-link" href="/dashboard">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cadastrodeproduto">Cadastro de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="cadastrofornecedor">Cadastro de fornecedor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cotacaoprodutos">Cotação de produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/informacaoproduto">Informação de produto</a>
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
                <a href="/notificacoes" class="btn btn-primary">Ver todas</a>
            </div>
        </div>
        <!-- Você pode usar qualquer componente Bootstrap ou elementos personalizados -->
    </div>
    </div>

    <div class=" d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="text-center">Cadastro de fornecedor</h2>
                            <form method="POST" action="/dashboard">
                                @csrf
                                <div class="form-group">
                                    <label for="nomefornecedor">Nome</label>
                                    <input type="text" class="form-control" id="nomefornecedor"
                                        placeholder="Digite o nome do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="cnpjornecedor">CNPJ</label>
                                    <input type="text" class="form-control" id="cnpjornecedor"
                                        placeholder="Digite o CNPJ do fornecdor">
                                </div>
                                <div class="form-group">
                                    <label for="enderecofornecedor">Endereço</label>
                                    <input type="text" class="form-control" id="enderecofornecedor"
                                        placeholder="Digite o endereço do fornecdor">
                                </div>
                                <div class="form-group">
                                    <label for="cidadefornecedor">Cidade</label>
                                    <input type="text" class="form-control" id="cidadefornecedor"
                                        placeholder="Digite a cidade do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="emailfornecedor">E-mail</label>
                                    <input type="text" class="form-control" id="emailfornecedor"
                                        placeholder="Digite o e-mail do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="telefonefornecedor">Telefone</label>
                                    <input type="text" class="form-control" id="telefonefornecedor"
                                        placeholder="Digite o telefone do fornecedor">
                                </div>
                                <div class= "text-center mt-1">
                                    <button type="submit" class="btn btn-primary text-center">Cadastrar</button>
                                    <button type="reset" class="btn btn-primary text-center">Limpar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class= "text-center mt-3">
                        <a href="/dashboard" class="btn btn-primary text-center">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
