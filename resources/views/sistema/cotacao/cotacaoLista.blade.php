@extends('layouts.lista')
@section('titulo', 'Lista de Cotações')
@section('lista')
    <p><a class="btn @include('partials.buttomCollor')" href="{{ route('cotacaoProdutos') }}">
            <i class="bi bi-plus-circle-fill"></i> Cadastrar Cotação</a></p>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cotacoes as $cotacao)
                <tr>
                    <td>{{ $cotacao->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($cotacao->data_cotacao)->format('d/m/Y') }}</td>
                    <td>
                        <button type="button" class="btn @include('partials.buttomCollor') text-light" data-bs-toggle="modal"
                            data-bs-target="#cotacao{{ $cotacao->id }}">
                            <i class="bi bi-search"></i>
                        </button>
                        <div class="modal fade" id="cotacao{{ $cotacao->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel{{ $cotacao->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="modalLabel{{ $cotacao->id }}">
                                            Cotação #{{ $cotacao->id }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-secondary-subtle">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">Data da Cotação:</label>
                                                <span>{{ \Carbon\Carbon::parse($cotacao->data_cotacao)->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Produtos:</label>
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Produto</th>
                                                            <th>Preço</th>
                                                            <th>Fornecedor</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($cotacao->itens as $item)
                                                            <tr>
                                                                <td>{{ $item->produto->nome }}</td>
                                                                <td>{{ number_format($item->preco, 2, ',', '.') }}</td>
                                                                <td>{{ $item->fornecedor->nome }}</td>
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
