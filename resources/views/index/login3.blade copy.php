<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simplifiq</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                            <div class="col-lg-6 col-sm-12">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="{{ global_asset('img/Logo.png') }}" style="width: 185px;"
                                            alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">Simplifiq System</h4>
                                    </div>

                                    <form method="POST" action="{{ route('identify.tenant') }}">
                                        @csrf
                                        <p>Acesse sua conta</p>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Digite seu e-mail" required>
                                            <label> Email:</label>
                                        </div>



                                        <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                                            <button class="btn btn-primary fa-lg bg-primary  mb-3"
                                                type="submit">Acesse</button>

                                            @include('partials.errorAndSuccess')
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Sua empresa não está cadastrada?</p>
                                            <a type="button" href="{{ route('cadastro') }}"
                                                class="btn btn-outline-primary">Cadastre agora</a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <!-- <div class="col-lg-6 d-flex align-items-center bg-primary bg-gradient">
                        <div class="text-white px-3 py-4 p-md-5 mx-md-4 text-center">
                          <h4 class="mb-4">Nós somos mais que uma empresa</h4>
                          <p class="small mb-0">
                            Somos um time comprometido em criar soluções que impulsionam o sucesso de negócios.
                            Juntos, transformamos desafios em resultados.</p>
                        </div>
                      </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
