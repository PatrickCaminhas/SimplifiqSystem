<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Cliente</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')
    <div class="d-flex align-items-center justify-content-center " style="height: 92vh;">
        <div class="container mt-5 col-lg-6 col-md-8 col-sm-12 col-12 ">
            <div class="row align-items-center justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="card-body ">
                                    <div class="container">
                                        <h2>Cadastrar Cliente</h2>
                                        <form action="{{ route('cliente.store') }}" method="POST" id="form-clientes">
                                            @csrf
                                            <div class="form-group">
                                                <label for="cliente">Nome do cliente
                                                    @include('partials.campoObrigatorio')    
                                                </label></label>
                                                <input type="text" class="form-control" name="nome" id="nome"
                                                    placeholder="Digite o nome do cliente"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cpf">CPF/CNPJ
                                                    @include('partials.campoObrigatorio')</label>
                                                    </label>
                                                <input type="number" class="form-control" name="cpfOuCnpj"
                                                    id="cpfOuCnpj" placeholder="Somente numeros" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefone">Telefone
                                                    @include('partials.campoObrigatorio')</label>
                                                    </label>
                                                <input type="number" class="form-control" name="telefone"
                                                    id="telefone" placeholder="Somente numeros" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">E-mail</label>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Digite o e-mail" 
                                                    id="email">
                                            </div>
                                            <div class="form-group">
                                                <label for="endereco">Endereço completo
                                                    @include('partials.campoObrigatorio')</label>
                                                    </label>
                                                <input type="text" class="form-control" name="endereco_completo"
                                                    placeholder="Digite o endereço completo"
                                                    id="endereco_completo" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3">Cadastrar
                                                cliente</button>
                                                <button type="reset" class="btn btn-primary mt-3">Limpar</button>
                                        </form>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-3">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
