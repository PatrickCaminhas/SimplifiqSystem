<p align="center"><a href="https://github.com/PatrickCaminhas/SimplifiqSystem/" target="_blank"><img src="https://i.imgur.com/10PlOF2.png" width="300" alt="Simplifiq Logo"></a></p>
<h1 align="center">Simplifiq</h1> 

<p align="justify">O Simplifiq é um sistema para auxilio administrativo voltado para microempreendedores individuais(MEI), microempreendedores e pequenos empreededores. A ideia do Simplifiq é ser uma aplicação leve, de facil acesso e que seja intuitiva para que todos consigam utilizar suas funções desde pequenos empreendedores com alguns computadores a até MEI's com apenas um celular em mãos. Foi decidido que o sistema seria um Software as a Service(SaaS) e teria arquitetura multilocatario e dentre as tecnologias utilizadas foi escolhido por opinião pessoal a linguagem PHP e o Framework back-end Laravel, para o front-end foi utilizado o framework Bootstrap por escolha pessoal e por ser responsivo, assim tornando a aplicação não somente usavel em um desktop quanto em celulares ou tablets. Dentre as ferramentas escolhidas para implementações do projeto foram escolhidas o Tenancy for Laravel para aplicação da arquitetura multilocatario pois é uma ferramenta robusta e completa, o Data Tables por permitir o uso de tabelas interativas e Chart.js por gerar graficos simples e flexiveis.

Diagrama do banco de dados: https://dbdiagram.io/d/Simplifiq-System-667b82739939893dae454c5f  
</p>

## Linguagens, ferramentas e frameworks utilizadas.
### 1. <a href="https://www.php.net/">PHP</a>
### 2. <a href="https://laravel.com/">Laravel</a>
### 3. <a href="https://getbootstrap.com/">Bootstrap </a>
### 4. <a href="https://tenancyforlaravel.com/">Tenancy for Laravel</a>
### 4. <a href="https://datatables.net/">Data Tables</a>
### 4. <a href="https://www.chartjs.org/">Chart.js</a>



# Requisitos Funcionais
## 1. Gerenciamento de Empresas
Cadastro de Empresas:  
O sistema deve permitir o cadastro de empresas com as seguintes informações: nome, CNPJ, tamanho da empresa (MEI, pequena empresa ou micro empresa), tipo de empresa (ramo de atuação), e telefone.  

Leitura de Empresas:  
O sistema deve permitir a consulta das informações cadastradas de cada empresa.  
## 2. Gerenciamento de Funcionários
Cadastro de Funcionários:  
O sistema deve permitir o cadastro de funcionários com as seguintes informações: nome, sobrenome, cargo, email, CNPJ da empresa em que trabalha (chave estrangeira) e senha.  

Leitura de Funcionários:  
O sistema deve permitir a consulta das informações de cada funcionário.  

Alteração de dados do Funcionários:  
O sistema deve permitir que o funcionário altere seus dados e sua senha.  

Controle de Acesso:  
O sistema deve permitir ao administrador da empresa definir e alterar os cargos dos funcionários e assim modificando suas permissões de acesso e operação no sistema (leitura, cadastro, alteração).  

Exclusão de funcionários:
O sistema deve permitir que o usuario administrador exclua outros funcionários do sistema que já não tem vinculo com a empresa.

Autenticação:  
O sistema deve permitir que os usuários façam login e possam mudar suas senhas.  
## 3. Gerenciamento de Produtos
Cadastro de Produtos:  
O sistema deve permitir o cadastro de produtos com as seguintes informações: nome, marca, modelo, categoria, unidade de medida, medida, descrição, quantidade, último fornecedor, preço de compra e preço de venda.  

Leitura de Produtos:  
O sistema deve permitir a consulta das informações cadastradas de cada produto.  

## 4. Gerenciamento de Fornecedores
Cadastro de Fornecedores:  
O sistema deve permitir o cadastro de fornecedores com as seguintes informações: nome, CNPJ, endereço, cidade, estado, nome do representante, email e telefone.  

Leitura de Fornecedores:  
O sistema deve permitir a consulta das informações cadastradas de cada fornecedor.  

## 5. Cotação de Produtos
Cadastro de Cotações:  
O sistema deve permitir o registro de cotações de produtos com as seguintes informações: id do produto, preço mais barato, nome do fornecedor que deu o preço mais barato, data e hora de criação da cotação.  

Leitura de Cotações:  
O sistema deve permitir a consulta das cotações registradas.  

## 6. Informações da Empresa
Leitura de Dados da Empresa:  
O sistema deve permitir a consulta de dados adicionais da empresa, tais como vendas semestrais, vendas durante o mês, produto mais rentável, despesas semestrais, despesas durante o mês, tipos de vendas cadastradas, vendas no crediario.  

## 7. Controle de metas
Cadastro de metas:
O sistema deve permitir que o usuario cadastre metas de vendas com prazo minimo de uma semana.

Leitura de metas:
O sistema deve listar todas as metas criadas e alem disso deve prover estatisticas das metas.

## 8. Estoque de produtos
Leitura de estoque:
O sistema deve listar todos os produtos e seus estoques.

