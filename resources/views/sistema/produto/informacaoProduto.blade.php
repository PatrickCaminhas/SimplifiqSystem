<!DOCTYPE html>
<html lang="pt-br">

@include('partials.head', ['chart' => true])

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
                        <a href="{{ route('produto.edit', ['id' => $produto->id]) }}" class="btn @include('partials.buttomCollor')">Alterar
                            dados</a>
                        <a href="{{ route('produto.preco', ['id' => $produto->id]) }}" class="btn @include('partials.buttomCollor')">Alterar
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
    @vite('resources/js/app.js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const estoqueData = {!! json_encode($estoque) !!};

            // Agrupar as quantidades de cada ação por mês/ano
            const groupedData = estoqueData.reduce((acc, item) => {
                const mesAno = `${String(item.mes).padStart(2, '0')}/${item.ano}`; // Formato MM/YYYY
                if (!acc[mesAno]) {
                    acc[mesAno] = {
                        baixa: 0,
                        venda: 0,
                        reposicao: 0
                    }; // Inicializa as quantidades para o mês/ano
                }
                // Sumariza as quantidades de acordo com a ação
                if (item.acao === 'baixa') {
                    acc[mesAno].baixa += item.quantidade;
                } else if (item.acao === 'Venda') {
                    acc[mesAno].venda += item.quantidade;
                } else if (item.acao === 'reposicao') {
                    acc[mesAno].reposicao += item.quantidade;
                }
                return acc;
            }, {});

            // Extrair os meses/anos ordenados e as quantidades para cada ação
            const mesesAnos = Object.keys(groupedData).sort((a, b) => {
                // Ordenar os meses/anos no formato MM/YYYY
                const [mesA, anoA] = a.split('/').map(Number);
                const [mesB, anoB] = b.split('/').map(Number);
                return new Date(anoA, mesA - 1) - new Date(anoB, mesB - 1);
            });

            // Preencher os arrays de quantidades, garantindo que todos os meses estejam no gráfico
            const quantidadeBaixas = mesesAnos.map(mesAno => groupedData[mesAno].baixa);
            const quantidadeVendas = mesesAnos.map(mesAno => groupedData[mesAno].venda);
            const quantidadeReposicoes = mesesAnos.map(mesAno => groupedData[mesAno].reposicao);

            const ctx = document.getElementById('estoqueChart').getContext('2d');
            const estoqueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: mesesAnos, // Meses/anos ordenados
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
                                text: 'Meses/Ano'
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
