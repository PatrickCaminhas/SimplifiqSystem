<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar Toggle</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .sidebar {
      height: 100vh; /* Faz a sidebar ocupar toda a altura */
      background-color: #f8f9fa; /* Cor de fundo */
      border-right: 1px solid #dee2e6; /* Borda para separar */
      transition: width 0.3s; /* Animação ao esconder/exibir */
      overflow: hidden; /* Esconde o conteúdo quando estiver colapsada */
    }
    .sidebar.collapsed {
      width: 0; /* Sidebar colapsada */
    }
    .sidebar:not(.collapsed) {
      width: 250px; /* Largura padrão da sidebar */
    }
    .main-content {
      transition: margin-left 0.3s; /* Suaviza o redimensionamento do conteúdo */
    }
    .main-content.expanded {
      margin-left: 250px; /* Espaço para a sidebar */
    }
    .main-content.full {
      margin-left: 0; /* Quando a sidebar está escondida */
    }
  </style>
</head>
<body>
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
          <button id="toggleSidebar"
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

      </div>
  </header>
  <div class="d-flex">
    <!-- Sidebar -->


    <nav class="sidebar collapsed
    @if (session('tema') == 'vermelho') bg-danger text-light navbar-dark
    @elseif (session('tema') == 'verde') bg-success text-light navbar-dark
    @elseif (session('tema') == 'amarelo') bg-warning text-dark
    @elseif (session('tema') == 'azul') bg-primary text-light navbar-dark
    @else bg-primary text-light navbar-dark @endif
    "    id="sidebar"
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

                         "
                            id ="buttomMenuInicio" aria-current="page" href="/dashboard">Inicio</a>
                    </li>

                    <!-- Submenu Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                            "
                            id="buttomMenuProdutos" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Produtos
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                            <li><a id ="buttomMenuProdutosCadastrar" class="dropdown-item"
                                    href="{{ route('produto.create') }}">Cadastrar</a></li>
                            <li><a id ="buttomMenuProdutosLista" class="dropdown-item"
                                    href="{{ route('produto.listar') }}">Informação</a></li>
                            <li><a id ="buttomMenuProdutosEstoque" class="dropdown-item"
                                    href="{{ route('estoque.create') }}">Estoque</a></li>

                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                            "
                            id ="buttomMenuVendas" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Vendas
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                            <li><a id ="buttomMenuVendasCadastrar" class="dropdown-item"
                                    href="{{ route('vendas.create') }}">Cadastro</a></li>
                            <li><a id ="buttomMenuVendasLista" class="dropdown-item"
                                    href="{{ route('vendas.info') }}">Informação</a></li>
                        </ul>
                    </li>
                    <!--
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                            "
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Serviços
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                            <li><a class="dropdown-item" href="{{ route('servicos.create') }}">Cadastrar</a></li>
                            <li><a class="dropdown-item" href="{{ route('servicos.read') }}">Informações</a></li>
                        </ul>
                    </li>-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                            "
                            id ="buttomMenuClientes" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Clientes
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                            <li><a id ="buttomMenuClientesCadastrar" class="dropdown-item"
                                    href="{{ route('cliente.store.create') }}">Cadastrar</a></li>
                            <li><a id ="buttomMenuClientesLista" class="dropdown-item"
                                    href="{{ route('cliente.read.all') }}">Lista</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                            "
                            id ="buttomMenuFornecedores" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Fornecedores
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">
                            <li><a id ="buttomMenuFornecedoresCadastrar" class="dropdown-item"
                                    href="{{ route('fornecedor.create') }}">Cadastrar</a></li>
                            <li><a id ="buttomMenuFornecedoresLista" class="dropdown-item"
                                    href="{{ route('fornecedores') }}">Lista</a></li>
                        </ul>
                    </li>

                    <!-- Outros Itens do Menu -->

                    <li class="nav-item">
                        <a class="nav-link

                    "
                            id ="buttomMenuCotacao" href="{{ route('cotacaoProdutos') }}">Cotação de produtos</a>
                    </li>

                    @if (session('Administrador') == true)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle

                            "
                                id ="buttomMenuEmpresa" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Empresa
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark @include('partials.bgCollor')">


                                <li><a id ="buttomMenuContas" class="dropdown-item"
                                        href="{{ route('contas.read') }}">Contas</a></li>
                                <li><a id ="buttomMenuMetas" class="dropdown-item"
                                        href="{{ route('metas.read') }}">Metas</a></li>

                                <li><a id ="buttomMenuInformacoes" class="dropdown-item"
                                        href="{{ route('informacoes.empresa') }}">Informações</a>
                                </li>


                                <li><a id ="buttomMenuSimples" class="dropdown-item"
                                        href="{{ route('simples.create.calculadora') }}">Simulador Simples Nacional</a>
                                </li>

                                <li><a id ="buttomMenuRendaBruta" class="dropdown-item"
                                        href="{{ route('faturamento.read') }}">Renda Bruta</a></li>


                            </ul>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link

                    "
                            id ="buttomMenuConfiguracoes" href="{{ route('configuracoes') }}">Configurações</a>
                    </li>
                    <li class="nav-item">
                        <a id ="buttomMenuLogout" class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                    <!-- Adicione mais itens de menu conforme necessário -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- Conteúdo principal -->
    <div class="container mt-4">
        <div class="row">
            <h5 class="display-6 text-white">Bem vindo,
                @if (session('funcionario'))
                    {{ session('funcionario')->nome }}!
                @endif
            </h5>


            <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                <div class="card mb-2 h-100 d-flex justify-content-center align-items-center">

                    <div class="card-body">
                        <h5>Resumo das atividades</h5>
                        <div class=" mb-2 h-100 d-flex">
                            <div class="card-body text-center">

                                <div class="row">

                                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                                        <div class="card text-bg-primary mb-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->produtosCadastrados }}
                                                    produtos cadastrados</h6>
                                            </div>
                                        </div>
                                        <div class="card text-bg-warning  mb-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->clientesCadastrados }}
                                                    clientes cadastrados</h6>
                                            </div>
                                        </div>
                                        <div class="card text-bg-secondary  mb-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->vendasRealizadas }} vendas
                                                    realizadas</h6>
                                            </div>
                                        </div>
                                        <div class="card text-bg-dark  mb-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->itensNoEstoque }} bens em
                                                    estoque</h6>
                                            </div>
                                        </div>
                                        <div class="card text-bg-success  mb-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->metasCumpridas }} metas
                                                    cumpridas</h6>
                                            </div>
                                        </div>
                                        <div class="card text-bg-info  mb-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->metasEmAndamento }} metas em
                                                    andamento</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                <div class="card h-100 d-flex">
                    <div class="card-body">

                        <h5 class="card-title">Vendas da ultima semana</h5>
                        <canvas id="vendasChart"></canvas>

                    </div>
                </div>
            </div>
        </div>
            <div class="row mt-2 mb-4">

                <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                    <div class="card mb-2 h-100 d-flex ">
                        <div class="card-body">
                            <h5 class="card-title">Ultimas vendas cadastradas</h5>
                            <table id="vendasCadastradas" class="display">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Data</th>
                                        <th>Valor</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ultimas6Vendas as $venda)
                                        <tr>
                                            <td style="overflow-x: auto;">{{ $venda->cliente->nome }}</td>

                                            <td>{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y') }}
                                            </td>
                                            <td style="overflow-x: auto;">{{ $venda->valor_total }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12  mt-2 ">
                    <div class="card h-100 d-flex">
                        <div class="card-body">
                            <h5 class="card-title">Proximas contas</h5>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>Vencimento</th>
                                        <th>Credor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contas as $conta)
                                        @if ($conta->estado == 'Pendente' || $conta->estado == 'Vencida')
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}
                                                </td>
                                                <td style="overflow-x: auto;">{{ $conta->credor }}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>


                        </div>
                    </div>


            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
                "pageLength": 6,
                "lengthChange": false,
            });
        });
        $(document).ready(function() {
            $('#produtosCadastrados').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
                "pageLength": 6,
                "lengthChange": false,
            });
        });
        $(document).ready(function() {
            $('#vendasCadastradas').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
                "pageLength": 6,
                "lengthChange": false,
            });
        });
        $(document).ready(function() {
            $('#metas').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
                "pageLength": 6,
                "lengthChange": false,
            });
        });
    </script>

    <script>
        const chartvsmeses = document.getElementById('vendasChart').getContext('2d');

        // Passando os dados do controlador
        const vendasData = @json($vendasSemana->pluck('total_vendas')->toArray()); // Valores somados de vendas
        const labelvsm = @json($vendasSemana->pluck('data')->toArray()); // Datas das vendas

        // Criando o gráfico
        const vendasChart = new Chart(chartvsmeses, {
            type: 'bar', // Gráfico de barras
            data: {
                labels: labelvsm,
                datasets: [{
                    label: 'Vendas',
                    data: vendasData,
                    backgroundColor: 'rgba(5, 171, 0, 0.8)', // Cor da barra
                    borderColor: 'rgba(5, 171, 0, 0.8)', // Cor da borda da barra
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                // Exibir o valor no topo de cada barra
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'R$ ' + tooltipItem.raw.toFixed(2); // Exibe o valor formatado
                            }
                        }
                    },
                    datalabels: {
                        display: true,
                        align: 'end',
                        formatter: function(value) {
                            return 'R$ ' + value.toFixed(2); // Exibe o valor na barra
                        }
                    }
                }
            }
        });
    </script>

  <script>
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    toggleButton.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed'); // Alterna a classe 'collapsed' na sidebar
      if (sidebar.classList.contains('collapsed')) {
        mainContent.classList.remove('expanded');
        mainContent.classList.add('full');
      } else {
        mainContent.classList.remove('full');
        mainContent.classList.add('expanded');
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
