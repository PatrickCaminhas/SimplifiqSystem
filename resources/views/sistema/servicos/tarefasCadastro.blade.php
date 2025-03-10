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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json">

</head>

<body class="bg-black bg-gradient">
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
                                    <h2 class="text-center">Cadastro de tarefas</h2>
                                    <div>
                                        <form action="{{ route('servicos.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_servico" value="{{ $servico_id }}">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="nome"
                                                    id="nome" placeholder="" required>
                                                <label>Tarefa:</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="nome_cliente"
                                                    id="nome" placeholder="" required><!--//Select -->
                                                <label>Funcionario:</label>
                                            </div>
                                            <div class="form-floating">
                                                <select class="form-select" id="funcionario_atribuido" aria-label="funcionario_atribuido">
                                                  <option selected disabled>Selecione o funcionário</option>
                                                  @foreach ($funcionarios as $funcionario)
                                                  <option value="{{$funcionario->id}}">{{$funcionario->nome." ".$funcionario->sobrenome}}</option>
                                                  @endforeach

                                                </select>
                                                <label for="floatingSelect">Funcionário</label>
                                              </div>
                                              <br>
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" name="data_inicio"
                                                    id="ending_at" min="{{ now()->addWeek()->format('Y-m-d') }}"
                                                    required>
                                                <label> Data de inicio:</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" name="data_fim"
                                                    id="ending_at" min="{{ now()->addWeek()->format('Y-m-d') }}"
                                                    required>
                                                <label> Data do fim:</label>
                                            </div>
                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="Descrição do serviço" id="descricao" name="descricao"></textarea>
                                                <label for="Descricao">Descrição:</label>
                                            </div>
                                            <div class=" text-center mt-3">
                                                <button type="submit" class="btn @include('partials.buttomCollor')">Cadastrar</button>
                                            </div>
                                        </form>
                                        @if ($errors->any())
                                            <div class="alert alert-danger mt-3">

                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}
                                                @endforeach

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
    </div>
    <!-- Features Section -->

    <!-- Inclua os arquivos JavaScript do Bootstrap -->

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
            });
        });
    </script>
</body>

</html>
