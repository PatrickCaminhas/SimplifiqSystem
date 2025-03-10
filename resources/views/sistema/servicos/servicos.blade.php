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







    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-8">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">
                            <h2 class="text-center">Servicos</h2>
                            <p>Deseja cadastar um novo servico? <a class ="btn btn-primary"
                                    href="{{ route('servicos.create') }}">Clique aqui</a></p>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Serviço</th>
                                        <th>Cliente</th>
                                        <th>Prazo final</th>
                                        <th>Estado</th>
                                        <th>Verificar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($servicos as $servico)
                                        <tr>
                                            <td style="overflow-x: auto;">{{$servico->id}}</td>

                                            <td>{{ $servico->nome }}</td>
                                            <td>{{ $servico->nome_cliente }}</td>

                                            <td>{{ \Carbon\Carbon::parse($servico->data_fim)->format('d/m/Y') }}
                                            </td>
                                            <td>{{ $servico->estado }}</td>
                                            <td>
                                                <button type="button" class="btn bg-primary text-light"
                                                    data-bs-toggle="modal" data-bs-target="#modalServico{{$servico->id}}">
                                                    Verificar
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modalServico{{$servico->id}}" data-bs-backdrop="static"
                                                    data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    Serviço #{{ $servico->id }}</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body bg-secondary-subtle">


                                                                <div class="col-4">
                                                                    <p for="exampleFormControlInput1"
                                                                        class="form-label">Serviço :
                                                                        <a>{{ $servico->nome }}</a>
                                                                    </p>
                                                                </div>
                                                                <div class="col-4">
                                                                    <p for="exampleFormControlInput1"
                                                                        class="form-label">Cliente:
                                                                        <a>{{ $servico->nome_cliente }}</a>
                                                                    </p>
                                                                </div>
                                                                <div class="col-4">
                                                                    <p for="exampleFormControlInput1"
                                                                        class="form-label">
                                                                        @if ($servico->tipo_cliente == 'CPF')
                                                                            CPF:
                                                                        @else
                                                                            CNPJ:
                                                                        @endif

                                                                        <a>{{ $servico->identificacao_cliente }}</a>
                                                                    </p>
                                                                </div>
                                                                <div class="col-4">
                                                                    <p for="exampleFormControlInput1"
                                                                        class="form-label">Tipo de serviço:
                                                                        <a>{{ $servico->tipo_servico }}</a>
                                                                    </p>
                                                                </div>
                                                                <div class="col-4">
                                                                    <p for="exampleFormControlInput1"
                                                                        class="form-label">Estado :
                                                                        <a>{{ $servico->estado }}</a>
                                                                    </p>
                                                                </div>
                                                                <div class="col-4">
                                                                    <p for="exampleFormControlInput1"
                                                                        class="form-label">Valor:
                                                                        <a>{{ $servico->valor }}</a>
                                                                    </p>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="exampleFormControlInput1"
                                                                        class="form-label">Criação:</label>
                                                                    <a>{{ \Carbon\Carbon::parse($servico->created_at)->format('d/m/Y') }}</a>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="exampleFormControlInput1"
                                                                        class="form-label">Inicio:</label>
                                                                    <a>{{ \Carbon\Carbon::parse($servico->data_inicio)->format('d/m/Y') }}</a>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="exampleFormControlInput1"
                                                                        class="form-label">Fim:</label>
                                                                    <a>{{ \Carbon\Carbon::parse($servico->data_fim)->format('d/m/Y') }}</a>
                                                                </div>
                                                                <div class="col-12">
                                                                    <p for="exampleFormControlInput1"
                                                                        class="form-label">Descrição:
                                                                        <a>{{ $servico->descricao }}</a>
                                                                    </p>
                                                                </div>

                                                            </div>



                                                            <div class="modal-footer">



                                                                <form action="{{ route('servicos.cancelar') }}"
                                                                    method="POST" class="row g-3">
                                                                    @csrf
                                                                    <input type="hidden" name="servico_id"
                                                                        value="{{ $servico->id }}">
                                                                    <button type="submit" class="btn btn-danger inline"
                                                                        @if ($servico->estado == 'Finalizado' || $servico->estado == 'Cancelado') disabled @endif>
                                                                        Cancelar serviço</button>
                                                                </form>
                                                                <form action="{{ route('servicos.finalizar') }}"
                                                                    method="POST" class="row g-3">
                                                                    @csrf
                                                                    <input type="hidden" name="servico_id"
                                                                        value="{{ $servico->id }}">
                                                                    <button type="submit"
                                                                        class="btn btn-primary inline"
                                                                        @if ($servico->estado == 'Finalizado' || $servico->estado == 'Cancelado') disabled @endif>
                                                                        Finalizar serviço</button>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
                order: [[3, 'desc']],
            });
        });
    </script>
</body>

</html>
