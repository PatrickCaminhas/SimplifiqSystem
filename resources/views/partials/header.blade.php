<header
    class="navbar  navbar-light
        @if (session('tema') == 'vermelho') bg-danger
        @elseif (session('tema') == 'verde') bg-success
        @elseif (session('tema') == 'amarelo') bg-warning
        @elseif (session('tema') == 'azul') bg-primary
        @else bg-primary @endif
    sticky-top  ">

    <div class="container-fluid min-vh-10 ">
        <!-- Botão de menu offcanvas -->
        <button
            class="navbar-dark btn text-light align-top
               @include('partials.buttomCollor')
            "type="button"
            data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
            <!--<span class=" navbar-toggler-icon "></span>-->
            <span class="navbar-brand mx-auto text-light"
                style="font-family: 'Quicksand', sans-serif;"><b>Simplifiq</b></span>
        </button>
        <!-- Nome da aplicação -->
        <!--<a href="/dashboard"><span class="navbar-brand mx-auto text-light"
                style="font-family: 'Quicksand', sans-serif;"><b>Simplifiq</b></span> </a>
         Botão para offcanvas de notificações -->
        @include('partials.menu')
    </div>
</header>
