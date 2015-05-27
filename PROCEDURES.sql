DELIMITER $$

USE projetobd$$

DROP PROCEDURE IF EXISTS gerar_relatorio_funcionario$$

CREATE PROCEDURE gerar_relatorio_funcionario (campo varchar(10), ordenacao varchar(4))
BEGIN
    SET @query = CONCAT('SELECT cpf, nome, salario, funcao FROM funcionario ORDER BY ', campo, ' ', ordenacao);
    PREPARE stmt FROM @query;
    EXECUTE stmt;
END$$

DELIMITER ;