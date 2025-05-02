@extends('layouts.cadastro')
@section('titulo', 'Cadastrar novo funcionário')
@section('formulario')
@section('voltar', route('configuracoes'))
@section('route', route('configuracoes.funcionario.cadastrar'))

<div class="form-group">
    <label for="nome">Nome
        @include('partials.campoObrigatorio')
    </label>
    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do funcionario"
        required>
</div>
<div class="form-group">
    <label for="sobrenome">Sobrenome
        @include('partials.campoObrigatorio')
    </label>
    <input type="text" class="form-control" id="sobrenome" name="sobrenome"
        placeholder="Digite o sobrenome do funcionario" required>
</div>
<div class="form-group">
    <label for="cargo">Cargo
        @include('partials.campoObrigatorio')
    </label>
    <select class="form-control" id="cargo" name="cargo" required>
        <option selected disabled>Selecione o cargo</option>
        <option value="vendedor">Vendedor</option>
        <option value="auxiliarAdministrativo">Auxiliar Administrativo</option>
        <option value="Administrador">Administrador</option>
    </select>
</div>
<div class="form-group">
    <label for="email">E-mail
        @include('partials.campoObrigatorio')
    </label>
    <input type="text" class="form-control" id="email" name="email"
        placeholder="Digite o e-mail do funcionario" required>
</div>
<div class="form-group alert alert-primary mt-3">
    <label for="senha">
      <p>Padrão da senha: 3 primeiras letras do primeiro nome, 3 primeiras letras do sobrenome, número 12. </p>
		<p>Todas as letras maiúsculas.</p>
     <p> Ex: JOAOSIL12 do usuário João Silva" </p>
    </label>
</div>
<div class="text-center mt-3">
    <button type="submit" class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
    <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
</div>
@endsection
