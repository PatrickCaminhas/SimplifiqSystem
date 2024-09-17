<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Confirmado - Simplifiq</title>
    <!-- Inclua os arquivos CSS do Bootstrap ou outros estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>
<body class="bg-primary text-white">
    <div class="container mt-5 col-lg-6 col-md-8 col-sm-12 ">
        <div class="row">
            <div class="col-6 offset-md-3 text-center">
                <h1 class="display-4">Cadastro Confirmado!</h1>
                <p class="lead">Seus dados foram enviados para análise. Em breve, você receberá uma mensagem no seu e-mail com os detalhes de acesso.</p>
                <p>Obrigado por escolher nosso sistema!</p>
                <!-- Contador para redirecionamento -->
                <div id="contador"></div>
            </div>
        </div>
    </div>
    <script>
        // Tempo em segundos para redirecionamento
        let tempoRedirecionamento = 10;

        // Função para atualizar o contador
        function atualizarContador() {
            const contadorElemento = document.getElementById("contador");
            contadorElemento.innerText = `Redirecionando em ${tempoRedirecionamento} segundos...`;

            // Atualiza o contador a cada segundo
            const intervalo = setInterval(() => {
                tempoRedirecionamento--;
                contadorElemento.innerText = `Redirecionando em ${tempoRedirecionamento} segundos...`;

                // Quando o tempo chegar a zero, redireciona
                if (tempoRedirecionamento === 0) {
                    clearInterval(intervalo);
                    window.location.href = "/pagina-inicial"; // Substitua pelo URL da página inicial
                }
            }, 1000); // 1000 milissegundos = 1 segundo
        }

        // Inicia o contador
        atualizarContador();
    </script>
    <!-- Contador para redirecionamento -->
    <script>
        setTimeout(function() {
            window.location.href = "/"; // Substitua pelo URL da página inicial
        }, 10000); // 5000 milissegundos = 5 segundos
    </script>

    <!-- Inclua os arquivos JavaScript do Bootstrap ou outros scripts -->
</body>
</html>
