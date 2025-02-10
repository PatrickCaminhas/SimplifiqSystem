@extends('layouts.lista')
@section('titulo', 'Lista de Funcionários')
@section('lista')
    <p><a class="btn @include('partials.buttomCollor')" href="{{ route('configuracoes.funcionario') }}"><i class="bi bi-plus-circle-fill"></i>
            Cadastrar Funcionário</a></p>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>Nome completo</th>
                <th>E-mail</th>
                <th>Cargo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($funcionarios as $funcionario)
                <tr>
                    <td>{{ $funcionario->nome . ' ' . $funcionario->sobrenome}}
                    </td>
                    <td>{{ $funcionario->email }}</td>
                    <td>{{ $funcionario->cargo}}</td>
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
            });
        });
    </script>
@endpush
