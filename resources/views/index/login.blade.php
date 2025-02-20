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
</head>



<body class="bg-dark">
    @include('partials.menuIndex')
    <section class="h-100 gradient-form">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="{{ global_asset('img/Logo.png') }}" style="width: 185px;"
                                            alt="logo">
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
                                            <button class="btn btn-primary fa-lg bg-primary  mb-3"
                                                type="submit">Acesse</button>

                                            <p><a class="text-muted" href="{{ route('password.request') }}">Esqueceu
                                                    sua senha?</a></p>
                                                    @include('partials.errorAndSuccess')

                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Não tem uma conta?</p>
                                            <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                class="btn btn-outline-primary">Cria agora</a>
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Criação
                                                                de conta</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Para criar uma conta, entre em contato com o administrador
                                                            do sistema na empresa {{ $empresa }}.
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
                           ! <div class="col-lg-6 d-flex align-items-center bg-primary bg-gradient">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4 text-center">
                                    <h4 class="mb-4">Nós somos mais que uma empresa</h4>
                                    <p class="small mb-0">
                                        Somos um time comprometido em criar soluções que impulsionam o sucesso de
                                        negócios.
                                        Juntos, transformamos desafios em resultados.</p>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @vite('resources/js/app.js')
</body>

</html>
