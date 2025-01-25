@extends('layouts.lista')
@section('titulo', 'Despesas')
@section('lista')
    <p><a class ="btn @include('partials.buttomCollor')" href="{{ route('contas.create') }}"><i class="bi bi-plus-circle-fill"></i> Cadastrar despesa</a></p>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>Credor</th>
                <th>Vencimento</th>
                <th>Valor</th>
                <th>Estado</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contas as $conta)
                <tr>
                    <td style="overflow-x: auto;">{{ $conta->credor }}</td>
                    <td>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}
                    </td>
                    <td>{{ $conta->valor }}</td>
                    <td>{{ $conta->estado }}</td>
                    <td>
                        <form method="GET" action="{{ route('contas.update', $conta->id) }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $conta->id }}">
                            <button type="submit" class="btn @include('partials.buttomCollor')"
                                @if ($conta->estado != 'Pendente') disabled @endif>
                                Finalizar</button>
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
    @vite('resources/js/app.js')
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
                    [1, 'desc']
                ],
            });
        });
    </script>
@endpush
