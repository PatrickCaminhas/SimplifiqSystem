<div class="offcanvas offcanvas-end navbar-dark" tabindex="-1" id="notificacoesOffcanvas"
    aria-labelledby="notificacoesOffcanvasLabel" data-bs-theme="dark">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="notificacoesOffcanvasLabel">Notificações</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Conteúdo das notificações aqui -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-1">
                    <div class="card-body">
                        <p class="figure-caption">Usuario: Sistema</p>
                        <p id="date_time" class="figure-caption"> 17/05/2024 13:27 </p>
                        <p class="card-text">Sistema ficará fora do ar e passará por atualizações no dia 21/05/2024
                            às 20:00, backup automatico do sistema será feito às 19:00 do dia 21/05/2024. </p>
                    </div>
                </div>
                <div class="card mt-1">
                    <div class="card-body">
                        <p class="figure-caption">Usuario: João</p>
                        <p id="date_time" class="figure-caption"> 10/05/2024 15:03 </p>
                        <p class="card-text">Encerrada parceria com fornecedor Giga Atacado.</p>
                    </div>
                </div>
            </div>

        </div>
        <div>
            <a href="/notificacoes"
                class="btn
                @if ($padrao_cores == 'vermelho') btn-danger
                @elseif ($padrao_cores == 'verde') btn-success
                @elseif ($padrao_cores == 'amarelo') btn-warning
                @elseif ($padrao_cores == 'azul') btn-primary
                @else bg-primary @endif
                ">Ver
                todas</a>
        </div>
    </div>
    <!-- Você pode usar qualquer componente Bootstrap ou elementos personalizados -->
</div>
