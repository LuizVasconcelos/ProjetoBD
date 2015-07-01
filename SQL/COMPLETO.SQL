CREATE USER 'projetobd'@'localhost' IDENTIFIED BY 'projetobd';
GRANT ALL PRIVILEGES ON * . * TO 'projetobd'@'localhost';
FLUSH PRIVILEGES;

CREATE DATABASE IF NOT EXISTS projetobd;

USE projetobd;

SET foreign_key_checks = 0;
DROP TABLE IF EXISTS ci_cookies CASCADE;
DROP TABLE IF EXISTS ci_sessions CASCADE;
SET foreign_key_checks = 1;

CREATE TABLE `ci_cookies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cookie_id` varchar(255) DEFAULT NULL,
  `netid` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `orig_page_requested` varchar(120) DEFAULT NULL,
  `php_session_id` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

DELIMITER $$

DROP PROCEDURE IF EXISTS gerar_relatorio_funcionario$$
DROP PROCEDURE IF EXISTS gerar_relatorio_estoque$$
DROP PROCEDURE IF EXISTS gerar_relatorio_movimentacao$$
DROP PROCEDURE IF EXISTS gerar_relatorio_fornecedor$$

CREATE PROCEDURE gerar_relatorio_funcionario (search varchar (20), campo varchar(10), ordenacao varchar(4))
BEGIN
    SET @query = CONCAT('SELECT F.cpf, F.nome, F.salario, FN.id AS funcao_id, FN.nome AS funcao_nome',
					' FROM funcionario F',
                    ' JOIN funcao FN ON F.funcao = FN.id',
                    ' WHERE F.cpf LIKE "%', search, '%"',
                    ' OR F.nome LIKE  "%', search, '%"',
                    ' OR F.salario LIKE  "%', search, '%"',
                    ' OR FN.nome LIKE  "%', search, '%"',
                    ' ORDER BY ', campo, ' ', ordenacao);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$

CREATE PROCEDURE gerar_relatorio_estoque (search varchar(20), campo varchar(10), ordenacao varchar(4))
BEGIN
    SET @query = CONCAT('SELECT id, nome, qtd, preco, descricao FROM produto_estoque',
                    ' WHERE id LIKE "%', search, '%"',
                    ' OR nome LIKE "%', search, '%"',
                    ' OR preco LIKE "%', search, '%"',
                    ' OR descricao LIKE "%', search, '%"',
                    ' ORDER BY ', campo, ' ', ordenacao);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$

CREATE PROCEDURE gerar_relatorio_fornecedor (search varchar(20), campo varchar(10), ordenacao varchar(4))
BEGIN
    SET @query = CONCAT('SELECT cnpj, nome FROM fornecedor',
                    ' WHERE cnpj LIKE "%', search, '%"',
                    ' OR nome LIKE "%', search, '%"',
                    ' ORDER BY ', campo, ' ', ordenacao);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$

CREATE PROCEDURE gerar_relatorio_movimentacao (search varchar(20), campo varchar(10), ordenacao varchar(4), data_inicial date, data_final date)
BEGIN
    SET @query = CONCAT('SELECT id, descricao, valor, tipo, data_movimentacao, cpf FROM movimentacao',
                    ' WHERE data_movimentacao BETWEEN ', data_inicial, ' AND ', data_final,
                    ' OR id LIKE "%', search, '%"',
                    ' OR descricao LIKE "%', search, '%"',
                    ' OR valor LIKE "%', search, '%"',
                    ' OR tipo LIKE "%', search, '%"',
                    ' OR data_movimentacao LIKE "%', search, '%"',
                    ' OR cpf LIKE "%', search, '%"',
                    ' ORDER BY ', campo, ' ', ordenacao);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$

DELIMITER ;

DELIMITER $$

DROP TRIGGER IF EXISTS verifica_autorizacao_compra$$
DROP TRIGGER IF EXISTS atualiza_quantidade_estoque$$

