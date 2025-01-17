<nav class="offcanvas offcanvas-start
@if (session('tema') == 'vermelho') bg-danger text-light navbar-dark
@elseif (session('tema') == 'verde') bg-success text-light navbar-dark
@elseif (session('tema') == 'amarelo') bg-warning text-dark
@elseif (session('tema') == 'azul') bg-primary text-light navbar-dark
@else bg-primary text-light navbar-dark @endif
"
    data-bs-theme="dark" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
    <div class="container-fluid">
        <div data-bs-theme="dark" class="navbar offcanvas-header ">
            <h5 class="offcanvas-title" id="menuOffcanvasLabel">Menu</h5>
            <button type="button" class="btn-close " data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>

        <div class="offcanvas-body ">
            <h6 class="offcanvas-subtitle">
                <p>Usuário:
                    @if (session('funcionario'))
                        {{ session('funcionario')->nome }}
                    @endif
                </p>

            </h6>
            <!-- Conteúdo do menu aqui -->
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                <li class="nav-item">
                    <a class="nav-link
                     @if ($page == 'Pagina Inicial') active @endif
                     "
                        aria-current="page" href="/dashboard">Inicio</a>
                </li>

                <!-- Submenu Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        @if ($page == 'Produtos') active @endif"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Produtos
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                        <li><a class="dropdown-item" href="{{ route('produto.create') }}">Cadastrar</a></li>
                        <li><a class="dropdown-item" href="{{ route('produto.listar') }}">Informação</a></li>
                        <li><a class="dropdown-item" href="{{ route('estoque.create') }}">Estoque</a></li>

                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        @if ($page == 'Vendas') active @endif"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Vendas
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                        <li><a class="dropdown-item" href="{{ route('vendas.create') }}">Cadastro</a></li>
                        <li><a class="dropdown-item" href="{{ route('vendas.info') }}">Informação</a></li>
                    </ul>
                </li>
                <!--
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        @if ($page == 'Servicos') active @endif"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Serviços
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                        <li><a class="dropdown-item" href="{{ route('servicos.create') }}">Cadastrar</a></li>
                        <li><a class="dropdown-item" href="{{ route('servicos.read') }}">Informações</a></li>
                    </ul>
                </li>-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        @if ($page == 'Clientes') active @endif"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Clientes
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                        <li><a class="dropdown-item" href="{{ route('cliente.store.create') }}">Cadastrar</a></li>
                        <li><a class="dropdown-item" href="{{ route('cliente.read.all') }}">Lista</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        @if ($page == 'Fornecedores') active @endif"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Fornecedores
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                        <li><a class="dropdown-item" href="{{ route('fornecedor.create') }}">Cadastrar</a></li>
                        <li><a class="dropdown-item" href="{{ route('fornecedores') }}">Lista</a></li>
                    </ul>
                </li>

                <!-- Outros Itens do Menu -->

                <li class="nav-item">
                    <a class="nav-link
                @if ($page == 'Cotação') active @endif
                "
                        href="{{ route('cotacaoProdutos') }}">Cotação de produtos</a>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        @if ($page == 'Empresa') active @endif
                        "
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Empresa
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">

                        @if(session('Administrador') == true)
                        <li><a class="dropdown-item" href="{{ route('contas.read') }}">Contas</a></li>
                        <li><a class="dropdown-item" href="{{ route('faturamento.read') }}">Faturamento</a></li>

                        <li><a class="dropdown-item" href="{{ route('informacoes.empresa') }}">Informações</a></li>


                        <li><a class="dropdown-item" href="{{ route('simples.create.calculadora') }}">Simples
                                Nacional</a></li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('metas.read') }}">Metas</a></li>

                    </ul>
                </li>


                <li class="nav-item">
                    <a class="nav-link
                @if ($page == 'Configurações') active @endif
                "
                        href="{{ route('configuracoes') }}">Configurações</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
                <!-- Adicione mais itens de menu conforme necessário -->
            </ul>
        </div>
    </div>
</nav>
