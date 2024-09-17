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

<body class="bg-dark" style="height: 100vh;">
    <!-- Menu superior -->
    @include('partials.header')
    <div class=" d-flex align-items-center justify-content-center" style="height: 90vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="text-center">Cadastro de fornecedor</h2>
                            <form method="POST" action="{{ route(' cadastroFornecedor.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="nomefornecedor">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                        placeholder="Digite o nome do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="cnpjornecedor">CNPJ</label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj"
                                        placeholder="Digite o CNPJ do fornecdor">
                                </div>
                                <div class="form-group">
                                    <label for="enderecofornecedor">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco"
                                        placeholder="Digite o endereço do fornecdor">
                                </div>
                                <div class="form-group">
                                    <label for="cidadefornecedor">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade"
                                        placeholder="Digite a cidade do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="estadofornecedor">Estado</label>
                                    <select class="form-control" id="estado" name="estado">
                                        <option selected disabled>Selecione o estado</option>
                                        @include('partials.estadosBrasil')
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="representantefornecedor">Representante</label>
                                    <input type="text" class="form-control" id="nome_representante"
                                        name="nome_representante"
                                        placeholder="Digite o nome do representante do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="emailfornecedor">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Digite o e-mail do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="telefonefornecedor">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone"
                                        placeholder="Digite o telefone do fornecedor">
                                </div>
                                <div class= "text-center mt-1">
                                    <button type="submit"
                                        class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
                                    <button type="reset"
                                        class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                                </div>
                            </form>
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
