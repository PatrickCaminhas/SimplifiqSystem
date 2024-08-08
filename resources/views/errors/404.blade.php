<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Página Não Encontrada</title>
</head>
<body>

    <h1>Página Não Encontrada</h1>
    <p>Desculpe, a página que você está procurando não existe.</p>
    <a href="{{ url()->previous() }}">Voltar</a>
</body>
</html>
