<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simplifiq</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <style>
        /* Sobrescreve o estilo do item de menu quando em foco ou ativo */
        .dropdown-item:focus,
        .dropdown-item:active {
            background-color: inherit !important;
            color: inherit !important;
        }

        /* Fonte padrão */
        body {
            font-size: 16px;
        }

        /* Estilo para o aumento de fonte */
        .font-large {
            font-size: 20px;
        }
    </style>
</head>


<body class="bg-white-subtle d-flex justify-content-center align-items-center vh-100">
    <div class="flex-fill">
        <div class = "container  ">
            <div class="mt-2 col-lg-6 col-md-8 col-sm-12">

                <a class="btn btn-primary" href="http://localhost:8000/">Voltar</a>
            </div>

            <div class="row justify-content-center ">
                <div class="col-md-6 col-lg-5 col-xl-4 align-self-center">

                    <div class="text-center">
                        <img src="{{ global_asset('img/Logo.png') }}" style="width: 185px;" alt="logo">
                        <h4 class="mt-1 mb-5 pb-1">Simplifiq System
                            <p>Administrativo</p>
                        </h4>
                    </div>

                    <form method="POST" action="{{ route('loginAdministrativo.store') }}">
                        @csrf
                        <p>Acesse sua conta</p>
                        @include('partials.errorAndSuccess')
                        <input type="hidden" class="form-control" name="email" id="email"
                            value="{{ $email }}" required>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="emailview" id="emailview"
                                placeholder="{{ $email }}" disabled required>
                            <label> Email: {{ $email }}</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="senha" id="senha"
                                placeholder="Digite sua senha" required>
                            <label> Senha:</label>
                        </div>
                        <input type="hidden" name="recaptcha_token" id="recaptcha_token">


                        <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                            <button class="btn btn-primary fa-lg bg-primary  mb-3" id="Acesse"
                                type="submit">Acesse</button>

                            <p><a class="text-muted" href="{{ route('password.request') }}">Esqueceu
                                    sua senha?</a></p>
                        </div>




                    </form>

                </div>
            </div>
        </div>
    </div>
    @include('partials.buttomsAcessibilidade')
    @vite('resources/js/app.js')

    @include('partials.scriptLightDark')
    @include('partials.scriptAumentarFonte')

</body>

</html>
