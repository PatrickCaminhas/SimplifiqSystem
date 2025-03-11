@extends('layouts.padrao')
@php
    $data_tables = true;
@endphp
@section('conteudo')
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body table-responsive" >
                    <h4 class="display-6 text-center">@yield('titulo', 'Lista')</h4>
                    @include('partials.errorAndSuccessToast')
                    @yield('lista')

                </div>
            </div>
        </div>
    </div>
@endsection
