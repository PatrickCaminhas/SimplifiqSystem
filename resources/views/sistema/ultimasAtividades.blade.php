<!DOCTYPE html>
<html lang="pt-br">

@include('partials.head', ['titulo' => 'Pagina inicial'])

<body class=bg-dark>
    <!-- Menu superior -->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
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


    <div class="offcanvas navbar-dark offcanvas-start bg-primary text-light" tabindex="-1" id="menuOffcanvas"
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
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cadastro de produto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cadastro de fornecedor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cotação de produto</a>
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
                    <a class="nav-link" href="#">Configurações</a>
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

    <div class="container mt-4 mb-4 bg-light text-dark">
        <div class="row">
            <div class="col-12 text-center">
                <h4 class="display-6">Ultimas atividades</h4>
               <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Atividade</th>
                            <th scope="col">Data</th>
                            <th scope="col">Hora</th>
                            <th scope="col">Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Alteração de preço do produto X</td>
                            <td>20/05/2024</td>
                            <td>13:27</td>
                            <td>João</td>
                        </tr>
                        <tr>
                            <td>Alteração de preço do produto Y</td>
                            <td>17/05/2024</td>
                            <td>14:31</td>
                            <td>João</td>
                        </tr>
                        <tr>
                            <td>Cotação de produtos</td>
                            <td>17/05/2024</td>
                            <td>10:06</td>
                            <td>Pedro</td>
                        </tr>
                        <tr>
                            <td>Cadastro de fornecedor</td>
                            <td>16/05/2024</td>
                            <td>09:44</td>
                            <td>João</td>
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    @vite('resources/js/app.js')
</body>

</html>
