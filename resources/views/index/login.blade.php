<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simplifiq</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>
<body  style="height: 100vh;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary text-light sticky-top">
    <a class="navbar-brand ms-2" style="font-family: 'Quicksand', sans-serif;">Simplifiq System</a>
    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse ml-auto" id="navbarNav">
        <ul class="navbar-nav >
            <li class="nav-item">
                <a class="nav-link" href="/">Início</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sobre</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="#">Contato</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link active" aria-current="page" href="/login">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/cadastrodeempresa">Cadastro</a>
            </li>
        </ul>
        
    </div>
</nav>

<div class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center">Login</h2>
                        <form method="POST" action="/dashboard">
                        @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Digite seu email">
                            </div>
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" class="form-control" id="password" placeholder="Digite sua senha">
                            </div>
                            <div class="d-grid gap-2" >
                            <button type="submit" class="btn btn-primary text-center">Entrar</button>
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
</body>
</html>
