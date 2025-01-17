@extends('layouts.cadastro')
@section('titulo', 'Cadastro de contas')
@section('formulario')
@section('route', route('contas.store'))

<div class="form-floating mb-3">
    <input type="text" class="form-control" name="credor" id="credor" required>
    <label>Credor:</label>
</div>
<div class="form-floating mb-3">


    <select class="form-select" id="tipo" name="tipo">
        <option selected disabled>Selecione o tipo de conta
        </option>
        <option value="agua">Água</option>
        <option value="aluguel">Aluguel</option>
        <option value="energia">Energia</option>
        <option value="fornecedor">Fornecedor</option>
        <option value="outros">Outros</option>
    </select>
    <label> Tipo:</label>
</div>
<div class="form-floating mb-3">
    <input type="number" class="form-control" name="valor" id="valor" min="1" step="0.01"
        required><label>
        Valor:</label>
</div>
<div class="form-floating mb-3">
    <input type="date" class="form-control" name="data_vencimento" id="data_vencimento" required>
    <label> Data de vencimento:</label>
</div>
<div class=" text-center mt-3">
    <button type="submit" class="btn @include('partials.buttomCollor')">Cadastrar</button>
</div>
</form>
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