Alteração no estoque:
O sistema deve permitir o usuario dar repor ou dar baixa no estoque de produtos cadastrados.

## 9. Controle de contas
Cadastro de contas:
O sistema deve permitir o cadastro de contas que será contabilizado nas desepesas da empresa, uma conta deve ter os seguiguintes dados: nome do credor, tipo de conta, valor da conta e data de nascimento.

Leitura de contas:
O sistema deve listar todas as contas da empresa.

Finalização de contas:
O sistema deve permitir ao usuario finalizar uma conta, sendo as finalizações dos tipos: cancelamento, conta paga e conta vencida.

## 10. Controle de vendas
Cadastro de vendas:
O sistema deve permitir o cadastro de vendas com os seguintes dados: os produtos vendidos, quantidade cada produto vendido, cliente que comprou, metodo de pagamento, informar valor total e valor total com desconto máximo possivel da venda e cadastrar o preço final da venda com valor entre o valor total e valor desconto maximo.

Leitura das vendas:
O sistema deve listar todas as vendas com os dados das vendas.

## 11. Controle de clientes
Cadastro de clientes:
O sistema deve permitir o cadastro de clientes com os seguintes dados: nome completo, cpf ou cnpj (o sistema deve distinguir se o numero cadastrado é cpf ou cnpj), telefone, email (não obrigatório) e o endereço completo.

Leitura de clientes:
O sistema deve listar todos os clientes e permitir ao usuario a visualização dos dados do cliente e se o cliente tiver comprado no crediario o sistema deve inclur nestes dados o valor total a receber do cliente, alem de poder ver a lista de todos os clientes que ainda tem a receber por compras no crediario.

Pagamento de contas:
O sistema deve permitir ao usuario pagamento completo ou parcial de contas de clientes.

# Requisitos Não Funcionais
## 1. Segurança
Autenticação e Autorização:  
O sistema deve garantir que apenas usuários autenticados possam acessar o sistema.  
O sistema deve implementar controles de autorização para garantir que os usuários só possam acessar funcionalidades e dados conforme suas permissões.  

Isolamento de Dados:  
Cada empresa deve ter seu próprio banco de dados para evitar a leitura de dados de empresas diferentes.  

## 2. Desempenho
Tempo de Resposta:  
O sistema deve garantir tempos de resposta rápidos para as operações de leitura e escrita nos bancos de dados.  

## 3. Usabilidade
Interface Amigável:  
O sistema deve fornecer uma interface de usuário amigável e intuitiva para facilitar o uso por micro e pequenos empreendedores.  

Documentação:  
O sistema deve ter uma documentação clara e completa para ajudar os usuários a entender e utilizar todas as funcionalidades.  
## 4. Manutenção
Facilidade de Manutenção:  
O sistema deve ser desenvolvido de forma modular para facilitar a manutenção e a adição de novas funcionalidades.  


# Modelo de Dados

## Banco de Dados Comum

### Tabela Empresas:
id (PK)  
nome  
cnpj  (Unique)
tamanho_empresa  
tipo_empresa  
telefone  

### Tabela Funcionários:
id (PK)  
nome  
sobrenome  
cargo  
email  (Unique)
cnpj (FK)  
senha  

## Banco de Dados por Empresa

### Tabela Produtos:

id (PK)  
nome  
marca  
modelo  
categoria  
unidade_medida  
medida  
descricao  
quantidade  
ultimo_fornecedor  
preco_compra  
preco_venda  

### Tabela Fornecedores:
id (PK)  
nome  
cnpj  (Unique)
endereco  
cidade  
estado  
nome_representante  
email  
telefone  

### Tabela Informações Empresa:
id (PK)  
lucro_mensal  
produto_mais_vendido  
produto_mais_rentavel  
produto_menos_vendido  
outras_informacoes  

### Tabela Cotações:
id (PK)  
produto_id (FK)  
preco_mais_barato  
id_fornecedor  (FK)
data_hora_criacao  

### Tabela Balanço Financeiro:
id (PK)  
descricao  
tipo [saida ou entrada]  
mes  
ano  

### Tabela Levantamento Metas:
id (PK)  
meta_mensal
meta_dia
dia 
mes  
ano  
venda (quanto vendeu no dia)
resultado_diario (venda menos a meta_dia)
resultado_acumulado(soma do resultado acumulado do dia atual e dos dias anteriores do mês)

# Próximos Passos
## Refinamento dos Requisitos:

Validar os requisitos com stakeholders.  
Refinar e detalhar requisitos específicos conforme necessário.  
Pesquisar novas funcionalidades para o sistema.  
Novas funções a serem desenvolvidos e pesquisadas:  
    2 - Balanço financeiro de entradas e saidas.  



## Implementação:
Desenvolver as funções não implementadas.  
Implementar graficos automatizados baseados nos valores do banco de dados.  
Melhorias no front-end, aplicação de frameworks e outras ferramentas.  
Realizar testes unitários, de integração e de aceitação.  


## Documentação:
Criar a documentação do sistema, incluindo manual do usuário e documentação técnica.  

## Deploy:
Configurar a infraestrutura necessária para o deploy do sistema na web.  
Implementar práticas de segurança e backup.  