CREATE TRIGGER verifica_autorizacao_compra BEFORE INSERT
ON movimentacao
FOR EACH ROW
BEGIN
	DECLARE funcao VARCHAR(20);
	-- se for uma compra
	IF NEW.tipo = 'c' THEN
		SET funcao := (SELECT FN.nome FROM funcao FN JOIN funcionario F ON F.funcao = FN.id WHERE F.cpf = NEW.cpf);
        -- se o funcionário não for gerente
        IF STRCMP(LOWER(funcao), 'gerente') <> 0 THEN
			SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Funcionário não possui autorização para realizar compra.';
        END IF;
    END IF;
END$$

CREATE TRIGGER atualiza_quantidade_estoque AFTER INSERT
ON estoque_movimentacao
FOR EACH ROW
BEGIN
	DECLARE quantidade INT(20);
    DECLARE tipo ENUM('c', 'v');
    
    SET tipo := (SELECT tipo FROM movimentacao WHERE id = NEW.id_movimentacao);
	SET quantidade := (SELECT qtd FROM produto_estoque WHERE id = NEW.id_produto);
    
    IF tipo = 'c' THEN
        -- compra
        SET quantidade := quantidade + NEW.qtd;
	ELSE
    	-- venda
        SET quantidade := quantidade - NEW.qtd;
	END IF;
    
    UPDATE produto_estoque SET qtd = quantidade WHERE id = NEW.id_produto;
END$$

DELIMITER ;

DELIMITER $$

DROP FUNCTION IF EXISTS lucro$$

CREATE FUNCTION lucro (data1 date, data2 date) RETURNS INT
DETERMINISTIC
BEGIN
	DECLARE v_result INT;
    SET v_result :=  (SELECT (SUM(M.valor) - y.somaCompra) FROM (
		SELECT SUM(valor) AS somaCompra FROM movimentacao
        WHERE tipo = 'c' AND data_movimentacao BETWEEN data1 AND data2
	) y, movimentacao M WHERE M.tipo = 'v' AND M.data_movimentacao BETWEEN data1 AND data2);

	RETURN v_result;
end$$

DELIMITER ;

INSERT INTO funcao (id, nome) VALUES (1, 'Vendedor');
INSERT INTO funcao (id, nome) VALUES (2, 'Gerente');
INSERT INTO funcao (id, nome) VALUES (3, 'Entregador');

INSERT INTO funcionario (cpf, nome, salario, senha, funcao) VALUES (10000000000, 'Pedro', 200.22, '1234', 1);
INSERT INTO funcionario (cpf, nome, salario, senha, funcao) VALUES (20000000000, 'Luis', 500.21, '1234', 1);
INSERT INTO funcionario (cpf, nome, salario, senha, funcao) VALUES (30000000000, 'Maria', 400.12, '1234', 2);
INSERT INTO funcionario (cpf, nome, salario, senha, funcao) VALUES (40000000000, 'Ricardo', 100.22, '1234', 3);
INSERT INTO funcionario (cpf, nome, salario, senha, funcao) VALUES (50000000000, 'Lucia', 100.22, '1234', 3);
INSERT INTO funcionario (cpf, nome, salario, senha, funcao) VALUES (60000000000, 'Joao', 400.12, '1234', 1);

