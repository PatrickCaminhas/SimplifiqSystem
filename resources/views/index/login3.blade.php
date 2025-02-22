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

<body class="bg-white-subtle d-flex justify-content-center align-items-center  vh-100">

    <div class="flex-fill">

        <div class = "container  ">
            <div class="mt-2 col-lg-6 col-md-8 col-sm-12">

                <a class="btn btn-primary" href="/">Voltar</a>
            </div>
            <div class="row justify-content-center ">
                <div class="col-md-6 col-lg-5 col-xl-4 align-self-center">

                    <div class="text-center">
                        <img src="{{ global_asset('img/Logo.png') }}" style="width: 185px;" alt="logo">
                        <h4 class="mt-1 mb-5 pb-1">Simplifiq System</h4>
                    </div>

                    <form method="POST" action="{{ route('identify.user') }}">
                        @csrf
                        <p>Acesse sua conta</p>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Digite seu e-mail" required>
                            <label> Email:</label>
                        </div>



                        <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                            <button class="btn btn-primary fa-lg bg-primary  mb-3" type="submit">Acesse</button>

                            @include('partials.errorAndSuccess')
                        </div>

                        <div class="d-flex align-items-center justify-content-center pb-4">
                            <p class="mb-0 me-2">Sua empresa não está cadastrada?</p>
                            <a type="button" href="{{ route('cadastro') }}" class="btn btn-outline-primary">Cadastre
                                agora</a>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
