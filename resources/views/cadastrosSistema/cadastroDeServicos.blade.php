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




    <!-- Offcanvas para notificações -->


    <div class=" d-flex align-items-center justify-content-center" style="height: 91vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="text-center">Cadastro de produto</h2>
                            <form method="POST" action="{{ route('cadastroproduto.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="nomeproduto">Nome</label>
                                    <input type="text" class="form-control" id="nomeproduto" name="nome"
                                        placeholder="Digite o nome do produto" required>
                                </div>
                                <div class="form-group">
                                    <label for="modeloproduto">Categoria</label>
                                    <input type="text" class="form-control" id="modeloproduto" name="modelo"
                                        placeholder="Digite a categoria do serviço">
                                </div>
                                <div class="form-group">
                                    <label for="marcaproduto">Duração estimada</label>
                                    <input type="text" class="form-control" id="marcaproduto" name="marca"
                                        placeholder="Digite o tempo estimado em minutos">
                                </div>
                                <div class="form-group">
                                    <label for="marcaproduto">Materiais necessários</label>
                                    <input type="text" class="form-control" id="marcaproduto" name="marca"
                                        placeholder="Digite o tempo estimado em minutos">
                                </div>
                                <div class="form-group">
                                    <label for="marcaproduto">Quantidade de pessoas necessárias</label>
                                    <input type="text" class="form-control" id="marcaproduto" name="marca"
                                        placeholder="Digite o tempo estimado em minutos">
                                </div>
                                <div class="form-group">
                                    <label for="marcaproduto">Valor</label>
                                    <input type="text" class="form-control" id="marcaproduto" name="marca"
                                        placeholder="Digite o tempo estimado em minutos">
                                </div>

                                <div class="form-group">
                                    <label for="descricao">Descrição</label>
                                    <textarea class="form-control" id="descricao" name="descricao" rows="3" style="resize: none;"
                                        placeholder="Digite a descrição do produto"></textarea>
                                </div>
                                <div class="text-center mt-1">
                                    <button type="submit" class="btn btn-success text-center">Cadastrar</button>
                                    <button type="reset" class="btn btn-success text-center">Limpar</button>
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
