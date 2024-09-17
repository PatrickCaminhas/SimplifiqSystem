<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Simplifiq</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>

<body class=bg-dark>
    <!-- Menu superior -->
    @include('partials.header')













    <div class="d-flex align-items-center justify-content-center " style="height: 92vh;">
        <div class="container mt-5 col-lg-6 col-md-8 col-sm-12 col-12 ">
            <div class="row align-items-center justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="card-body ">
                                    <div class="container">
                                        <h2>Registrar Faturamento</h2>
                                        <form action="{{ route('faturamento.store') }}" method="POST"
                                            id="form-faturamento">
                                            @csrf
                                            <!-- Select Cliente -->
                                            <div class="form-group">
                                                <p>Faturamento ou renda bruta é valor total recebido de venda e/ou
                                                    serviços. </p>
                                            </div>

                                            <div class="form-group">
                                                <label for="mes">Mês:</label>
                                                <select name="mes" id="mes" class="form-control" required>
                                                    <option selected disabled>Selecione o mês do faturamento</option>
                                                    <option value="01">Janeiro</option>
                                                    <option value="02">Fevereiro</option>
                                                    <option value="03">Março</option>
                                                    <option value="04">Abril</option>
                                                    <option value="05">Maio</option>
                                                    <option value="06">Junho</option>
                                                    <option value="07">Julho</option>
                                                    <option value="08">Agosto</option>
                                                    <option value="09">Setembro</option>
                                                    <option value="10">Outubro</option>
                                                    <option value="11">Novembro</option>
                                                    <option value="12">Dezembro</option>
                                                </select>
                                            </div>

                                            <!-- Input para buscar Produto -->
                                            <div class="form-group">
                                                <label for="ano">Ano:</label>
                                                <input type="number" id="ano" name="ano" class="form-control"
                                                    maxlength="4" min="2000" max="{{ date('Y') }}"
                                                    pattern="[0-9]{4}" placeholder="Digite o ano do faturamento"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="valor">Valor:</label>
                                                <input type="number" id="valor" name="valor" class="form-control"
                                                    step="0.01" min="0.01"
                                                    placeholder="Digite o valor do faturamento" required>
                                            </div>

                                            <!-- Botão de Registrar Venda -->
                                            <button type="submit" class="btn btn-primary mt-3">Registrar
                                                faturamento</button>
                                        </form>
                                        @if ($errors->any())
                                            <div class="alert alert-danger mt-3">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @elseif(session('error'))
                                            <div class="alert alert-danger mt-3">
                                                <a>{{ session('error') }}</a>
                                            </div>
                                        @elseif(session('success'))
                                            <div class="alert alert-success mt-3">
                                                <a>{{ session('success') }}</a>
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
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        const input = document.getElementById('ano');

        input.addEventListener('input', (event) => {
            event.target.value = event.target.value.slice(0, 4);
        });

        input.addEventListener('keypress', (event) => {
            // Permite apenas números
            if (event.key < '0' || event.key > '9') {
                event.preventDefault();
            }
        });
    </script>
    <script>
        function formatNumber(valor) {
            // Remove todos os caracteres que não sejam números ou o ponto decimal
            let value = input.value.replace(/[^0-9.]/g, '');

            // Permite no máximo um ponto decimal
            value = value.replace(/\./g, '.', 1);

            // Limita para duas casas decimais
            value = value.toFixed(2);

            // Atualiza o valor do input
            input.value = value;
        }
    </script>

</body>

</html>
