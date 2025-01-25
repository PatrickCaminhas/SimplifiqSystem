@if (session('tema') == 'vermelho')
    btn-danger
@elseif (session('tema') == 'verde')
    btn-success
@elseif (session('tema') == 'amarelo')
    btn-warning
@elseif (session('tema') == 'azul')
    btn-primary
@elseif (session('tema') == 'dark')
    btn-dark
@else
    btn-primary
@endif
