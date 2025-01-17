@extends('layouts.cadastro')
@section('titulo', 'Cadastro de meta')
@section('formulario')
@section('route', route('metas.store'))
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" name="valor"
                                                    id="valor" min="1" step="0.01" required>
                                                <label>Valor:</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" name="ending_at"
                                                    id="ending_at" min="{{ now()->addWeek()->format('Y-m-d') }}"
                                                    required>
                                                <label> Prazo final:</label>
                                            </div>
                                            <div class=" text-center mt-3">
                                                <button type="submit" class="btn @include('partials.buttomCollor')">Cadastrar</button>
                                            </div>


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
@endsection
