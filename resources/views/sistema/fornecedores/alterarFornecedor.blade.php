@extends('layouts.cadastro')
@section('titulo', 'Alterar dados de fornecedor')
@section('formulario')
@section('route', route('fornecedores.edit.store'))

                                <input type="hidden" name="id" value="{{ $fornecedor->id }}">
                                <div class="form-group">
                                    <label for="nomefornecedor">Nome
                                        @include('partials.campoObrigatorio')
                                    </label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome', $fornecedor->nome) }}"
                                        placeholder="Digite o nome do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="cnpjornecedor">CNPJ
                                        @include('partials.campoObrigatorio')
                                    </label>
                                    <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ old('nome', $fornecedor->CNPJ) }}"
                                        placeholder="Digite o CNPJ do fornecdor">
                                </div>
                                <div class="form-group">
                                    <label for="enderecofornecedor">Endereço
                                        @include('partials.campoObrigatorio')
                                    </label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" value="{{ old('nome', $fornecedor->endereco) }}"
                                        placeholder="Digite o endereço do fornecdor">
                                </div>
                                <div class="form-group">
                                    <label for="cidadefornecedor">Cidade
                                        @include('partials.campoObrigatorio')</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('nome', $fornecedor->cidade) }}"
                                        placeholder="Digite a cidade do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="estadofornecedor">Estado
                                        @include('partials.campoObrigatorio')
                                    </label>
                                        <select class="form-control" id="estado" name="estado"  value="{{ old('nome', $fornecedor->estado) }}">
                                            <option selected disabled>Selecione o estado</option>
                                            @include('partials.estadosBrasil')
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="representantefornecedor">Representante
                                        @include('partials.campoObrigatorio')
                                    </label>
                                    <input type="text" class="form-control" id="nome_representante" name="nome_representante"  value="{{ old('nome', $fornecedor->nome_representante) }}"
                                        placeholder="Digite o nome do representante do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="emailfornecedor">E-mail
                                        @include('partials.campoObrigatorio')
                                    </label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('nome', $fornecedor->email) }}"
                                        placeholder="Digite o e-mail do fornecedor">
                                </div>
                                <div class="form-group">
                                    <label for="telefonefornecedor">Telefone
                                        @include('partials.campoObrigatorio')
                                    </label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('nome', $fornecedor->telefone) }}"
                                        placeholder="Digite o telefone do fornecedor" maxlength="15">
                                </div>
                                <div class= "text-center mt-1">
                                    <button type="submit" class="btn @include('partials.buttomCollor') text-center">Alterar</button>
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
@push('scripts')
<script>
    // Função para formatar o CNPJ enquanto o usuário digita
    function formatarCNPJ() {
        let input = document.getElementById('cnpj');
        let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        let formattedValue = '';

        if (value.length > 0) {
            formattedValue = value.substring(0, 2); // Adiciona os dois primeiros dígitos

            if (value.length > 2) {
                formattedValue += '.' + value.substring(2, 5); // Adiciona o ponto e os três próximos dígitos
            }

            if (value.length > 5) {
                formattedValue += '.' + value.substring(5, 8); // Adiciona o ponto e os três próximos dígitos
            }

            if (value.length > 8) {
                formattedValue += '/' + value.substring(8, 12); // Adiciona a barra e os quatro próximos dígitos
            }

            if (value.length > 12) {
                formattedValue += '-' + value.substring(12, 14); // Adiciona o hífen e os dois últimos dígitos
            }
        }

        input.value = formattedValue;
    }

    // Adiciona o evento de input para chamar a função de formatação quando o usuário digitar no campo
    document.getElementById('cnpj').addEventListener('input', formatarCNPJ);
</script>
<script>
    function formatarTelefone() {
        let input = document.getElementById('telefone');
        let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        let formattedValue = '';

        if (value.length > 2) {
            formattedValue = '(' + value.substring(0, 2) + ') ';
        } else {
            formattedValue = value;
        }

        if (value.length === 10) { // Telefone fixo (8 dígitos + DDD)
            formattedValue += value.substring(2, 6) + '-' + value.substring(6, 10);
        } else if (value.length === 11) { // Celular (9 dígitos + DDD)
            formattedValue += value.substring(2, 7) + '-' + value.substring(7, 11);
        } else {
            formattedValue += value.substring(2);
        }

        input.value = formattedValue;
    }

    // Adiciona o evento de input para chamar a função de formatação quando o usuário digitar no campo
    document.getElementById('telefone').addEventListener('input', formatarTelefone);


    </script>
@endpush