INSERT INTO codigos_telefone (id, codigo) VALUES (1, 11);
INSERT INTO codigos_telefone (id, codigo) VALUES (2, 12);
INSERT INTO codigos_telefone (id, codigo) VALUES (3, 13);
INSERT INTO codigos_telefone (id, codigo) VALUES (4, 14);
INSERT INTO codigos_telefone (id, codigo) VALUES (5, 15);
INSERT INTO codigos_telefone (id, codigo) VALUES (6, 16);
INSERT INTO codigos_telefone (id, codigo) VALUES (7, 17);
INSERT INTO codigos_telefone (id, codigo) VALUES (8, 18);
INSERT INTO codigos_telefone (id, codigo) VALUES (9, 19);
INSERT INTO codigos_telefone (id, codigo) VALUES (10, 21);
INSERT INTO codigos_telefone (id, codigo) VALUES (11, 22);
INSERT INTO codigos_telefone (id, codigo) VALUES (12, 24);
INSERT INTO codigos_telefone (id, codigo) VALUES (13, 27);
INSERT INTO codigos_telefone (id, codigo) VALUES (14, 28);
INSERT INTO codigos_telefone (id, codigo) VALUES (15, 31);
INSERT INTO codigos_telefone (id, codigo) VALUES (16, 33);
INSERT INTO codigos_telefone (id, codigo) VALUES (17, 34);
INSERT INTO codigos_telefone (id, codigo) VALUES (18, 35);
INSERT INTO codigos_telefone (id, codigo) VALUES (19, 37);
INSERT INTO codigos_telefone (id, codigo) VALUES (20, 38);
INSERT INTO codigos_telefone (id, codigo) VALUES (21, 41);
INSERT INTO codigos_telefone (id, codigo) VALUES (22, 42);
INSERT INTO codigos_telefone (id, codigo) VALUES (23, 43);
INSERT INTO codigos_telefone (id, codigo) VALUES (24, 44);
INSERT INTO codigos_telefone (id, codigo) VALUES (25, 45);
INSERT INTO codigos_telefone (id, codigo) VALUES (26, 46);
INSERT INTO codigos_telefone (id, codigo) VALUES (27, 48);
INSERT INTO codigos_telefone (id, codigo) VALUES (28, 49);
INSERT INTO codigos_telefone (id, codigo) VALUES (29, 51);
INSERT INTO codigos_telefone (id, codigo) VALUES (30, 53);
INSERT INTO codigos_telefone (id, codigo) VALUES (31, 54);
INSERT INTO codigos_telefone (id, codigo) VALUES (32, 55);
INSERT INTO codigos_telefone (id, codigo) VALUES (33, 61);
INSERT INTO codigos_telefone (id, codigo) VALUES (34, 62);
INSERT INTO codigos_telefone (id, codigo) VALUES (35, 63);
INSERT INTO codigos_telefone (id, codigo) VALUES (36, 64);
INSERT INTO codigos_telefone (id, codigo) VALUES (37, 65);
INSERT INTO codigos_telefone (id, codigo) VALUES (38, 66);
INSERT INTO codigos_telefone (id, codigo) VALUES (39, 67);
INSERT INTO codigos_telefone (id, codigo) VALUES (40, 68);
INSERT INTO codigos_telefone (id, codigo) VALUES (41, 69);
INSERT INTO codigos_telefone (id, codigo) VALUES (42, 71);
INSERT INTO codigos_telefone (id, codigo) VALUES (43, 73);
INSERT INTO codigos_telefone (id, codigo) VALUES (44, 74);
INSERT INTO codigos_telefone (id, codigo) VALUES (45, 75);
INSERT INTO codigos_telefone (id, codigo) VALUES (46, 77);
INSERT INTO codigos_telefone (id, codigo) VALUES (47, 79);
INSERT INTO codigos_telefone (id, codigo) VALUES (48, 81);
INSERT INTO codigos_telefone (id, codigo) VALUES (49, 82);
INSERT INTO codigos_telefone (id, codigo) VALUES (50, 83);
INSERT INTO codigos_telefone (id, codigo) VALUES (51, 84);
INSERT INTO codigos_telefone (id, codigo) VALUES (52, 85);
INSERT INTO codigos_telefone (id, codigo) VALUES (53, 86);
INSERT INTO codigos_telefone (id, codigo) VALUES (54, 87);
INSERT INTO codigos_telefone (id, codigo) VALUES (55, 88);
INSERT INTO codigos_telefone (id, codigo) VALUES (56, 89);
INSERT INTO codigos_telefone (id, codigo) VALUES (57, 91);
INSERT INTO codigos_telefone (id, codigo) VALUES (58, 92);
INSERT INTO codigos_telefone (id, codigo) VALUES (59, 93);
INSERT INTO codigos_telefone (id, codigo) VALUES (60, 94);
INSERT INTO codigos_telefone (id, codigo) VALUES (61, 95);
INSERT INTO codigos_telefone (id, codigo) VALUES (62, 96);
INSERT INTO codigos_telefone (id, codigo) VALUES (63, 97);
INSERT INTO codigos_telefone (id, codigo) VALUES (64, 98);
INSERT INTO codigos_telefone (id, codigo) VALUES (65, 99);

