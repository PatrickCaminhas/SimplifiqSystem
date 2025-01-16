<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="app">
        <login-component tokencsrf="{{ csrf_token() }}"></login-component>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
