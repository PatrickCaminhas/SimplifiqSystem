@extends('layouts.lista')
@section('titulo', 'Lista de Vendas')
@section('lista')
    <p>Deseja cadastrar uma nova venda? <a class="btn btn-primary" href="{{ route('vendas.create') }}">Clique aqui</a></p>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data da venda</th>
                <th>Valor total</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendas as $venda)
                <tr>
                    <td>{{ $venda->id }}</td>
                    <td>{{ $venda->cliente->nome }}</td>
                    <td>{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y') }}</td>
                    <td>{{ $venda->valor_total }}</td>
                    <td>
                        <button type="button" class="btn bg-primary text-light" data-bs-toggle="modal"
                            data-bs-target="#venda{{ $venda->id }}" data-venda-id="{{ $venda->id }}">
                            Consultar
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="venda{{ $venda->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                            Venda #{{ $venda->id }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-secondary-subtle">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="exampleFormControlInput1" class="form-label">Cliente:</label>
                                                <a>{{ $venda->cliente->nome }}</a>
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleFormControlInput1" class="form-label">Data da
                                                    venda:</label>

                                                <a>{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y') }}</a>
                                            </div>

                                            <div class="col-12">
                                                <label for="produtosVendidos" class="form-label">Produtos:</label>
                                                <table id="itensTabela{{ $venda->id }}" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Produto</th>
                                                            <th>Quantidade</th>
                                                            <th>Valor unitário</th>
                                                            <th>Valor total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <p>Metodo de pagamento:
                                                {{ $venda->metodo_pagamento }}</p>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">

                                            <label for="exampleFormControlInput1" class="form-label">Valor total: </label>
                                            <a>R$ {{ $venda->valor_total }}</a>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <form method="POST" action="#">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $venda->id }}">
                                            <!--<button type="submit"
                                                                            class="btn btn-danger">Cancelar venda</button>-->
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

            // Preenche a tabela de itens da venda no modal
            $('[data-bs-target]').on('click', function() {
                var vendaId = $(this).data('venda-id');

                // Obtendo os itens no formato JSON
                var itens = {!! json_encode(
                    $vendas->keyBy('id')->map(function ($venda) {
                            return $venda->itens->map(function ($item) {
                                return [
                                    'produto' => $item->produto->nome,
                                    'quantidade' => $item->quantidade,
                                    'preco_unitario' => $item->preco_unitario,
                                    'subtotal' => $item->subtotal,
                                ];
                            });
                        })->toArray(),
                ) !!};

                var tabela = $('#itensTabela' + vendaId + ' tbody');
                tabela.empty();

                if (itens[vendaId]) {
                    itens[vendaId].forEach(function(item) {
                        tabela.append(
                            `<tr>
                                <td>${item.produto}</td>
                                <td>${item.quantidade}</td>
                                <td>${item.preco_unitario}</td>
                                <td>${item.subtotal}</td>
                            </tr>`
                        );
                    });
                }
            });
        });
    </script>
@endpush
