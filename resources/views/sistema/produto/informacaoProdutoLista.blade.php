@extends('layouts.lista')
@section('titulo', 'Lista de Produtos')
@section('lista')
    <p><a class="btn @include('partials.buttomCollor')" href="{{ route('produto.create') }}"><i class="bi bi-plus-circle-fill"></i>
            Cadastrar produto</a></p>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtos as $produto)
                <tr>
                    <td>{{ $produto->nome . ' ' . $produto->modelo . ' ' . $produto->marca }}
                    </td>
                    <td>{{ $produto->categoria->nome }}</td>
                    <td>

                        <a href="/informacaoproduto/{{ $produto->id }}" class="btn @include('partials.buttomCollor') text-light">
                            <i class="bi bi-search"></i>
                        </a>
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
            });
        });
    </script>
@endpush
