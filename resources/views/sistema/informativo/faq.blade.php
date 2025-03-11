@extends('layouts.padrao')
@php
    $page = 'FAQ';
@endphp
@section('conteudo')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title display-6 text-center">Perguntas Frequentes</h5>
                        <p class="card-text text-center">Aqui você encontra respostas para as dúvidas mais comuns sobre o
                            sistema.</p>

                        <div class="accordion" id="faqAccordion">
                            <!-- Pergunta 1 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Gerenciamento de Produtos
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">

                                        <div class="accordion" id="nestedAccordion1">
                                            <!-- Sub-pergunta 1 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingOne">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseOne"
                                                        aria-expanded="true" aria-controls="nestedCollapseOne">
                                                        Como cadastrar um novo produto?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseOne" class="accordion-collapse collapse show"
                                                    aria-labelledby="nestedHeadingOne" data-bs-parent="#nestedAccordion1">
                                                    <div class="accordion-body">
                                                        Para cadastrar um novo produto, no menu acesse a aba "Produtos",
                                                        clique em
                                                        "Cadastrar" e preencha os dados necessários.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 2 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingTwo">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseTwo"
                                                        aria-expanded="false" aria-controls="nestedCollapseTwo">
                                                        Como visualizar informações de um produto?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseTwo" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingTwo" data-bs-parent="#nestedAccordion1">
                                                    <div class="accordion-body">
                                                        Para visualizar um produto, acesse a aba "Produtos", clique em
                                                        "Lista",
                                                        procure o produto desejado e clique na lupa da coluna detalhes.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 3 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingThree">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseThree"
                                                        aria-expanded="false" aria-controls="nestedCollapseThree">
                                                        É possível alterar um produto?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseThree" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingThree" data-bs-parent="#nestedAccordion1">
                                                    <div class="accordion-body">
                                                        Sim, siga os passos para visualizar um produto e na página do
                                                        produto clique em "Alterar dados"
                                                        para mudar algum dado do produto e em "Alterar preços" para alterar
                                                        o preço de venda ou o preço mínimo de venda.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 4 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingFour">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseFour"
                                                        aria-expanded="false" aria-controls="nestedCollapseFour">
                                                        É possível excluir um produto?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseFour" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingFour" data-bs-parent="#nestedAccordion1">
                                                    <div class="accordion-body">
                                                        Não, não é possível excluir um produto, mas é possível desativá-lo.
                                                        Para isso, siga os passos para visualizar um produto e na página do
                                                        produto
                                                        clique em "Desativar produto".
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 5 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingFive">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseFive"
                                                        aria-expanded="false" aria-controls="nestedCollapseFive">
                                                        O sistema tem controle de estoque?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseFive" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingFive" data-bs-parent="#nestedAccordion1">
                                                    <div class="accordion-body">
                                                        Sim, o sistema tem controle de estoque, permitindo visualizar a
                                                        quantidade de produtos em estoque,
                                                        a última movimentação do estoque e realizar reposição ou dar baixa
                                                        em um produto.
                                                    </div>
                                                </div>
                                            </div>

                                        </div> <!-- Fim do Accordion Interno -->
                                    </div>
                                </div>
                            </div>


                            <!-- Pergunta 2: Gerenciamento de clientes e fornecedores -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Gerenciamento de clientes e fornecedores
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <div class="accordion" id="nestedAccordion2">
                                            <!-- Sub-pergunta 1 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingSix">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseSix"
                                                        aria-expanded="true" aria-controls="nestedCollapseSix">
                                                        Como cadastrar um novo cliente?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseSix" class="accordion-collapse collapse show"
                                                    aria-labelledby="nestedHeadingSix" data-bs-parent="#nestedAccordion2">
                                                    <div class="accordion-body">
                                                        No menu acesse a aba "Clientes", clique em "Cadastrar" e preencha os
                                                        dados necessários.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 2 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingSeven">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseSeven"
                                                        aria-expanded="false" aria-controls="nestedCollapseSeven">
                                                        Como alterar e visualizar dados de um cliente?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseSeven" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingSeven"
                                                    data-bs-parent="#nestedAccordion2">
                                                    <div class="accordion-body">
                                                        No menu acesse a aba "Clientes", clique em "Lista", procure o
                                                        cliente desejado e clique na lupa da coluna detalhes.
                                                        Se necessário editar os dados, clique em "Alterar".
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 3 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingEight">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseEight"
                                                        aria-expanded="false" aria-controls="nestedCollapseEight">
                                                        Como cadastrar um fornecedor?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseEight" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingEight"
                                                    data-bs-parent="#nestedAccordion2">
                                                    <div class="accordion-body">
                                                        No menu acesse a aba "Fornecedores", clique em "Cadastrar" e
                                                        preencha os dados necessários.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 4 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingNine">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseNine"
                                                        aria-expanded="false" aria-controls="nestedCollapseNine">
                                                        Como alterar e visualizar dados de um fornecedor?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseNine" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingNine"
                                                    data-bs-parent="#nestedAccordion2">
                                                    <div class="accordion-body">
                                                        No menu acesse a aba "Fornecedores", clique em "Lista", procure o
                                                        fornecedor desejado e clique na lupa da coluna detalhes.
                                                        Se necessário editar os dados, clique em "Alterar".
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- Fim do Accordion Interno -->
                                    </div>
                                </div>
                            </div>

                            <!-- Pergunta 3: Gestão de vendas -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Gestão de vendas
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <div class="accordion" id="nestedAccordion3">
                                            <!-- Sub-pergunta 1 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingTen">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseTen"
                                                        aria-expanded="true" aria-controls="nestedCollapseTen">
                                                        Como realizar uma venda?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseTen" class="accordion-collapse collapse show"
                                                    aria-labelledby="nestedHeadingTen" data-bs-parent="#nestedAccordion3">
                                                    <div class="accordion-body">
                                                        Acesse a aba "Vendas" no menu e depois em "Cadastro". Escolha o
                                                        cliente cadastrado ou "Cliente Não cadastrado", selecione o método
                                                        de pagamento, escolha os produtos e suas quantidades, aplique
                                                        descontos se necessário e clique em "Finalizar venda".
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 2 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingEleven">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseEleven"
                                                        aria-expanded="false" aria-controls="nestedCollapseEleven">
                                                        Sou obrigado a digitar o preço da venda no cadastro?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseEleven" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingEleven"
                                                    data-bs-parent="#nestedAccordion3">
                                                    <div class="accordion-body">
                                                        Não, o campo "Preço de Venda" pode ser deixado em branco. Ele só
                                                        deve ser preenchido se for necessário dar um desconto dentro do
                                                        intervalo permitido.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 3 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingTwelve">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseTwelve"
                                                        aria-expanded="false" aria-controls="nestedCollapseTwelve">
                                                        Como visualizar vendas anteriores?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseTwelve" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingTwelve"
                                                    data-bs-parent="#nestedAccordion3">
                                                    <div class="accordion-body">
                                                        No menu vá em "Vendas" e depois em "Lista". Lá você pode visualizar
                                                        todas as vendas cadastradas e acessar os detalhes clicando na lupa
                                                        da coluna "Detalhes".
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- Fim do Accordion Interno -->
                                    </div>
                                </div>
                            </div>

                            <!-- Pergunta 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCotacao">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseCotacao" aria-expanded="false"
                                        aria-controls="collapseCotacao">
                                        Cotação de produtos
                                    </button>
                                </h2>
                                <div id="collapseCotacao" class="accordion-collapse collapse"
                                    aria-labelledby="headingCotacao" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <div class="accordion" id="nestedAccordionCotacao">
                                            <!-- Sub-pergunta 1 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingCotacao1">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseCotacao1"
                                                        aria-expanded="true" aria-controls="nestedCollapseCotacao1">
                                                        O que é cotação de produtos?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseCotacao1" class="accordion-collapse collapse show"
                                                    aria-labelledby="nestedHeadingCotacao1"
                                                    data-bs-parent="#nestedAccordionCotacao">
                                                    <div class="accordion-body">
                                                        Cotação de produtos é o processo de solicitar orçamentos a
                                                        fornecedores para comparar preços e assim obtendo
                                                        melhores valores para compra.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 2 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingCotacao2">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseCotacao2"
                                                        aria-expanded="false" aria-controls="nestedCollapseCotacao2">
                                                        Como realizar a cotação de produtos?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseCotacao2" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingCotacao2"
                                                    data-bs-parent="#nestedAccordionCotacao">
                                                    <div class="accordion-body">
                                                        No menu, acesse "Cotação de Produtos" e clique em "Cadastro".
                                                        Selecione os produtos que deseja cotar e avance.
                                                        Insira os preços fornecidos por cada fornecedor (deixe em branco
                                                        caso um fornecedor não ofereça o produto).
                                                        <p> Após salvar, visualize a lista e, se desejar, imprima ou salve
                                                            em PDF clicando em "Salvar em PDF/Imprimir". </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 3 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingCotacao3">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseCotacao3"
                                                        aria-expanded="false" aria-controls="nestedCollapseCotacao3">
                                                        É possível verificar o gasto total da compra?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseCotacao3" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingCotacao3"
                                                    data-bs-parent="#nestedAccordionCotacao">
                                                    <div class="accordion-body">
                                                        Sim. Vá até "Cotação de Produtos" > "Lista" > "Verificar".
                                                        Nesta página, insira a quantidade desejada de cada produto e
                                                        visualize o custo total da compra.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 4 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingCotacao4">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#nestedCollapseCotacao4"
                                                        aria-expanded="false" aria-controls="nestedCollapseCotacao4">
                                                        É possível repor o estoque com base na cotação?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseCotacao4" class="accordion-collapse collapse"
                                                    aria-labelledby="nestedHeadingCotacao4"
                                                    data-bs-parent="#nestedAccordionCotacao">
                                                    <div class="accordion-body">
                                                        Sim. Vá até "Cotação de Produtos" > "Lista" > "Repor Estoque".
                                                        Insira a quantidade de cada produto a ser reposta e clique em
                                                        "Repor".
                                                        Caso não reponha um item, deixe o campo em branco.
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- Fim do Accordion Interno -->
                                    </div>
                                </div>
                            </div>
                            @if (session('funcionario') && session('funcionario')->cargo == 'Administrador')
                            <!-- Pergunta 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Relatórios e informações financeiras
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <div class="accordion" id="nestedAccordion2">
                                            <!-- Sub-pergunta 1 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingThree">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#nestedCollapseThree" aria-expanded="true" aria-controls="nestedCollapseThree">
                                                        Como cadastrar uma conta?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseThree" class="accordion-collapse collapse show" aria-labelledby="nestedHeadingThree"
                                                    data-bs-parent="#nestedAccordion2">
                                                    <div class="accordion-body">
                                                        Acesse a aba "Empresa" e depois "Despesas", nesta página você pode visualizar
                                                        todas as despesas cadastradas e adicionar uma nova despesa no botão "Cadastrar despesa".
                                                        Para cadastrar basta inserir um credor, ou seja, a quem você vai pagar, o tipo de despesa, o valor
                                                        e a data de vencimento.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 2 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingFour">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#nestedCollapseFour" aria-expanded="false" aria-controls="nestedCollapseFour">
                                                        O sistema tem gerenciamento de metas?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseFour" class="accordion-collapse collapse" aria-labelledby="nestedHeadingFour"
                                                    data-bs-parent="#nestedAccordion2">
                                                    <div class="accordion-body">
                                                        Sim, o sistema tem gerenciamento de metas, na aba Empresa e na opção metas.
                                                        Na página você pode ver a meta do mês atual, o valor da meta em vendas e uma barra de progresso,
                                                        na página também é possível alterar o valor da meta. Você também pode verificar metas antigas clicando no
                                                        botão "Metas anteriores" e depois na lupa da coluna estatísticas.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 3 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingFive">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#nestedCollapseFive" aria-expanded="false" aria-controls="nestedCollapseFive">
                                                        O que é o Simulador Simples Nacional?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseFive" class="accordion-collapse collapse" aria-labelledby="nestedHeadingFive"
                                                    data-bs-parent="#nestedAccordion2">
                                                    <div class="accordion-body">
                                                        É um simulador do valor que a empresa irá pagar de impostos do Simples Nacional, no simulador além do valor
                                                        do mês atual de acordo com suas vendas cadastradas no sistema é possível ver quanto de cada imposto
                                                        está contido no documento de arrecadação do Simples Nacional.
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 4 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingSix">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#nestedCollapseSix" aria-expanded="false" aria-controls="nestedCollapseSix">
                                                        O valor do simulador está diferente do real, o que fazer?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseSix" class="accordion-collapse collapse" aria-labelledby="nestedHeadingSix"
                                                    data-bs-parent="#nestedAccordion2">
                                                    <div class="accordion-body">
                                                        O que pode estar acontecendo é que o valor do imposto do Simples é baseado na renda bruta cadastrada
                                                        no sistema, é necessário antes de tudo você cadastrar os valores da renda bruta da sua empresa dos
                                                        12 meses anteriores ao mês vigente.

                                                        <p>Para isso basta no menu em "Empresa" e depois em "Renda bruta", corrija alguma renda bruta de
                                                            meses passados na lista se necessário ou clique em "Registrar" para cadastrar uma nova renda
                                                            bruta anterior.</p>
                                                        <p>O valor do mês atual é sempre incrementado com cada venda cadastrada no sistema.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 5 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingSeven">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#nestedCollapseSeven" aria-expanded="false" aria-controls="nestedCollapseSeven">
                                                        Como verificar relatório da situação da empresa?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseSeven" class="accordion-collapse collapse" aria-labelledby="nestedHeadingSeven"
                                                    data-bs-parent="#nestedAccordion2">
                                                    <div class="accordion-body">
                                                        Acesse no menu em "Empresa" e depois em "Informações", nesta página você pode verificar dados da
                                                        empresa e informações de estoque, além de informações e gráficos da situação financeira da empresa.
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- Fim do Accordion Interno -->
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Pergunta 3 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Configurações
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <div class="accordion" id="nestedAccordion3">
                                        <!-- Sub-pergunta 1 -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="nestedHeadingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#nestedCollapseOne" aria-expanded="true" aria-controls="nestedCollapseOne">
                                                    Como alterar meus dados de usuário?
                                                </button>
                                            </h2>
                                            <div id="nestedCollapseOne" class="accordion-collapse collapse show" aria-labelledby="nestedHeadingOne"
                                                data-bs-parent="#nestedAccordion3">
                                                <div class="accordion-body">
                                                    ---
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sub-pergunta 2 -->
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="nestedHeadingTwo">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#nestedCollapseTwo" aria-expanded="false" aria-controls="nestedCollapseTwo">
                                                    Como alterar minha senha?
                                                </button>
                                            </h2>
                                            <div id="nestedCollapseTwo" class="accordion-collapse collapse" aria-labelledby="nestedHeadingTwo"
                                                data-bs-parent="#nestedAccordion3">
                                                <div class="accordion-body">
                                                    ----
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sub-pergunta 3 (Visível apenas para Administradores) -->
                                        @if (session('funcionario') && session('funcionario')->cargo == 'Administrador')
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingThree">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#nestedCollapseThree" aria-expanded="false" aria-controls="nestedCollapseThree">
                                                        Como cadastrar um novo funcionário?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseThree" class="accordion-collapse collapse" aria-labelledby="nestedHeadingThree"
                                                    data-bs-parent="#nestedAccordion3">
                                                    <div class="accordion-body">
                                                        ----
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 4 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingFour">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#nestedCollapseFour" aria-expanded="false" aria-controls="nestedCollapseFour">
                                                        Como visualizar os funcionários cadastrados?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseFour" class="accordion-collapse collapse" aria-labelledby="nestedHeadingFour"
                                                    data-bs-parent="#nestedAccordion3">
                                                    <div class="accordion-body">
                                                        ----
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 5 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingFive">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#nestedCollapseFive" aria-expanded="false" aria-controls="nestedCollapseFive">
                                                        Como alterar cargos de funcionários no sistema?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseFive" class="accordion-collapse collapse" aria-labelledby="nestedHeadingFive"
                                                    data-bs-parent="#nestedAccordion3">
                                                    <div class="accordion-body">
                                                        ----
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-pergunta 6 -->
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="nestedHeadingSix">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#nestedCollapseSix" aria-expanded="false" aria-controls="nestedCollapseSix">
                                                        Como excluir um funcionário?
                                                    </button>
                                                </h2>
                                                <div id="nestedCollapseSix" class="accordion-collapse collapse" aria-labelledby="nestedHeadingSix"
                                                    data-bs-parent="#nestedAccordion3">
                                                    <div class="accordion-body">
                                                        ----
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div> <!-- Fim do Accordion Interno -->
                                </div>
                            </div>
                        </div>


                        </div> <!-- Fim do Accordion Principal -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
