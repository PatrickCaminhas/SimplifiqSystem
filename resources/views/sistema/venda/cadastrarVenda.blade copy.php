<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Venda</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>

<body class=bg-dark>
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
                                    <div class="container">
                                        <h2>Registrar Venda</h2>
                                        <form action="{{ route('vendas.store') }}" method="POST" id="form-venda">
                                            @csrf
                                            <!-- Select Cliente -->
                                            <div class="form-group">
                                                <label for="cliente">Cliente:</label>
                                                <select name="cliente_id" class="form-control">
                                                    @foreach ($clientes as $cliente)
                                                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="data">Metodo de pagamento:</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="metodo_pagamento" id="Dinheiro" value="Dinheiro" checked>
                                                    <label class="form-check-label" for="Dinheiro">
                                                        Dinheiro
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="metodo_pagamento" id="Pix" value="Pix">
                                                    <label class="form-check-label" for="Pix">
                                                        Pix
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="metodo_pagamento" id="Cartão de credito"
                                                        value="Cartão de credito">
                                                    <label class="form-check-label" for="Cartão de credito">
                                                        Cartão de credito
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="metodo_pagamento" id="Cartão de debito"
                                                        value="Cartão de debito">
                                                    <label class="form-check-label" for="Cartão de debito">
                                                        Cartão de debito
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="metodo_pagamento" id="Crediario" value="Crediário">
                                                    <label class="form-check-label" for="Crediário">
                                                        Crediário
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- Input para buscar Produto -->
                                            <div class="form-group">
                                                <label for="produto-search">Produto:</label>
                                                <input type="text" id="produto-search" class="form-control"
                                                    placeholder="Digite o nome do produto">
                                            </div>

                                            <!-- Lista de produtos selecionados -->
                                            <div id="produtos-selecionados">
                                                <h5>Produtos Selecionados:</h5>
                                                <div class="form-group" id="produtos-list">
                                                    <!-- Produtos serão adicionados aqui dinamicamente -->
                                                </div>
                                            </div>

                                            <!-- Botão de Registrar Venda -->
                                            <button type="submit" class="btn btn-primary mt-3">Registrar Venda</button>
                                        </form>
                                        @if ($errors->any())
                                            <div class="alert alert-danger mt-3">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
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

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


    <script>
        $(document).ready(function() {
            let produtos = {}; // Para armazenar os produtos selecionados

            // Função para buscar produtos via AJAX
            $("#produto-search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('produtos.search') }}", // Rota para buscar produtos
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.nome + ' ' + item.modelo +
                                        ' / ' + item.marca,
                                    value: item.nome,
                                    id: item.id
                                };
                            }));
                        }
                    });
                },
                select: function(event, ui) {
                    // Quando um produto for selecionado, adicionar à lista
                    if (!produtos[ui.item.id]) {
                        produtos[ui.item.id] = ui.item.label;

                        // Criar os inputs para quantidade
                        let produtoHtml = `
                    <div class="form-group row align-items-center mb-2" id="produto-${ui.item.id}">
                        <label class="col-4 col-form-label">${ui.item.label}</label>
                        <div class="col-3">
                            <input type="number" name="quantidades[${ui.item.id}]" class="form-control" placeholder="Quantidade" min="1" required>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-danger remove-produto" data-id="${ui.item.id}">Remover</button>
                        </div>
                    </div>

                `;

                        // Adicionar o HTML no form
                        $('#produtos-list').append(produtoHtml);
                    }

                    // Limpar o campo de busca
                    $(this).val('');
                    return false;
                }
            });

            // Função para remover produto da lista
            $(document).on('click', '.remove-produto', function() {
                let id = $(this).data('id');
                delete produtos[id];
                $('#produto-' + id).remove();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Monitorar mudanças no select do cliente
            $('select[name="cliente_id"]').on('change', function() {
                let clienteSelecionado = $(this).find('option:selected').text().trim();
                let crediarioSelecionado = $('input[name="metodo_pagamento"]:checked').val() ===
                'Crediário';

                if (clienteSelecionado === 'Cliente Não cadastrado') {
                    // Se "Cliente Não cadastrado" for selecionado, desabilita o crediário
                    $('#Crediario').prop('disabled', true);
                    if (crediarioSelecionado) {
                        // Se já estiver crediário selecionado, volta para outro método
                        $('#Dinheiro').prop('checked', true);
                    }
                } else {
                    // Habilita o crediário se não for "Cliente Não cadastrado"
                    $('#Crediario').prop('disabled', false);
                }
            });

            // Monitorar mudanças no método de pagamento
            $('input[name="metodo_pagamento"]').on('change', function() {
                let metodoSelecionado = $(this).val();
                let clienteSelecionado = $('select[name="cliente_id"]').find('option:selected').text()
                .trim();

                if (metodoSelecionado === 'Crediário' && clienteSelecionado === 'Cliente Não cadastrado') {
                    // Se crediário for selecionado e o cliente não for cadastrado, volta ao estado anterior
                    alert('Não é possível selecionar Crediário para "Cliente Não cadastrado".');
                    $(this).prop('checked', false);
                    $('#Dinheiro').prop('checked', true);
                }
            });
        });
    </script>
</body>

</html>
