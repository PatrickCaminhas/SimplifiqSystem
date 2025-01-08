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

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')
    <div class="container mt-2 col-12 mb-3 ">
        <div class="row">

            <div id="produto_info" class="col-md-6 col-lg-6 col-sm-12 mt-2">
                <div class="card mb-2 h-100">
                    <div class="card-body">


                        <h5 class="card-title">Informações do produto</h5>
                        <p class="card-text">ID: {{ $produto->id }}</p>
                        <p class="card-text">Nome: {{ $produto->nome }}</p>
                        <p class="card-text">Categoria: {{ $produto->categoria->nome }}</p>
                        <p class="card-text">Valor Compra: R$ {{ $produto->preco_compra }}</p>
                        <p class="card-text">Preço venda: R$ {{ $produto->preco_venda }}</p>
                        <p class="card-text">Ultimo fornecedor: {{ $produto->ultimo_fornecedor }}</p>
                        <p class="card-text">Estoque: {{ $produto->quantidade }}</p>

                    </div>
                </div>
            </div>

            <div id="produto_acoes" class="col-md-6 col-lg-6 col-sm-12 mt-2">
                <div class="card mb-2 h-100 d-flex">
                    <div class="card-body">
                        <h5 class="card-title">Ações</h5>
                        <a href="{{ route('produto.edit', ['id' => $produto->id]) }}" class="btn btn-primary">Alterar
                            dados</a>
                        <a href="{{ route('produto.preco', ['id' => $produto->id]) }}" class="btn btn-primary">Alterar
                            preço de venda</a>
                        <a href="#" class="btn btn-danger">Excluir produto</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">Estoque</h5>
                        <p class="card-text">
                            <!-- GRAFICO DE ESTOQUE -->
                        <div>
                            <canvas id="estoqueChart"></canvas>
                        </div>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Features Section -->

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const estoqueData = {!! json_encode($estoque) !!};

            // Filtra os dados de baixas, vendas e reposições
            const baixas = estoqueData.filter(item => item.acao === 'baixa');
            const vendas = estoqueData.filter(item => item.acao === 'Venda');
            const reposicoes = estoqueData.filter(item => item.acao === 'reposicao');

            // Extrai os meses (presumindo que os meses estão no formato de string)
            const meses = estoqueData.map(item => item.mes);

            // Extrai as quantidades para baixas e reposições
            const quantidadeBaixas = baixas.map(item => item.quantidade);
            const quantidadeVendas = vendas.map(item => item.quantidade);
            const quantidadeReposicoes = reposicoes.map(item => item.quantidade);

            const ctx = document.getElementById('estoqueChart').getContext('2d');
            const estoqueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [...new Set(meses)], // Remove duplicatas dos meses
                    datasets: [{
                            label: 'Baixas',
                            data: quantidadeBaixas, // Quantidade de baixas
                            borderColor: 'rgba(247, 39, 39, 1)',
                            backgroundColor: 'rgba(247, 39, 39, 1)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'Vendas',
                            data: quantidadeVendas, // Quantidade de vendas
                            borderColor: 'rgba(39, 247, 46, 1)',
                            backgroundColor: 'rgba(39, 247, 46, 1)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'Reposições',
                            data: quantidadeReposicoes, // Quantidade de reposições
                            borderColor: 'rgba(38, 72, 255, 1)',
                            backgroundColor: 'rgba(38, 72, 255, 1)',
                            fill: false,
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Meses'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Quantidade'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
