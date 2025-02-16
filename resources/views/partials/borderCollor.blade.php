@if (session('tema') == 'vermelho')
    border-danger
@elseif (session('tema') == 'verde')
    border-success
@elseif (session('tema') == 'amarelo')
    border-warning
@elseif (session('tema') == 'azul')
    border-primary
@elseif (session('tema') == 'dark')
    border-black
@else
    border-secondary
@endif
