<!DOCTYPE html>
<html lang="pt-br">
    @include('partials.head')



<body class=bg-dark>
     <!-- Menu superior -->
     @include('partials.header')








    <div class="container mt-4 mb-4 bg-light text-dark">
        <div class="row">
            <div class="col-12 text-center" style="overflow: auto;">
                <h4 class="display-6">Resultado da cotação de produtos</h4>
                <h4 class ="lead"> Data: $DATA $HORA</h4>
                 <h4 class="lead mb-3">Total: R$ 8000,00</h4>
                <form method="POST" action="/dashboard">
                    @csrf
                    <table class="table table-hover table-secondary table-border border-dark">
                        <thead>
                            <tr class=" text-light">
                                <th scope="col">Produto</th>
                                <th scope="col">Fornecedor</th>
                                <th scope="col">Preço</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Total</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-3">Produto 1</td>
                                <td class="col-3">Fornecedor 1</td>
                                <td class="col-2">R$ 100,00</td>
                                <td class="col-2">10</td>
                                <td class="col-2">R$ 1000,00</td>
                            </tr>
                            <tr>
                                <td class="col-3">Produto 2</td>
                                <td class="col-3">Fornecedor 2</td>
                                <td class="col-2">R$ 200,00</td>
                                <td class="col-2">10</td>
                                <td class="col-2">R$ 1000,00</td>
                            </tr>
                            <tr>
                                <td class="col-3">Produto 3</td>
                                <td class="col-3">Fornecedor 3</td>
                                <td class="col-2">R$ 300,00</td>
                                <td class="col-2">10</td>
                                <td class="col-2">R$ 1000,00</td>
                            </tr>
                            <tr>
                                <td class="col-3">Produto 4</td>
                                <td class="col-3">Fornecedor 2</td>
                                <td class="col-2">R$ 50,00</td>
                                <td class="col-2">10</td>
                                <td class="col-2">R$ 1000,00</td>
                            </tr>
                            <tr>
                                <td class="col-3">Produto 5</td>
                                <td class="col-3">Fornecedor 2</td>
                                <td class="col-2">R$ 100,00</td>
                                <td class="col-2">10</td>
                                <td class="col-2">R$ 1000,00</td>
                            </tr>
                            <tr>
                                <td class="col-3">Produto 6</td>
                                <td class="col-3">Fornecedor 1</td>
                                <td class="col-2">R$ 144,00</td>
                                <td class="col-2">10</td>
                                <td class="col-2">R$ 1000,00</td>
                            </tr>
                            <tr>
                                <td class="col-3">Produto 7</td>
                                <td class="col-3">Fornecedor 3</td>
                                <td class="col-2">R$ 79,00</td>
                                <td class="col-2">10</td>
                                <td class="col-2">R$ 1000,00</td>
                            </tr>
                            <tr>
                                <td class="col-3">Produto 8</td>
                                <td class="col-3">Fornecedor 1</td>
                                <td class="col-2">R$ 30,00</td>
                                <td class="col-2">10</td>
                                <td class="col-2">R$ 1000,00</td>
                            </tr>
                        </tbody>

                    </table>

                    <div class="mt-4 mb-4">

                        <button class="btn @include('partials.buttomCollor') me-2">Salvar</button>
                        <a class="btn btn-primary me-2">Baixar PDF</a>
                        <a class="btn btn-danger me-2" href="/cotacaoprodutos">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
