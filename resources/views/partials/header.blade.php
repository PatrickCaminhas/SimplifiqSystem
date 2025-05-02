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
            " > <i class="bi bi-list"></i></span>
        </button>
        <!-- Nome da aplicação -->
        <a href="/" style="text-decoration: none;">
    <span class="navbar-brand mx-auto text-light" style="font-family: 'Quicksand', sans-serif;">
        <b>Simplifiq</b>
    </span>
</a>

         <!-- Botão para offcanvas de notificações -->
         <span>
           <span>
    
               <button class="btn btn-primary mt-2" id="font-size-btn" type="button" aria-label="Increase font size">
        <i id="font-size-icon" class="bi bi-zoom-in"></i>
    </button>
           </span>
           <span>
           <button id="toggle-theme" class="btn btn-primary mt-2">
    <span id="theme-icon" class="bi bi-moon-stars-fill"></span>
</button>	
           </span>
        
</span>
        @include('partials.menu')
    </div>
</header>
