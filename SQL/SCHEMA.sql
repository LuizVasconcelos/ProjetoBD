USE projetobd;

SET foreign_key_checks = 0;
DROP TABLE IF EXISTS funcao CASCADE;
DROP TABLE IF EXISTS funcionario CASCADE;
DROP TABLE IF EXISTS codigos_telefone CASCADE;
DROP TABLE IF EXISTS telefone_funcionario CASCADE;
DROP TABLE IF EXISTS fornecedor CASCADE;
DROP TABLE IF EXISTS telefone_fornecedor CASCADE;
DROP TABLE IF EXISTS produto_estoque CASCADE;
DROP TABLE IF EXISTS fornecedor_produto CASCADE;
DROP TABLE IF EXISTS movimentacao CASCADE;
DROP TABLE IF EXISTS estoque_movimentacao CASCADE;
SET foreign_key_checks = 1;

CREATE TABLE funcao(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(20)
);

CREATE TABLE funcionario(
	cpf BIGINT PRIMARY KEY,
    nome VARCHAR(100),
    salario FLOAT,
    senha VARCHAR(20),
    funcao INT,
    FOREIGN KEY (funcao) REFERENCES funcao (id)
);

CREATE TABLE codigos_telefone(
	id INT PRIMARY KEY AUTO_INCREMENT,
    codigo INT
);

CREATE TABLE telefone_funcionario(
	cpf BIGINT,
	codigo INT,
	numero INT,
    PRIMARY KEY (cpf, numero),
	FOREIGN KEY (cpf) REFERENCES funcionario(cpf),
	FOREIGN KEY (codigo) REFERENCES codigos_telefone(id)
);

CREATE TABLE fornecedor(
	cnpj BIGINT PRIMARY KEY,
    nome VARCHAR(100)
);

CREATE TABLE telefone_fornecedor(
	cnpj BIGINT,
	codigo INT,
	numero INT,
    PRIMARY KEY (cnpj, numero),
	FOREIGN KEY (cnpj) REFERENCES fornecedor(cnpj),
	FOREIGN KEY (codigo) REFERENCES codigos_telefone(id)
);



CREATE TABLE produto_estoque(
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50),
    qtd INT,
    descricao TEXT,
    preco FLOAT
);

CREATE TABLE fornecedor_produto(
	id INT,
    cnpj BIGINT,
    PRIMARY KEY (id, cnpj),
    FOREIGN KEY (cnpj) REFERENCES fornecedor(cnpj),
    FOREIGN KEY (id) REFERENCES produto_estoque(id)
);

CREATE TABLE movimentacao(
	id INT PRIMARY KEY AUTO_INCREMENT,
	descricao TEXT,
	valor FLOAT,
	tipo ENUM('c','v'),
	data_movimentacao DATE,
	cpf BIGINT,
	FOREIGN KEY (cpf) REFERENCES funcionario(cpf)
);

CREATE TABLE estoque_movimentacao(
	id_produto INT,
    id_movimentacao INT,
    qtd INT,
    PRIMARY KEY (id_produto, id_movimentacao),
    FOREIGN KEY (id_produto) REFERENCES produto_estoque(id),
    FOREIGN KEY (id_movimentacao) REFERENCES movimentacao(id)
);
