<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Fornecedores</title>
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
                            <h2 class="text-center">Fornecedores</h2>
                            <p>Deseja cadastar um novo fornecedor? <a class="btn btn-primary"
                                    href="{{route('cadastroFornecedor') }}">Clique aqui</a></p>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>CNPJ</th>
                                        <th>Telefone</th>
                                        <th>Detalhes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fornecedores as $fornecedor)
                                        <tr>
                                            <td style="overflow-x: auto;">{{ $fornecedor->id }}</td>
                                            <td>{{ $fornecedor->nome }}</td>
                                            <td>{{ $fornecedor->CNPJ }}</td>
                                            <td>{{ $fornecedor->telefone }}</td>
                                            <td>
                                                <button type="button" class="btn bg-primary text-light"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#fornecedor{{ $fornecedor->id }}"
                                                    data-produto-id="{{ $fornecedor->id }}">
                                                    Consultar
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="fornecedor{{ $fornecedor->id }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    Fornecedor #{{ $fornecedor->id }}</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body bg-secondary-subtle">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Nome:</label>
                                                                        <a>{{ $fornecedor->nome }}</a>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Cnpj:</label>
                                                                        <a>{{ $fornecedor->CNPJ }}</a>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Representante:</label>
                                                                        <a>{{ $fornecedor->nome_representante }}</a>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Endereço:
                                                                            <a>{{ $fornecedor->endereco . ' - ' . $fornecedor->cidade . '/' . $fornecedor->estado }}</a>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-12 d-flex justify-content-center fw-semibold">
                                                                        <a>Contatos</a>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Telefone:
                                                                            <a>{{ $fornecedor->telefone }}</a>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">E-mail:
                                                                            <a>{{ $fornecedor->email }}</a>
                                                                        </p>
                                                                    </div>



                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST"
                                                                    action="{{route('fornecedores.edit')}}">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $fornecedor->id }}">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        Alterar</button>
                                                                </form>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

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
