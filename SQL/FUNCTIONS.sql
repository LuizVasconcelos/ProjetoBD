DELIMITER $$

USE projetobd$$

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