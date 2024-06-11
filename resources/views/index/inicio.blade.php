<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Simplifiq</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body style="height: 100vh;" class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary text-light">
        <a class="navbar-brand ms-2 " style="font-family: 'Quicksand', sans-serif;">Simplifiq System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div     class="collapse navbar-collapse ml-auto"" id="navbarNav">
            <ul class="navbar-nav >
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sobre</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="#">Contato</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="/cadastro">Cadastro</a>
                </li>


            </ul>

        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="display-4">Bem-vindo ao Sistema de Administração</h1>
                <p class="lead">Gerencie suas operações de forma eficiente e eficaz com nosso sistema robusto e
                    intuitivo.</p>
                <a href="login" class="btn btn-primary btn-lg mt-3">Entrar</a>
                <a href="cadastro" class="btn btn-primary btn-lg mt-3">Cadastrar</a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fácil de Usar</h5>
                        <p class="card-text">Interface amigável e intuitiva para facilitar o uso diário.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Segurança</h5>
                        <p class="card-text">Sua segurança é nossa prioridade. Todos os dados são protegidos.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Suporte 24/7</h5>
                        <p class="card-text">Nossa equipe está disponível para ajudá-lo a qualquer momento.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class=" bg-primary  text-light text-center text-lg-start mt-5">
        <div class="container p-4">
            <p class="text-center">&copy; 2024 Sistema de Administração. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Verifica o tamanho da tela e aplica a classe apropriada ao footer
        if (window.innerWidth <= window.innerHeight) {
            document.querySelector('footer').classList.add('sticky-bottom');
        } else {
            document.querySelector('footer').classList.add('fixed-bottom');
        }
    </script>
</body>

</html>
