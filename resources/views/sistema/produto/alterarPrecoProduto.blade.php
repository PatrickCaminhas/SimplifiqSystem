@extends('layouts.cadastro')
@section('titulo', 'Cadastro de Produto')
@section('formulario')
@section('route', route('produto.preco.store'))

    <input type="hidden" name="id" value="{{ $produto->id }}">
    <div class=" form-group">
        <label for="descontomaximoproduto">Produto:
            {{ $produto->nome . ' ' . $produto->modelo . ' / ' . $produto->marca }}</label>
    </div>
    <div class=" form-group">
        <label for="precovendaproduto">Preço de venda<label class="text-danger">*</label></label>
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1">R$</span>
            <input type="number" class="form-control" id="precovendaproduto" name="preco_venda"
                min='{{ $produto->preco_compra }}' placeholder="{{ $produto->preco_venda }}"
                value="{{ old('preco_venda', $produto->preco_venda) }}" step="0.01" required>
        </div>
    </div>
    <div class=" form-group">
        <label for="descontomaximoproduto">Desconto máximo</label>
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1">R$</span>
            <input type="number" class="form-control" id="descontomaximoproduto" name="desconto_maximo"
                min='{{ $produto->preco_compra }}' placeholder="{{ $produto->desconto_maximo }}" step="0.01">
        </div>
    </div>
    <div class="text-center mt-1">
        <button type="submit" class="btn @include('partials.buttomCollor') text-center">Alterar</button>
        <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
    </div>


    @endsection
    @push('scripts')
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

@endpush
