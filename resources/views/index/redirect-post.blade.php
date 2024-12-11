<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecionando...</title>
</head>
<body>
    <form id="postForm" action="{{ $url }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="senha" value="{{ $senha }}">

    </form>
    {{dd(session()->all())}}
    {{$email}}
    {{$senha}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Supondo que você tenha as variáveis $email e $senha
        $.ajax({
            url: '/central-login',  // A URL que chama o método centralLogin
            type: 'POST',
            data: {
                email: '{{ $email }}',
                senha: '{{ $senha }}',
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.url) {
                    $.ajax({
                        url: response.url,
                        type: 'POST',
                        data: {
                            email: response.email,
                            senha: response.senha,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(subdomainResponse) {
                            window.location.href = subdomainResponse.redirect_url;  // Substitua pelo redirecionamento necessário
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                alert('Erro ao fazer login');
            }
        });
    </script>
</body>
</html>
