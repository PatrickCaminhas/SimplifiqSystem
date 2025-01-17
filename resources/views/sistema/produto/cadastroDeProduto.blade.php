@extends('layouts.cadastro')
@section('titulo', 'Cadastro de Produto')
@section('formulario')
@section('route', route('cadastroproduto.store'))
<div class="form-group">
    <label for="nomeproduto">Nome</label>
    <input type="text" class="form-control" id="nomeproduto" name="nome" placeholder="Digite o nome do produto"
        required>
</div>
<div class="form-group">
    <label for="modeloproduto">Modelo</label>
    <input type="text" class="form-control" id="modeloproduto" name="modelo"
        placeholder="Digite o modelo do produto">
</div>
<div class="form-group">
    <label for="marcaproduto">Marca</label>
    <input type="text" class="form-control" id="marcaproduto" name="marca"
        placeholder="Digite o nome da marca do produto">
</div>
<div class="form-group">
    <label for="categoriaproduto">Categoria</label>
    @if ($categorias->count() == 1)
        <input type="hidden" name="categoria" value="{{ $categorias[0]->nome }}">
        <label class="fst-italic">[Nenhuma categoria cadastrada]</label>
        <div id="emailHelp" class="form-text">Irá cadastrar o produto como
            "Sem categoria".</div>
    @else
        <select class="form-control" id="categoria" name="categoria">
            <option selected disabled>Selecione a categoria do produto
            </option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nome }}
                </option>
            @endforeach

        </select>

    @endif
    <label>Precisa de uma nova categoria?  <a type="submit"
        class="btn @include('partials.buttomCollor') text-center"
        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
        href="{{ route('produto.categoria') }}">Clique aqui</a></label>



</div>
<div class="form-group">
    <label for="unidadeproduto">Unidade de medida</label>
    <select class="form-control" id="unidadeproduto" name="unidade_medida">
        <option selected disabled>Selecione a unidade de medida do produto
        </option>
        <option value="peso">Peso (Kg)</option>
        <option value="volume">Volume (Litros)</option>
        <option value="energia">Energia (Watt)</option>
        <option value="comprimento">Comprimento (Metros)</option>
        <option value="area_quadrado">Área (Metros quadrados)</option>
        <option value="area_cubico">Área (Metros cubicos)</option>
        <option value="unidade">Unidade</option>

    </select>
</div>
<div class="form-group">
    <label for="medidaproduto">Medida</label>
    <input type="text" class="form-control" id="medidaproduto" name="medida" min='1'
        placeholder="Digite a medida do produto">
</div>
<div class="form-group">
    <label for="descricao">Descrição</label>
    <textarea class="form-control" id="descricao" name="descricao" rows="3" style="resize: none;"
        placeholder="Digite a descrição do produto"></textarea>
</div>
<div class="text-center mt-1">
    <button type="submit" class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
    <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
</div>
@endsection
