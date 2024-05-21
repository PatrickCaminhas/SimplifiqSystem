<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Simplifiq</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
  </head>
<body style="height: 100vh;" class="bg-primary">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary text-light sticky-top">
    <a class="navbar-brand ms-2 " style="font-family: 'Quicksand', sans-serif;">Simplifiq System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse ml-auto"" id="navbarNav">
        <ul class="navbar-nav >
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
                <a class="nav-link" href="/login">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/cadastrodeempresa">Cadastro</a>
            </li>
        </ul>
        
    </div>
</nav>
<!-- -->
<div class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center">Cadastro</h2>
                        <form method="POST" action="/cadastroempresaconcluido">
                        @csrf
                            <div class="form-group">
                                <label for="nomeempresa">Nome da empresa</label>
                                <input type="text" class="form-control" id="nomeempresa" placeholder="Digite o nome da empresa">
                            </div>
                            <div class="form-group">
                                <label for="cnpj">CNPJ</label>
                                <input type="text" class="form-control" id="cnpj" placeholder="Digite o CNPJ da empresa">
                            </div>
                            <div class="form-group">
                              <label for="tipoEmpresa">Tamanho da empresa</label>
                              <div>
                              <input type="radio" class="btn-check" name="options-outlined" id="mei" autocomplete="off" value="mei">
                              <label class="btn btn-outline-primary" for="mei">MEI</label>
                              <!-- -->
                              <input type="radio" class="btn-check" name="options-outlined" id="micro" autocomplete="off" value="microempresa">
                              <label class="btn btn-outline-primary" for="micro">Micro</label>
                              
                              <input type="radio" class="btn-check" name="options-outlined" id="pequena" autocomplete="off" value="pequenaempresa">
                              <label class="btn btn-outline-primary" for="pequena">Pequena</label>
                            </div>
                            </div>
                            <div class="form-group">
                              <label for="tipoEmpresa">Tipo de empresa</label>
                              <select  class="form-control" id="empresatipo">
                                <option selected disabled  >Selecione o tipo de empresa</option>
                                <option value="industria">Indústria</option>
                                <option value="comercio">Comércio</option>
                                <option value="servicos">Serviços</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="telefone">Telefone</label>
                              <input  class="form-control" type="tel" id="telefone" name="telefone" placeholder="(33) 90123-4567"  required>
                          </div>
                          <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" placeholder="Digite seu email">
                        </div>
                        <div class="form-group">
                          <label for="senha">Senha</label>
                          <input  class="form-control" type="password" id="senha" name="senha" placeholder="Digite sua senha" minlength="8" required>
                      </div>
                      <div class= "text-center mt-1">
                            <button type="submit" class="btn btn-primary text-center">Cadastrar</button>
                            <button type="reset" class="btn btn-primary text-center">Limpar</button>
                      </div>
                        </form>
                    </div>
                    
                </div>
                <div class= "text-center mt-3" >
                    <a href="/" class="btn btn-primary text-center">Voltar</a>
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
