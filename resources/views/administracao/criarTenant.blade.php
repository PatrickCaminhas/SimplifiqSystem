<!DOCTYPE html>
<html>
<head>
    <title>Simplifiq - Administração</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form id="create-tenant-form">
        <label for="name">Nome do Tenant:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Criar Tenant</button>
    </form>

    <script>
        $(document).ready(function() {
            $('#create-tenant-form').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: '/create-tenant',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: $('#name').val()
                    },
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(response) {
                        alert(response.responseJSON.message);
                    }
                });
            });
        });
    </script>
</body>
</html>
