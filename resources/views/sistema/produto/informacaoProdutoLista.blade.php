<!DOCTYPE html>
<html lang="pt-br">

@include('partials.head', ['select2' => true, 'data_tables' => true])



<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')
    <div class="container mt-5 col-lg-6 col-md-8 col-sm-12  col-6 bg-light text-dark">
        <div class="row">
            <div class=" text-center">
                <h4 class="display-6">Lista de produtos</h4>


                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>

                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produtos as $produto)
                            <tr>
                                <td>{{ $produto->nome . " " . $produto->modelo . " " . $produto->marca  }}</td>
                                <td>{{ $produto->categoria->nome}}</td>
                                <td>

                                        <a href="/informacaoproduto/{{$produto->id}}" class="btn bg-primary text-light">
                                            Verificar
                                        </a>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>



            </div>
        </div>
    </div>
    <!--<script>
        document.getElementById('busca-produto').addEventListener('input', function() {
            const query = this.value;

            if (query.length >= 2) { // Executa a busca a partir de 2 caracteres
                fetch(`/buscar-produto?query=${query}`)

                    .then(response => response.json())
                    .then(data => {
                        const sugestoes = document.getElementById('sugestoes');
                        sugestoes.innerHTML = '';

                        data.forEach(produto => {
                            const li = document.createElement('li');
                            li.textContent = `${produto.nome} ${produto.modelo} ${produto.marca}`;
                            li.className =
                                'list-group-item list-group-item-action list-group-item-primary';
                            li.setAttribute('data-id', produto.id);

                            li.addEventListener('click', function() {
                                const produtoId = this.getAttribute('data-id');
                                window.location.href = `/informacaoproduto/${produtoId}`;
                            });

                            sugestoes.appendChild(li);
                        });
                    });
            } else {
                document.getElementById('sugestoes').innerHTML = '';
            }
        });
    </script>-->

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
</body>

</html>
