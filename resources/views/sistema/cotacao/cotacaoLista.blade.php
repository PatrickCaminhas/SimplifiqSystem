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
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cotacoes as $cotacao)
                <tr>
                    <td>{{ $cotacao->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($cotacao->data_cotacao)->format('d/m/Y') }}</td>
                    <td class="grid gap-3 row-gap-3 ">

                        <a type="button" class="btn @include('partials.buttomCollor') text-light m-2"
                            href="{{ route('cotacao.verificarCotacao.create', $cotacao->id) }}">
                            <i class="bi bi-search"></i> Verificar
                        </a>
                        <a type="button" class="btn @include('partials.buttomCollor') text-light m-2 "
                            href="{{ route('cotacao.reporEstoque.create', $cotacao->id) }}">
                            <i class="bi bi-box2-fill"></i> Repor estoque
                        </a>

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
