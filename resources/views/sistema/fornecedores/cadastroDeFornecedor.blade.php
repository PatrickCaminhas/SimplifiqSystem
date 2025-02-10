@extends('layouts.cadastro')
@section('titulo', 'Cadastro de fornecedor')
@section('formulario')
@section('route', route('fornecedor.store'))

<div class="form-group">
    <label for="nomefornecedor">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do fornecedor">
</div>
<div class="form-group">
    <label for="cnpjornecedor">CNPJ</label>
    <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o CNPJ do fornecdor">
</div>
<div class="form-group">
    <label for="enderecofornecedor">Endereço</label>
    <input type="text" class="form-control" id="endereco" name="endereco"
        placeholder="Digite o endereço do fornecdor">
</div>
<div class="form-group">
    <label for="cidadefornecedor">Cidade</label>
    <input type="text" class="form-control" id="cidade" name="cidade"
        placeholder="Digite a cidade do fornecedor">
</div>
<div class="form-group">
    <label for="estadofornecedor">Estado</label>
    <select class="form-control" id="estado" name="estado">
        <option selected disabled>Selecione o estado</option>
        @include('partials.estadosBrasil')
    </select>
</div>
<div class="form-group">
    <label for="representantefornecedor">Representante</label>
    <input type="text" class="form-control" id="nome_representante" name="nome_representante"
        placeholder="Digite o nome do representante do fornecedor">
</div>
<div class="form-group">
    <label for="emailfornecedor">E-mail</label>
    <input type="text" class="form-control" id="email" name="email"
        placeholder="Digite o e-mail do fornecedor">
</div>
<div class="form-group">
    <label for="telefonefornecedor">Telefone</label>
    <input type="text" class="form-control" id="telefone" name="telefone"
        placeholder="Digite o telefone do fornecedor" maxlength="15">
</div>
<div class= "text-center mt-1">
    <button type="submit" class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
    <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
</div>
@endsection
@push('scripts')
<script>
    // Função para formatar o CNPJ enquanto o usuário digita
    function formatarCNPJ() {
        let input = document.getElementById('cnpj');
        let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        let formattedValue = '';

        if (value.length > 0) {
            formattedValue = value.substring(0, 2); // Adiciona os dois primeiros dígitos

            if (value.length > 2) {
                formattedValue += '.' + value.substring(2, 5); // Adiciona o ponto e os três próximos dígitos
            }

            if (value.length > 5) {
                formattedValue += '.' + value.substring(5, 8); // Adiciona o ponto e os três próximos dígitos
            }

            if (value.length > 8) {
                formattedValue += '/' + value.substring(8, 12); // Adiciona a barra e os quatro próximos dígitos
            }

            if (value.length > 12) {
                formattedValue += '-' + value.substring(12, 14); // Adiciona o hífen e os dois últimos dígitos
            }
        }

        input.value = formattedValue;
    }

    // Adiciona o evento de input para chamar a função de formatação quando o usuário digitar no campo
    document.getElementById('cnpj').addEventListener('input', formatarCNPJ);
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
