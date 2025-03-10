<!DOCTYPE html>
<html lang="pt-br">

@include('partials.head', ['titulo' => 'Pagina inicial'])

<body class=bg-dark>
      <!-- Menu superior -->
      @include('partials.header')













    <div class=" d-flex align-items-center justify-content-center" style="height: 91vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="text-center">Cadastro de serviços</h2>
                            <form method="POST" action="{{ route('servicos.tipo.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="nomeservico">Nome</label>
                                    <input type="text" class="form-control" id="nomeservico" name="nome"
                                        placeholder="Digite o nome do serviço" required>
                                </div>
                                <div class="form-group">
                                    <label for="duracaoservico">Duração estimada por dia em minutos</label>
                                    <input type="number" class="form-control" id="duracaoservico" name="duracao"
                                        placeholder="Digite o tempo estimado em minutos">
                                </div>
                                <div class="form-group">
                                    <label for="materiaisservico">Materiais necessários</label>
                                    <input type="text" class="form-control" id="materiais" name="materiais"
                                        placeholder="Informe os materiais necessários para o serviço">
                                </div>
                                <div class="form-group">
                                    <label for="quantidadefuncionarios">Quantidade de funcionários necessários</label>
                                    <input type="number" class="form-control" id="quantidade_de_funcionarios" name="quantidade_de_funcionarios"
                                    placeholder="Quantidade de funcionarios para realizar o serviço" min="1">

                                </div>
                                <div class="form-group">
                                    <label for="valorservico">Valor diário do serviço</label>
                                    <input type="number" class="form-control" id="valor" name="valor"
                                        placeholder="Digite o valor do serviço">
                                </div>

                                <div class="form-group">
                                    <label for="descricao">Descrição</label>
                                    <textarea class="form-control" id="descricao" name="descricao" rows="3" style="resize: none;"
                                        placeholder="Digite a descrição do serviço."></textarea>
                                </div>
                                <div class="text-center mt-1">
                                    <button type="submit" class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
                                    <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
