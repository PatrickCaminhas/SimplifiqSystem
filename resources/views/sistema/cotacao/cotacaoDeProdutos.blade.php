@extends('layouts.padrao')
@section('conteudo')
    <div class="col-md-10 col-sm-12 container mt-4 mb-4 bg-light text-dark">
        <div class="row">
            <div class="text-center" style="overflow: auto;">
                <h4 class="display-6">Cotação de Produtos</h4>
                @if ($checagem != 'true')
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Atenção!</h4>
                        @if ($checagem == 'produtos')
                            <p>Para realizar uma cotação é necessário ter produtos cadastrados no sistema.</p>
                        @elseif($checagem == 'fornecedores')
                            <p>Para realizar uma cotação é necessário ter fornecedores cadastrados no sistema.</p>
                        @else
                            <p>Para realizar uma cotação é necessário ter produtos e fornecedores cadastrados no
                                sistema.</p>
                        @endif
                    </div>
                @else
                    <form method="POST" action="{{ route('cotacao.produtos.selecionados') }}">
                        @csrf
                        <table class="table table-striped-columns table-bordered border border-secondary border-2 table-secondary">
                            <thead>
                                <tr class="text-light">
                                    <th scope="col">Estoque</th>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Selecione</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produtos as $produto)
                                    <tr>
                                        <td >
                                            <span>{{ $produto->quantidade }}</span>
                                        </td>
                                        <td >
                                            <span>{{ $produto->nome }} {{ $produto->modelo }}
                                                {{ $produto->marca }}</span>
                                        </td>
                                        <td >
                                            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">

                                            <input  type="checkbox" class="btn-check" name="produtos[]" id="btncheck{{ $produto->id }}"
                                                value="{{ $produto->id }}" autocomplete="off">
                                                <label class="btn @include('partials.buttomOutlineCollor')" for="btncheck{{$produto->id}}">Cotar</label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center mt-2 mb-4">
                            <button type="submit" class="btn @include('partials.buttomCollor') text-center">Avançar</button>
                            <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
