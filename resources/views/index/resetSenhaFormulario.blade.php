<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha - Simplifiq</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

                <a class="btn btn-primary" href="/">Voltar</a>
            </div>

            <div class="row justify-content-center ">
                <div class="col-md-6 col-lg-5 col-xl-4 align-self-center">

                    <div class="text-center">
                        <img src="{{ global_asset('img/Logo.png') }}" style="width: 185px;" alt="logo">
                        <h4 class="mt-1 mb-5 pb-1">Simplifiq System
                        </h4>
                    </div>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" name="email" id="email"
                                placeholder="Digite seu e-mail" value="{{request('email')}}" required>
                            <label>Email: {{request('email')}}</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Digite sua senha" required>
                            <label> Senha:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation" placeholder="Digite sua senha" required>
                            <label> Senha:</label>
                        </div>

                        <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                            <button class="btn btn-primary fa-lg bg-primary  mb-3" type="submit">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('partials.buttomsAcessibilidade')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>


    @include('partials.scriptLightDark')
    @include('partials.scriptAumentarFonte')

</body>

</html>
