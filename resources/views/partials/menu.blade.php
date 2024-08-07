<div class="offcanvas offcanvas-start
@if ($padrao_cores == 'vermelho') bg-danger text-light navbar-dark
@elseif ($padrao_cores == 'verde') bg-success text-light navbar-dark
@elseif ($padrao_cores == 'amarelo') bg-warning text-dark
@elseif ($padrao_cores == 'azul') bg-primary text-light navbar-dark
@else bg-primary text-light navbar-dark @endif
"
    data-bs-theme="dark" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
    <div data-bs-theme="dark" class="navbar offcanvas-header">
        <h5 class="offcanvas-title" id="menuOffcanvasLabel">Menu</h5>
        <button type="button" class="btn-close " data-bs-dismiss="offcanvas" aria-label="Fechar"></button>

    </div>

    <div class="offcanvas-body ">
        <h6 class="offcanvas-subtitle">
            <p>Bem-vindo,
                @if (session('funcionario'))
                    {{ session('funcionario')->nome }}!
            </p>
            @endif

        </h6>
        <!-- Conteúdo do menu aqui -->
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

            <li class="nav-item ">
                <b> <a class="nav-link
                     @if($page == 'dashboard') active @endif
                     " aria-current="page" href="/dashboard">Inicio</a></b>
            </li>

            @if (isset($menu) && $menu == 'Comércio' || isset($menu) && $menu == 'Indústria')
                <li class="nav-item">
                    <a class="nav-link
                    @if($page == 'cadastroproduto') active @endif
                    " href="{{ route('cadastroproduto') }}">Cadastro de produto</a>
                </li>
            @elseif(isset($menu) && $menu == 'Serviços')
                <li class="nav-item
                @if($page == 'cadastroservicos') active @endif
                ">
                    <a class="nav-link" href="{{ route('servicos.tipo.read') }}">Cadastro de serviços</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link
                @if($page == 'cadastroFornecedor') active @endif
                " href="{{ route('cadastrofornecedor') }}">Cadastro de fornecedor
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                @if($page == 'cotacao') active @endif
                " href="cotacaoprodutos">Cotação de produtos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                @if($page == 'informacaoProduto') active @endif
                " href="{{ route('produto.listar') }}">Informação de produto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                @if($page == 'informacaoEmpresa') active @endif
                " href="#">Informação da empresa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                @if($page == 'calculadoraEmpresarial') active @endif
                " href="#">Calculadora empresarial</a>
            </li>
            <li class="nav-item">
                <a class="nav-link
                @if($page == 'confirguracoes') active @endif
                " href="{{ route('configuracoes') }}">Configurações</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
            </li>
            <!-- Adicione mais itens de menu conforme necessário -->
        </ul>
    </div>
</div>
