@extends('layouts.cadastro')
@section('titulo', 'Excluir funcionário do sistema')
@section('formulario')
@section('voltar', route('configuracoes'))
@section('route', route('configuracoes.funcionario.excluir'))

                                <div class="form-group">

                                    @if($funcionarios->count() == 0)
                                        <div class="alert alert-danger">
                                            Não há outros funcionários cadastrados no sistema.
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

                                <div class="text-center mt-3">
                                    <button type="submit"
                                        class="btn @include('partials.buttomCollor') text-center">Excluir</button>
                                    <button type="reset"
                                        class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                                </div>
                                @endif
@endsection
