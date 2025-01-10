<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Produto</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

</head>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
