#CREATE USER 'projetobd'@'localhost' IDENTIFIED BY 'projetobd';
#GRANT ALL PRIVILEGES ON * . * TO 'projetobd'@'localhost';
#FLUSH PRIVILEGES;

#CREATE DATABASE IF NOT EXISTS projetobd;

USE projetobd;
SET foreign_key_checks = 0;

DROP TABLE IF EXISTS funcao CASCADE;
DROP TABLE IF EXISTS funcionario CASCADE;
DROP TABLE IF EXISTS telefone_funcionario CASCADE;
DROP TABLE IF EXISTS fornecedor CASCADE;
DROP TABLE IF EXISTS telefone_fornecedor CASCADE;
DROP TABLE IF EXISTS produto_estoque CASCADE;
DROP TABLE IF EXISTS fornecedor_produto CASCADE;
DROP TABLE IF EXISTS movimentacao CASCADE;
DROP TABLE IF EXISTS estoque_movimentacao CASCADE;

SET foreign_key_checks = 1;



CREATE TABLE funcao(
	nome VARCHAR(20) PRIMARY KEY
);




CREATE TABLE funcionario(
	cpf INT PRIMARY KEY,
    nome VARCHAR(100),
    salario FLOAT,
    senha VARCHAR(20),
    funcao VARCHAR(20),
    FOREIGN KEY (funcao) REFERENCES funcao(nome)
);



CREATE TABLE telefone_funcionario(
	cpf INT,
	numero INT,
    PRIMARY KEY (cpf, numero),
	FOREIGN KEY (cpf) REFERENCES funcionario(cpf)
);



CREATE TABLE fornecedor(
	cnpj INT PRIMARY KEY,
    nome VARCHAR(100)
);



CREATE TABLE telefone_fornecedor(
	cnpj INT,
	numero INT,
    PRIMARY KEY (cnpj, numero),
	FOREIGN KEY (cnpj) REFERENCES fornecedor(cnpj)
);



CREATE TABLE produto_estoque(
	id INT PRIMARY KEY,
    nome VARCHAR(50),
    qtd INT,
    descricao TEXT,
    preco FLOAT
);



CREATE TABLE fornecedor_produto(
	id INT,
    cnpj INT,
    PRIMARY KEY (id, cnpj),
    FOREIGN KEY (cnpj) REFERENCES fornecedor(cnpj),
    FOREIGN KEY (id) REFERENCES produto_estoque(id)
);



CREATE TABLE movimentacao(
	id INT PRIMARY KEY,
	descricao TEXT,
	valor FLOAT,
	tipo ENUM('c','v'),
	data_movimentacao DATE,
	cpf INT,
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
