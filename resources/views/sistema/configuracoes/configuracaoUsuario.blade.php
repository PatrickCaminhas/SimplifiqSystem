<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Configurações</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')







    <div class="container mt-5 col-lg-6 col-md-8 col-sm-12 bg-light pt-2 pb-4">

        <h1 class="text-center">Configurações</h1>

        <div class="container mt-4">
            <div class="row">
                <h4> Configurações pessoais</h3>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-subtitle mb-2 text-muted text-center">Alterar dados pessoais</h5>
                            <p class="card-text">Altere os seus dados cadastrais.</p>
                            <a href="{{ route('configuracoes.dados') }}"
                                class="btn @include('partials.buttomCollor')">Alterar dados</a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-subtitle mb-2 text-muted text-center">Alterar senha</h5>
                            <p class="card-text">Altere sua senha para garantir a segurança de sua conta.</p>
                            <a href="{{ route('configuracoes.senha') }}"
                                class="btn @include('partials.buttomCollor')">Alterar senha</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($Administrador == true)
            <div class="container mt-4">
                <div class="row">
                    <h4> Configurações do sistema</h3>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-subtitle mb-2 text-muted text-center">Cadastrar funcionario </h5>
                                <p class="card-text">Cadastre um novo funcionário na empresa.</p>
                                @if ($cadastro_funcionario == 'negado')
                                    <a class="btn btn-secondary "disabled>
                                    @else
                                        <a class="btn @include('partials.buttomCollor')"
                                            href="{{ route('configuracoes.funcionario') }}">
                                @endif
                                Cadastraar funcionário</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">

                                <h5 class="card-subtitle mb-2 text-muted text-center">Excluir funcionario </h5>
                                <p class="card-text">Exclua um usuario do sistema.</p>


                                <a href="{{ route('configuracoes.excluir') }}"
                                    class="btn @include('partials.buttomCollor')">Cadastrar funcionário</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                <div class="row">


                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-subtitle mb-2 text-muted text-center">Alterar cargo de usuário</h5>
                                <p class="card-text">Altere os cargos dos usuarios da sua empresa.</p>
                                <a href="{{ route('configuracoes.cargos') }}"
                                    class="btn @include('partials.buttomCollor')">Alterar cargos</a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        @endif

    </div>



    <!-- Features Section -->

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
