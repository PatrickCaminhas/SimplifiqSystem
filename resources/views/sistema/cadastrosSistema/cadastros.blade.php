<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Simplifiq</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

</head>

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')







    <div class="container mt-5 col-lg-6 col-md-8 col-sm-12  col-12 bg-light text-dark">
        <div class="row">
            <div class=" text-center">
                <h4 class="display-6">Cadastros do sistema</h4>

                <div class="row">
                    <div class="col-6 mb-3 mb-sm-0 mx-auto p-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Cadastro de produtos e materiais</h5>
                                <p class="card-text">Registre no sistema um novo produto a ser vendido ou ativos a serem usado no serviço.</p>
                                <a href="{{ route('cadastroproduto') }}" class="btn btn-primary">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mx-auto p-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Cadastro de fornecedores</h5>
                                <p class="card-text">Registre um novo fornecedor no sistema para a realização de cotações de produtos e ativos.</p>
                                <a href="{{ route(' cadastroFornecedor') }}" class="btn btn-primary">Acessar</a>
                            </div>
                        </div>
                    </div>
                    @if(isset($menu) && $menu !== 'Serviços')
                    <div class="col-6 mx-auto p-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Cadastro de tipos serviços</h5>
                                <p class="card-text">Registre um novo tipo de serviço que pode ser executado pela empresa.</p>
                                <a href="{{ route('servicos.tipo.read') }}" class="btn btn-primary">Acessar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mx-auto p-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Cadastro de serviços</h5>
                                <p class="card-text">Registre um serviço a ser executado pela empresa.</p>
                                <a href="{{ route('servicos.create') }}" class="btn btn-primary">Acessar</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>



            </div>
        </div>
    </div>


    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
