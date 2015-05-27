DELIMITER $$

USE projetobd$$

DROP TRIGGER IF EXISTS verifica_autorizacao_compra$$
CREATE TRIGGER verifica_autorizacao_compra BEFORE INSERT
ON movimentacao
FOR EACH ROW
BEGIN
	DECLARE funcao VARCHAR(20);
	-- se for uma compra
	IF NEW.tipo = 'c' THEN
		SET funcao := (SELECT FN.nome FROM funcao FN JOIN funcionario F ON F.funcao = FN.nome);
        -- se o funcionário não for gerente
        IF strcomp(funcao, 'gerente') <> 0 THEN
			SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Funcionário não possui autorização para realizar compra.';
        END IF;
    END IF;
END$$

DELIMITER ;
