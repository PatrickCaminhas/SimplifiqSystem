@extends('layouts.cadastro')
@section('titulo', 'Alterar dados de cliente')
@section('formulario')
@section('route', route('cliente.update.store'))
<input type="hidden" name="id" value="{{ $cliente->id }}">
<div class="form-group">
    <label for="cliente">Nome do cliente:@include('partials.campoObrigatorio')</label>
    <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $cliente->nome) }}"
        required>
</div>
<div class="form-group">
    <label for="cpf">CPF/CNPJ:@include('partials.campoObrigatorio')</label>
    <input type="text" class="form-control" name="cpfOuCnpj" id="cpfOuCnpj"
        value="{{ old('cfpcnpj', $cliente->cpfOuCnpj) }}" maxlength="18" required>
</div>
<div class="form-group">
    <label for="telefone">Telefone:@include('partials.campoObrigatorio')</label>
    <input type="text" class="form-control" name="telefone" id="telefone"
        value="{{ old('telefone', $cliente->telefone) }}" maxlength="15" required>
</div>
<div class="form-group">
    <label for="email">E-mail:</label>
    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $cliente->email) }}">
</div>
<div class="form-group">
    <label for="endereco">Endereço completo:@include('partials.campoObrigatorio')</label>
    <input type="text" class="form-control" name="endereco_completo" id="endereco_completo"
        value="{{ old('endereco', $cliente->endereco_completo) }}" required>
</div>
<div class= "text-center mt-2">
<button type="submit" class="btn @include('partials.buttomCollor') mt-3">Alterar dados do
    cliente</button>
</div>
@endsection
@push('scripts')
<script>
    function formatarCpfCnpj() {
        let input = document.getElementById('cpfOuCnpj');
        let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        let formattedValue = '';
        let cursorPosition = input.selectionStart;
        let oldLength = input.value.length;

        if (value.length <= 11) { // CPF
            if (value.length > 3) {
                formattedValue = value.substring(0, 3) + '.' + value.substring(3, 6);
            } else {
                formattedValue = value;
            }
            if (value.length > 6) {
                formattedValue += '.' + value.substring(6, 9);
            }
            if (value.length > 9) {
                formattedValue += '-' + value.substring(9, 11);
            }
        } else { // CNPJ
            formattedValue = value.substring(0, 2) + '.' + value.substring(2, 5);
            if (value.length > 5) {
                formattedValue += '.' + value.substring(5, 8);
            }
            if (value.length > 8) {
                formattedValue += '/' + value.substring(8, 12);
            }
            if (value.length > 12) {
                formattedValue += '-' + value.substring(12, 14);
            }
        }

        input.value = formattedValue;
        let newLength = formattedValue.length;
        cursorPosition += (newLength - oldLength);
        input.setSelectionRange(cursorPosition, cursorPosition);
    }

    // Adiciona o evento de input para chamar a função de formatação quando o usuário digitar no campo
    document.getElementById('cpfOuCnpj').addEventListener('input', function() {
        let cursorPosition = this.selectionStart;
        formatarCpfCnpj();
    });
</script>

<script>
function formatarTelefone() {
    let input = document.getElementById('telefone');
    let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    let formattedValue = '';

    if (value.length > 2) {
        formattedValue = '(' + value.substring(0, 2) + ') ';
    } else {
        formattedValue = value;
    }

    if (value.length === 10) { // Telefone fixo (8 dígitos + DDD)
        formattedValue += value.substring(2, 6) + '-' + value.substring(6, 10);
    } else if (value.length === 11) { // Celular (9 dígitos + DDD)
        formattedValue += value.substring(2, 7) + '-' + value.substring(7, 11);
    } else {
        formattedValue += value.substring(2);
    }

    input.value = formattedValue;
}

// Adiciona o evento de input para chamar a função de formatação quando o usuário digitar no campo
document.getElementById('telefone').addEventListener('input', formatarTelefone);


</script>
@endpush
