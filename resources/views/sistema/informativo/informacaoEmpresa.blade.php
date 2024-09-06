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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-black">
    <!-- Menu superior -->
    @include('partials.header')

    <!-- Offcanvas para o menu -->
    @include('partials.menu')

    <!-- Offcanvas para notificações -->
    @include('partials.notificacoes')

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title display-6 text-center">Dados da empresa</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
                                    <p href="#" class="btn btn-primary">Alterar logo da empresa </p>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5 mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Despesas dos ultimos 6 meses</h5>
                                <canvas id="despesasChart"></canvas>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Despesas diarias do mês atual</h5>
                                <canvas id="despesasDiariasChart"></canvas>



                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Fácil de Usar</h5>
                                <p class="card-text">
                                    aaa

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Fornecedores por % de produto</h5>
                                <img src="{{ global_asset('img/Screenshot_2.png') }}" alt="Descrição da Imagem"
                                    class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Proximas contas</h5>
                                <table class="table table-light  border table-dorder table-hover">
                                    <thead class="table-group-divider">
                                        <tr class="">
                                            <th class=" ">Data</th>
                                            <th class="">Conta</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider ">
                                        <tr class="text-danger">
                                            <th class="text-danger">03/05</th>
                                            <th class="text-danger">Energia eletrica</th>
                                        </tr>
                                        <tr class="">
                                            <th class="">11/05</th>
                                            <th class="">Pedido #00077</th>
                                        </tr>
                                        <tr class="">
                                            <th class="">15/05</th>
                                            <th class="">Água e esgoto</th>
                                        </tr>
                                        <tr class="">
                                            <th class="">15/05</th>
                                            <th class="">Pedido #00078</th>
                                        </tr>
                                        <tr class="">
                                            <th class="">19/05</th>
                                            <th class="">Aluguel</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="btn @include('partials.buttomCollor')">Ver todas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->

            <!-- Inclua os arquivos JavaScript do Bootstrap -->
            <script>
                const ctxs = document.getElementById('despesasChart').getContext('2d');
                const despesasData = @json(array_values($despesasPorMes));
                const labelsm = @json(array_keys($despesasPorMes));

                const despesasChart = new Chart(ctxs, {
                    type: 'bar', // ou 'line' para um gráfico de linha
                    data: {
                        labels: labelsm,
                        datasets: [{
                            label: 'Despesas',
                            data: despesasData,
                            backgroundColor: 'rgba(214, 11, 11, 1)',
                            borderColor: 'rgba(214, 11, 11, 1)',
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
                const ctxm = document.getElementById('despesasDiariasChart').getContext('2d');
                const despesasDiariasData = @json(array_values($despesasDiarias));
                const labelsd = @json(array_keys($despesasDiarias));

                const despesasDiariasChart = new Chart(ctxm, {
                    type: 'line', // ou 'line' para um gráfico de linha
                    data: {
                        labels: labelsd,
                        datasets: [{
                            label: 'Despesas',
                            data: despesasDiariasData,
                            backgroundColor: 'rgba(214, 11, 11, 1)',
                            borderColor: 'rgba(214, 11, 11, 1)',
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
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
