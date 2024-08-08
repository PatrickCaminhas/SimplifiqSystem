<header
    class="navbar navbar-expand-lg navbar-light
        @if ($padrao_cores == 'vermelho') bg-danger
        @elseif ($padrao_cores == 'verde') bg-success
        @elseif ($padrao_cores == 'amarelo') bg-warning
        @elseif ($padrao_cores == 'azul') bg-primary
        @else bg-primary @endif
    sticky-top  ">

    <div class="container-fluid">
        <!-- Botão de menu offcanvas -->
        <button
            class="navbar-dark btn text-light
                @if ($padrao_cores == 'vermelho') btn-danger
                @elseif ($padrao_cores == 'verde') btn-success
                @elseif ($padrao_cores == 'amarelo') btn-warning
                @elseif ($padrao_cores == 'azul')
                @else bg-primary @endif
            "type="button"
            data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
            <span class=" navbar-toggler-icon "></span>
        </button>
        <!-- Nome da aplicação -->
        <a href="/dashboard"><span class="navbar-brand mx-auto text-light "
                style="font-family: 'Quicksand', sans-serif;"><b>{{ $empresa }} </b></span> </a>
        <!-- Botão para offcanvas de notificações -->
        <button
            class="btn
                @if ($padrao_cores == 'vermelho') btn-danger text-light border-light
                @elseif ($padrao_cores == 'verde') btn-success text-light border-light
                @elseif ($padrao_cores == 'amarelo') btn-warning text-black border-dark
                @elseif ($padrao_cores == 'azul') btn-primary text-light border-light
                @else bg-primary border-light @endif
                "
            type="button" data-bs-toggle="offcanvas" data-bs-target="#notificacoesOffcanvas"
            aria-controls="notificacoesOffcanvas">
            Notificações
        </button>
    </div>
</header>
