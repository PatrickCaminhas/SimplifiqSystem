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

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

</head>

<body class="bg-black">
    <!-- Menu superior -->
    @include('partials.header')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title display-6 text-center">Dados da empresa</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Nome: {{ $informacaoEmpresa->nome }}</h5>
                                    <p class="card-text">CNPJ: {{ $informacaoEmpresa->cnpj }}</p>
                                    <p class="card-text">Tipo de empresa:
                                        @if ($informacaoEmpresa->tamanho_empresa == 'pequenaempresa')
                                            Empresa de pequeno porte (EPP)
                                        @elseif($informacaoEmpresa->tamanho_empresa == 'microempresa')
                                            Microempresa(ME)
                                        @elseif($informacaoEmpresa->tamanho_empresa == 'mei')
                                            Microempreendedor Individual (MEI)
                                        @endif

                                    </p>
                                    <p class="card-text">Setor: {{ $informacaoEmpresa->tipo_empresa }}</p>
                                    <p class="card-text">Telefone do responsavel: {{ $informacaoEmpresa->telefone }}</p>
                                    <p class="card-text">Estado no sistema: {{ ucfirst($informacaoEmpresa->estado) }}
                                    </p>
                                    <p class="card-text">Padrão de cores do sistema:
                                        {{ ucfirst($informacaoEmpresa->padrao_cores) }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="card-text">Logo:
                                        @if ($informacaoEmpresa->logo)
                                            <img src="{{ $informacaoEmpresa->logo }}" alt="Logo da empresa"
                                                class="img-fluid">
                                        @else
                                            a empresa não possui logo!
                                        @endif
                                    </p>
                                    <p class="card-text">Inicio no sistema: {{ $informacaoEmpresa->created_at }}</p>
                                    <h5 class="card-title">Ações</h5>
                                    <p href="#" class="btn btn-primary">Alterar dados da empresa</p>
                                    <br>
                                    <p href="#" class="btn btn-primary">Alterar tema da empresa </p>
                                    <br>
                                    <p href="#" class="btn btn-primary">Historico de faturamentos</p>
                                    <br>
                                    <p href="#" class="btn btn-primary">Cadastrar faturamento</p>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-2 col-12 mb-5 ">
                <div class="row">
                    <div class="col-12 mt-2">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title text-center">Informações da empresa</h5>

                                <div class=row>
                                <div class="col-6">
                                    <p class="card-text">Quantidade de clientes no crediário: {{$crediarioClientes->qtdClientes}}.</p>
                                    <p class="card-text">Valor total a receber no crediário: R$ {{$crediarioClientes->valorTotal}}.</p>
                                    <p class="card-text">Quantidade de produtos com estoque: {{$produtos->qtdProdutosEmEstoque}}.</p>
                                <p class="card-text">Lista de produtos mais vendidos: </p>
                                </div>
                                <div class="col-6">
                                    <p class="card-text">Quantidade de produtos em falta: {{$produtos->qtdProdutosSemEstoque}}.</p>
                                    <p class="card-text">Total de produtos em estoque: {{$produtos->estoque}}.</p>
                                    <p class="card-text">Valor total em estoque: R$ {{$produtos->valorTotalEmEstoque}},00</p>
                                <p class="card-text">Lista de produtos menos vendidos: </p>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Vendas nos ultimos 6 meses</h5>
                                <canvas id="vendasChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Vendas diarias do mês atual</h5>
                                <canvas id="vendasDiariasChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Despesas dos ultimos 6 meses</h5>
                                <canvas id="despesasChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Despesas diarias do mês atual</h5>
                                <canvas id="despesasDiariasChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Vendas por metodo de pagamento nos ultimos 12 meses</h5>
                                <canvas id="vendasPorMetodoPagamentoChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 mt-2">
                        <div class="card h-auto">
                            <div class="card-body">
                                <h5 class="card-title">Vendas por crédiario nos ultimos 6 meses</h5>
                                <canvas id="crediarioSeisMesesChart"></canvas>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            <!-- Features Section -->

            <!-- Inclua os arquivos JavaScript do Bootstrap -->
            <script>
                const chartvsmeses = document.getElementById('vendasChart').getContext('2d');
                const vendasData = @json(array_values($vendasPorMes));
                const labelvsm = @json(array_keys($vendasPorMes));

                const vendasChart = new Chart(chartvsmeses, {
                    type: 'bar', // ou 'line' para um gráfico de linha
                    data: {
                        labels: labelvsm,
                        datasets: [{
                            label: 'Vendas',
                            data: vendasData,
                            backgroundColor: 'rgba(5, 171, 0, 0.8)',
                            borderColor: 'rgba(5, 171, 0, 0.8)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
            <script>
                const chartvdiarias = document.getElementById('vendasDiariasChart').getContext('2d');
                const vendasDiariasData = @json(array_values($vendasDiarias));
                const labelvd = @json(array_keys($vendasDiarias));

                const vendasDiariasChart = new Chart(chartvdiarias, {
                    type: 'line', // ou 'line' para um gráfico de linha
                    data: {
                        labels: labelvd,
                        datasets: [{
                            label: 'Vendas',
                            data: vendasDiariasData,
                            backgroundColor: 'rgba(5, 171, 0, 0.8)',
                            borderColor: 'rgba(5, 171, 0, 0.8)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
            <script>
                const ctx = document.getElementById('vendasPorMetodoPagamentoChart').getContext('2d');
                const vendasPorMetodoPagamentoData = @json(array_values($vendasPorMetodoPagamento));
                const labelsMetodosPagamento = @json(array_keys($vendasPorMetodoPagamento));

                const vendasPorMetodoPagamentoChart = new Chart(ctx, {
                    type: 'pie', // Gráfico de torta/pizza
                    data: {
                        labels: labelsMetodosPagamento,
                        datasets: [{
                            label: 'Métodos de Pagamento',
                            data: vendasPorMetodoPagamentoData,
                            backgroundColor: [
                                'rgba(5, 149, 0, 1)', // Dinheiro
                                'rgba(217, 0, 56, 1)', // Pix
                                'rgba(106, 0, 157, 1)', // Cartão de crédito
                                'rgba(0, 89, 208, 1)', // Cartão de débito
                                'rgba(217, 102, 0, 1)' // Crediário
                            ],
                            borderColor: [
                                'rgba(5, 149, 0, 1)',
                                'rgba(217, 0, 56, 1)',
                                'rgba(106, 0, 157, 1)',
                                'rgba(0, 89, 208, 1)',
                                'rgba(217, 102, 0, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            datalabels: {
                                color: '#fff', // Cor do texto
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                formatter: (value, ctx) => {
                                    if (value === 0) {
                                        return ''; // Não exibe nada se o valor for zero
                                    }
                                    let total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    let percentage = (value / total * 100).toFixed(1) + "%";
                                    return percentage; // Exibir a porcentagem dentro da fatia
                                },
                                align: 'center', // Alinha o texto ao centro da fatia
                            }
                        }
                    },
                    plugins: [ChartDataLabels] // Adiciona o plugin de Data Labels
                });
            </script>

            <script>
                const chartdsmeses = document.getElementById('despesasChart').getContext('2d');
                const despesasData = @json(array_values($despesasPorMes));
                const labeldsm = @json(array_keys($despesasPorMes));

                const despesasChart = new Chart(chartdsmeses, {
                    type: 'bar', // ou 'line' para um gráfico de linha
                    data: {
                        labels: labeldsm,
                        datasets: [{
                            label: 'Despesas',
                            data: despesasData,
                            backgroundColor: 'rgba(214, 11, 11, 1)',
                            borderColor: 'rgba(214, 11, 11, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
            <script>
                const chartddiarias = document.getElementById('despesasDiariasChart').getContext('2d');
                const despesasDiariasData = @json(array_values($despesasDiarias));
                const labeldd = @json(array_keys($despesasDiarias));

                const despesasDiariasChart = new Chart(chartddiarias, {
                    type: 'line', // ou 'line' para um gráfico de linha
                    data: {
                        labels: labeldd,
                        datasets: [{
                            label: 'Despesas',
                            data: despesasDiariasData,
                            backgroundColor: 'rgba(214, 11, 11, 1)',
                            borderColor: 'rgba(214, 11, 11, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
            <script>
                const chartcredsmeses = document.getElementById('crediarioSeisMesesChart').getContext('2d');
                const crediarioData = @json(array_values($despesasPorMes));
                const labelcsm = @json(array_keys($despesasPorMes));

                const crediarioSeisMesesChart = new Chart(chartcredsmeses, {
                    type: 'bar', // ou 'line' para um gráfico de linha
                    data: {
                        labels: labelcsm,
                        datasets: [{
                            label: 'Crediário',
                            data: crediarioData,
                            backgroundColor: 'rgba(44, 43, 43, 1)',
                            borderColor: 'rgba(44, 43, 43, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Esta linha inverte os eixos para exibir o gráfico horizontal
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
