@extends('layouts.cadastro')
@section('titulo', 'Cadastrar novo funcionário')
@section('formulario')
@section('voltar', route('configuracoes'))
@section('route', route('configuracoes.funcionario.cadastrar'))

<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do funcionario"
        required>
</div>
<div class="form-group">
    <label for="sobrenome">Sobrenome</label>
    <input type="text" class="form-control" id="sobrenome" name="sobrenome"
        placeholder="Digite o sobrenome do funcionario" required>
</div>
<div class="form-group">
    <label for="cargo">Cargo</label>
    <select class="form-control" id="cargo" name="cargo" required>
        <option selected disabled>Selecione o cargo</option>
        <option value="vendedor">Vendedor</option>
        <option value="auxiliarAdministrativo">Auxiliar Administrativo</option>
        <option value="Administrador">Administrador</option>
    </select>
</div>
<div class="form-group">
    <label for="email">E-mail</label>
    <input type="text" class="form-control" id="email" name="email"
        placeholder="Digite o e-mail do funcionario" required>
</div>
<div class="form-group alert alert-primary mt-3">
    <label for="senha">A senha inicial será padronizada como:
        <br>
        Em maiusculo as 3 primeiras letras do nome mais as 3 primeiras letras do sobrenome também em maiusculo mais o numero 12.
        <br>
        Exemplo: João Silva = JOASIL12
    </label>
</div>
<div class="text-center mt-3">
    <button type="submit" class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
    <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
</div>
@endsection
