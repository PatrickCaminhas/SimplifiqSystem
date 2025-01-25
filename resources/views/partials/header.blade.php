<header
    class="navbar
        @if (session('tema') == 'vermelho') navbar-light bg-danger
        @elseif (session('tema') == 'verde') navbar-light bg-success
        @elseif (session('tema') == 'amarelo') navbar-light bg-warning
        @elseif (session('tema') == 'azul') navbar-light bg-primary
        @elseif (session('tema') == 'dark') navbar-dark bg-dark
        @else navbar-light bg-primary @endif
    sticky-top  ">

    <div class="container-fluid min-vh-10 ">
        <!-- Botão de menu offcanvas -->
        <button id="menuButtom"
            class="navbar-dark btn text-light align-top
               @include('partials.buttomCollor')
            "type="button"
            data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
            <!--<span class=" navbar-toggler-icon "></span>-->
            <span class="navbar-brand mx-auto
            @if(session('tema') == 'amarelo')
                text-dark
            @else
                text-light
            @endsession
            "
                style="font-family: 'Quicksand', sans-serif;"><b>Simplifiq</b></span>
        </button>
        <!-- Nome da aplicação -->
        <!--<a href="/dashboard"><span class="navbar-brand mx-auto text-light"
                style="font-family: 'Quicksand', sans-serif;"><b>Simplifiq</b></span> </a>
         Botão para offcanvas de notificações -->
        @include('partials.menu')
    </div>
</header>
