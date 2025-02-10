<!DOCTYPE html>
<html lang="pt-br">

@include('partials.head', ['chart' => true])

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')
    <div class="container mt-2 col-12 mb-3 ">
        @include('partials.errorAndSuccessToast')
        <div class="row">

            <div id="produto_info" class="col-md-6 col-lg-6 col-sm-12 mt-2">
                <div class="card mb-2 h-100">
                    <div class="card-body">


                        <h5 class="card-title">Informações do produto</h5>
                        <p id="produto_id" class="card-text">ID: {{ $produto->id }}</p>
                        <p id="produto_nome" class="card-text">Nome:
                            {{ $produto->nome . ' ' . $produto->modelo . ' ' . $produto->marca }}
                        </p>
                        <p id="produto_categoria" class="card-text">Categoria: {{ $produto->categoria->nome }}</p>
                        <p id="produto_valor_compra" class="card-text">Valor Compra: R$ {{ $produto->preco_compra }}</p>
                        <p id="produto_valor_venda" class="card-text">Preço venda: R$ {{ $produto->preco_venda }}</p>
                        <p id="produto_ultimo_fornecedor" class="card-text">Ultimo fornecedor:
                            {{ $produto->ultimo_fornecedor }}</p>
                        <p id="produto_estoque" class="card-text">Estoque: {{ $produto->quantidade }}</p>

                    </div>
                </div>
            </div>

            <div id="produto_acoes" class="col-md-6 col-lg-6 col-sm-12 mt-2">
                <div class="card mb-2 h-100 d-flex">
                    <div class="card-body">
                        <h5 class="card-title">Ações</h5>
                        <!--<a href="{{ route('produto.edit', ['id' => $produto->id]) }}" class="btn @include('partials.buttomCollor')">Alterar
                            dados</a>
                        <a href="{{ route('produto.preco', ['id' => $produto->id]) }}" class="btn @include('partials.buttomCollor')">Alterar
                            preço de venda</a>
                        -->
                        <!-- Modal de Edição -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalEditarProduto">
                            Alterar dados
                        </button>

                        <div class="modal fade" id="modalEditarProduto" tabindex="-1"
                            aria-labelledby="modalEditarProdutoLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditarProdutoLabel">Editar Produto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formEditarProduto"
                                            action="{{ route('produto.atualizar.api', ['id' => $produto->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="id" value="{{ $produto->id }}">

                                            <label for="nomeproduto">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome"
                                                placeholder="{{ $produto->nome }}"
                                                value="{{ old('nome', $produto->nome) }}" required>
                                            <div class="form-group">
                                                <label for="modeloproduto">Modelo</label>
                                                <input type="text" class="form-control" id="modeloproduto"
                                                    name="modelo" placeholder="{{ $produto->modelo }}"
                                                    value="{{ old('nome', $produto->modelo) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="marcaproduto">Marca</label>
                                                <input type="text" class="form-control" id="marcaproduto"
                                                    name="marca" placeholder="{{ $produto->marca }}"
                                                    value="{{ old('nome', $produto->marca) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="categoriaproduto">Categoria</label>
                                                @php
                                                    $categorias = \App\Models\Produtos_categoria::all();
                                                @endphp
                                                @if ($categorias->count() == 1)
                                                    <input type="hidden" name="categoria"
                                                        value="{{ $categorias[0]->nome }}">
                                                    <label class="fst-italic">[Nenhuma categoria cadastrada]</label>
                                                    <div id="emailHelp" class="form-text">Irá cadastrar o produto como
                                                        "Sem
                                                        categoria".</div>
                                                @else
                                                    <select class="form-control" id="categoriaproduto" name="categoria"
                                                        required>
                                                        <option disabled>Selecione a categoria do produto</option>
                                                        @foreach ($categorias as $categoria)
                                                            @if ($produto->categoria->id == $categoria->id)
                                                                {
                                                                <option value="{{ $categoria->id }}" selected>
                                                                    {{ $categoria->nome }}</option>
                                                            }@else{
                                                                <option value="{{ $categoria->id }}">
                                                                    {{ $categoria->nome }}
                                                                </option>

                                                                }
                                                            @endif
                                                        @endforeach

                                                    </select>

                                                @endif
                                                <label>Precisa de uma nova categoria? <a type="submit"
                                                        class="btn @include('partials.buttomCollor') text-center"
                                                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
                                                        href="{{ route('produto.categoria') }}">Clique aqui</a></label>
                                            </div>
                                            <div class="form-group">
                                                <label for="unidadeproduto">Unidade de medida</label>
                                                @php
                                                    // Lista de opções de unidades de medida
                                                    $unidadesMedida = [
                                                        'peso' => 'Peso (gramas)',
                                                        'volume' => 'Volume (mililitros)',
                                                        'energia' => 'Energia (Watt)',
                                                        'comprimento' => 'Comprimento (Metros)',
                                                        'area_quadrado' => 'Área (metro quadrado)',
                                                        'area_cubico' => 'Área (metro cubico)',
                                                        'unidade' => 'Unidade',
                                                    ];
                                                @endphp

                                                <select class="form-control" id="unidadeproduto" name="unidade_medida"
                                                    required>
                                                    <option selected disabled>Selecione a unidade de medida do produto
                                                    </option>
                                                    @foreach ($unidadesMedida as $value => $label)
                                                        <option value="{{ $value }}"
                                                            {{ $produto->unidade_medida == $value ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="form-group">
                                                <label for="medidaproduto">Medida</label>
                                                <input type="text" class="form-control" id="medidaproduto"
                                                    name="medida" min='1'
                                                    placeholder="{{ $produto->medida }}"
                                                    value="{{ old('nome', $produto->medida) }}" required>
                                            </div>
                                            <div class=" form-group">
                                                <label for="precocompraproduto">Preço de compra</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                    <input type="number" class="form-control"
                                                        id="precocompraproduto" name="preco_compra" min='1'
                                                        placeholder="{{ $produto->preco_compra }}"
                                                        value="{{ old('nome', $produto->preco_compra) }}"
                                                        step="0.01" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="descricao">Descrição</label>
                                                <textarea class="form-control" id="descricao" name="descricao" rows="3" style="resize: none;"
                                                    placeholder="{{ $produto->descricao }}" value="{{ old('nome', $produto->descricao) }}">{{ $produto->descricao }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary"
                                                data-bs-dismiss="modal">Salvar Alterações</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalEditarPreco">
                            Alterar preços
                        </button>

                        <div class="modal fade" id="modalEditarPreco" tabindex="-1"
                            aria-labelledby="modalEditarPrecoLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditarProdutoLabel">Editar Preços</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formEditarPreco"
                                            action="{{ route('produto.atualizar.precos.api', ['id' => $produto->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')

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
                                                        value="{{ old('preco_venda', $produto->preco_venda) }}"
                                                        step="0.01" required>
                                                </div>
                                            </div>
                                            <div class=" form-group">
                                                <label for="descontomaximoproduto">Desconto máximo</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">R$</span>
                                                    <input type="number" class="form-control" id="desconto_maximo"
                                                        name="desconto_maximo" min='{{ $produto->preco_compra }}'
                                                        placeholder="{{ $produto->desconto_maximo }}" step="0.01">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary"
                                                >Salvar Alterações</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="#" class="btn btn-danger">Excluir produto</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">Estoque</h5>
                        <p class="card-text">
                            <!-- GRAFICO DE ESTOQUE -->
                        <div>
                            <canvas id="estoqueChart"></canvas>
                        </div>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Features Section -->

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    @vite('resources/js/app.js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const estoqueData = {!! json_encode($estoque) !!};

            // Agrupar as quantidades de cada ação por mês/ano
            const groupedData = estoqueData.reduce((acc, item) => {
                const mesAno = `${String(item.mes).padStart(2, '0')}/${item.ano}`; // Formato MM/YYYY
                if (!acc[mesAno]) {
                    acc[mesAno] = {
                        baixa: 0,
                        venda: 0,
                        reposicao: 0
                    }; // Inicializa as quantidades para o mês/ano
                }
                // Sumariza as quantidades de acordo com a ação
                if (item.acao === 'baixa') {
                    acc[mesAno].baixa += item.quantidade;
                } else if (item.acao === 'Venda') {
                    acc[mesAno].venda += item.quantidade;
                } else if (item.acao === 'reposicao') {
                    acc[mesAno].reposicao += item.quantidade;
                }
                return acc;
            }, {});

            // Extrair os meses/anos ordenados e as quantidades para cada ação
            const mesesAnos = Object.keys(groupedData).sort((a, b) => {
                // Ordenar os meses/anos no formato MM/YYYY
                const [mesA, anoA] = a.split('/').map(Number);
                const [mesB, anoB] = b.split('/').map(Number);
                return new Date(anoA, mesA - 1) - new Date(anoB, mesB - 1);
            });

            // Preencher os arrays de quantidades, garantindo que todos os meses estejam no gráfico
            const quantidadeBaixas = mesesAnos.map(mesAno => groupedData[mesAno].baixa);
            const quantidadeVendas = mesesAnos.map(mesAno => groupedData[mesAno].venda);
            const quantidadeReposicoes = mesesAnos.map(mesAno => groupedData[mesAno].reposicao);

            const ctx = document.getElementById('estoqueChart').getContext('2d');
            const estoqueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: mesesAnos, // Meses/anos ordenados
                    datasets: [{
                            label: 'Baixas',
                            data: quantidadeBaixas, // Quantidade de baixas
                            borderColor: 'rgba(247, 39, 39, 1)',
                            backgroundColor: 'rgba(247, 39, 39, 1)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'Vendas',
                            data: quantidadeVendas, // Quantidade de vendas
                            borderColor: 'rgba(39, 247, 46, 1)',
                            backgroundColor: 'rgba(39, 247, 46, 1)',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'Reposições',
                            data: quantidadeReposicoes, // Quantidade de reposições
                            borderColor: 'rgba(38, 72, 255, 1)',
                            backgroundColor: 'rgba(38, 72, 255, 1)',
                            fill: false,
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Meses/Ano'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Quantidade'
                            }
                        }
                    }
                }
            });
        });
    </script>

    <script>
        document.getElementById('formEditarProduto').addEventListener('submit', function(event) {
            event.preventDefault(); // Previne o redirecionamento padrão do formulário

            let form = this;
            let formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Atualiza os elementos da página com os novos dados do produto
                        // (Utilize os IDs ou seletores adequados para cada campo)
                        data.produto.preco_compra = parseFloat(data.produto.preco_compra).toFixed(2);
                        data.produto.preco_venda = parseFloat(data.produto.preco_venda).toFixed(2);


                        document.getElementById('produto_info').innerHTML = `
                <div class="card mb-2 h-100">
                    <div class="card-body">
                        <h5 class="card-title">Informações do produto</h5>
                        <p class="card-text">ID: ${data.produto.id}</p>
                        <p class="card-text" id="produto_nome">Nome: ${data.produto.nome} ${data.produto.modelo} ${data.produto.marca}</p>
                        <p class="card-text">Categoria: ${data.produto.categoria.nome}</p>
                        <p class="card-text">Valor Compra: R$ ${data.produto.preco_compra}</p>
                        <p  class="card-text">Preço venda: R$ ${ data.produto.preco_venda}</p>
                        <p id="produto_ultimo_fornecedor" class="card-text">Ultimo fornecedor:
                            ${ data.produto.ultimo_fornecedor }</p>
                        <p id="produto_estoque" class="card-text">Estoque: ${ data.produto.quantidade }</p>
                    </div>
                </div>
            `;

                        // Exibe o toast de sucesso
                        const toastEl = document.getElementById('toastSuccess');
                        if (toastEl) {
                            // Se necessário, remova a classe 'show' para reiniciar o toast
                            toastEl.classList.remove('show');
                            const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
                            document.getElementById('toastMessage').innerText =
                                'Produto atualizado com sucesso!';
                            toast.show();
                        } else {
                            console.warn("Elemento 'toastSuccess' não encontrado!");
                        }


                    } else {
                        alert("Erro ao atualizar produto!");
                    }
                })
                .catch(error => console.error("Erro:", error));
        });
    </script>

    <script>
        document.getElementById('formEditarPreco').addEventListener('submit', function(event) {
            event.preventDefault(); // Previne o redirecionamento padrão do formulário

            let form = this;
            let formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Atualiza os elementos da página com os novos dados do produto
                        // (Utilize os IDs ou seletores adequados para cada campo)

                        data.produto.preco_venda = parseFloat(data.produto.preco_venda).toFixed(2);
                        data.produto.desconto_maximo = parseFloat(data.produto.desconto_maximo).toFixed(2);

                        document.getElementById('produto_info').innerHTML = `
            <div class="card mb-2 h-100">
                <div class="card-body">
                    <h5 class="card-title">Informações do produto</h5>
                    <p class="card-text">ID: ${data.produto.id}</p>
                    <p class="card-text" id="produto_nome">Nome: ${data.produto.nome} ${data.produto.modelo} ${data.produto.marca}</p>
                    <p class="card-text">Categoria: ${data.produto.categoria.nome}</p>
                    <p class="card-text">Valor Compra: R$ ${data.produto.preco_compra}</p>
                    <p  class="card-text">Preço venda: R$ ${ data.produto.preco_venda}</p>
                    <p id="produto_ultimo_fornecedor" class="card-text">Ultimo fornecedor:
                        ${ data.produto.ultimo_fornecedor }</p>
                    <p id="produto_estoque" class="card-text">Estoque: ${ data.produto.quantidade }</p>
                </div>
            </div>
        `;

                        // Exibe o toast de sucesso
                        const toastEl = document.getElementById('toastSuccess');
                        if (toastEl) {
                            // Se necessário, remova a classe 'show' para reiniciar o toast
                            toastEl.classList.remove('show');
                            const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
                            document.getElementById('toastMessage').innerText =
                                'Produto atualizado com sucesso!';
                            toast.show();
                        } else {
                            console.warn("Elemento 'toastSuccess' não encontrado!");
                        }


                    } else {
                        alert("Erro ao atualizar produto!");
                    }
                })
                .catch(error => console.error("Erro:", error));
        });
    </script>


</body>

</html>
