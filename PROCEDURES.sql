DELIMITER $$

USE projetobd$$

DROP PROCEDURE IF EXISTS gerar_relatorio_funcionario$$
DROP PROCEDURE IF EXISTS gerar_relatorio_estoque$$

CREATE PROCEDURE gerar_relatorio_funcionario (campo varchar(10), ordenacao varchar(4))
BEGIN
    SET @query = CONCAT('SELECT cpf, nome, salario, funcao FROM funcionario ORDER BY ', campo, ' ', ordenacao);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$

CREATE PROCEDURE gerar_relatorio_estoque (campo varchar(10), ordenacao varchar(4))
BEGIN
    SET @query = CONCAT('SELECT id, nome, quantidade, preco, descricao FROM produto_estoque ORDER BY ', campo, ' ', ordenacao);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$

DELIMITER ;