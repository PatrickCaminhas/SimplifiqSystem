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
</head>

<body class=bg-dark>
     <!-- Menu superior -->
     @include('partials.header')

     <!-- Offcanvas para o menu -->
    @include('partials.menu')

     <!-- Offcanvas para notificações -->
     @include('partials.notificacoes')

    <div class="container mt-4 mb-4 bg-light text-dark">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4 class="display-6">Notificações</h4>
               <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Sistema ficará fora do ar e passará por atualizações no dia 21/05/2024 às 20:00, backup automatico do sistema será feito às 19:00 do dia 21/05/2024.</td>
                            <td>17/05/2024 - 13:27</td>
                            <td>Sistema</td>
                        </tr>
                        <tr>
                            <td>Encerrada parceria com fornecedor Giga Atacado.</td>
                            <td>10/05/2024 - 15:03</td>
                            <td>João</td>
                        </tr>
                    </tbody>
                </table>
                <a href="#" class="btn btn-primary mb-4">Limpar</a>

            </div>
        </div>

    <!-- Inclua os arquivos JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
