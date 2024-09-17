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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-black bg-gradient">

    <!-- Menu superior -->
    @include('partials.header')







    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body row" style="overflow-x: auto;">
                            <h2 class="text-center">Estatisticas da meta #{{ $meta->id }}</h2>
                            <div class="col-6">
                                <div style="width: 75%; margin: auto;">
                                    <canvas id="myChart"></canvas>
                                </div>

                            </div>
                            <div class="col-6">
                                <p>Começo: {{$informacoes->data_inicial}} | Fim:  {{$informacoes->data_final}}</p>

                                <p>Maior progresso: {{$informacoes->maiorProgresso}} | Data: {{$informacoes->diaComMaiorProgresso}}</p>
                                <p>Menor progresso: {{$informacoes->menorProgresso}} | Data: {{$informacoes->diaComMenorProgresso}}</p>

                                <p>Diferença de dias ultimo progresso para data final: {{$informacoes->diferencaDias}} dias</p>
                                <p>Data do ultimo progresso: {{$informacoes->UltimoProgresso}}</p>
                                <p>
                                    @if($informacoes->estado == "Finalizada" || $informacoes->estado == "Cumprida")
                                    Excedido {{$informacoes->porcentagem}} da meta em {{$informacoes->total}}
                                    @endif
                                </p>
                                <a href="{{ route('metas.read') }}" class="btn btn-primary">Voltar</a>
                            </div>

                        </div>

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
            });
        });
    </script>

    <script>
        // Agora você pode usar o Chart.js diretamente
        const ctx = document.getElementById('myChart').getContext('2d');
        const progressos = @json($progressos);
        var datas = [];
        // Função para converter a data no formato desejado
        function formatarData(data) {
            var dateObj = new Date(data);

            var dia = String(dateObj.getDate()).padStart(2, '0');
            var mes = String(dateObj.getMonth() + 1).padStart(2, '0'); // Meses são baseados em zero
            var ano = dateObj.getFullYear();

            return dia + '/' + mes + '/' + ano;
        }

        // Itera sobre os progressos e armazena as datas formatadas no array
        progressos.forEach(function(progresso) {
            var dataOriginal = progresso.created_at;
            var dataFormatada = formatarData(dataOriginal);

            datas.push(dataFormatada);
        });

        // Configuração do gráfico
        const myChart = new Chart(ctx, {
            type: 'line', // Tipo de gráfico
            data: {
                labels: datas, // Usa o array 'datas' como labels
                datasets: [{
                    label: 'Progresso da Meta',
                    data: progressos.map(progresso => progresso.valor), // Mapeia os valores dos progressos
                    backgroundColor: 'rgba(13, 131, 4, 0.2)',
                    borderColor: 'rgba(13, 131, 4, 1)',
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                // Adiciona o prefixo 'R$' aos valores do eixo Y
                                return 'R$ ' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>
