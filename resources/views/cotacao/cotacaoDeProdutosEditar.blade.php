<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Simplifiq</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body class=bg-dark>
     <!-- Menu superior -->
     @include('partials.header')

     <!-- Offcanvas para o menu -->
    @include('partials.menu')

     <!-- Offcanvas para notificações -->
     @include('partials.notificacoes')


    <div class="container mt-4 mb-4 bg-light text-dark">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4 class="display-6">Cotação de Produtos</h4>
               <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Fornecedor</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Produto 1</td>
                            <td>Fornecedor 1</td>
                            <td>R$ 100,00</td>
                            <td>10</td>
                            <td>
                                <button class="btn btn-primary">Editar</button>
                                <button class="btn btn-danger">Excluir</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Produto 2</td>
                            <td>Fornecedor 2</td>
                            <td>R$ 150,00</td>
                            <td>5</td>
                            <td>
                                <button class="btn btn-primary">Editar</button>
                                <button class="btn btn-danger">Excluir</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Produto 3</td>
                            <td>Fornecedor 3</td>
                            <td>R$ 200,00</td>
                            <td>8</td>
                            <td>
                                <button class="btn btn-primary">Editar</button>
                                <button class="btn btn-danger">Excluir</button>
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
