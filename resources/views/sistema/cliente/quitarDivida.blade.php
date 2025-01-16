<!DOCTYPE html>
<html lang="pt-br">


@include('partials.head', ['jquery' => true])


<body class="bg-dark">
    <!-- Menu superior -->
    @include('partials.header')
    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container mt-5 col-lg-6 col-md-8 col-sm-12 col-12">
            <div class="row align-items-center justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="card-body">
                                    <div class="container">
                                        <h2>Quitar divida</h2>
                                        <form action="{{ route('cliente.quitar') }}" method="POST" id="form-clientes">
                                            @csrf
                                            <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
                                            <div class="form-group">
                                                <label for="cliente">Nome do cliente: {{$cliente->nome}}</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="cpfOuCnpj">CPF/CNPJ: {{$cliente->cpfOuCnpj}}</label>
                                            </div>

                                            <div class="form-group">
                                                <label for="debito">Débito: {{$cliente->debitos}}</label>
                                            </div>
                                            <div class="form-group">
                                                <p for="tipo_quitacao">Tipo de quitação: </p>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tipo_quitacao" id="quitacao_total" value="quitacao_total">
                                                    <label class="form-check-label" for="quitacao_total">
                                                        Quitação total
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tipo_quitacao" id="quitacao_parcial" value="quitacao_parcial" checked>
                                                    <label class="form-check-label" for="quitacao_parcial">
                                                        Quitação parcial
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Input de valor será inserido dinamicamente aqui -->
                                            <div class="form-group mt-3" id="input-container">
                                            </div>

                                            <button type="submit" class="btn btn-primary mt-3">Quitar</button>
                                        </form>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-3">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap e jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('input[name="tipo_quitacao"]').on('change', function() {
                var selectedValue = $(this).val();
                var inputContainer = $('#input-container');

                inputContainer.empty(); // Limpa o container para evitar inputs duplicados

                if (selectedValue === 'quitacao_parcial') {
                    // Se quitação parcial, exibe o input de valor
                    inputContainer.append('<label for="valor_quitacao">Valor da quitação:</label>' +
                        '<input type="number" name="valor_quitacao" id="valor_quitacao" class="form-control" placeholder="Informe o valor">');
                } else if (selectedValue === 'quitacao_total') {
                    // Se quitação total, adiciona um input hidden com o valor do débito
                    inputContainer.append('<input type="hidden" name="valor_quitacao" id="valor_quitacao" value="{{$cliente->debitos}}">');
                }
            });
        });
    </script>
</body>

</html>
