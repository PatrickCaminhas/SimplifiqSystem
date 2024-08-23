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

    <!-- Offcanvas para o menu -->
   @include('partials.menu')

    <!-- Offcanvas para notificações -->
    @include('partials.notificacoes')

    <div class="container mt-5 bg-light pt-2 pb-4">

        <h1 class="text-center">Configurações</h1>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-subtitle mb-2 text-muted text-center">Backup</h5>
                        <p class="card-text">Realize o backup de seus dados para garantir a segurança de suas informações.</p>
                        <a href="#" class="btn @include('partials.buttomCollor')">Realizar backup</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-subtitle mb-2 text-muted text-center">Cadastrar funcionario </h5>
                        <p class="card-text">Cadastre um novo funcionário na empresa.</p>

                        @if($cadastro_funcionario == "negado")
                        <button class="btn @include('partials.buttomCollor')" disabled>Cadastrar funcionário</button>
                        @else
                        <a href="{{route('configuracoes.funcionario')}}" class="btn @include('partials.buttomCollor')">Cadastrar funcionário</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-subtitle mb-2 text-muted text-center">Alterar cargos</h5>
                        <p class="card-text">Altere os cargos dos usuarios da sua empresa.</p>
                        <a href="#" class="btn @include('partials.buttomCollor')">Alterar cargos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-subtitle mb-2 text-muted text-center">Alterar seus dados</h5>
                        <p class="card-text">Altere os seus dados cadastrais.</p>
                        <a href="#" class="btn @include('partials.buttomCollor')">Alterar senha</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-subtitle mb-2 text-muted text-center">Alterar senha</h5>
                        <p class="card-text">Altere sua senha para garantir a segurança de sua conta.</p>
                        <a href="{{route('configuracoes.senha')}}" class="btn @include('partials.buttomCollor')">Alterar senha</a>
                    </div>
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
