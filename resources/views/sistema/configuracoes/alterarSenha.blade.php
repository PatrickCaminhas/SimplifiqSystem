@extends('layouts.cadastro')
@section('titulo', 'Alterar senha')
@section('formulario')
@section('voltar', route('configuracoes'))
@section('route', route('configuracoes.senha.alterar'))

                                <div class="form-group">
                                    <label for="senhaantiga">Senha antiga</label>
                                    <input type="password" class="form-control" id="senhaantiga" name="senhaantiga"
                                        placeholder="Digite a senha antiga" required>
                                </div>
                                <div class="form-group">
                                    <label for="novasenha">Nova senha</label>
                                    <input type="password" class="form-control" id="novasenha" name="novasenha"
                                        placeholder="Digite a nova senha" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirmanovasenha">Confirme nova senha</label>
                                    <input type="password" class="form-control" id="confirmanovasenha"
                                        name="confirmasenhanova" placeholder="Confirme a nova senha" required>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit"
                                        class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
                                    <button type="reset"
                                        class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                                </div>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">

                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach

                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success mt-3">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
