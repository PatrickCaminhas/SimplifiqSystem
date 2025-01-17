@extends('layouts.cadastro')
@section('titulo', 'Cadastro de cliente')
@section('formulario')
@section('route', route('cliente.store'))
<div class="form-group">
    <label for="cliente">Nome do cliente
        @include('partials.campoObrigatorio')
    </label>
    <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o nome do cliente" required>
</div>
<div class="form-group">
    <label for="cpf">CPF/CNPJ
        @include('partials.campoObrigatorio')</label>
    </label>
    <input type="number" class="form-control" name="cpfOuCnpj" id="cpfOuCnpj" placeholder="Somente numeros" required>
</div>
<div class="form-group">
    <label for="telefone">Telefone
        @include('partials.campoObrigatorio')</label>
    </label>
    <input type="number" class="form-control" name="telefone" id="telefone" placeholder="Somente numeros" required>
</div>
<div class="form-group">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" name="email" placeholder="Digite o e-mail" id="email">
</div>
<div class="form-group">
    <label for="endereco">Endereço completo
        @include('partials.campoObrigatorio')</label>
    </label>
    <input type="text" class="form-control" name="endereco_completo" placeholder="Digite o endereço completo"
        id="endereco_completo" required>
</div>
<div class= "text-center mt-2">
    <button type="submit" class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
    <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
</div>
@endsection
