DELIMITER $$

USE projetobd$$

DROP PROCEDURE IF EXISTS gerar_relatorio_funcionario$$
DROP PROCEDURE IF EXISTS gerar_relatorio_estoque$$
DROP PROCEDURE IF EXISTS gerar_relatorio_movimentacao$$

CREATE PROCEDURE gerar_relatorio_funcionario (search varchar (20), campo varchar(10), ordenacao varchar(4))
BEGIN
    SET @query = CONCAT('SELECT cpf, nome, salario, funcao FROM funcionario',
                    ' ORDER BY ', campo, ' ', ordenacao,
                    ' WHERE cpf LIKE \'%', search, '%\'',
                    ' OR nome LIKE  \'%', search, '%\'',
                    ' OR salario LIKE  \'%', search, '%\'',
                    ' OR funcao LIKE  \'%', search, '%\'');
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$

CREATE PROCEDURE gerar_relatorio_estoque (campo varchar(10), ordenacao varchar(4))
BEGIN
    SET @query = CONCAT('SELECT id, nome, quantidade, preco, descricao FROM produto_estoque ORDER BY ',
                    campo, ' ', ordenacao);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$

CREATE PROCEDURE gerar_relatorio_movimentacao (campo varchar(10), ordenacao varchar(4), data_inicio date, data_final date)
BEGIN
    SET @query = CONCAT('SELECT id, nome, quantidade, preco, descricao FROM produto_estoque WHERE data_movimentacao BETWEEN ', data_inicial, ' AND ', data_final, ' ORDER BY ', campo, ' ', ordenacao);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$

DELIMITER ;