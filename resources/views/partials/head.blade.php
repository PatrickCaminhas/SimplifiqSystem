<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page }} | Simplifiq
    </title>
    <!-- Inclua os arquivos CSS do Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('no-captcha.sitekey') }}"></script>

    @if ($jquery ?? false)
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    @endif
    @if ($data_tables ?? false)
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json">
    @endif
    @if ($chartjs ?? false)
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    @endif
    @if ($select2 ?? false)
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
        <style>
             /* Ajustar a cor de fundo do Select2 */
        .select2-container--default .select2-selection--single {
            background-color: #343a40 !important;
            /* Cor escura para combinar com o Bootstrap */
            color: #fff !important;
            /* Texto branco */
            border: 1px solid #555 !important;
            /* Borda para harmonizar */
        }

        /* Ajustar a cor de fundo quando está aberto */
        .select2-dropdown {
            background-color: #ffffff !important;
            /* Fundo escuro */
            color: #000000 !important;
            /* Texto branco */
        }

        /* Ajustar o campo de entrada dentro do Select2 */
        .select2-search--dropdown .select2-search__field {
            background-color: #ffffff !important;
            color: #000000 !important;
            border: 1px solid #555 !important;
        }

        /* Ajustar a cor dos itens do dropdown */
        .select2-results__option {
            background-color: #ffffff !important;
            color: #000000 !important;
        }

        /* Alterar cor ao passar o mouse nos itens */
        .select2-results__option--highlighted {
            background-color: #525252 !important;
            /* Um cinza um pouco mais claro */
            color: #ffffff !important;
        }
        </style>
    @endif



    <style>
        /* Sobrescreve o estilo do item de menu quando em foco ou ativo */
        .dropdown-item:focus,
        .dropdown-item:active {
            background-color: inherit !important;
            color: inherit !important;
        }

        /* Fonte padrão */
        body {
            font-size: 16px;
        }

        /* Estilo para o aumento de fonte */
        .font-large {
            font-size: 20px;
        }


    </style>

<style>
    /* Esconde elementos com a classe .no-print ao imprimir */
    @media print {
        .no-print {
            display: none;
        }
    }
</style>

</head>
