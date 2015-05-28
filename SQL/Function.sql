create or replace function lucro (data1 date, data2 date) return integer is

declare v_result integer;
begin
	select (SUM(M.valor) - y.somaCompra) into v_result from (select SUM(valor) as somaCompra 
	from movimentacao where tipo = 'c' and data_movimentacao between data1 and data2) y, 
	movimentacao M where M.tipo = 'v' and M.data_movimentacao between data1 and data2;		

	return v_result;
end;