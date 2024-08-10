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

<body class="bg-black bg-gradient">
    <!-- Menu superior -->
    @include('partials.header')

    <!-- Offcanvas para o menu -->
    @include('partials.menu')

    <!-- Offcanvas para notificações -->
    @include('partials.notificacoes')
    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">
                            <h2 class="text-center">Calculadora de Simples Nacional</h2>
                            <div class="form-text" >Esta calculadora é uma estimativa, contate o seu contador.</div>

                            <div>
                                <form action="{{ route('simples.calculate') }}" method="POST">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" name="receita_bruta_mes" id="receita_bruta_mes"
                                        step="0.01" required>
                                        <label>Renda bruta do mês:</label>
                                        <div class="form-text" >Valor total de vendas ou serviços prestados incluindo valores que não emitiram nota fiscal do mês.</div>

                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" name="receita_bruta_anual" id="receita_bruta_anual"
                                            min="1" step="0.01"  required><label>
                                            Média da renda bruta dos ultimos 12 meses:</label>
                                            <div class="form-text" >Soma das rendas brutas dos 12 meses anteriores divididos por 12.</div>

                                    </div>
                                    <div class=" text-center mt-3">
                                        <button type="submit" class="btn btn-success">Cadastrar</button>
                                        <button type="reset" class="btn btn-success">Limpar</button>
                                    </div>
                                </form>
                                @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('valor'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('valor') }}
                                </div>
                            @endif




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
</body>

</html>