INSERT INTO telefone_funcionario(cpf,codigo, numero) VALUES (10000000000,1,37758490);
INSERT INTO telefone_funcionario(cpf,codigo, numero) VALUES (10000000000,1,87258196);
INSERT INTO telefone_funcionario(cpf,codigo, numero) VALUES (20000000000,1,32798130);
INSERT INTO telefone_funcionario(cpf,codigo, numero) VALUES (30000000000,1,34218400);
INSERT INTO telefone_funcionario(cpf,codigo, numero) VALUES (40000000000,1,32718250);
INSERT INTO telefone_funcionario(cpf,codigo, numero) VALUES (50000000000,1,30708100);
INSERT INTO telefone_funcionario(cpf,codigo, numero) VALUES (50000000000,1,86251420);
INSERT INTO telefone_funcionario(cpf,codigo, numero) VALUES (60000000000,1,33018450);
INSERT INTO telefone_funcionario(cpf,codigo, numero) VALUES (60000000000,1,92732780);

INSERT INTO fornecedor(cnpj, nome) VALUES(800000000000,'petrobras');
INSERT INTO fornecedor(cnpj, nome) VALUES(900000000000,'gastudo');
INSERT INTO fornecedor(cnpj, nome) VALUES(880000000000,'vivergas');
INSERT INTO fornecedor(cnpj, nome) VALUES(990000000000,'gasgasgas');
INSERT INTO fornecedor(cnpj, nome) VALUES(770000000000,'gastotal');

INSERT INTO telefone_fornecedor(cnpj,codigo,numero) VALUES (800000000000,1,32259640);
INSERT INTO telefone_fornecedor(cnpj,codigo,numero) VALUES (800000000000,1,32004750);
INSERT INTO telefone_fornecedor(cnpj,codigo,numero) VALUES (900000000000,1,33748301);
INSERT INTO telefone_fornecedor(cnpj,codigo,numero) VALUES (880000000000,1,39947503);
INSERT INTO telefone_fornecedor(cnpj,codigo,numero) VALUES (880000000000,1,30387572);
INSERT INTO telefone_fornecedor(cnpj,codigo,numero) VALUES (990000000000,1,36588429);
INSERT INTO telefone_fornecedor(cnpj,codigo,numero) VALUES (770000000000,1,39837341);
INSERT INTO telefone_fornecedor(cnpj,codigo,numero) VALUES (770000000000,1,39949850);

INSERT INTO produto_estoque(id,nome,qtd,descricao,preco) VALUES (1,'botijao',50,'11kg azul',13.50);
INSERT INTO produto_estoque(id,nome,qtd,descricao,preco) VALUES (2,'botijao',25,'13kg cinza',19.30);
INSERT INTO produto_estoque(id,nome,qtd,descricao,preco) VALUES (3,'mangueira',20,'marca1',10.50);
INSERT INTO produto_estoque(id,nome,qtd,descricao,preco) VALUES (4,'mangueira',18,'marca2',9.70);
INSERT INTO produto_estoque(id,nome,qtd,descricao,preco) VALUES (5,'suporte',5,'marca1',20.00);
INSERT INTO produto_estoque(id,nome,qtd,descricao,preco) VALUES (6,'suporte',7,'marca2',35.00);
INSERT INTO produto_estoque(id,nome,qtd,descricao,preco) VALUES (7,'regulador pressao',5,'marca1',13.50);
INSERT INTO produto_estoque(id,nome,qtd,descricao,preco) VALUES (8,'regulador pressao',2,'marca2',12.50);

