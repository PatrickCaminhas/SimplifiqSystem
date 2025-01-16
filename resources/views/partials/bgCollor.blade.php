@if (session('tema') == 'vermelho')
    bg-danger-subtle
@elseif (session('tema') == 'verde')
    bg-success-subtle
@elseif (session('tema') == 'amarelo')
    bg-warning-subtle
@elseif (session('tema') == 'azul')
    bg-primary-subtle
@else
    bg-primary-subtle
@endif
