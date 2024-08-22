<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Página Não Encontrada</title>
    <link rel="shortcut icon" type="imagex/png" href="{{ global_asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body class="bg-primary">
    <div class="container text-center text-white">
        <div class="row align-items-center ">
            <div class="col">
                <h1 class="display-1">404</h1>
                <h2>Página Não Encontrada</h2>
                <p>Desculpe, a página que você está procurando não existe.</p>
                <a href="{{ url()->previous() }}" class="btn btn-light">Voltar</a>
            </div>
        </div>
    </div>

</body>

</html>
