BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "produtos" (
	"id"	INTEGER NOT NULL,
	"nome"	TEXT NOT NULL,
	"marca"	TEXT,
	"modelo"	TEXT,
	"categoria"	TEXT NOT NULL,
	"unidade_medida"	TEXT,
	"medida"	TEXT,
	"preco_compra"	REAL NOT NULL,
	"preco_venda"	REAL NOT NULL,
	"imposto"	REAL NOT NULL,
	"desconto_maximo"	REAL NOT NULL,
	"descricao"	TEXT NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "fornecedores" (
	"nome"	TEXT NOT NULL,
	"cnpj"	TEXT NOT NULL,
	"endereco"	TEXT NOT NULL,
	"cidade"	TEXT NOT NULL,
	"email"	TEXT NOT NULL,
	"telefone"	TEXT NOT NULL,
	PRIMARY KEY("cnpj")
);
CREATE TABLE IF NOT EXISTS "cargos" (
	"cargo"	TEXT NOT NULL,
	"nivel_de_permisao"	INTEGER NOT NULL,
	"id_cargo"	INTEGER NOT NULL,
	PRIMARY KEY("id_cargo")
);
CREATE TABLE IF NOT EXISTS "cotacao" (
	"id_cotacao"	INTEGER NOT NULL,
	"produto_id"	INTEGER NOT NULL,
	"fornecedor"	TEXT NOT NULL,
	"preco_compra"	REAL NOT NULL,
	"data"	TEXT NOT NULL,
	FOREIGN KEY("produto_id") REFERENCES "produtos"("id"),
	FOREIGN KEY("fornecedor") REFERENCES "fornecedores"("cnpj"),
	PRIMARY KEY("id_cotacao" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "mensagens" (
	"cpf_remente"	TEXT NOT NULL,
	"cpf_destinatario"	TEXT NOT NULL,
	"data_hora"	TEXT NOT NULL,
	"mensagem"	TEXT NOT NULL,
	FOREIGN KEY("cpf_destinatario") REFERENCES "funcionarios"("id"),
	FOREIGN KEY("cpf_remente") REFERENCES "funcionarios"("id"),
	PRIMARY KEY("cpf_remente","cpf_destinatario","data_hora")
);
CREATE TABLE IF NOT EXISTS "notificacoes" (
	"cpf_remente"	TEXT NOT NULL,
	"cpf_destinatario"	TEXT NOT NULL,
	"data_hora"	TEXT NOT NULL,
	"notifcacao"	TEXT NOT NULL,
	"lido"	INTEGER NOT NULL,
	FOREIGN KEY("cpf_destinatario") REFERENCES "funcionarios"("id"),
	FOREIGN KEY("cpf_remente") REFERENCES "funcionarios"("id"),
	PRIMARY KEY("cpf_remente","cpf_destinatario","data_hora")
);
CREATE TABLE IF NOT EXISTS "funcionarios" (
	"nome"	TEXT NOT NULL,
	"sobrenome"	TEXT NOT NULL,
	"id"	TEXT NOT NULL,
	"empresa"	TEXT NOT NULL,
	"cargo"	TEXT NOT NULL,
	"email"	TEXT NOT NULL,
	FOREIGN KEY("cargo") REFERENCES "cargos"("cargo"),
	PRIMARY KEY("id")
);
COMMIT;
