@extends('layouts.cadastro')
@section('titulo', 'Alterar dados de Produto')
@section('formulario')
@section('route', route('produto.edit.store'))

<input type="hidden" name="id" value="{{ $produto->id }}">

<label for="nomeproduto">Nome</label>
<input type="text" class="form-control" id="nome" name="nome" placeholder="{{ $produto->nome }}"
    value="{{ old('nome', $produto->nome) }}" required>
<div class="form-group">
    <label for="modeloproduto">Modelo</label>
    <input type="text" class="form-control" id="modeloproduto" name="modelo" placeholder="{{ $produto->modelo }}"
        value="{{ old('nome', $produto->modelo) }}" required>
</div>
<div class="form-group">
    <label for="marcaproduto">Marca</label>
    <input type="text" class="form-control" id="marcaproduto" name="marca" placeholder="{{ $produto->marca }}"
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
        <select class="form-control" id="categoriaproduto" name="categoria" required>
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
    <label>Precisa de uma nova categoria? <a type="submit" class="btn @include('partials.buttomCollor') text-center"
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

    <select class="form-control" id="unidadeproduto" name="unidade_medida" required>
        <option selected disabled>Selecione a unidade de medida do produto</option>
        @foreach ($unidadesMedida as $value => $label)
            <option value="{{ $value }}" {{ $produto->unidade_medida == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>

</div>
<div class="form-group">
    <label for="medidaproduto">Medida</label>
    <input type="text" class="form-control" id="medidaproduto" name="medida" min='1'
        placeholder="{{ $produto->medida }}" value="{{ old('nome', $produto->medida) }}" required>
</div>
<div class=" form-group">
    <label for="precocompraproduto">Preço de compra</label>
    <div class="input-group">
        <span class="input-group-text" id="basic-addon1">R$</span>
        <input type="number" class="form-control" id="precocompraproduto" name="preco_compra" min='1'
            placeholder="{{ $produto->preco_compra }}" value="{{ old('nome', $produto->preco_compra) }}"
            step="0.01" required>
    </div>
</div>
<div class="form-group">
    <label for="descricao">Descrição</label>
    <textarea class="form-control" id="descricao" name="descricao" rows="3" style="resize: none;"
        placeholder="{{ $produto->descricao }}" value="{{ old('nome', $produto->descricao) }}">{{ $produto->descricao }}</textarea>
</div>
<div class="text-center mt-1">
    <button type="submit" class="btn @include('partials.buttomCollor') text-center">Alterar</button>
    <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
</div>

@endsection
