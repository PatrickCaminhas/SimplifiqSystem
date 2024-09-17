@if ($tamanho_empresa == 'mei')
    <div class="form-text">Você é um Microempreendedor Individual (MEI) e o valor do DAS MEI é de R$ {{ $simplesMei }}.
    </div>
@else
    <div class="form-text">Esta calculadora é uma estimativa, contate o seu contador.</div>

    <div>
        <form action="{{ route('simples.calculate') }}" method="POST">
            @csrf
            <div class="form-floating mb-3">
                <input type="number" class="form-control" name="receita_bruta_mes" id="receita_bruta_mes" step="0.01"
                    required>
                <label>Renda bruta do mês:</label>
                <div class="form-text">Valor total de vendas ou serviços prestados incluindo valores que não emitiram
                    nota fiscal do mês.</div>

            </div>

            <div class="form-floating mb-3">
                <input type="number" class="form-control" name="receita_bruta_anual" id="receita_bruta_anual"
                    min="1" step="0.01" required><label>
                    Renda bruta dos ultimos 12 meses:</label>
                <div class="form-text">Soma do faturamento dos ultimos 12 meses.</div>

            </div>
            <div class=" text-center mt-3">
                <button type="submit" class="btn @include('partials.buttomCollor')">Cadastrar</button>
                <button type="reset" class="btn @include('partials.buttomCollor')">Limpar</button>
            </div>
        </form>
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (session('valor'))
            <div class="alert alert-success" role="alert">
                {{session('valor') }}
            </div>
        @endif




    </div>

    </div>

@endif