INSERT INTO fornecedor_produto(id,cnpj) VALUES (1,800000000000);
INSERT INTO fornecedor_produto(id,cnpj) VALUES (1,880000000000);
INSERT INTO fornecedor_produto(id,cnpj) VALUES (3,900000000000);
INSERT INTO fornecedor_produto(id,cnpj) VALUES (4,900000000000);
INSERT INTO fornecedor_produto(id,cnpj) VALUES (5,800000000000);
INSERT INTO fornecedor_produto(id,cnpj) VALUES (1,770000000000);
INSERT INTO fornecedor_produto(id,cnpj) VALUES (2,990000000000);
INSERT INTO fornecedor_produto(id,cnpj) VALUES (2,800000000000);
INSERT INTO fornecedor_produto(id,cnpj) VALUES (6,800000000000);
INSERT INTO fornecedor_produto(id,cnpj) VALUES (7,990000000000);
INSERT INTO fornecedor_produto(id,cnpj) VALUES (8,990000000000);

INSERT INTO movimentacao (id,descricao, valor, tipo, data_movimentacao, cpf) VALUES (1,	'ventilador', 40.00, 'c',STR_TO_DATE('01,5,2015','%d,%m,%Y'),30000000000);
INSERT INTO movimentacao (id,descricao, valor, tipo, data_movimentacao, cpf) VALUES (2,	'computador', 1500.00, 'c',STR_TO_DATE('01,5,2015','%d,%m,%Y'),30000000000);
INSERT INTO movimentacao (id,descricao, valor, tipo, data_movimentacao, cpf) VALUES (3,	NULL, 29.80, 'v',STR_TO_DATE('02,5,2015','%d,%m,%Y'),20000000000);
INSERT INTO movimentacao (id,descricao, valor, tipo, data_movimentacao, cpf) VALUES (4,	NULL, 47.00, 'v',STR_TO_DATE('02,5,2015','%d,%m,%Y'),30000000000);
INSERT INTO movimentacao (id,descricao, valor, tipo, data_movimentacao, cpf) VALUES (5,	NULL, 38.60, 'v',STR_TO_DATE('02,5,2015','%d,%m,%Y'),20000000000);
INSERT INTO movimentacao (id,descricao, valor, tipo, data_movimentacao, cpf) VALUES (6,	NULL, 40.00, 'c',STR_TO_DATE('03,5,2015','%d,%m,%Y'),30000000000);
INSERT INTO movimentacao (id,descricao, valor, tipo, data_movimentacao, cpf) VALUES (7,	NULL, 19.30, 'v',STR_TO_DATE('03,5,2015','%d,%m,%Y'),20000000000);
INSERT INTO movimentacao (id,descricao, valor, tipo, data_movimentacao, cpf) VALUES (8,	'extintor', 150.00, 'c',STR_TO_DATE('04,5,2015','%d,%m,%Y'),30000000000);
INSERT INTO movimentacao (id,descricao, valor, tipo, data_movimentacao, cpf) VALUES (9,	NULL, 29.80, 'v',STR_TO_DATE('05,5,2015','%d,%m,%Y'),20000000000);

INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (2,3,1);
INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (3,3,1);
INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (2,4,1);
INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (1,4,1);
INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (5,4,1);
INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (7,4,1);
INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (1,5,2);
INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (5,6,2);
INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (3,7,1);
INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (2,7,1);
INSERT INTO estoque_movimentacao (id_produto, id_movimentacao, qtd) VALUES (2,9,1);
