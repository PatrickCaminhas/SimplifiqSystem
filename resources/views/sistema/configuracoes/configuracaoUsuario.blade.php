@extends('layouts.padrao')
@section('conteudo')
    <div class="card shadow-sm">

        <h1 class="text-center">Configurações</h1>

        <div class="container mt-4">
            <div class="row">
                <h4> Configurações pessoais</h3>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-subtitle mb-2 text-muted text-center">Alterar dados pessoais</h5>
                            <p class="card-text">Altere os seus dados cadastrais.</p>
                            <a href="{{ route('configuracoes.dados') }}"
                                class="btn @include('partials.buttomCollor')">Alterar dados</a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-subtitle mb-2 text-muted text-center">Alterar senha</h5>
                            <p class="card-text">Altere sua senha para garantir a segurança de sua conta.</p>
                            <a href="{{ route('configuracoes.senha') }}"
                                class="btn @include('partials.buttomCollor')">Alterar senha</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('Administrador') == true)
            <div class="container mt-4">
                <div class="row">
                    <h4> Configurações do sistema</h3>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-subtitle mb-2 text-muted text-center">Cadastrar funcionario </h5>
                                <p class="card-text">Cadastre um novo funcionário na empresa.</p>
                                @if ($cadastro_funcionario == 'negado')
                                    <a class="btn btn-secondary "disabled>
                                    @else
                                        <a class="btn @include('partials.buttomCollor')"
                                            href="{{ route('configuracoes.funcionario') }}">
                                @endif
                                Cadastraar funcionário</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-subtitle mb-2 text-muted text-center">Lista de usuários</h5>
                                <p class="card-text">Veja lista de todos os usuários da empresa {{session('empresa')}} cadastrados no sistema.</p>
                                <a href="{{ route('configuracoes.cargos') }}"
                                    class="btn @include('partials.buttomCollor')">Alterar cargos</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="container mt-4 mb-4">
                <div class="row">


                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-subtitle mb-2 text-muted text-center">Alterar cargo de usuário</h5>
                                <p class="card-text">Altere os cargos dos usuarios da sua empresa.</p>
                                <a href="{{ route('configuracoes.cargos') }}"
                                    class="btn @include('partials.buttomCollor')">Alterar cargos</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">

                                <h5 class="card-subtitle mb-2 text-muted text-center">Excluir funcionario </h5>
                                <p class="card-text">Exclua um usuario do sistema.</p>


                                <a href="{{ route('configuracoes.excluir') }}"
                                    class="btn @include('partials.buttomCollor')">Cadastrar funcionário</a>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        @endif

    </div>
@endsection
