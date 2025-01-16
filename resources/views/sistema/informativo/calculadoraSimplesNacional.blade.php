<!DOCTYPE html>
<html lang="pt-br">

@include('partials.head', ['data_tables' => true])



<body class="bg-black bg-gradient" >
    <!-- Menu superior -->
    @include('partials.header')







    <div class="d-flex justify-content-center align-items-center vh-100 flex-wrap">
        <div class="container">
            <div class="row">
                <div class="col-6 col-6 g-4">
                    <div class="card shadow-sm d-flex flex-column justify-content-center align-items-center">
                        <div class="card-body">
                            <h2>Estimativa de Simples Nacional</h2>
                            <p class="form-text">Mês referente: {{ \Carbon\Carbon::parse($informacoes[2])->format('m/Y')}}</p>
                            <p class="form-text">Renda bruta do mês referente: R${{number_format($informacoes[1], 2,',','.')}}</p>
                            @if($informacoes[4] >= 1)
                            <p class="form-text">Renda bruta dos últimos {{$informacoes[4]}} meses: R${{number_format($informacoes[3], 2,',','.')}}</p>
                            @elseif($informacoes[4] == 1)
                            @endif
                            @if($informacoes[4] >= 12)
                            <p class="form-text">Média da renda bruta dos últimos 12 meses:
                            @elseif($informacoes[4] < 12)
                            <p class="form-text">Média da renda bruta dos últimos {{$informacoes[4]}} meses:
                            @elseif($informacoes[4] == 1)
                            <p class="form-text">Renda bruta do último {{$informacoes[4]}} mês:
                            R${{number_format($informacoes[5], 2,',','.')}} </p>
                            @endif
                            <!--<p class="form-text">Valor do DAS do mês passado: </p>-->
                            <p class="form-text">Valor do DAS atual: R${{number_format($informacoes[0], 2,',','.')}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-6 mt-4">
                    <div class="card shadow-sm d-flex flex-column justify-content-center align-items-center">
                        <div class="card-body">
                            <h2>Calculadora de Simples Nacional</h2>
                            @include('partials.simplesNacional')
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
</body>

</html>
