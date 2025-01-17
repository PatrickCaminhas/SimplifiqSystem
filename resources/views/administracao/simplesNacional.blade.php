<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplifiq - Administração</title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json">

</head>

<body class="bg-black bg-gradient">
    @include('partials.menuAdmin')

    <div class="d-flex align-items-center justify-content-center" style="height: 92vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 col-8">
                    <div class="card shadow-sm">
                        <div class="card-body" style="overflow-x: auto;">


                            <h2 class="text-center">Aliquotas Simples Nacional</h2>

                            <!-- Modal -->
                            <div class="modal fade" id="adicionarFaixaModal" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="adicionarFaixaModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="adicionarFaixaModalLabel">
                                                Cadastro de faixa</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('simples.store') }}" method="POST" class="row g-3"
                                        onsubmit="return validateForm(this)">
                                            @csrf
                                            <div class="modal-body bg-secondary-subtle">
                                                <div class="form-group">
                                                    <label for="nome_anexo">Anexo:</label>
                                                    <select class="form-control" id="nome_anexo" name="nome_anexo"
                                                        required>
                                                        <option selected disabled>Selecione o anexo.</option>
                                                        <option value="1">Anexo 1</option>
                                                        <option value="2">Anexo 2</option>
                                                        <option value="3">Anexo 3</option>
                                                        <option value="4">Anexo 4</option>
                                                        <option value="5">Anexo 5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="faixa_anexo">Faixa:</label>
                                                    <input type="number" class="form-control" id="faixa_anexo"
                                                        name="faixa_anexo" placeholder="Somente o numero." required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="receita_bruta_anual_min">Valor minimo da receita bruta
                                                        anual</label>
                                                    <input type="number" class="form-control"
                                                        id="receita_bruta_anual_min" name="receita_bruta_anual_min"
                                                        placeholder="Digite o valor minimo da receita bruta anual."
                                                        step="0.01" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="receita_bruta_anual_max">Valor máximo da receita bruta
                                                        anual</label>
                                                    <input type="number" class="form-control"
                                                        id="receita_bruta_anual_max" name="receita_bruta_anual_max"
                                                        placeholder="Digite o valor maximo da receita bruta anual."
                                                        step="0.01" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="aliquota">Alíquota</label>
                                                    <input class="form-control" type="number" id="aliquota"
                                                        name="aliquota"
                                                        placeholder="Digite o valor da alíquota. Ex: 3.9 ou 14.2"
                                                        step="0.01" maxlength="2" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="aliquota">Dedução</label>
                                                    <input class="form-control" type="number" id="deducao"
                                                        name="deducao"
                                                        placeholder="Digite o valor da dedução do imposto"
                                                        step="0.01" maxlength="2" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary inline">
                                                    Cadastrar faixa
                                                </button>
                                                <button type="reset" class="btn btn-primary text-center">
                                                    Limpar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>



                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>Anexo</th>
                                        <th>Faixa</th>
                                        <th>Receita Bruta Anual</th>
                                        <th>Aliquota</th>
                                        <th>Dedução</th>
                                        <th>Ultima atualização</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($simplesNacional as $simples)
                                        <tr>
                                            <td>{{ $simples->nome_anexo }}</td>
                                            <td>Faixa {{ $simples->faixa_anexo }}</td>
                                            <td>R${{ $simples->receita_bruta_anual_min }} -
                                                R${{ $simples->receita_bruta_anual_max }}</td>
                                            <td>{{ $simples->aliquota }}%</td>
                                            <td>R${{ $simples->deducao }}</td>
                                            <td>{{ $simples->updated_at }}</td>
                                            <td>

                                                <button type="button" class="btn bg-primary text-light"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#alterarModal{{ $simples->nome_anexo }}{{ $simples->faixa_anexo }}">
                                                    Alterar
                                                </button>
                                                <div class="modal fade"
                                                    id="alterarModal{{ $simples->nome_anexo }}{{ $simples->faixa_anexo }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="alterarModalModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="alterarModalModalLabel">
                                                                    Alterar {{ $simples->nome_anexo }} -
                                                                    {{ $simples->faixa_anexo }}</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('simples.update') }}"
                                                                method="POST" class="row g-3"
                                                                onsubmit="return validateForm(this)">
                                                                @csrf
                                                                <div class="modal-body bg-secondary-subtle">
                                                                    <input type="hidden" name="nome_anexo"
                                                                        value="{{ $simples->nome_anexo }}">
                                                                    <input type="hidden" name="faixa_anexo"
                                                                        value="{{ $simples->faixa_anexo }}">

                                                                    <div class="form-group">
                                                                        <label for="receita_bruta_anual_min">Valor
                                                                            minimo da
                                                                            receita bruta
                                                                            anual</label>
                                                                        <input type="number" class="form-control"
                                                                            id="receita_bruta_anual_min"
                                                                            name="receita_bruta_anual_min"
                                                                            placeholder="Digite o valor minimo da receita bruta anual."
                                                                            step="0.01"
                                                                            maxlength="7 "value="{{ $simples->receita_bruta_anual_min }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="receita_bruta_anual_max">Valor
                                                                            máximo da
                                                                            receita bruta
                                                                            anual</label>
                                                                        <input type="number" class="form-control"
                                                                            id="receita_bruta_anual_max"
                                                                            name="receita_bruta_anual_max"
                                                                            placeholder="Digite o valor maximo da receita bruta anual."
                                                                            step="0.01" maxlength="7"
                                                                            value="{{ $simples->receita_bruta_anual_max }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="aliquota">Alíquota</label>
                                                                        <input class="form-control" type="number"
                                                                            id="aliquota" name="aliquota"
                                                                            placeholder="Digite o valor da alíquota. Ex: 3.9 ou 14.2"
                                                                            step="0.01" maxlength="2"
                                                                            value="{{ $simples->aliquota }}" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="aliquota">Dedução</label>
                                                                        <input class="form-control" type="number"
                                                                            id="deducao" name="deducao"
                                                                            placeholder="Digite o valor da dedução do imposto"
                                                                            step="0.01" maxlength="7"
                                                                            value="{{ $simples->deducao }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-primary inline">
                                                                        Alterar
                                                                    </button>
                                                                    <button type="reset"
                                                                        class="btn btn-primary text-center">
                                                                        Limpar
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <a>Para cadastrar uma nova faixa, clique no botão:</a>
                            <button type="button" class="btn bg-primary text-light" data-bs-toggle="modal"
                                data-bs-target="#adicionarFaixaModal">
                                Adicionar faixa
                            </button>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap e DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    @vite('resources/js/app.js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                },
                "pageLength": 6,
                "lengthChange": false,
            });
        });
    </script>
    <script>
        function validateForm(form) {
            function parseNumber(value) {
                return parseFloat(value.replace(/[^0-9.]/g, ''));
            }

            const receitaMin = parseNumber(form.receita_bruta_anual_min.value);
            const receitaMax = parseNumber(form.receita_bruta_anual_max.value);

            if (isNaN(receitaMin) || receitaMin < 0 || receitaMin > 4800000.00) {
                alert("O valor mínimo da receita bruta anual deve estar entre 0 e 4.800.000,00.");
                return false;
            }
            if (isNaN(receitaMax) || receitaMax < 0 || receitaMax > 4800000.00) {
                alert("O valor máximo da receita bruta anual deve estar entre 0 e 4.800.000,00.");
                return false;
            }

            const aliquota = parseNumber(form.aliquota.value);
            if (isNaN(aliquota) || aliquota < 0 || aliquota > 99.99) {
                alert("O valor da alíquota deve estar entre 0 e 99,99.");
                return false;
            }

            const deducao = parseNumber(form.deducao.value);
            if (isNaN(deducao) || deducao < 0 || deducao > 999999.99) {
                alert("O valor da dedução deve estar entre 0 e 999.999,99.");
                return false;
            }

            return true;
        }
    </script>

</body>

</html>
