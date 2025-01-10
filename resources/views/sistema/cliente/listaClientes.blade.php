<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Cliente</title>
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







    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-8">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">
                            <h2 class="text-center">Clientes</h2>
                            <p>Deseja cadastar um novo cliente? <a class="btn btn-primary"
                                    href="{{ route('cliente.store.create') }}">Clique aqui</a></p>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Tipo de pessoa</th>
                                        <th hidden>Débito</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            <td style="overflow-x: auto;">{{ $cliente->id }}</td>
                                            <td>{{ $cliente->nome }}</td>
                                            <td>
                                                @if (strlen($cliente->cpfOuCnpj) == 11)
                                                    CPF
                                                @else
                                                    CNPJ
                                                @endif
                                            </td>
                                            <td hidden>
                                                @if ($cliente->debitos == null || $cliente->debitos == '0' || $cliente->debitos == '0.00')
                                                    Não possui débitos!
                                                @else
                                                    Fiado - Devedor - Debito - Inadimplente
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn bg-primary text-light"
                                                    data-bs-toggle="modal" data-bs-target="#cliente{{ $cliente->id }}"
                                                    data-produto-id="{{ $cliente->id }}">
                                                    Consultar
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="cliente{{ $cliente->id }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    cliente #{{ $cliente->id }}</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body bg-secondary-subtle">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Nome
                                                                            completo:</label>
                                                                        <a>{{ $cliente->nome }}</a>
                                                                    </div>

                                                                    <div class="col-6">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">
                                                                            @if (strlen($cliente->cpfOuCnpj) == 11)
                                                                                CPF:
                                                                            @else
                                                                                CNPJ:
                                                                                </a>
                                                                            @endif
                                                                            <a>{{ $cliente->cpfOuCnpj }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Telefone:
                                                                            <a>{{ $cliente->telefone }}</a>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">E-mail:
                                                                            <a>
                                                                                @if ($cliente->email)
                                                                                    {{ $cliente->email }}
                                                                                @elseif($cliente->email == null || $cliente->email == '' || $cliente->email == '-')
                                                                                    Não informado
                                                                                @endif
                                                                            </a>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Pendências:
                                                                            <a>
                                                                                @if ($cliente->debitos == null || $cliente->debitos == '0' || $cliente->debitos == '0.00')
                                                                                    Não possui.
                                                                                @else
                                                                                    R${{ $cliente->debitos }}
                                                                                @endif
                                                                            </a>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Observações:
                                                                            <a>{{ $cliente->observacoes }}</a>
                                                                        </p>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST"
                                                                    action="{{ route('cliente.edit') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $cliente->id }}">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        Alterar</button>
                                                                </form>
                                                                @if ($cliente->debitos > 0)
                                                                    <form method="POST"
                                                                        action="{{ route('cliente.quitar.view') }}">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $cliente->id }}">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            Quitar divida</button>
                                                                    </form>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p class="fs-6 fw-lighter">Para ver todos os clientes devedores procure por: Fiado, Devedor,
                                Debito ou Inadimplente</p>
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach

                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setActionAndSubmit(acao) {
            document.getElementById('acao').value = acao;
            document.getElementById('form-estoque').submit(); // Força o envio do formulário após setar a ação
        }
    </script>

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
