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

<body class="bg-image" style="height: 100vh; background-image: url({{ asset('img/login.jpg') }}); background-size: cover; background-repea: no-repeat;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary text-dark sticky-top" style="height: 8vh;">
        <a class="navbar-brand ms-2" style="font-family: 'Quicksand', sans-serif;">Simplifiq System</a>
        <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ml-auto text-dark" id="navbarNav">
            <ul class="navbar-nav bg-primary">
                <li class="nav-item ">
                    <a class="nav-link" href="/">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sobre</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="#">Contato</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link active" aria-current="page" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('cadastro') }}">Cadastro</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('loginAdministrativo.form') }}">Administração</a>
                </li>
            </ul>
        </div>
    </nav>
    <div>
        <div class="bg-dark bg-opacity-75 col-6">
            <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
                <div class="container-fluid ps-0 pe-0">
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <div class="card shadow-lg border border-dark">
                                <div class="card-body bg-dark text-light">
                                    <h2 class="text-center">Procure a empresa</h2>
                                    <form method="POST" action="{{ route('paginalogin') }}">
                                        @csrf
                                        <div class="form-group">

                                            <select class="select2 form-control" id="empresa" name="empresa"
                                            onchange="updateFormAction()">
                                            <option selected disabled>Selecione a sua empresa</option>

                                            @foreach ($empresas as $empresa)
                                                <option value="{{$empresa->nome }}">{{$empresa->nome}} </option>
                                            @endforeach
                                        </select>
                                        </div>


                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-primary text-center">Entrar</button>
                                        </div>
                                    </form>
                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-3">

                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}
                                                @endforeach

                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
