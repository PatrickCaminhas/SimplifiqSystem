@extends('layouts.lista')
@section('titulo', 'Meta do mês')
@section('lista')
    <p><a class="btn @include('partials.buttomCollor')" href="{{ route('metas.lista') }}"><i class="bi bi-flag-fill"></i>
            Metas anteriores</a></p>
    <p><strong>Mês de referência:</strong> {{ ucfirst($mes) }}</p>
    <p class="row">
        <div class="col-auto">

        <strong>Valor da Meta:</strong> R$
        <span id="valorMetaDisplay">{{ number_format($meta->valor, 2, ',', '.') }}</span>

        <button id="btnEditar" class="btn @include('partials.buttomCollor') btn-sm">Atualizar Meta</button>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <span id="editMetaContainer" style="display: none;">
            <input type="number"  id="valorMeta" min="1" value="{{ $meta->valor }}">
            <button id="btnAtualizar" class="btn @include('partials.buttomCollor')  btn-sm">Atualizar</button>
        </span>
        </div>
    </p>

    <p><strong>Valor Atual:</strong> R$ <span
            id="valorAtualDisplay">{{ number_format($meta->valor_atual, 2, ',', '.') }}</span></p>
    <p><strong>Prazo:</strong> {{ \Carbon\Carbon::parse($meta->ending_at)->format('d/m/Y') }}</p>

    @php
        $percentual = min(100, ($meta->valor_atual / $meta->valor) * 100);
        $data_atual = \Carbon\Carbon::now();
        if ($data_atual > $meta->ending_at) {
            $bg = 'bg-danger';
        } else {
            $bg = 'bg-success';
        }
    @endphp

    <div class="progress" style="height: 25px;">
        <div class="progress-bar {{ $bg }}" role="progressbar" id="progressBar"
            style="width: {{ $percentual }}%;" aria-valuenow="{{ $percentual }}" aria-valuemin="0" aria-valuemax="100">
            <span id="percentualDisplay">{{ round($percentual, 2) }}%</span>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>


    <script>
        document.getElementById("btnEditar").addEventListener("click", function() {
            document.getElementById("editMetaContainer").style.display = "inline";
            document.getElementById("btnEditar").style.display = "none";
        });

        document.getElementById("btnAtualizar").addEventListener("click", function() {
            let novoValor = document.getElementById('valorMeta').value;
            let metaId = {{ $meta->id }};

            fetch(`/api/metas/update/${metaId}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        valor: novoValor
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);

                    // Atualizar valores na interface
                    document.getElementById('valorMetaDisplay').innerText = parseFloat(data.meta.valor)
                        .toLocaleString('pt-BR', {
                            minimumFractionDigits: 2
                        });

                    // Atualizar barra de progresso
                    let percentual = Math.min(100, (data.meta.valor_atual / data.meta.valor) * 100);
                    document.getElementById('progressBar').style.width = percentual + "%";
                    document.getElementById('percentualDisplay').innerText = percentual.toFixed(2) + "%";

                    // Esconder input e botão, mostrar botão "Atualizar Meta" novamente
                    document.getElementById("editMetaContainer").style.display = "none";
                    document.getElementById("btnEditar").style.display = "inline";
                })
                .catch(error => console.error('Erro:', error));
        });
    </script>
@endpush
