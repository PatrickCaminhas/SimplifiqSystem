@php
    $data_tables = true;
@endphp
@extends('layouts.lista')
@section('titulo', content: 'Cotação de produtos')

@section('lista')

    @if ($checagem != 'true')
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Atenção!</h4>
            @if ($checagem == 'produtos')
                <p>Para realizar uma cotação é necessário ter produtos cadastrados no sistema.</p>
            @elseif($checagem == 'fornecedores')
                <p>Para realizar uma cotação é necessário ter fornecedores cadastrados no sistema.</p>
            @else
                <p>Para realizar uma cotação é necessário ter produtos e fornecedores cadastrados no
                    sistema.</p>
            @endif
        </div>
    @else

        <form method="POST" action="{{ route('cotacao.produtos.selecionados') }}">
            @csrf
          <h5 class="text-center">Selecione todos os produtos que deseje comparar preços</h5>
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th scope="col">Estoque</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Selecione</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>
                                <span>{{ $produto->quantidade }}</span>
                            </td>
                            <td>
                                <span>{{ $produto->nome }} {{ $produto->modelo }}
                                    {{ $produto->marca }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">

                                    <input type="checkbox" class="btn-check" name="produtos[]"
                                        id="btncheck{{ $produto->id }}" value="{{ $produto->id }}" autocomplete="off">
                                    <label class="btn @include('partials.buttomOutlineCollor')"
                                        for="btncheck{{ $produto->id }}">Cotar</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center mt-2 mb-4">
                <button type="submit" class="btn @include('partials.buttomCollor') text-center"><i class="bi bi-arrow-right"></i> Prossiga</button>
                <button type="reset" class="btn @include('partials.buttomCollor') text-center"><i class="bi bi-eraser-fill"></i> Limpar</button>
            </div>
        </form>
<button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalDuvidaCotacao">
                            O que é uma cotação de produtos?
                        </button>

                        <div class="modal fade" id="modalDuvidaCotacao" tabindex="-1"
                            aria-labelledby="modalDuvidaCotacaoLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditarProdutoLabel">O que é uma cotação de produtos?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <p>Uma cotação de produtos é o processo de pesquisar e comparar preços
                                        de um mesmo item por diferentes fornecedores.</p>
                                      <p>No sistema Simplifiq, deixamos este processo mais rápido e simples,
                                        basta apenas você selecionar dentre os produtos cadastrados aqueles que queira
                                        comparar clicando no botão "Cotar" e avançando, na proxima pagina coloque coloque os preços
                                        de cada fornecedor, podendo deixar em branco se o fornecedor não vender o produto.
                                      </p>
                                      <p>Por fim na pagina dos resultados você pode decidir baixar a cotação em formato PDF ou imprimir antes de voltar ao sistema.
                                      </p>
                                    </div>
                                </div>
                            </div>
                        </div>
    @endif

@endsection
@push('scripts')
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
                order: [
                    [0, 'desc']
                ],
                lengthMenu: [
                    [-1],
                    ["Todos"]
                ], // Define opção "Todos"
                pageLength: -1, // Exibe todas as linhas
              	 "paging": false,       // Remove a paginação
        "lengthChange": false, // Remove a opção de alterar o número de registros por página
        "info": false          // (Opcional) Remove o texto de informações sobre registros

            });
        });
    </script>
@endpush
