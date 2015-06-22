DELIMITER $$

USE projetobd$$

DROP PROCEDURE IF EXISTS gerar_relatorio_funcionario$$
DROP PROCEDURE IF EXISTS gerar_relatorio_estoque$$
DROP PROCEDURE IF EXISTS gerar_relatorio_movimentacao$$
DROP PROCEDURE IF EXISTS gerar_relatorio_fornecedor$$

CREATE PROCEDURE gerar_relatorio_funcionario (search varchar (20), campo varchar(10), ordenacao varchar(4))
BEGIN
    SET @query = CONCAT('SELECT F.cpf, F.nome, F.salario, FN.id as funcao_id, FN.nome as funcao_nome',
					' FROM funcionario F',
                    ' JOIN funcao FN ON F.funcao AS FN.id',
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