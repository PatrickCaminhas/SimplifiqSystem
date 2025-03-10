<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Simplifiq</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">


</head>

<body  class="bg-dark text-light" >
    <!-- Navbar -->
 @include('partials.menuIndex')

    <!-- Main Content -->
    <div >
    <div class="container mt-5 col-lg-6 col-md-8 col-sm-12">
        <div class="row">
            <div class="col-12 text-center">
                <img src="{{ global_asset('img/Logo.png') }}" style="width: 185px;"
                                            alt="logo">
                <h1 class="display-4">Bem-vindo ao Simplifiq</h1>
                <p class="lead">Gerencie suas operações de forma eficiente e eficaz com nosso sistema leve e
                    intuitivo.</p>
                <a href="{{route('login')}}" class="btn btn-primary btn-lg mt-3">Entrar</a>
                <a href="{{route('cadastro')}}" class="btn btn-primary btn-lg mt-3">Cadastrar</a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mt-5 mb-8 col-lg-6 col-md-8 col-sm-12">
        <div class="row">
            <div class="col-4">
                <div class="card bg-black text-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">Fácil de Usar</h5>
                        <p class="card-text">Interface amigável, leve e intuitiva para facilitar o uso diário.</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card bg-black text-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">Segurança</h5>
                        <p class="card-text">Sua segurança é nossa prioridade. Todos os dados são protegidos.</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card bg-black text-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">Responsivo</h5>
                        <p class="card-text">Utilize o sistema adaptado para computadores, tablets e celulares.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class=" bg-primary   text-light text-center text-lg-start mt-5">
        <div class="container p-4">
            <p class="text-center">&copy; 2024 Simplifiq Sistem. Todos os direitos reservados.</p>
        </div>
    </footer>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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
