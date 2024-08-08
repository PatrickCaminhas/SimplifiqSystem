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


    <div class="container mt-4 mb-4 bg-light text-dark ">
        <div class="row">
            <div class="col-md-12 text-center " style="overflow: auto;">
                <h4 class="display-6">Cotação de Produtos</h4>
                <form method="POST" action="/cotacaoprodutosrevisao" >
                    @csrf
                    <table class="col-md-12 table table-striped table-hover table-secondary ">
                        <thead>
                            <tr class=" text-light">
                                <th scope="col">Produto</th>
                                <th scope="col">Fornecedor 1</th>
                                <th scope="col">Fornecedor 2</th>
                                <th scope="col">Fornecedor 3</th>
                                <th scope="col">Fornecedor 4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mesa de madeira flexivel 70x70 Imbuia</td>
                                <td> <input type="text" class="form-control" id="produto1fornecedor1"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto1fornecedor2"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto1fornecedor3"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto1fornecedor4"
                                        placeholder="Digite o preço"> </td>
                            </tr>
                            <tr>
                                <td>Fogao camping 2 bocas Camper</td>
                                <td> <input type="text" class="form-control" id="produto2fornecedor1"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto2fornecedor2"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto2fornecedor3"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto2fornecedor4"
                                        placeholder="Digite o preço"> </td>
                            </tr>
                            <tr>
                                <td>Guarda-sol 2,5m de diametro</td>
                                <td> <input type="text" class="form-control" id="produto3fornecedor1"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto3fornecedor2"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto3fornecedor3"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto3fornecedor4"
                                        placeholder="Digite o preço"> </td>
                            </tr>
                            <tr>
                                <td>Luminaria Led 12W Everled</td>
                                <td> <input type="text" class="form-control" id="produto4fornecedor1"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto4fornecedor2"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto4fornecedor3"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto4fornecedor4"
                                        placeholder="Digite o preço"> </td>
                            </tr>
                            <tr>
                                <td>Churrasqueira portatil 3 espetos</td>
                                <td> <input type="text" class="form-control" id="produto5fornecedor1"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto5fornecedor2"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto5fornecedor3"
                                        placeholder="Digite o preço"> </td>
                                <td> <input type="text" class="form-control" id="produto5fornecedor4"
                                        placeholder="Digite o preço"> </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class= "text-center mt-2 mb-4">
                        <button type="submit" class="btn btn-success text-center">Salvar</button>
                        <button type="reset" class="btn btn-success text-center">Limpar</button>





                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
