@extends('layouts.padrao')
@section('conteudo')
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="@yield('voltar', '/dashboard')" class="btn @include('partials.buttomCollor') text-center""> <i class="bi bi-arrow-return-left"></i> Voltar</a>
                    <h4 class="display-6 text-center">@yield('titulo', 'Cadastro') </h2>
                    @include('partials.errorAndSuccess')
                    <form method="POST" action="@yield('route')">
                        @csrf
                        @yield('formulario')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
