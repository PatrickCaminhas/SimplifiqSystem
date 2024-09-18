<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Simplifiq</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json">

</head>

<body class="bg-black">
    <!-- Menu superior -->
    @include('partials.header')

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <h5 class="display-6 text-white">Bem vindo,
                    @if (session('funcionario'))
                        {{ session('funcionario')->nome }}!
                    @endif
                </h5>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title display-6">Dashboard</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <div class="card text-bg-primary m-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->produtosCadastrados }}
                                                    produtos cadastrados</h6>
                                            </div>
                                        </div>
                                        <div class="card text-bg-warning m-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->clientesCadastrados }}
                                                    clientes cadastrados</h6>
                                            </div>
                                        </div>
                                        <div class="card text-bg-dark m-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->vendasRealizadas }} vendas
                                                    realizadas</h6>
                                            </div>
                                        </div>
                                        <div class="card text-bg-success m-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->itensNoEstoque }} bens em
                                                    estoque</h6>
                                            </div>
                                        </div>
                                        <div class="card text-bg-danger m-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->metasCumpridas }} metas
                                                    cumpridas</h6>
                                            </div>
                                        </div>
                                        <div class="card text-bg-info m-2 col-md-3 col-sm-4">
                                            <div class="card-body d-flex align-items-center">
                                                <h6 class="card-text">{{ $cartoesDashboard->metasEmAndamento }} metas em
                                                    andamento</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="card-text">GRAFICO
                                        [COLOCAR GRAFICO AQUI]
                                    </p>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-2 col-12 mb-5 ">
                <div class="row">

                    <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                        <div class="card mb-2">
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
                   <!-- <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Ultimos produtos cadastrados</h5>
                                <table id="produtosCadastrados" class="display">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Quantidade</th>
                                            <th>Preço de venda</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ultimos6Produtos as $produto)
                                            <tr>
                                                <td style="overflow-x: auto;">
                                                    {{ $produto->nome . ' ' . $produto->modelo . ' ' . $produto->marca }}
                                                </td>
                                                <td style="overflow-x: auto;">{{ $produto->quantidade }}</td>
                                                <td style="overflow-x: auto;">R${{ $produto->preco_venda }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Metas faltando 1 semana</h5>
                                @if ($metasFaltandoUmaSemana->count() == 0)
                                    <tr>
                                        <td colspan="2">Nenhuma meta faltando uma semana</td>
                                    </tr>
                                @else
                                    <table id="metas" class="display">
                                        <thead>
                                            <tr>
                                                <th>Objetivo</th>
                                                <th>Valor atual</th>
                                                <th>Final</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($metasFaltandoUmaSemana as $meta)
                                                <tr>
                                                    <td style="overflow-x: auto;">{{ $meta->valor }}</td>
                                                    <td style="overflow-x: auto;">{{ $meta->valor_atual }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($meta->ending_at)->format('d/m/Y') }}

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>


                                @endif
                            </div>
                        </div>
                    </div>-->
                    <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                        <div class="card">
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


            <!-- Features Section -->

            <!-- Inclua os arquivos JavaScript do Bootstrap -->
            <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

</body>

</html>
