<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Simplifiq</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <style>
        /* Sobrescreve o estilo do item de menu quando em foco ou ativo */
        .dropdown-item:focus,
        .dropdown-item:active {
            background-color: inherit !important;
            color: inherit !important;
        }

        /* Fonte padrão */
        body {
            font-size: 16px;
        }

        /* Estilo para o aumento de fonte */
        .font-large {
            font-size: 20px;
        }
    </style>
</head>

<body class="bg-dark-subtle">
    <section class="h-100 gradient-form">

        <div class="container py-5 h-100">

            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="m-2 col-lg-6 col-md-8 col-sm-12">

                                    <a class="btn btn-primary" href="/">Voltar</a>
                                </div>
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center d-block d-sm-none">
                                        <img src="{{ global_asset('img/Logo.png') }}" style="width: 185px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">Simplifiq System</h4>
                                    </div>
                                    <form method="POST" action="{{ route('cadastro') }}">
                                        @csrf
                                        <h4 class=" mb-2">Cadastro</h4>

                                        @include('partials.errorAndSuccess')
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" name="nomeempresa"
                                                id="nomeempresa" placeholder="Digite o nome da empresa" required>
                                            <label> Nome da empresa:</label>
                                        </div>
                                        <div class="form-floating mb-2"">
                                            <input type="text" class="form-control" id="cnpj"
                                                placeholder="Digite o CNPJ da empresa" name="cnpj" required>
                                            <label for="cnpj">CNPJ</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <select class="form-control" id="tamanhoempresa" name="tamanhoempresa"
                                                required>
                                                <option selected disabled>Selecione o tamanho de empresa</option>
                                                <option value="mei">MEI</option>
                                                <option value="microempresa">MICRO</option>
                                                <option value="pequenaempresa">PEQUENA</option>
                                            </select>
                                            <label for="tamanhoempresa">Tamanho da empresa</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <select class="form-control" id="tipoempresa" name="tipoempresa" required>
                                                <option selected disabled>Selecione o tipo de empresa</option>
                                                <!-- As opções serão alteradas dinamicamente com JavaScript -->
                                            </select>
                                            <label>Tipo de empresa</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="tel" class="form-control" id="telefone" name="telefone"
                                                placeholder="(33) 90123-4567" required>
                                            <label for="telefone">Telefone</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="date" class="form-control" id="data_de_criacao"
                                                name="data_de_criacao" required>
                                            <label>Data de abertura da empresa:</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="nome" name="nome"
                                                placeholder="Digite seu nome" required>
                                            <label for="nome">Nome:</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="sobrenome" name="sobrenome"
                                                placeholder="Digite seu sobrenome" required>
                                            <label for="sobrenome">Sobrenome:</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Digite seu email" required>
                                            <label for="email">E-mail</label>
                                        </div>
                                        <div class="form-floating mb-2">
                                            <input type="password" class="form-control" name="senha" id="senha"
                                                placeholder="Digite sua senha" required>
                                            <label> Senha:</label>
                                        </div>


                                        <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                                            <button class="btn btn-primary fa-lg bg-primary  mb-3"
                                                type="submit">Cadastre-se</button>

                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Já tem uma conta?</p>
                                            <a type="button" href="{{ route('login') }}"
                                                class="btn btn-outline-primary">Acesse agora</a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <div class="d-none d-sm-block col-lg-6 d-flex align-items-center bg-primary bg-gradient">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4 text-center">
                                    <div class="text-center">
                                        <img src="{{ global_asset('img/Logo.png') }}" style="width: 185px;"
                                            alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">Simplifiq System</h4>
                                    </div>
                                    <h4 class="mb-4">Nós somos mais que uma empresa</h4>
                                    <p class="small mb-0">
                                        Somos um time comprometido em criar soluções que impulsionam o sucesso de
                                        negócios.
                                        Juntos, transformamos desafios em resultados.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('partials.buttomsAcessibilidade')
    @include('partials.scriptAumentarFonte')
    @include('partials.scriptLightDark')
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
        document.getElementById('tamanhoempresa').addEventListener('change', function() {
            const tipoEmpresaSelect = document.getElementById('tipoempresa');
            const tamanhoEmpresa = this.value;

            // Limpa as opções atuais do select de tipo de empresa
            tipoEmpresaSelect.innerHTML = '<option selected disabled>Selecione o tipo de empresa</option>';

            let options = [];

            // Define as opções com base no tamanho da empresa
            if (tamanhoEmpresa === 'mei') {
                options = [{
                        value: 'comercio',
                        text: 'Somente comércio'
                    },
                    {
                        value: 'comercioEservicos',
                        text: 'Serviços e comércio'
                    }
                ];
            } else if (tamanhoEmpresa === 'microempresa' || tamanhoEmpresa === 'pequenaempresa') {
                options = [{
                        value: 'alimentosEbebidas',
                        text: 'Alimentos e bebidas'
                    },
                    {
                        value: 'agropecuarios',
                        text: 'Produtos Agropecuários'
                    },
                    {
                        value: 'atacado',
                        text: 'Atacado'
                    },
                    {
                        value: 'autopecas',
                        text: 'Autopeças'
                    },
                    {
                        value: 'construcao',
                        text: 'Materiais de construção'
                    },
                    {
                        value: 'livrosJornaisPapelaria',
                        text: 'Livros, jornais, revistas e artigos de papelaria.'
                    },
                    {
                        value: 'moveis',
                        text: 'Móveis e eletrodomésticos'
                    },
                    {
                        value: 'farmaceuticos',
                        text: 'Produtos farmacêuticos'
                    },
                    {
                        value: 'informatica',
                        text: 'Produtos de informática'
                    },
                    {
                        value: 'vestuario',
                        text: 'Vestuario'
                    },
                    {
                        value: 'outros',
                        text: 'Outros'
                    },
                ];
            }

            // Adiciona as novas opções ao select de tipo de empresa
            options.forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option.value;
                newOption.textContent = option.text;
                tipoEmpresaSelect.appendChild(newOption);
            });
        });
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
