@extends('layouts.padrao')
@section('conteudo')
    <div class="col-md-10 col-sm-12 container mt-4 mb-4 bg-light text-dark">
        <div class="row">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-start" style="overflow: auto;">
                        <a href="@yield('voltar', '/cotacoes')" class="btn @include('partials.buttomCollor') text-center""> <i
                                class="bi bi-arrow-return-left"></i> Voltar</a>

                        <div class=text-center>
                            <h4 class="display-6">Reposição de estoque </h4>
                            <h5>Cotação de Produtos #{{ $cotacao->id }} Data:
                                {{ \Carbon\Carbon::parse($cotacao->data_cotacao)->format('d/m/Y') }}</h5>
                        </div>
                        <form method="POST" action="{{ route('repor.estoque') }}">

                            @csrf
                            <table class="table  table-bordered border border-secondary border-2 table-white">
                                <thead>
                                    <tr class="text-light ">
                                        <th scope="col ">Estoque</th>
                                        <th scope="col ">Produto</th>
                                        <th scope="col">Fornecedor</th>
                                        <th scope="col">Quantidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($itens as $item_cotacao)
                                        <tr>
                                            <td>
                                                <span>{{ $item_cotacao->produto->quantidade }}</span>
                                            </td>
                                            <td>
                                                <span>{{ $item_cotacao->produto->nome }}
                                                    {{ $item_cotacao->produto->modelo }}
                                                    {{ $item_cotacao->produto->marca }}</span>
                                            </td>
                                            <td>
                                                <span>{{ $item_cotacao->fornecedor->nome }}</span>
                                            <td>
                                                <div class="btn-group" role="group"
                                                    aria-label="Basic checkbox toggle button group">

                                                    <input type="number" name="produto{{ $item_cotacao->produto->id }}"
                                                        step="1" id="produto{{ $item_cotacao->produto->id }}"
                                                        class="form-control" min="0" value="0"
                                                        oninput="validateInput(this)">
                                                        <input type="hidden"
                                                            name="produto_id_{{ $item_cotacao->produto->id }}"
                                                            id="produto_id_{{ $item_cotacao->produto->id }}"
                                                            value="{{ $item_cotacao->produto->id }}">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center mt-2 mb-4">
                                <button type="submit" class="btn @include('partials.buttomCollor') text-center"><i
                                        class="bi bi-floppy-fill"></i> Repor</button>
                                <button type="reset" class="btn @include('partials.buttomCollor') text-center"><i
                                        class="bi bi-eraser-fill"></i> Limpar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.errorAndSuccessToast')

@endsection
@push('scripts')
    <script>
        function validateInput(input) {
            let value = input.value;

            // Impede valores negativos
            if (value < 0) {
                input.value = 0;
            }

            // Remove valores quebrados (apenas inteiros)
            input.value = Math.floor(value);
        }
    </script>
@endpush
