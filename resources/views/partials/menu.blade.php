<nav class="offcanvas offcanvas-start
@if (session('tema') == 'vermelho') bg-danger text-light navbar-dark
@elseif (session('tema') == 'verde') bg-success text-light navbar-dark
@elseif (session('tema') == 'amarelo') bg-warning text-dark
@elseif (session('tema') == 'azul') bg-primary text-light navbar-dark
@elseif (session('tema') == 'dark') bg-dark text-light navbar-light
@else bg-primary text-light navbar-dark @endif
"
    data-bs-theme="dark" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
    <div class="container-fluid">
        <div data-bs-theme="dark" class="navbar offcanvas-header ">
            <h5 class="offcanvas-title" id="menuOffcanvasLabel">Menu</h5>
            <button type="button" class="btn-close " data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>

        <div class="offcanvas-body">
            <h6 class="offcanvas-subtitle">
                <p>Usuário:
                    @if (session('funcionario'))
                        {{ session('funcionario')->nome }}
                    @endif
                </p>

            </h6>
            <!-- Conteúdo do menu aqui -->
            <ul class="navbar-nav text-light justify-content-end flex-grow-1 pe-3">

                <li class="nav-item ">
                    <a class="nav-link
                     @if ($page == 'Pagina Inicial') active @endif
                     "
                        id ="buttomMenuInicio" aria-current="page" href="/dashboard"><i class="bi bi-house"></i>
                        Inicio</a>
                </li>

                <!-- Submenu Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        @if ($page == 'Produtos') active @endif"
                        id="buttomMenuProdutos" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false"><i class="bi bi-box-seam"></i> Produtos
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">

                        <li><a id ="buttomMenuProdutosCadastrar" class="dropdown-item"
                                href="{{ route('produto.create') }}"><i class="bi bi-plus-square-fill"></i>
                                Cadastrar</a></li>
                        <li><a id ="buttomMenuProdutosLista" class="dropdown-item"
                                href="{{ route('produto.listar') }}"><i class="bi bi-box-seam-fill"></i> Lista</a>
                        </li>
                        <li><a id ="buttomMenuProdutosEstoque" class="dropdown-item"
                                href="{{ route('estoque.create') }}"><i class="bi bi-stack"></i> Estoque</a></li>

                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        @if ($page == 'Vendas') active @endif"
                        id ="buttomMenuVendas" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false"><i class="bi bi-cart"></i> Vendas
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                        <li><a id ="buttomMenuVendasCadastrar" class="dropdown-item"
                                href="{{ route('vendas.create') }}"><i class="bi bi-cart-plus-fill"></i> Cadastro</a>
                        </li>
                        <li><a id ="buttomMenuVendasLista" class="dropdown-item" href="{{ route('vendas.info') }}"> <i
                                    class="bi bi-cart-check-fill"></i> Lista</a></li>
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
                        id ="buttomMenuClientes" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false"><i class="bi bi-people"></i> Clientes
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                        <li><a id ="buttomMenuClientesCadastrar" class="dropdown-item"
                                href="{{ route('cliente.store.create') }}"><i class="bi bi-person-plus-fill"></i>
                                Cadastrar</a></li>
                        <li><a id ="buttomMenuClientesLista" class="dropdown-item"
                                href="{{ route('cliente.read.all') }}"><i class="bi bi-person-lines-fill"></i> Lista</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        @if ($page == 'Fornecedores') active @endif"
                        id ="buttomMenuFornecedores" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false"><i class="bi bi-truck"></i> Fornecedores
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                        <li><a id ="buttomMenuFornecedoresCadastrar" class="dropdown-item"
                                href="{{ route('fornecedor.create') }}"><i class="bi bi-person-plus-fill"></i>
                                Cadastrar</a></li>
                        <li><a id ="buttomMenuFornecedoresLista" class="dropdown-item"
                                href="{{ route('fornecedores') }}"><i class="bi bi-person-lines-fill"></i> Lista</a>
                        </li>
                    </ul>
                </li>

                <!-- Outros Itens do Menu -->

                <li class="nav-item">
                    <a class="nav-link
                @if ($page == 'Cotação') active @endif
                "
                        id ="buttomMenuCotacao" href="{{ route('cotacaoProdutos') }}"><i class="bi bi-cash"></i>
                        Cotação de produtos</a>
                </li>

                @if (session('Administrador') == true)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                        @if ($page == 'Empresa') active @endif
                        "
                            id ="buttomMenuEmpresa" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="bi bi-building"> </i>Empresa
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">


                            <li><a id ="buttomMenuContas" class="dropdown-item" href="{{ route('contas.read') }}"><i
                                        class="bi bi-wallet-fill"></i> Despesas</a></li>
                            <li><a id ="buttomMenuMetas" class="dropdown-item" href="{{ route('metas.read') }}"><i
                                        class="bi bi-flag-fill"></i> Metas</a></li>

                            <li><a id ="buttomMenuInformacoes" class="dropdown-item"
                                    href="{{ route('informacoes.empresa') }}"><i class="bi bi-graph-up"></i>
                                    Informações</a>
                            </li>


                            <li><a id ="buttomMenuSimples" class="dropdown-item"
                                    href="{{ route('simples.create.calculadora') }}"><i
                                        class="bi bi-calculator-fill"></i> Simulador Simples Nacional</a>
                            </li>

                            <li><a id ="buttomMenuRendaBruta" class="dropdown-item"
                                    href="{{ route('faturamento.read') }}"><i class="bi bi-cash-stack"></i> Renda
                                    Bruta</a></li>


                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link
                @if ($page == 'Configurações') active @endif
                "
                        id ="buttomMenuConfiguracoes" href="{{ route('configuracoes') }}"><i class="bi bi-gear"></i>
                        Configurações</a>
                </li>
                <li class="nav-item">
                    <a id ="buttomMenuLogout" class="nav-link" href="{{ route('logout') }}"><i
                            class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
                <!-- Adicione mais itens de menu conforme necessário -->
            </ul>
        </div>
    </div>
</nav>
