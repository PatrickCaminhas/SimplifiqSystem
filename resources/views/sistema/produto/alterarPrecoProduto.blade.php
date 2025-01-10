<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Produto</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')
    <div class=" d-flex align-items-center justify-content-center" style="height: 91vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="text-center">Alterar preço</h2>
                            @include('partials.errorAndSuccess')
                            <form method="POST" action="{{ route('produto.preco.store') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $produto->id }}">
                                <div class=" form-group">
                                    <label for="descontomaximoproduto">Produto:
                                        {{ $produto->nome . ' ' . $produto->modelo . ' / ' . $produto->marca }}</label>
                                </div>
                                <div class=" form-group">
                                    <label for="precovendaproduto">Preço de venda<label
                                            class="text-danger">*</label></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                        <input type="number" class="form-control" id="precovendaproduto"
                                            name="preco_venda" min='{{ $produto->preco_compra }}'
                                            placeholder="{{ $produto->preco_venda }}"
                                            value="{{ old('preco_venda', $produto->preco_venda) }}" step="0.01"
                                            required>
                                    </div>
                                </div>
                                <div class=" form-group">
                                    <label for="descontomaximoproduto">Desconto máximo</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                        <input type="number" class="form-control" id="descontomaximoproduto"
                                            name="desconto_maximo" min='{{ $produto->preco_compra }}'
                                            placeholder="{{ $produto->desconto_maximo }}" step="0.01">
                                    </div>
                                </div>
                                <div class="text-center mt-1">
                                    <button type="submit"
                                        class="btn @include('partials.buttomCollor') text-center">Alterar</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const precoVendaInput = document.getElementById('precovendaproduto');
            const descontoMaximoInput = document.getElementById('descontomaximoproduto');

            form.addEventListener('submit', function(e) {
                const precoVenda = parseFloat(precoVendaInput.value) || 0;
                const descontoMaximo = parseFloat(descontoMaximoInput.value) || 0;

                if (descontoMaximo > precoVenda) {
                    e.preventDefault();
                    alert('O desconto máximo não pode ser maior que o preço de venda.');
                }
            });
        });
    </script>

</body>

</html>
