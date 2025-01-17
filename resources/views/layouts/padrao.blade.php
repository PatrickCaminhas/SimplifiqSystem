<!DOCTYPE html>
<html lang="pt-br">
@include('partials.head',['data_tables' => $data_tables ?? false,'chartjs' => $chartjs ?? false, 'jquery' => $jquery ?? false])

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                @yield('conteudo')
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
    @stack('scripts')
</body>

</html>
