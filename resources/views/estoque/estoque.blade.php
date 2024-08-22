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

    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">
                            <h2 class="text-center">Estoque</h2>
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Quantidade</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produtos as $produto)
                                        <tr>
                                            <td style="overflow-x: auto;">{{ $produto->id }}</td>
                                            <td>{{ $produto->nome }}</td>
                                            <td>{{ $produto->quantidade }}</td>
                                            <td>
                                                <button type="button" class="btn bg-primary text-light"
                                                    data-bs-toggle="modal" data-bs-target="#meta{{ $produto->id }}"
                                                    data-produto-id="{{ $produto->id }}">
                                                    Alterar
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="meta{{ $produto->id }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    Produto #{{ $produto->id }}</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body bg-secondary-subtle">

                                                                    <div class="col-md-8">
                                                                        <label for="exampleFormControlInput1"
                                                                            class="form-label">Produto:</label>
                                                                        <a>{{ $produto->nome . ' ' . $produto->modelo . ' ' }}</a>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Marca:
                                                                        <a>{{ $produto->marca }}</a></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Quantidade atual:
                                                                        <a>{{ $produto->quantidade }}</a></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p for="exampleFormControlInput1"
                                                                            class="form-label">Ultima ação:</p>
                                                                        <a id="ultima-acao-{{ $produto->id }}">
                                                                          Nenhuma ação
                                                                        </a>
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form method="POST" action="{{ route('estoque.update', $produto->id) }}" id="form-estoque">
                                                                    @csrf
                                                                    <div class="col-md-12">
                                                                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                                                        <input type="hidden" id="tipo_acao" name="tipo_acao" value="">
                                                                        <div class="form-floating mb-3">
                                                                            <input type="number" class="form-control" name="quantidade" id="quantidade" min="1" required>
                                                                            <label for="quantidade">Quantidade:</label>
                                                                        </div>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary" onclick="definirAcao('baixa')" @if ($produto->quantidade == 0) disabled @endif>
                                                                        Baixa
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary" onclick="definirAcao('reposicao')">
                                                                        Reposição
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('button[data-produto-id]');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const produtoId = this.getAttribute('data-produto-id');
                    fetch(`/estoque/recente/${produtoId}`)
                        .then(response => response.json())
                        .then(data => {
                            const ultimaAcao = document.getElementById(`ultima-acao-${produtoId}`);
                            if (data) {
                                ultimaAcao.innerHTML = `Última ação: ${data.acao || 'Nenhuma ação'} de ${data.quantidade || '0'} unidades pelo usuário ${data.usuario || 'desconhecido'}`;
                            } else {
                                ultimaAcao.innerHTML = 'Nenhuma ação';
                            }
                        })
                        .catch(error => console.error('Erro ao carregar a última ação:', error));
                });
            });
        });
    </script>
    <script>
        function definirAcao(acao) {
            document.getElementById('tipo_acao').value = acao;
        }
    </script>

</body>

</html>
