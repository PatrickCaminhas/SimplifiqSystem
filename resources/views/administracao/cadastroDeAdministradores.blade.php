<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Administração</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body
    style="height: 100vh; background-image: url({{ global_asset('img/login.jpg') }}); background-size: cover; background-repea: no-repeat;"
    class="bg-success">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success text-light sticky-top" style="height: 8vh;">
        <a class="navbar-brand ms-2 " style="font-family: 'Quicksand', sans-serif;">Simplifiq System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ml-auto" id="navbarNav">
            <ul class="navbar-nav bg-success">
                <li class="nav-item">
                    <a class="nav-link" href="/">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contato</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('cadastro') }}">Cadastro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('loginAdministrativo.form') }}">Administracao</a>
                </li>
            </ul>

        </div>
    </nav>
    <!-- -->
    <div class="bg-dark bg-opacity-25">
        <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
            <div class="container" style="height: 92vh;">
                <div class="row justify-content-center">
                    <div class="col-6 col-4">
                        <div class="card shadow-sm">
                            <div class="card-body bg-dark text-light border">
                                <h3 class="text-center">Cadastro</h3>
                                <form method="POST" action="{{ route('cadastroAdministrador.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nome">Nome:</label>
                                        <input type="text" class="form-control" id="nome" name="nome"
                                            placeholder="Digite seu nome" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="sobrenome">Sobrenome:</label>
                                        <input type="text" class="form-control" id="sobrenome" name="sobrenome"
                                            placeholder="Digite seu sobrenome" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Digite seu email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="senha">Senha</label>
                                        <input class="form-control" type="password" id="senha" name="senha"
                                            placeholder="Digite sua senha" minlength="8" required>
                                    </div>
                                    <div class="text-center mt-2">
                                        <button type="submit" class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
                                        <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                                    </div>
                                </form>
                                @if ($errors->any())
                                <div class="alert alert-danger mt-3">

                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach

                                </div>
                            @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Função para formatar o número de telefone enquanto o usuário digita
        function formatarTelefone() {
            let input = document.getElementById('telefone');
            let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = '(' + value.substring(0, 2); // Adiciona os dois primeiros dígitos entre parênteses

                if (value.length > 2) {
                    formattedValue += ') ' + value.substring(2, 7); // Adiciona os quatro próximos dígitos com espaço
                }

                if (value.length > 6) {
                    formattedValue += '-' + value.substring(7, 11); // Adiciona o hífen e os quatro últimos dígitos
                }
            }

            input.value = formattedValue;
        }

        // Adiciona o evento de input para chamar a função de formatação quando o usuário digitar no campo
        document.getElementById('telefone').addEventListener('input', formatarTelefone);
    </script>
    <script>
        // Função para formatar o CNPJ enquanto o usuário digita
        function formatarCNPJ() {
            let input = document.getElementById('cnpj');
            let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = value.substring(0, 2); // Adiciona os dois primeiros dígitos

                if (value.length > 2) {
                    formattedValue += '.' + value.substring(2, 5); // Adiciona o ponto e os três próximos dígitos
                }

                if (value.length > 5) {
                    formattedValue += '.' + value.substring(5, 8); // Adiciona o ponto e os três próximos dígitos
                }

                if (value.length > 8) {
                    formattedValue += '/' + value.substring(8, 12); // Adiciona a barra e os quatro próximos dígitos
                }

                if (value.length > 12) {
                    formattedValue += '-' + value.substring(12, 14); // Adiciona o hífen e os dois últimos dígitos
                }
            }

            input.value = formattedValue;
        }

        // Adiciona o evento de input para chamar a função de formatação quando o usuário digitar no campo
        document.getElementById('cnpj').addEventListener('input', formatarCNPJ);
    </script>
    <script>
        // Função para validar a senha enquanto o usuário digita
        function validarSenha() {
            let input = document.getElementById('senha');
            let senha = input.value;

            // Padrão para verificar se há pelo menos 2 letras e 1 letra maiúscula
            let letras = senha.replace(/[^a-zA-Z]/g, '');
            let letrasMaiusculas = letras.replace(/[^A-Z]/g, '');
            let caracteresEspeciais = senha.match(/[!@#$%^&*(),.?":{}|<>]/g);

            let senhaValida = true;
            let mensagemErro = '';

            if (senha.length < 8) {
                senhaValida = false;
                mensagemErro = 'A senha deve ter pelo menos 8 caracteres.';
            } else if (letras.length < 2 || letrasMaiusculas.length < 1) {
                senhaValida = false;
                mensagemErro = 'A senha deve conter pelo menos 2 letras, incluindo pelo menos uma maiúscula.';
            } else if (!caracteresEspeciais) {
                senhaValida = false;
                mensagemErro = 'A senha deve conter pelo menos um caractere especial.';
            }

            // Atualiza a mensagem de erro
            document.getElementById('senhaHelp').textContent = mensagemErro;

            // Retorna verdadeiro se a senha for válida, falso caso contrário
            return senhaValida;
        }

        // Adiciona o evento de input para chamar a função de validação quando o usuário digitar no campo
        document.getElementById('senha').addEventListener('input', validarSenha);
    </script>
</body>

</html>
