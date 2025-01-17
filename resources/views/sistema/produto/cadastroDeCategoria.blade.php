@extends('layouts.cadastro')
@section('titulo', 'Cadastro de Categoria')
@section('formulario')
@section('route', route('produto.categoria.store'))
<div class="form-group">
    <label for="nomeproduto">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome da nova categoria"
        required>
</div>

<div class="text-center mt-1">
    <button type="submit" class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
    <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
</div>
@endsection
