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

      <!-- Offcanvas para o menu -->
     @include('partials.menu')

      <!-- Offcanvas para notificações -->
      @include('partials.notificacoes')

    <div class="d-flex align-items-center justify-content-center " style="height: 92vh;">
        <div class="container mt-5 col-md-6 ">
            <div class="row align-items-center justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="card-body ">
                                    <h2 class="text-center">Estoque</h2>
                                    <div>
                                        <form action="{{ route('estoque.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="acao" id="acao" value="">
                                            <input type="hidden" name="id" id="id" value="{{$produto->id}}">

                                            <p> Nome do produto: {{ $produto->nome }}</p>
                                            <p> Quantidade atual: {{ $produto->quantidade }}</p>
                                            <p> Ultima ação:
                                                @if ($estoqueRecente->acao == null)
                                                    Nenhuma ação
                                                @else
                                                    {{ $estoqueRecente->acao }} de {{ $estoqueRecente->quantidade }}
                                                    unidades pelo usuario {{ $estoqueRecente->usuario }}
                                                @endif
                                            </p>
                                            <p> Valor a alterar </a> <input type="number" name="quantidade"
                                                    id="quantidade" min="1" required>
                                            <div class=" text-center mt-3">
                                                <button type="submit" class="btn btn-success"
                                                    onclick="setAction('reposicao')">Reposição</button>
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="setAction('baixa')">Baixa</button>
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
    <script>
        function setAction(action) {
            document.getElementById('acao').value = action;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
