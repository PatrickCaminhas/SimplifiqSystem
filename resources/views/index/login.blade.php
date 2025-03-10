<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simplifiq</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                            <p>{{ $empresa }}</p>
                        </h4>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <p>Acesse sua conta</p>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Digite seu e-mail" required>
                            <label> Email:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="senha" id="senha"
                                placeholder="Digite sua senha" required>
                            <label> Senha:</label>
                        </div>


                        <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                            <button class="btn btn-primary fa-lg bg-primary  mb-3" type="submit">Acesse</button>

                            <p><a class="text-muted" href="{{ route('password.request') }}">Esqueceu
                                    sua senha?</a></p>
                            @include('partials.errorAndSuccess')

                        </div>

                        <div class="d-flex align-items-center justify-content-center pb-4">
                            <p class="mb-0 me-2">Não tem uma conta?</p>
                            <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                class="btn btn-outline-primary">Veja aqui</a>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Criação
                                                de conta</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Para criar uma conta, entre em contato com a empresa {{ $empresa }}.

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"
                                                data-bs-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    @include('partials.buttomsAcessibilidade')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    @include('partials.scriptLightDark')
    @include('partials.scriptAumentarFonte')

</body>

</html>
