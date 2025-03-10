<!DOCTYPE html>
<html lang="pt-br">
@include('partials.head',['data_tables' => $data_tables ?? false,'chartjs' => $chartjs ?? false, 'jquery' => $jquery ?? false])

<body class="
@if(session('tema') == 'dark')
bg-black
@else
bg-secondary-subtle
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
    @include('partials.buttomsAcessibilidade')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @stack('scripts')
    @include('partials.scriptLightDark')
    @include('partials.scriptAumentarFonte')

</html>
