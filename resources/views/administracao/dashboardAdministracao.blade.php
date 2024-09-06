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
    @include('partials.menuAdmin')

    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">
                            <h2 class="text-center">Empresas</h2>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>CNPJ</th>
                                        <th>Tamanho da empresa</th>
                                        <th>Tipo de empresa</th>
                                        <th>Telefone</th>
                                        <th>Estado</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($empresas as $empresa)
                                        <tr>
                                            <td>{{ $empresa->nome }}</td>
                                            <td>{{ $empresa->cnpj }}</td>
                                            <td>
                                                @if ($empresa->tamanho_empresa == 'microempresa')
                                                    Micro-empresa
                                                @elseif ($empresa->tamanho_empresa == 'pequenaempresa')
                                                    Pequena-empresa
                                                @elseif ($empresa->tamanho_empresa == 'mei')
                                                    MEI
                                                @endif
                                            </td>
                                            <td>{{ $empresa->tipo_empresa }}</td>
                                            <td>{{ $empresa->telefone }}</td>
                                            <td>{{ $empresa->estado }}</td>
                                            <td>
                                                @if ($empresa->estado == 'inexistente')
                                                    <form method="POST" action="{{ route('criarTenant') }}">
                                                        @csrf
                                                        <input type="hidden" name="nome"
                                                            value="{{ $empresa->nome }}">
                                                        <input type="hidden" name="cnpj"
                                                            value="{{ $empresa->cnpj }}">
                                                        <input type="hidden" name="tamanho_empresa"
                                                            value="{{ $empresa->tamanho_empresa }}">
                                                        <input type="hidden" name="tipo_empresa"
                                                            value="{{ $empresa->tipo_empresa }}">
                                                        <input type="hidden" name="telefone"
                                                            value="{{ $empresa->telefone }}">
                                                        <input type="hidden" name="area_atuacao"
                                                            value="{{ $empresa->area_atuacao }}">
                                                        <button type="submit" class="btn btn-primary">
                                                            Criar empresa</button>
                                                    </form>
                                                @elseif ($empresa->estado == 'ativa')
                                                    <a class="btn btn-danger disabled">Desativar</a>
                                                @elseif ($empresa->estado == 'desativada')
                                                    <a class="btn btn-primary disabled">Ativar</a>
                                                @endif

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
                }
            });
        });
    </script>
</body>

</html>
