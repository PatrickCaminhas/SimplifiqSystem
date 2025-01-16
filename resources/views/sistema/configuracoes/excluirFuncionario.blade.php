<!DOCTYPE html>
<html lang="pt-br">
    @include('partials.head')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Configurações</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')







    <div class=" d-flex align-items-center justify-content-center" style="height: 90vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <a href="{{route('configuracoes')}}" class="btn @include('partials.buttomCollor')">Voltar</a>
                            <h1 class="text-center">Excluir funcionario do sistema</h1>
                            <form method="POST" action="{{ route('configuracoes.funcionario.excluir') }}">
                                @csrf
                                <div class="form-group">
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


    <!-- Features Section -->

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
