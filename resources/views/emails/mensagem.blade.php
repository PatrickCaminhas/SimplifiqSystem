<x-mail::message>
# Bem vindo ao Simplifiq

A sua empresa foi criada com sucesso. Para acessar à sua conta, clique no botão abaixo.
<x-mail::button :url="'http://localhost:8000/empresas'">
Acessar a minha conta
</x-mail::button>
Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>