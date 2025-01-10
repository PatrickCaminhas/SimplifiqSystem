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
                            <h2 class="text-center">Alterar dados do produto</h2>
                            @include('partials.errorAndSuccess')
                            <form method="POST" action="{{ route('produto.edit.store') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $produto->id }}">
                                <div class="form-group">
                                    <label for="nomeproduto">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                        placeholder="{{ $produto->nome }}" value="{{ old('nome', $produto->nome) }}"
                                        required>
                                    <div class="form-group">
                                        <label for="modeloproduto">Modelo</label>
                                        <input type="text" class="form-control" id="modeloproduto" name="modelo"
                                            placeholder="{{ $produto->modelo }}"
                                            value="{{ old('nome', $produto->modelo) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="marcaproduto">Marca</label>
                                        <input type="text" class="form-control" id="marcaproduto" name="marca"
                                            placeholder="{{ $produto->marca }}"
                                            value="{{ old('nome', $produto->marca) }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="categoriaproduto">Categoria</label>
                                        @if ($categorias->count() == 1)
                                            <input type="hidden" name="categoria" value="{{ $categorias[0]->nome }}">
                                            <label class="fst-italic">[Nenhuma categoria cadastrada]</label>
                                            <div id="emailHelp" class="form-text">Irá cadastrar o produto como "Sem
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
                                                        <option value="{{ $categoria->id }}">{{ $categoria->nome }}
                                                        </option>

                                                        }
                                                    @endif
                                                @endforeach

                                            </select>

                                        @endif
                                        <label>Para cadastrar uma nova categoria clique aqui: <a type="submit"
                                                class="btn @include('partials.buttomCollor') text-center"
                                                style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
                                                href="#">Cadastrar categoria</a></label>

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

                                        <select class="form-control" id="unidadeproduto" name="unidade_medida" required>
                                            <option selected disabled>Selecione a unidade de medida do produto</option>
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
                                        <input type="text" class="form-control" id="medidaproduto" name="medida"
                                            min='1' placeholder="{{ $produto->medida }}"
                                            value="{{ old('nome', $produto->medida) }}" required>
                                    </div>
                                    <div class=" form-group">
                                        <label for="precocompraproduto">Preço de compra</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                            <input type="number" class="form-control" id="precocompraproduto"
                                                name="preco_compra" min='1'
                                                placeholder="{{ $produto->preco_compra }}"
                                                value="{{ old('nome', $produto->preco_compra) }}" step="0.01"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="descricao">Descrição</label>
                                        <textarea class="form-control" id="descricao" name="descricao" rows="3" style="resize: none;"
                                            placeholder="{{ $produto->descricao }}" value="{{ old('nome', $produto->descricao) }}">{{ $produto->descricao }}</textarea>
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
</body>

</html>
