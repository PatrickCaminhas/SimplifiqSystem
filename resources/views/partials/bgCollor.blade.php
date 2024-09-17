@if ($padrao_cores == 'vermelho')
    bg-danger-subtle
@elseif ($padrao_cores == 'verde')
    bg-success-subtle
@elseif ($padrao_cores == 'amarelo')
    bg-warning-subtle
@elseif ($padrao_cores == 'azul')
    bg-primary-subtle
@else
    bg-primary-subtle
@endif
