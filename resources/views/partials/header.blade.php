<header
    class="navbar  navbar-light
        @if ($padrao_cores == 'vermelho') bg-danger
        @elseif ($padrao_cores == 'verde') bg-success
        @elseif ($padrao_cores == 'amarelo') bg-warning
        @elseif ($padrao_cores == 'azul') bg-primary
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
