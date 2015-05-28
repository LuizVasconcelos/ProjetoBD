USE projetobd;

INSERT INTO funcao(nome) VALUES ('vendedor');
INSERT INTO funcao(nome) VALUES ('gerente');
INSERT INTO funcao(nome) VALUES ('entregador');

INSERT INTO funcionario (cpf,nome,salario,senha,funcao) VALUES (10000000000,'Pedro',200.22,'1234','vendedor');
INSERT INTO funcionario (cpf,nome,salario,senha,funcao) VALUES (20000000000,'Luis',500.21,'1234','vendedor');
INSERT INTO funcionario (cpf,nome,salario,senha,funcao) VALUES (30000000000,'Maria',400.12,'1234','gerente');
INSERT INTO funcionario (cpf,nome,salario,senha,funcao) VALUES (40000000000,'Ricardo',100.22,'1234','entregador');
INSERT INTO funcionario (cpf,nome,salario,senha,funcao) VALUES (50000000000,'Lucia',100.22,'1234','entregador');
INSERT INTO funcionario (cpf,nome,salario,senha,funcao) VALUES (60000000000,'Joao',400.12,'1234','vendedor');


INSERT INTO telefone_funcionario(cpf,numero) VALUES (10000000000,37758490);
INSERT INTO telefone_funcionario(cpf,numero) VALUES (10000000000,87258196);
INSERT INTO telefone_funcionario(cpf,numero) VALUES (20000000000,32798130);
INSERT INTO telefone_funcionario(cpf,numero) VALUES (30000000000,34218400);
INSERT INTO telefone_funcionario(cpf,numero) VALUES (40000000000,32718250);
INSERT INTO telefone_funcionario(cpf,numero) VALUES (50000000000,30708100);
INSERT INTO telefone_funcionario(cpf,numero) VALUES (50000000000,86251420);
INSERT INTO telefone_funcionario(cpf,numero) VALUES (60000000000,33018450);
INSERT INTO telefone_funcionario(cpf,numero) VALUES (60000000000,92732780);




INSERT INTO fornecedor(cnpj, nome) VALUES(800000000000,'petrobras');
INSERT INTO fornecedor(cnpj, nome) VALUES(900000000000,'gastudo');
INSERT INTO fornecedor(cnpj, nome) VALUES(880000000000,'vivergas');
INSERT INTO fornecedor(cnpj, nome) VALUES(990000000000,'gasgasgas');
INSERT INTO fornecedor(cnpj, nome) VALUES(770000000000,'gastotal');



INSERT INTO telefone_fornecedor(cnpj,numero) VALUES (800000000000,32259640);
INSERT INTO telefone_fornecedor(cnpj,numero) VALUES (800000000000,32004750);
INSERT INTO telefone_fornecedor(cnpj,numero) VALUES (900000000000,33748301);
INSERT INTO telefone_fornecedor(cnpj,numero) VALUES (880000000000,39947503);
INSERT INTO telefone_fornecedor(cnpj,numero) VALUES (880000000000,30387572);
INSERT INTO telefone_fornecedor(cnpj,numero) VALUES (990000000000,36588429);
INSERT INTO telefone_fornecedor(cnpj,numero) VALUES (770000000000,39837341);
INSERT INTO telefone_fornecedor(cnpj,numero) VALUES (770000000000,39949850);


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
