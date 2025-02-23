   <!-- Menu superior -->
   <nav class="navbar navbar-expand-lg navbar-light bg-primary sticky-top">
       <div class="container-fluid">
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



       </div>
   </nav>


   <div class="offcanvas navbar-dark offcanvas-start bg-primary text-light" tabindex="-1" id="menuOffcanvas"
       aria-labelledby="menuOffcanvasLabel">
       <div data-bs-theme="dark" class="offcanvas-header">
           <h5 class="offcanvas-title" id="menuOffcanvasLabel">Menu administrativo</h5>
           <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
       </div>

       <div class="offcanvas-body">
           <h6 class="offcanvas-subtitle text-light">
               <p>Bem-vindo,
                   @if (session('administrador'))
                       {{ optional(session('administrador'))->nome . ' ' . optional(session('administrador'))->sobrenome }}!
                   @endif
               </p>
           </h6>
           <!-- Conteúdo do menu aqui -->
           <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
               <li class="nav-item">
                   <a class="nav-link active" aria-current="page"
                       href="{{ route('dashboardAdministrador.log') }}">Inicio</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="{{ route('simples.create') }}">Simples Nacional</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="{{ route('logout') }}">Logout</a>
               </li>
               <!-- Adicione mais itens de menu conforme necessário -->
           </ul>
       </div>
   </div>


   <div class="offcanvas offcanvas-end navbar-dark" tabindex="-1" id="notificacoesOffcanvas"
       aria-labelledby="notificacoesOffcanvasLabel" data-bs-theme="dark">
       <div class="offcanvas-header">
           <h5 class="offcanvas-title" id="notificacoesOffcanvasLabel">Notificações</h5>
           <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
       </div>
       <div class="offcanvas-body">
           <!-- Conteúdo das notificações aqui -->
           <div class="row">
               <div class="col-12">
                   <div class="card mt-1">
                       <div class="card-body">
                           <p class="figure-caption">Usuario: Sistema</p>
                           <p id="date_time" class="figure-caption"> 17/05/2024 13:27 </p>
                           <p class="card-text">Sistema ficará fora do ar e passará por atualizações no dia 21/05/2024
                               às 20:00, backup automatico do sistema será feito às 19:00 do dia 21/05/2024.</p>
                       </div>
                   </div>
                   <div class="card mt-1">
                       <div class="card-body">
                           <p class="figure-caption">Usuario: João</p>
                           <p id="date_time" class="figure-caption"> 10/05/2024 15:03 </p>
                           <p class="card-text">Encerrada parceria com fornecedor Giga Atacado.</p>
                       </div>
                   </div>
               </div>
           </div>
           <div>
               <a href="/notificacoes" class="btn btn-primary">Ver todas</a>
           </div>
       </div>
   </div>
