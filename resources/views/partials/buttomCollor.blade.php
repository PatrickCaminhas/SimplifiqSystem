@if (session('tema') == 'vermelho')
    btn-danger
@elseif (session('tema') == 'verde')
    btn-success
@elseif (session('tema') == 'amarelo')
    btn-warning
@elseif (session('tema') == 'azul')
    btn-primary
@else
    btn-primary
@endif
