@if (session('tema') == 'vermelho')
    btn-outline-danger
@elseif (session('tema') == 'verde')
    btn-outline-success
@elseif (session('tema') == 'amarelo')
    btn-outline-warning
@elseif (session('tema') == 'azul')
    btn-outline-primary
@else
    btn-outline-primary
@endif
