@extends('layouts.padrao')
@section('conteudo')
    <div class="container mt-4 mb-4 bg-light text-dark">
        <div class="row">
            <div class="col-12 text-center" style="overflow: auto;">
                <h4 class="display-6">Cotação de Produtos</h4>
                @include('partials.errorAndSuccess')
                <form method="POST" action="{{ route('inserir.cotacao') }}">
                    @csrf
                    <table class="table table-bordered border border-secondary border-2 table-secondary table-responsive">
                        <thead class="table-dark">
                            <input type="hidden" name="fornecedores" value="{{ json_encode($fornecedores->pluck('id')->toArray()) }}">
                            <input type="hidden" name="produtos" value="{{ json_encode($produtos->pluck('id')->toArray()) }}">

                            <tr class="text-light">
                                <th scope="col">Produto</th>
                                @foreach ($fornecedores as $fornecedor)
                                    <th scope="col-3">{{ $fornecedor->nome }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                                <tr>
                                    <td class="text-start">
                                        <label class="text-break">{{ $produto->nome }} {{ $produto->modelo }} {{ $produto->marca }}</label>
                                    </td>
                                    @foreach ($fornecedores as $fornecedor)
                                        <td>
                                            <input type="number" class="form-control"
                                                name="cotacao[{{ $produto->id }}][{{ $fornecedor->id }}]"
                                                step="0.01" placeholder="Digite o preço">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center mt-2 mb-4">
                        <button type="submit" class="btn @include('partials.buttomCollor') text-center">Salvar</button>
                        <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
