@extends('layouts.lista')
@section('titulo', 'Metas')
@section('lista')
    <p><a class="btn @include('partials.buttomCollor')" href="{{ route('metas.read') }}"><i class="bi bi-arrow-return-left"></i>
            Voltar</a></p>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Valor final</th>
                <th>Prazo final</th>
                <th>Estatísticas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($metas as $meta)
                <tr>
                    <td >{{ $meta->id }}</td>

                    <td>{{ $meta->valor }}</td>

                    <td>{{ \Carbon\Carbon::parse($meta->ending_at)->format('d/m/Y') }}
                    </td>
                    <td>
                        <form action="{{ route('metas.informacoes') }}" method="POST">
                            @csrf
                            <input type="hidden" name="meta_id" value="{{ $meta->id }}">
                            <button type="submit" class="btn bg-primary text-light">
                                <i class="bi bi-search"></i>
                            </button>
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
                order: [
                    [2, 'desc']
                ],
            });
        });
    </script>
@endpush
