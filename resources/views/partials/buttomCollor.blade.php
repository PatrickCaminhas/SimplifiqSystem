@if ($padrao_cores == 'vermelho')
    btn-danger
@elseif ($padrao_cores == 'verde')
    btn-success
@elseif ($padrao_cores == 'amarelo')
    btn-warning
@elseif ($padrao_cores == 'azul')
    btn-primary
@else
    btn-primary
@endif
