<!-- resources/views/pdf/cotacao.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Cotação de Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Cotação de Produtos</h1>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Fornecedor</th>
                <th>Preço</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $produto)
                <tr>
                    <td>{{ $produto['nome'] }}</td>
                    <td>{{ $produto['fornecedor'] }}</td>
                    <td>{{ $produto['preco'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>