<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simples Nacional - Simplifiq</title>
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
    @include('partials.menuAdmin')

    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">
                            <h2 class="text-center">Aliquotas Simples Nacional</h2>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>Anexo</th>
                                        <th>Faixa</th>
                                        <th>Receita Bruta Anual</th>
                                        <th>Aliquota</th>
                                        <th>Dedução</th>
                                        <th>Ultima atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($simplesNacional as $simples)
                                        <tr>
                                            <td>{{ $simples->nome_anexo }}</td>
                                            <td>{{ $simples->faixa_anexo }}</td>
                                            <td>{{ $simples->receita_bruta_anual }}</td>
                                            <td>{{ $simples->aliquota }}</td>
                                            <td>{{ $simples->deducao }}</td>
                                            <td>{{ $simples->updated_at }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('criarTenant') }}">
                                                    @csrf
                                                    <input type="hidden" name="nome_anexo"
                                                        value="{{ $simples->nome_anexo }}">
                                                    <input type="hidden" name="cnpj"
                                                        value="{{ $simples->faixa_anexo }}">

                                                    <button type="submit" class="btn btn-primary">
                                                        Alterar dados</button>
                                                </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap e DataTables -->
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
    </script>
</body>

</html>
