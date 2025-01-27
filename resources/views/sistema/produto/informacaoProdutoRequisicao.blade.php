<!DOCTYPE html>
<html lang="pt-br">

@include('partials.head', ['select2' => true])



<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')







    <div class="container mt-5 col-lg-6 col-md-8 col-sm-12  col-6 bg-light text-dark">
        <div class="row">
            <div class=" text-center">
                <h4 class="display-6">Informação de produto</h4>
                <form id="produto-form">
                    @csrf
                    <p class="lead">Aqui você pode visualizar informações detalhadas sobre um produto específico.</p>
                    <label for="produto" class="form-label">Selecione o produto:</label>


                    {{-- <select class="select2 form-control" id="nome" name="nome"
                        onchange="updateFormAction()">
                        <option selected disabled>Selecione um produto</option>
                        @foreach ($produtos as $produto)
                            <option value="{{$produto->nome}}">{{$produto->nome}} </option>
                        @endforeach
                    </select> --}}

                    <div class="form-group">
                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        <input type="text" id="busca-produto" class="form-control" name="nome"
                            placeholder="Digite o nome do produto...">
                        <ul class="list-group" id="sugestoes"></ul>
                    </div>




                </form>



            </div>
        </div>
    </div>
    <script>
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
    </script>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    @vite('resources/js/app.js')

</body>

</html>
