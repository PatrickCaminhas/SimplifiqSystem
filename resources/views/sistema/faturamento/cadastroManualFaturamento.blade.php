@extends('layouts.cadastro')
@section('titulo', 'Cadastro de Renda Bruta')
@section('formulario')
@section('route', route('faturamento.store'))
<div class="form-group">
    <p>Renda bruta é valor total recebido em sua empresa.</p>
</div>
<div class="form-group">
    <label for="mes">Mês:</label>
    <select name="mes" id="mes" class="form-control" required>
        <option selected disabled>Selecione o mês do faturamento</option>
        <option value="01">Janeiro</option>
        <option value="02">Fevereiro</option>
        <option value="03">Março</option>
        <option value="04">Abril</option>
        <option value="05">Maio</option>
        <option value="06">Junho</option>
        <option value="07">Julho</option>
        <option value="08">Agosto</option>
        <option value="09">Setembro</option>
        <option value="10">Outubro</option>
        <option value="11">Novembro</option>
        <option value="12">Dezembro</option>
    </select>
</div>

<!-- Input para buscar Produto -->
<div class="form-group">
    <label for="ano">Ano:</label>
    <input type="number" id="ano" name="ano" class="form-control" maxlength="4" min="2007"
        max="{{ date('Y') }}" pattern="[0-9]{4}" placeholder="Digite o ano do faturamento" required>
</div>
<div class="form-group">
    <label for="valor">Valor:</label>
    <input type="number" id="valor" name="valor" class="form-control" step="0.01" min="0.01"
        placeholder="Digite o valor do faturamento" required>
</div>

<button type="submit" class="btn @include('partials.buttomCollor') mt-3">Registrar
    faturamento</button>


@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    const input = document.getElementById('ano');

    input.addEventListener('input', (event) => {
        event.target.value = event.target.value.slice(0, 4);
    });

    input.addEventListener('keypress', (event) => {
        // Permite apenas números
        if (event.key < '0' || event.key > '9') {
            event.preventDefault();
        }
    });
</script>
<script>
    function formatNumber(valor) {
        // Remove todos os caracteres que não sejam números ou o ponto decimal
        let value = input.value.replace(/[^0-9.]/g, '');

        // Permite no máximo um ponto decimal
        value = value.replace(/\./g, '.', 1);

        // Limita para duas casas decimais
        value = value.toFixed(2);

        // Atualiza o valor do input
        input.value = value;
    }
</script>
@endpush
