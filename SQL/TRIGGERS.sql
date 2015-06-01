DELIMITER $$

USE projetobd$$

DROP TRIGGER IF EXISTS verifica_autorizacao_compra$$
DROP TRIGGER IF EXISTS atualiza_quantidade_estoque$$

CREATE TRIGGER verifica_autorizacao_compra BEFORE INSERT
ON movimentacao
FOR EACH ROW
BEGIN
	DECLARE funcao VARCHAR(20);
	-- se for uma compra
	IF NEW.tipo = 'c' THEN
		SET funcao := (SELECT FN.nome FROM funcao FN JOIN funcionario F ON F.funcao = FN.nome WHERE F.cpf = NEW.cpf);
        -- se o funcionário não for gerente
        IF STRCMP(funcao, 'gerente') <> 0 THEN
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
