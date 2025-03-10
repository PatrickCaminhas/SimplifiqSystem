@extends('layouts.lista')
@section('titulo', 'Fornecedores')
@section('lista')
    <p><a class="btn @include('partials.buttomCollor')" href="{{ route('fornecedor.store') }}"><i class="bi bi-plus-circle-fill"></i> Cadastrar forenecedor</a>
    </p>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CNPJ</th>
                <th>Telefone</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fornecedores as $fornecedor)
                <tr>
                    <td style="overflow-x: auto;">{{ $fornecedor->id }}</td>
                    <td>{{ $fornecedor->nome }}</td>
                    <td>{{ $fornecedor->CNPJ }}</td>
                    <td>{{ $fornecedor->telefone }}</td>
                    <td>
                        <button type="button" class="btn @include('partials.buttomCollor') text-light" data-bs-toggle="modal"
                            data-bs-target="#fornecedor{{ $fornecedor->id }}" data-produto-id="{{ $fornecedor->id }}">
                            <i class="bi bi-search"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="fornecedor{{ $fornecedor->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                            Fornecedor #{{ $fornecedor->id }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-secondary-subtle">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="exampleFormControlInput1" class="form-label">Nome:</label>
                                                <a>{{ $fornecedor->nome }}</a>
                                            </div>
                                            <div class="col-12">
                                                <label for="exampleFormControlInput1" class="form-label">Cnpj:</label>
                                                <a>{{ $fornecedor->CNPJ }}</a>
                                            </div>
                                            <div class="col-12">
                                                <label for="exampleFormControlInput1"
                                                    class="form-label">Representante:</label>
                                                <a>{{ $fornecedor->nome_representante }}</a>
                                            </div>
                                            <div class="col-12">
                                                <p for="exampleFormControlInput1" class="form-label">Endereço:
                                                    <a>{{ $fornecedor->endereco . ' - ' . $fornecedor->cidade . '/' . $fornecedor->estado }}</a>
                                                </p>
                                            </div>
                                            <div class="col-12 d-flex justify-content-center fw-semibold">
                                                <a>Contatos</a>
                                            </div>
                                            <div class="col-6">
                                                <p for="exampleFormControlInput1" class="form-label">Telefone:
                                                    <a>{{ $fornecedor->telefone }}</a>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p for="exampleFormControlInput1" class="form-label">E-mail:
                                                    <a>{{ $fornecedor->email }}</a>
                                                </p>
                                            </div>




                                        </div>
                                        <div class="col-12">
                                            <h5 class="mt-3">Produtos Mais Cotados</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Produto</th>
                                                        <th>Total Cotado</th>
                                                        <th>Preço Mínimo</th>
                                                        <th>Preço Máximo</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="produtosTabela{{ $fornecedor->id }}">
                                                    <tr>
                                                        <td colspan="4">Carregando...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <form method="POST" action="{{ route('fornecedores.edit') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $fornecedor->id }}">
                                            <button type="submit" class="btn @include('partials.buttomCollor')">
                                                Alterar</button>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@push('scripts')
    <script>
        function setActionAndSubmit(acao) {
            document.getElementById('acao').value = acao;
            document.getElementById('form-estoque').submit(); // Força o envio do formulário após setar a ação
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
            });
        });
    </script>
    <script>
    $(document).ready(function() {
        $('button[data-bs-toggle="modal"]').click(function() {
            let fornecedorId = $(this).data('produto-id');
            let tabelaBody = $('#produtosTabela' + fornecedorId);

            // Limpa a tabela e exibe "Carregando..."
            tabelaBody.html('<tr><td colspan="4">Carregando...</td></tr>');

            $.ajax({
                url: `/api/produtos-mais-cotados/${fornecedorId}`,
                type: 'GET',
                success: function(response) {
                    if (response.error) {
                        tabelaBody.html('<tr><td colspan="4">Erro ao carregar os produtos.</td></tr>');
                        return;
                    }

                    tabelaBody.empty(); // Limpa a tabela

                    if (response.produtos.length > 0) {
                        response.produtos.forEach(produto => {
                            tabelaBody.append(`
                                <tr>
                                    <td>${produto.produto_nome}</td>
                                    <td>${produto.total_cotado}</td>
                                    <td>R$ ${produto.preco_min}</td>
                                    <td>R$ ${produto.preco_max}</td>
                                </tr>
                            `);
                        });
                    } else {
                        tabelaBody.html('<tr><td colspan="4">Nenhum produto encontrado.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                    tabelaBody.html('<tr><td colspan="4">Erro ao buscar os produtos.</td></tr>');
                }
            });
        });
    });
    </script>
@endpush
