@extends('layouts.cadastro')
@section('titulo', 'Alterar dados pessoais')
@section('formulario')
@section('voltar', route('configuracoes'))
@section('route', route('configuracoes.dados.alterar'))
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                        placeholder="{{$funcionario->nome}}"
                                         value="{{ old('nome', $funcionario->nome) }}" required>

                                </div>
                                <div class="form-group">
                                    <label for="sobrenome">Sobrenome</label>
                                    <input type="text" class="form-control" id="sobrenome" name="sobrenome"
                                        placeholder="{{$funcionario->sobrenome}}"
                                         value="{{ old('sobrenome', $funcionario->sobrenome) }}" required>

                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="{{$funcionario->email}}"
                                         value="{{ old('email', $funcionario->email) }}" required>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit"
                                        class="btn @include('partials.buttomCollor') text-center">Atualizar</button>
                                    <button type="reset"
                                        class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                                </div>
@endsection
