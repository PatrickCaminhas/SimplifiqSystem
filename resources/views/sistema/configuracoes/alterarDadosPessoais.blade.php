<!DOCTYPE html>
<html lang="pt-br">

@include('partials.head')


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
                            <h1 class="text-center">Alterar dados pessoais</h1>
                            <form method="POST" action="{{ route('configuracoes.dados.alterar') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                        placeholder="{{$funcionario->nome}}"
                                         value="{{ old('nome', $funcionario->nome) }}" required>

                                </div>
                                <div class="form-group">
                                    <label for="sobrenome">Sobrenome</label>
                                    <input type="text" class="form-control" id="sobrenome" name="sobrenome"
                                        placeholder="{{$funcionario->sobrenome}}"
                                         value="{{ old('sobrenome', $funcionario->sobrenome) }}" required>

                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="{{$funcionario->email}}"
                                         value="{{ old('email', $funcionario->email) }}" required>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit"
                                        class="btn @include('partials.buttomCollor') text-center">Atualizar</button>
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
