@extends('layouts.cadastro')
@section('titulo', 'Cadastro de cliente')
@section('formulario')
@section('route', route('cliente.update.store'))
<input type="hidden" name="id" value="{{ $cliente->id }}">
<div class="form-group">
    <label for="cliente">Nome do cliente:</label>
    <input type="text" class="form-control" name="nome" id="nome" value="{{ old('nome', $cliente->nome) }}"
        required>
</div>
<div class="form-group">
    <label for="cpf">CPF/CNPJ:</label>
    <input type="number" class="form-control" name="cpfOuCnpj" id="cpfOuCnpj"
        value="{{ old('cfpcnpj', $cliente->cpfOuCnpj) }}" required>
</div>
<div class="form-group">
    <label for="telefone">Telefone:</label>
    <input type="number" class="form-control" name="telefone" id="telefone"
        value="{{ old('telefone', $cliente->telefone) }}" required>
</div>
<div class="form-group">
    <label for="email">E-mail:</label>
    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $cliente->email) }}">
</div>
<div class="form-group">
    <label for="endereco">Endereço completo:</label>
    <input type="text" class="form-control" name="endereco_completo" id="endereco_completo"
        value="{{ old('endereco', $cliente->endereco_completo) }}" required>
</div>
<div class= "text-center mt-2">
<button type="submit" class="btn @include('partials.buttomCollor') mt-3">Alterar dados do
    cliente</button>
</div>
@endsection
