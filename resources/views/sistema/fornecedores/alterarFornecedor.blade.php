@extends('layouts.cadastro')
@section('titulo', 'Alterar dados de fornecedor')
@section('formulario')
@section('route', route('fornecedores.edit.store'))

                                <input type="hidden" name="id" value="{{ $fornecedor->id }}">
                                <div class="form-group">
                                    <label for="nomefornecedor">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $fornecedor->nome) }}"
                                        placeholder="Digite o nome do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="cnpjornecedor">CNPJ</label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ old('nome', $fornecedor->CNPJ) }}"
                                        placeholder="Digite o CNPJ do fornecdor">
                                </div>
                                <div class="form-group">
                                    <label for="enderecofornecedor">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" value="{{ old('nome', $fornecedor->endereco) }}"
                                        placeholder="Digite o endereço do fornecdor">
                                </div>
                                <div class="form-group">
                                    <label for="cidadefornecedor">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('nome', $fornecedor->cidade) }}"
                                        placeholder="Digite a cidade do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="estadofornecedor">Estado</label>
                                        <select class="form-control" id="estado" name="estado"  value="{{ old('nome', $fornecedor->estado) }}">
                                            <option selected disabled>Selecione o estado</option>
                                            @include('partials.estadosBrasil')
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="representantefornecedor">Representante</label>
                                    <input type="text" class="form-control" id="nome_representante" name="nome_representante"  value="{{ old('nome', $fornecedor->nome_representante) }}"
                                        placeholder="Digite o nome do representante do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="emailfornecedor">E-mail</label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('nome', $fornecedor->email) }}"
                                        placeholder="Digite o e-mail do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="telefonefornecedor">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('nome', $fornecedor->telefone) }}"
                                        placeholder="Digite o telefone do fornecedor">
                                </div>
                                <div class= "text-center mt-1">
                                    <button type="submit" class="btn @include('partials.buttomCollor') text-center">Cadastrar</button>
                                    <button type="reset" class="btn @include('partials.buttomCollor') text-center">Limpar</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
