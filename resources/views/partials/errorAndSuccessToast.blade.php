<div class="toast-container position-fixed bottom-0 start-50 translate-middle p-3">
    @if (session(key: 'error'))

            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger">
                    <strong class="me-auto text-white">Erro!</strong>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>

                </div>
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session(key: 'error') }}
                    </div>
                </div>

            </div>

    @endif

    @if (session(key: 'success'))
        <div id="toastSuccess" class="toast align-items-center text-bg-success border-0 show" role="alert" data-bs-delay="3000" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <strong class="me-auto text-white">Sucesso!</strong>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>

            </div>
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>

        </div>
    @endif
</div>
