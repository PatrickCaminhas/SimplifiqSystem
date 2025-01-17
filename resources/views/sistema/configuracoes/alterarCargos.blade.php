@extends('layouts.cadastro')
@section('titulo', 'Alterar cargos')
@section('formulario')
@section('voltar', route('configuracoes'))
@section('route', route('configuracoes.cargos.alterar'))

                                <div class="form-group">
                                @if($funcionarios->count() == 0)
                                    <div class="alert alert-danger">
                                        Você não pode alterar o próprio cargo.
                                    </div>
                                @else
                                    <label for="funcionario">Funcionários</label>
                                    <select class="form-control" id="funcionario" name="funcionario" required>
                                        <option selected disabled>Selecione o funcionário</option>
                                        @foreach ($funcionarios as $funcionario)
                                            <option value="{{ $funcionario->id }}">{{ $funcionario->nome }} - [{{$funcionario->cargo}}]
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cargo">Cargo</label>
                                    <select class="form-control" id="cargo" name="cargo" required>
                                        <option selected disabled>Selecione o cargo</option>
                                        <option value="Proprietário">1. Proprietário</option>
                                        <option value="Gerente">1. Gerente</option>
                                        <option value="Administrador do sistema">1. Administrador do sistema</option>
                                        <option value="Atendente/Vendedor">2. Atendente/Vendedor</option>
                                        <option value="Caixa">2. Caixa</option>
                                        <option value="Auxiliar Administrativo">2. Auxiliar Administrativo</option>
                                    </select>
                                </div>
                                <div class="form-group alert alert-primary mt-3">
                                    <label for="senha">Os cargos são divididos em 2 niveis, sendo o nivel 1 para cargos com permissões
                                        administrativas nas configurações do sistema e o nivel 2 para cargos com permissões operacionais.
                                        <br>
                                        Ex: Gerente (nivel 1) e Atendente/Vendedor (nivel 2).
                                    </label>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit"
                                        class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
                                    <button type="reset"
                                        class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                                </div>
                                @endif
@endsection
