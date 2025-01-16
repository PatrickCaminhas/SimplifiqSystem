<!DOCTYPE html>
<html lang="pt-br">

@include('partials.head', ['data_tables' => true])


<body class="bg-black bg-gradient">

    <!-- Menu superior -->
    @include('partials.header')







    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-8">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">
                            <h2 class="text-center">Metas</h2>
                            <p>Deseja cadastar uma nova meta? <a class ="btn btn-primary"
                                    href="{{ route('metas.create') }}">Clique aqui</a></p>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Valor final</th>
                                        <th>Prazo final</th>
                                        <th>Progresso</th>
                                        <th>Estatísticas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($metas as $meta)
                                        <tr>
                                            <td style="overflow-x: auto;">{{ $meta->id }}</td>

                                            <td>{{ $meta->valor }}</td>

                                            <td>{{ \Carbon\Carbon::parse($meta->ending_at)->format('d/m/Y') }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn bg-primary text-light"
                                                    data-bs-toggle="modal" data-bs-target="#meta{{ $meta->id }}">
                                                    Adicionar
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="meta{{ $meta->id }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    Meta #{{ $meta->id }}</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body bg-secondary-subtle">

                                                                <form action="{{ route('metas.storeProgresso') }}"
                                                                    method="POST" class="row g-3">
                                                                    @csrf
                                                                    <div class="col-6">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Criação:</label>
                                                                        <a>{{ \Carbon\Carbon::parse($meta->created_at)->format('d/m/Y') }}</a>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Vencimento:</label>
                                                                        <a>{{ \Carbon\Carbon::parse($meta->ending_at)->format('d/m/Y') }}</a>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Valor final:</p>
                                                                        <a>R$ {{ $meta->valor }}</a>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Valor atual:</p>
                                                                        <a>R$ {{ $meta->valor_atual }}</a>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        @if ($meta->valor_atual >= $meta->valor)
                                                                            <p for="exampleFormControlInput1"
                                                                                class="form-label">Valor excedido:</p>
                                                                            <a>R$
                                                                                {{ $excedido = $meta->valor - $meta->valor_atual }}.00</a>
                                                                        @else
                                                                            <p for="exampleFormControlInput1"
                                                                                class="form-label">Valor faltante:</p>
                                                                            <a>R$
                                                                                {{ $faltante = ($meta->valor_atual - $meta->valor) * -1 }}.00</a>
                                                                        @endif
                                                                    </div>

                                                            </div>
                                                            <div class="modal-body bg-secondary-subtle col-12">
                                                                <div class="progress bg-light" role="progressbar"
                                                                    aria-label="Default striped example"
                                                                    aria-valuenow="10" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                    <div class="progress-bar progress-bar-striped
                                                                    @if ($meta->valor_atual >= $meta->valor) bg-success
                                                                    @elseif($meta->estado == 'Não cumprida') bg-danger @endif
                                                                    "
                                                                        style="width:
                                                                    {{ $valor = floor(($meta->valor_atual * 100) / $meta->valor) }}%">
                                                                        {{ $valor }}%
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="modal-footer">
                                                                <div class="col-8">
                                                                    <input type="hidden" name="meta_id"
                                                                        value="{{ $meta->id }}">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="number" class="form-control"
                                                                            name="valor" id="valor" min="1"
                                                                            step="0.01" required
                                                                            @if ($meta->estado == 'Finalizada' || $meta->estado == 'Não cumprida') disabled @endif>
                                                                        <label>
                                                                            Progresso de meta:</label>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary"
                                                                    @if ($meta->estado == 'Finalizada' || $meta->estado == 'Não cumprida') disabled @endif>
                                                                    Novo progresso</button>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                </form>

                                            </td>
                                            <td>
                                                <form action="{{ route('metas.informacoes') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="meta_id" value="{{ $meta->id }}">
                                                    <button type="submit" class="btn bg-primary text-light">
                                                        Verificar
                                                    </button>
                                                </form>

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
                order: [[2, 'desc']],
            });
        });
    </script>
</body>

</html>
