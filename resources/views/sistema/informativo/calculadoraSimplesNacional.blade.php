@extends('layouts.padrao')
@section('conteudo')
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12">
            <div class="card shadow-sm d-flex flex-column justify-content-center align-items-center ">
                <div class="card-body">
                    <h2>Simulador de Simples Nacional</h2>
                    @if ($tabela_vazia == true ?? false)
                        <p class="fs-6">
                        <h6>Não foi possível simular o DAS, pois <span class="text-danger">não</span> há renda
                            bruta cadastrada no sistema para o cálculo.</h6>
                        </p>
                        <p>Cadastre renda bruta para calcular o DAS.</p>
                        <p><a href="{{ route('faturamento.create') }}" class="btn @include('partials.buttomCollor')">Cadastre
                                faturamento</a></p>
                        <p>Cadastre uma venda que automaticamente criará o faturamento do mês atual. </p>
                        <p><a href="{{ route('vendas.create') }}" class="btn @include('partials.buttomCollor')">Cadastre uma
                                venda</a></p>
                    @elseif($tabela_vazia == false && isset($simplesMei))
                        <p class="fs-6">Mês de referente: @php
                            echo \Carbon\Carbon::now()->format('m/Y');
                        @endphp</p>
                        <p class="fs-6">Você é um Microempreendedor Individual (MEI) e o valor do DAS MEI é
                            de
                            R${{ number_format($simplesMei, 2, ',', '.') }}.</p>
                    @else
                        <p class="fs-6">Mês referente:
                            {{ \Carbon\Carbon::parse($informacoes['ultimo_mes_ano_mes'])->format('m/Y') }}</p>
                        <p class="fs-6">Renda bruta do mês referente:
                            R${{ number_format($informacoes['ultimo_mes_faturamento'], 2, ',', '.') }}</p>

                        @if ($informacoes['quantidade_meses'] > 1)
                            <p class="fs-6">Renda bruta acumulada dos últimos
                                {{ $informacoes['quantidade_meses'] }} meses:
                                R${{ number_format($informacoes['faturamento_total'], 2, ',', '.') }}</p>
                            <p class="fs-6">Renda bruta proporcionalizada dos últimos
                                {{ $informacoes['quantidade_meses'] }} meses:
                                R${{ number_format($informacoes['rbt12'], 2, ',', '.') }}</p>
                        @elseif($informacoes['quantidade_meses'] == 1)
                            <p class="fs-6">Renda bruta do último mês:
                                R${{ number_format($informacoes['faturamento_total'], 2, ',', '.') }}</p>
                        @endif
                        <p class="fs-6">
                        <h5>Valor do DAS:
                            R${{ number_format($informacoes['valor_das'], 2, ',', '.') }}</h5>
                        </p>
                        <p class="fs-6">Deseja verificar quanto de cada imposto está pagando no DAS?
                        <p><button type="button" class="btn @include('partials.buttomCollor')" data-bs-toggle="modal"
                                data-bs-target="#impostosModal">
                                Veja agora
                            </button></p>
                        <p class="fw-lighter">DAS = Documento de Arreacadação do Simples Nacional.</p>

                        <div class="modal fade" id="impostosModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Valor de cada
                                            imposto
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Valor do CPP:
                                            R${{ number_format($informacoes['valores_impostos']['cpp'], 2, ',', '.') }}
                                        </p>
                                        <p>Valor do ICMS:
                                            R${{ number_format($informacoes['valores_impostos']['icms'], 2, ',', '.') }}
                                        </p>
                                        <p>Valor do IRPJ:
                                            R${{ number_format($informacoes['valores_impostos']['irpj'], 2, ',', '.') }}
                                        </p>
                                        <p>Valor do CSLL:
                                            R${{ number_format($informacoes['valores_impostos']['csll'], 2, ',', '.') }}
                                        </p>
                                        <p>Valor do Cofins:
                                            R${{ number_format($informacoes['valores_impostos']['cofins'], 2, ',', '.') }}
                                        </p>
                                        <p>Valor do PIS:
                                            R${{ number_format($informacoes['valores_impostos']['pis_pasep'], 2, ',', '.') }}
                                        </p>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn @include('partials.buttomCollor')"
                                            data-bs-dismiss="modal">Fechar</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>


@endsection
