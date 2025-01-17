@extends('layouts.lista')
@section('titulo', 'Faturamento')
@section('lista')
    <p> Está faltando faturamento de algum mês? Clique em <a class="btn btn-primary"
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
                        <button type="button" class="btn bg-primary text-light" data-bs-toggle="modal"
                            data-bs-target="#faturamento{{ $faturamento->id }}">
                            Alterar
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="faturamento{{ $faturamento->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                            Faturamento #{{ $faturamento->id }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-secondary-subtle">
                                        <form action="{{ route('faturamento.update') }}" method="POST" class="row g-3">
                                            @csrf
                                            <div class="col-12">
                                                <p>Se houve algum erro no
                                                    faturamento ou
                                                    deseja alterar o valor, insira o
                                                    novo
                                                    valor abaixo:</p>
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleFormControlInput1" class="form-label">Data:</label>
                                                <a>{{ \Carbon\Carbon::parse($faturamento->ano_mes)->format('m/Y') }}</a>
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleFormControlInput1" class="form-label">Valor atual:
                                                </label>
                                                <a>R$
                                                    {{ $faturamento->renda_bruta }}</a>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="col-8">
                                            <input type="hidden" name="faturamento_id" value="{{ $faturamento->id }}">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" name="valor" id="valor"
                                                    min="1" step="0.01" required>
                                                <label>
                                                    Novo valor do
                                                    faturamento:</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
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
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>
@endpush
