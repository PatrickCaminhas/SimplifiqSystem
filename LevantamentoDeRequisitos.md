# Requisitos Funcionais
## 1. Gerenciamento de Empresas
Cadastro de Empresas:  
O sistema deve permitir o cadastro de empresas com as seguintes informações: nome, CNPJ, tamanho da empresa (MEI, pequena empresa ou micro empresa), tipo de empresa (ramo de atuação), e telefone.  

Leitura de Empresas:  
O sistema deve permitir a consulta das informações cadastradas de cada empresa.  
## 2. Gerenciamento de Funcionários
Cadastro de Funcionários:  
O sistema deve permitir o cadastro de funcionários com as seguintes informações: nome, sobrenome, cargo, email, CNPJ da empresa em que trabalha (chave estrangeira), e senha.  

Leitura de Funcionários:  
O sistema deve permitir a consulta das informações de cada funcionário.  

Controle de Acesso:  
O sistema deve permitir ao administrador da empresa definir e alterar os cargos dos funcionários, modificando suas permissões de acesso e operação no sistema (leitura, cadastro, alteração).  

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
O sistema deve permitir a consulta de dados adicionais da empresa, tais como lucro mensal, produto mais vendido, produto mais rentável, produto menos vendido, entre outras informações.  

# Requisitos Não Funcionais
## 1. Segurança
Autenticação e Autorização:  
O sistema deve garantir que apenas usuários autenticados possam acessar o sistema.  
O sistema deve implementar controles de autorização para garantir que os usuários só possam acessar funcionalidades e dados conforme suas permissões.  

Isolamento de Dados:  
Cada empresa deve ter seu próprio banco de dados para evitar o vazamento de dados entre empresas diferentes.  

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

Backup e Recuperação:  
O sistema deve ter mecanismos de backup e recuperação para garantir a integridade dos dados em caso de falha.  

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
    1 - Calendario controle de metas.  
    2 - Balanço financeiro de entradas e saidas.  
    3 - Gestão de inventario  
    4 - Envio de mensagens entre funcionarios.  
    5 - Envio de notificações para funcionarios.  
    6 - Controle de folha de pagamento.  
    7 - Gestão de benefícios e férias.  
    8 - Informativo de proximas contas.  
    9 - Informativo de ultimas atividades (ultimas alterações no sistema).  


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