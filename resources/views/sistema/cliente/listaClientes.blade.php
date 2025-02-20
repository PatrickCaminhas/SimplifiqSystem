@extends('layouts.lista')
@section('titulo', 'Clientes')
@section('lista')
    <p> <a class="btn @include('partials.buttomCollor')" href="{{ route('cliente.store.create') }}"><i
                class="bi bi-plus-circle-fill"></i> Cadastrar cliente</a></p>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Tipo de pessoa</th>
                <th hidden>Débito</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td style="overflow-x: auto;">{{ $cliente->id }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>
                        @if (strlen($cliente->cpfOuCnpj) == 14)
                            CPF
                        @else
                            CNPJ
                        @endif
                    </td>
                    <td hidden>
                        @if ($cliente->debitos == null || $cliente->debitos == '0' || $cliente->debitos == '0.00')
                            Não possui débitos!
                        @else
                            fiado - crediario - crédito - prazo - pendencias
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn @include('partials.buttomCollor') text-light" data-bs-toggle="modal"
                            data-bs-target="#cliente{{ $cliente->id }}" data-cliente-id="{{ $cliente->id }}">
                            <i class="bi bi-search"></i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="cliente{{ $cliente->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                            cliente #{{ $cliente->id }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-secondary-subtle">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="exampleFormControlInput1" class="form-label">Nome
                                                    completo:</label>
                                                <a>{{ $cliente->nome }}</a>
                                            </div>

                                            <div class="col-6">
                                                <p for="exampleFormControlInput1" class="form-label">
                                                    @if (strlen($cliente->cpfOuCnpj) == 11)
                                                        CPF:
                                                    @else
                                                        CNPJ:
                                                        </a>
                                                    @endif
                                                    <a>{{ $cliente->cpfOuCnpj }}
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p for="exampleFormControlInput1" class="form-label">Telefone:
                                                    <a>{{ $cliente->telefone }}</a>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p for="exampleFormControlInput1" class="form-label">E-mail:
                                                    <a>
                                                        @if ($cliente->email)
                                                            {{ $cliente->email }}
                                                        @elseif($cliente->email == null || $cliente->email == '' || $cliente->email == '-')
                                                            Não informado
                                                        @endif
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p for="exampleFormControlInput1" class="form-label">Pendências:
                                                    <a>
                                                        @if ($cliente->debitos == null || $cliente->debitos == '0' || $cliente->debitos == '0.00')
                                                            Não possui.
                                                        @else
                                                            R${{ $cliente->debitos }}
                                                        @endif
                                                    </a>
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <p for="exampleFormControlInput1" class="form-label">Observações:
                                                    <a>{{ $cliente->observacoes }}</a>
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <h5>Produtos Mais Comprados</h5>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Produto</th>
                                                            <th>Total Comprado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="produtosTabela{{ $cliente->id }}">
                                                        <tr>
                                                            <td colspan="2">Carregando...</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="POST" action="{{ route('cliente.edit') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $cliente->id }}">
                                            <button type="submit" class="btn @include('partials.buttomCollor')">
                                                Alterar</button>
                                        </form>
                                        @if ($cliente->debitos > 0)
                                            <form method="POST" action="{{ route('cliente.quitar.view') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $cliente->id }}">
                                                <button type="submit" class="btn @include('partials.buttomCollor')">
                                                    Quitar divida</button>
                                            </form>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="fs-6 fw-lighter">Para ver todos os clientes em crediário procure por: crediario ou pendencias</p>
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
            $('.modal').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget); // Botão que acionou o modal
                let clienteId = button.data('cliente-id'); // Pegamos o ID do cliente

                console.log("Cliente ID:", clienteId); // Para testar se pegou certo

                $.ajax({
                    url: `/api/produtos-mais-comprados/${clienteId}`,
                    type: 'GET',
                    success: function(data) {
                        console.log("Dados recebidos:", data);

                        let tbody = $('#produtosTabela' + clienteId);
                        tbody.empty();

                        if (data.length > 0) {
                            data.forEach(produto => {
                                tbody.append(
                                    `<tr><td>${produto.produto.nome} ${produto.produto.modelo} ${produto.produto.marca}</td><td>${produto.total_comprado}</td></tr>`
                                );
                            });
                        } else {
                            tbody.append(
                                '<tr><td colspan="2">Nenhum produto encontrado</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro na requisição:', error);
                        alert('Erro ao buscar os produtos mais comprados.');
                    }
                });
            });
        });
    </script>
@endpush
