<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Simplifiq</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json">
</head>

<body class="bg-black bg-gradient">
    <!-- Menu superior -->
    @include('partials.header')

    <!-- Offcanvas para o menu -->
    @include('partials.menu')

    <!-- Offcanvas para notificações -->
    @include('partials.notificacoes')

    <div class="d-flex align-items-center justify-content-center " style="height: 92vh;">
        <div class="container mt-5 col-md-4 ">
            <div class="row align-items-center justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="card-body ">
                                    <h2 class="text-center">Cadastro de Serviço</h2>
                                    <div>
                                        <form action="{{ route('servicos.store') }}" method="POST">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="nome" id="nome"
                                                    placeholder="" required>
                                                <label>Serviço:</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="nome_cliente"
                                                    id="nome_cliente" placeholder="" required>
                                                <label>Nome do cliente:</label>
                                            </div>
                                            <label for="tipo_cliente">Tipo de cliente:</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="tipo_cliente"
                                                    id="tipo_cliente_CPF" value="CPF">
                                                <label class="form-check-label" for="CPF">CPF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="tipo_cliente"
                                                    id="tipo_cliente_CNPJ" value="CNPJ">
                                                <label class="form-check-label" for="CNPJ">CNPJ</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="identificacao_cliente"
                                                    id="identificacao_cliente" placeholder="Somente números" disabled
                                                    required>
                                                <label>CPF/CNPJ:</label>
                                                <div id="identificadorHelp" class="form-text">Use somente números.</div>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <select class="form-select" id="tipo_servico"
                                                    aria-label="Floating label select example">
                                                    <option selected disabled>Selecione o tipo de serviço</option>
                                                    @foreach ($tipos_servico as $tipo_servico)
                                                        <option value="{{ $tipo_servico->id }}"
                                                            data-valor="{{ $tipo_servico->valor_diario }}"
                                                            data-duracao="{{ $tipo_servico->duracao }}">
                                                            {{ $tipo_servico->nome }}</option>
                                                    @endforeach
                                                </select>
                                                <label>Tipo de serviço:</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" name="data_inicio"
                                                    id="data_inicio" min="{{ now()->format('Y-m-d') }}" required>
                                                <label>Data de início:</label>
                                            </div>

                                            <label for="tipo_prestacao_servico">Tipo de prestação de serviço:</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="tipo_prestacao_servico" id="tipo_prestacao_servico_dias"
                                                    value="Dias">
                                                <label class="form-check-label" for="Dias">Dias</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="tipo_prestacao_servico" id="tipo_prestacao_servico_horas"
                                                    value="Horas">
                                                <label class="form-check-label" for="Horas">Horas</label>
                                            </div>

                                            <!-- Campos Dinâmicos -->
                                            <div id="campo_dias_servico" class="form-floating mb-3 d-none">
                                                <input type="number" class="form-control" name="dias_servico"
                                                    id="dias_servico"
                                                    placeholder="Informe a quantidade de dias para o serviço">
                                                <label>Dias de serviço:</label>
                                            </div>

                                            <div id="campo_horas_servico" class="row d-none">
                                                <label for="mediaTempo">Tempo para esse tipo de serviço: <span
                                                    id="duracao_servico"></span> minutos</label>

                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="number" class="form-control" name="horas"
                                                            id="horas" placeholder="Quantidade de horas">
                                                        <label>Horas:</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="number" class="form-control" name="minutos"
                                                            id="minutos" placeholder="Quantidade de minutos">
                                                        <label>Minutos:</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <p><label for="valor">Valor: <span
                                                            id="valor_servico"></span></label>
                                                </p>
                                                <input type="hidden" name="valor" id="valor">
                                            </div>

                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="Descrição do serviço" id="descricao" name="descricao"></textarea>
                                                <label for="descricao">Descrição:</label>
                                            </div>
                                            <div class="text-center mt-3">
                                                <button type="submit" class="btn @include('partials.buttomCollor')">Cadastrar</button>
                                            </div>
                                        </form>

                                        @if ($errors->any())
                                            <div class="alert alert-danger mt-3">
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}
                                                @endforeach
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

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Mostrar campos dinâmicos com base na seleção do tipo de prestação de serviço
            $('input[name="tipo_prestacao_servico"]').change(function() {
                if ($(this).val() === 'Dias') {
                    $('#campo_dias_servico').removeClass('d-none');
                    $('#campo_horas_servico').addClass('d-none');
                } else if ($(this).val() === 'Horas') {
                    $('#campo_horas_servico').removeClass('d-none');
                    $('#campo_dias_servico').addClass('d-none');
                }
                calcularValor(); // Recalcular valor ao mudar o tipo de prestação de serviço
            });

            // Limitar valores de horas e minutos
            $('#horas').attr({
                'min': 0,
                'max': 8
            });
            $('#minutos').attr({
                'min': 0,
                'max': 59
            });

            // Recalcular valor ao mudar o tipo de serviço ou quantidade de dias/horas/minutos
            $('#tipo_servico, #dias_servico, #horas, #minutos').change(calcularValor);
            $('#data_inicio').change(calcularValor);

            function calcularValor() {
                var tipoServicoSelect = document.getElementById('tipo_servico');
                var selectedOption = tipoServicoSelect.options[tipoServicoSelect.selectedIndex];
                var valorDiario = parseFloat(selectedOption.getAttribute('data-valor'));
                var duracaoDiario = parseFloat(selectedOption.getAttribute('data-duracao'));

                var tipoPrestacao = $('input[name="tipo_prestacao_servico"]:checked').val();
                var valorTotal = 0;


                if (tipoPrestacao === 'Dias') {
                    var dias = parseInt(document.getElementById('dias_servico').value);
                    if (dias > 0) {
                        valorTotal = valorDiario * dias;
                    }
                } else if (tipoPrestacao === 'Horas') {
                    document.getElementById('duracao_servico').textContent = parseInt(duracaoDiario);

                    var horas = parseInt(document.getElementById('horas').value);
                    var minutos = parseInt(document.getElementById('minutos').value);
                    if (horas >= 0 && minutos >= 0) {
                        var valorPorMinuto = valorDiario / duracaoDiario;
                        var tempoTotalMinutos = (horas * 60) + minutos;
                        valorTotal = valorPorMinuto * tempoTotalMinutos;
                    }
                }

                document.getElementById('valor_servico').textContent = 'R$ ' + valorTotal.toFixed(2);
                document.getElementById('valor').value = valorTotal.toFixed(2);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const identificacaoCliente = document.getElementById('identificacao_cliente');
            const radioCPF = document.getElementById('tipo_cliente_CPF');
            const radioCNPJ = document.getElementById('tipo_cliente_CNPJ');

            radioCPF.addEventListener('change', function() {
                identificacaoCliente.disabled = false;
                identificacaoCliente.maxLength = 11;
                identificacaoCliente.value = ''; // Limpa o campo
            });

            radioCNPJ.addEventListener('change', function() {
                identificacaoCliente.disabled = false;
                identificacaoCliente.maxLength = 14;
                identificacaoCliente.value = ''; // Limpa o campo
            });

            identificacaoCliente.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, ''); // Remove qualquer coisa que não seja número
            });
        });
    </script>

</body>

</html>
