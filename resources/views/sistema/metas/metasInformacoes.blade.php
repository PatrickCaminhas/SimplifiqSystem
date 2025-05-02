@php
    $chartjs = true;
	
@endphp
@extends('layouts.padrao')

@section('conteudo')








    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body row" style="overflow-x: auto;">
                            <h2 class="text-center">Detalhes da meta de {{ \Carbon\Carbon::createFromFormat('d/m/Y', $informacoes->data_final)->translatedFormat('F \d\e Y') }}
</h2>
                            <div class="col-md-6 col-sm-12">
                                <div style="width: 75%; margin: auto;">
                                    <canvas id="myChart"></canvas>
                                </div>

                            </div>
                            <div class="col-6">
                                <p>Começo: {{$informacoes->data_inicial}} | Fim:  {{$informacoes->data_final}}</p>

                                <p>Maior progresso: {{$informacoes->maiorProgresso}} | Data: {{$informacoes->diaComMaiorProgresso}}</p>
                                <p>Menor progresso: {{$informacoes->menorProgresso}} | Data: {{$informacoes->diaComMenorProgresso}}</p>
								
                              	@if (\Carbon\Carbon::now() < $informacoes->data_final)
                                 <p>Faltam {{$informacoes->diferencaDias}} dias para final da meta.</p>
                              	@elseif(\Carbon\Carbon::now() > $informacoes->data_final)
                              <p>Estado atual da meta é de: {{$informacoes->estado}}. </p>
                                @endif
                                <p>Data do ultimo progresso: {{$informacoes->UltimoProgresso}}</p>
                                <p>
                                    @if($informacoes->estado == "Finalizada" || $informacoes->estado == "Cumprida")
                                    Excedido {{$informacoes->porcentagem}} da meta com {{$informacoes->total}}.
                                  	@elseif($informacoes->estado == "Pendente")
                                    Faltam {{$informacoes->porcentagem}} da meta, correspondente a {{$informacoes->total}}.
                                    @endif
                                </p>
                                <a href="{{ route('metas.read') }}" class="btn @include('partials.buttomCollor')">Voltar</a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Features Section -->

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
   
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

@endpush
