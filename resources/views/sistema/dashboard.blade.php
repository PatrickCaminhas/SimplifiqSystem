@php
    $data_tables = true;
    $chartjs = true;
    $jquery = true;
@endphp
@extends('layouts.padrao')

@section('conteudo')
    <div class="container mt-4">
        <div class="row">
           <!-- <h5 class="display-6 text-white">Bem vindo,
                @if (session('funcionario'))
                    {{ session('funcionario')->nome }}!
                @endif
            </h5> -->

            <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                <div class="card mb-2 h-100 d-flex justify-content-center align-items-center">
                    <div class="card-body">
                        <h5 class="mb-4">Resumo das atividades</h5>
                        <div class="row gy-3">
                            <!-- Produtos Cadastrados -->
                            <div class="col-md-4 col-sm-6">
                                <div class="card text-bg-primary shadow-sm border-0 h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-boxes display-6 mb-2"></i>
                                        <h6 class="card-text">
                                            {{ $cartoesDashboard->produtosCadastrados }} produtos cadastrados
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <!-- Clientes Cadastrados -->
                            <div class="col-md-4 col-sm-6">
                                <div class="card text-bg-warning shadow-sm border-0 h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-people-fill display-6 mb-2"></i>
                                        <h6 class="card-text">
                                            {{ $cartoesDashboard->clientesCadastrados }} clientes cadastrados
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <!-- Vendas Realizadas -->
                            <div class="col-md-4 col-sm-6">
                                <div class="card text-bg-danger shadow-sm border-0 h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-cart-check-fill display-6 mb-2"></i>
                                        <h6 class="card-text">
                                            {{ $cartoesDashboard->vendasRealizadas }} vendas realizadas
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <!-- Estoque -->
                            <div class="col-md-4 col-sm-6">
                                <div class="card bg-black text-white shadow-sm border-0 h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-box-seam display-6 mb-2"></i>
                                        <h6 class="card-text">
                                            {{ $cartoesDashboard->itensNoEstoque }} bens em estoque
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <!-- Metas Cumpridas -->
                            <div class="col-md-4 col-sm-6">
                                <div class="card text-bg-success shadow-sm border-0 h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-graph-up-arrow display-6 mb-2"></i>
                                        <h6 class="card-text">
                                            {{ $cartoesDashboard->metasCumpridas }} metas cumpridas
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <!-- Metas em Andamento -->
                            <div class="col-md-4 col-sm-6">
                                <div class="card text-bg-info shadow-sm border-0 h-100">
                                    <div class="card-body text-center">
                                        <i class="bi bi-hourglass-split display-6 mb-2"></i>
                                        <h6 class="card-text">
                                            {{ $cartoesDashboard->metasEmAndamento }} metas em andamento
                                        </h6>
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

@endsection
@push('scripts')
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
        const chartvsdias = document.getElementById('vendasChart').getContext('2d');

        // Passando os dados do controlador
        const vendasData = @json($vendasSemana->pluck('total_vendas')->toArray()); // Valores somados de vendas
        const labelvsm = @json($vendasSemana->pluck('data')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d/m/Y'))->toArray());

        // Criando o gráfico
        const vendasChart = new Chart(chartvsdias, {
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
        $(document).ready(function() {
            // Ativar tooltips do Bootstrap
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Adicionar animação nos cards ao passar o mouse
            $(".card").hover(
                function() {
                    $(this).addClass("shadow-lg");
                },
                function() {
                    $(this).removeClass("shadow-lg");
                }
            );
        });
    </script>
@endpush
