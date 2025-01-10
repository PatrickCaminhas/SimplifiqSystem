<!DOCTYPE html>
<html lang="pt-br">

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
                            <h1 class="text-center">Alterar cargos</h1>
                            <form method="POST" action="{{ route('configuracoes.cargos.alterar') }}">
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
