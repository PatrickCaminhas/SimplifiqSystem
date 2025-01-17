<nav class="navbar navbar-expand-lg navbar-dark bg-primary text-dark">
    <span class="navbar-brand mx-auto text-light ms-3"
                style="font-family: 'Quicksand', sans-serif;"><b>Simplifiq</b></span>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse ml-auto" id="navbarNav">
        <ul class="navbar-nav bg-primary ps-3">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/">Início</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sobre</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
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
