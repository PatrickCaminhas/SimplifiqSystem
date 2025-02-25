@php
    $data_tables = true;
@endphp
@extends('layouts.lista')
@section('titulo', content: 'Cotação de produtos')

@section('lista')

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
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th scope="col">Estoque</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Selecione</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>
                                <span>{{ $produto->quantidade }}</span>
                            </td>
                            <td>
                                <span>{{ $produto->nome }} {{ $produto->modelo }}
                                    {{ $produto->marca }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">

                                    <input type="checkbox" class="btn-check" name="produtos[]"
                                        id="btncheck{{ $produto->id }}" value="{{ $produto->id }}" autocomplete="off">
                                    <label class="btn @include('partials.buttomOutlineCollor')"
                                        for="btncheck{{ $produto->id }}">Cotar</label>
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
                lengthMenu: [
                    [-1],
                    ["Todos"]
                ], // Define opção "Todos"
                pageLength: -1 // Exibe todas as linhas
            });
        });
    </script>
@endpush
