<!DOCTYPE html>
<html lang="pt-br">
@include('partials.head',['data_tables' => $data_tables ?? false,'chartjs' => $chartjs ?? false, 'jquery' => $jquery ?? false])

<body class="
@if(session('tema') == 'dark')
bg-black
@else
bg-dark
@endsession


">
    <!-- Menu superior -->
    @include('partials.header')
    <div class="container mt-4 ">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-12">
                @yield('conteudo')
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
    @stack('scripts')
</body>

</html>
