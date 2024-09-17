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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json">
</head>

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')













    <div class="d-flex align-items-center justify-content-center " style="height: 92vh;">
        <div class="container mt-5 col-lg-6 col-md-8 col-sm-12 col-lg-6 col-sm-12">
            <div class="row align-items-center justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="card-body ">
                                    <div class="container">
                                        <h2>Registrar Faturamento</h2>

                                        <p> Está faltando algum mês do faturamento? Clique em <a class="btn btn-primary"
                                            href="{{ route('faturamento.create') }}">Registrar</a></p>
                                        <table id="myTable" class="display">
                                            <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Faturamento</th>
                                                    <th>Alterar</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($faturamentos as $faturamento)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($faturamento->ano_mes)->format('m/Y') }}
                                                        </td>

                                                        <td>{{ $faturamento->renda_bruta }}</td>

                                                        <td>
                                                            <button type="button" class="btn bg-primary text-light"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#faturamento{{ $faturamento->id }}">
                                                                Alterar
                                                            </button>
                                                            <!-- Modal -->
                                                            <div class="modal fade"
                                                                id="faturamento{{ $faturamento->id }}"
                                                                data-bs-backdrop="static" data-bs-keyboard="false"
                                                                tabindex="-1" aria-labelledby="staticBackdropLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5"
                                                                                id="staticBackdropLabel">
                                                                                Faturamento #{{ $faturamento->id }}</h1>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body bg-secondary-subtle">
                                                                            <form
                                                                                action="{{ route('faturamento.update') }}"
                                                                                method="POST" class="row g-3">
                                                                                @csrf
                                                                                <div class="col-12">
                                                                                    <p>Se houve algum erro no
                                                                                        faturamento ou
                                                                                        deseja alterar o valor, insira o
                                                                                        novo
                                                                                        valor abaixo:</p>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label
                                                                                        for="exampleFormControlInput1"
                                                                                        class="form-label">Data:</label>
                                                                                    <a>{{ \Carbon\Carbon::parse($faturamento->ano_mes)->format('m/Y') }}</a>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label for="exampleFormControlInput1"
                                                                                        class="form-label">Valor atual:
                                                                                </label>
                                                                                    <a>R$
                                                                                        {{ $faturamento->renda_bruta }}</a>
                                                                                </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <div class="col-8">
                                                                                <input type="hidden" name="faturamento_id"
                                                                                    value="{{ $faturamento->id }}">
                                                                                <div class="form-floating mb-3">
                                                                                    <input type="number"
                                                                                        class="form-control"
                                                                                        name="valor" id="valor"
                                                                                        min="1" step="0.01"
                                                                                        required>
                                                                                    <label>
                                                                                        Novo valor do
                                                                                        faturamento:</label>
                                                                                </div>
                                                                            </div>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">
                                                                                Alterar</button>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            </form>

                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        @if ($errors->any())
                                            <div class="alert alert-danger mt-3">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
