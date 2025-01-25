@extends('layouts.cadastro')
@section('titulo', 'Cadastro de Produto')
@section('formulario')
    @php
        $jquery = true;
    @endphp
@section('route', route('vendas.store'))
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
    <label for="data">Metodo de pagamento:</label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="metodo_pagamento" id="Dinheiro" value="Dinheiro" checked>
        <label class="form-check-label" for="Dinheiro">
            <i class="bi bi-cash-coin"></i> Dinheiro
        </label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="metodo_pagamento" id="Pix" value="Pix">
        <label class="form-check-label" for="Pix">
            <i class="bi bi-x-diamond-fill"></i> Pix
        </label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="metodo_pagamento" id="Cartão de credito"
            value="Cartão de credito">
        <label class="form-check-label" for="Cartão de credito">
            <i class="bi bi-credit-card-fill"></i> Cartão de credito
        </label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="metodo_pagamento" id="Cartão de debito"
            value="Cartão de debito">
        <label class="form-check-label" for="Cartão de debito">
            <i class="bi bi-credit-card"></i> Cartão de debito
        </label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="metodo_pagamento" id="Crediario" value="Crediário">
        <label class="form-check-label" for="Crediário">
            <i class="bi bi-journal-bookmark-fill"></i> Crediário
        </label>
    </div>
</div>
<!-- Input para buscar Produto -->
<div class="form-group">
    <label for="produto-search">Produto:</label>
    <input type="text" id="produto-search" class="form-control" placeholder="Digite o nome do produto">
</div>

<!-- Lista de produtos selecionados -->
<div id="produtos-selecionados">
    <h5>Produtos Selecionados:</h5>
    <div class="form-group" id="produtos-list">
        <!-- Produtos serão adicionados aqui dinamicamente -->
    </div>
</div>
<div class="form-group">
    <label for="valor-total"><i class="bi bi-cash-stack"></i> Valor Total: </label>
    <span type="text" id="valor-total" class="form-control-static"></span>
</div>
<div class="form-group">
    <label for="desconto-maximo"><i class="bi bi-tag"></i> Desconto Máximo: </label>
    <span type="text" id="desconto-maximo" class="form-control-static">
    </span>
</div>
<div class="form-group">
    <label for="valor_venda">Valor da venda:</label>
    <input type="number" name="valor_venda" id="valor_venda" class="form-control" placeholder="Digite o valor da venda"
        step="0.01">
    <input type="hidden" name="desconto_maximo" id="input_desconto_maximo" value="0">
    <input type="hidden" name="valor_total" id="input_valor_total" value="0">
</div>

<!-- Botão de Registrar Venda -->
<button type="submit" class="btn @include('partials.buttomCollor') mt-3">Registrar
    Venda</button>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


<script>
    $(document).ready(function() {
        let produtos = {}; // Armazena os produtos selecionados com valores

        // Função para buscar produtos via AJAX
        $("#produto-search").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('produtos.search') }}",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.nome + " " + item.modelo +
                                    " / " + item.marca,
                                value: item.nome,
                                id: item.id,
                                preco_venda: item.preco_venda,
                                desconto_maximo: item
                                    .desconto_maximo // Adicionar o desconto máximo do produto
                            };
                        }));
                    }
                });
            },
            select: function(event, ui) {
                // Adicionar o produto à lista, se ainda não estiver
                if (!produtos[ui.item.id]) {
                    produtos[ui.item.id] = {
                        nome: ui.item.label,
                        preco_venda: parseFloat(ui.item.preco_venda),
                        desconto_maximo: parseFloat(ui.item.desconto_maximo),
                        quantidade: 1
                    };

                    let produtoHtml = `
                <div class="form-group row align-items-center mb-2" id="produto-${ui.item.id}">
                    <label class="col-4 col-form-label">${ui.item.label}</label>
                    <div class="col-3">
                        <input type="number" name="quantidades[${ui.item.id}]" class="form-control quantidade-produto" data-id="${ui.item.id}" value="1" min="1" required>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger remove-produto" data-id="${ui.item.id}">Remover</button>
                    </div>
                </div>`;
                    $("#produtos-list").append(produtoHtml);

                    atualizarValores();
                }

                $(this).val('');
                return false;
            }
        });

        // Função para remover produto da lista
        $(document).on('click', '.remove-produto', function() {
            let id = $(this).data('id');
            delete produtos[id];
            $(`#produto-${id}`).remove();
            atualizarValores();
        });

        // Atualizar os valores quando a quantidade mudar
        $(document).on('input', '.quantidade-produto', function() {
            let id = $(this).data('id');
            let quantidade = parseInt($(this).val()) || 1;
            produtos[id].quantidade = quantidade;
            atualizarValores();
        });

        // Função para atualizar valores total e desconto máximo
        function atualizarValores() {
            let valorTotal = 0;
            let descontoMaximo = 0;

            Object.values(produtos).forEach(produto => {
                let subtotal = produto.preco_venda * produto.quantidade;
                let desconto = produto.desconto_maximo * produto.quantidade;

                valorTotal += subtotal;
                descontoMaximo += desconto;
            });

            function formatarMoeda(valor) {
                return valor.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
            }

            // Atualiza os valores na interface
            document.getElementById('valor-total').innerText = formatarMoeda(valorTotal);
            document.getElementById('desconto-maximo').innerText = formatarMoeda(descontoMaximo);

            // Define os valores de min e max no input de valor de venda
            const inputValorVenda = document.getElementById('valor_venda');
            inputValorVenda.min = descontoMaximo.toFixed(2);
            inputValorVenda.max = valorTotal.toFixed(2);

            document.getElementById('input_desconto_maximo').value = descontoMaximo.toFixed(2);
            document.getElementById('input_valor_total').value = valorTotal.toFixed(2);
        }

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
@endpush
