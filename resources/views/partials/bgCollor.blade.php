@if (session('tema') == 'vermelho')
    bg-danger-subtle
@elseif (session('tema') == 'verde')
    bg-success-subtle
@elseif (session('tema') == 'amarelo')
    bg-warning-subtle
@elseif (session('tema') == 'azul')
    bg-primary-subtle
@elseif (session('tema') == 'dark')
    bg-dark-subtle

@else
    bg-seco-subtle
@endif
