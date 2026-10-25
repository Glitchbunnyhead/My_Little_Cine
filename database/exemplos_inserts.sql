INSERT INTO Usuario (nome, email, senha, cpf, data_nascimento, tipo) VALUES
('Carlos Silva', 'carlos.silva@email.com', 'senha123', '12345678901', '1995-05-10', 'cliente'),
('Ana Souza', 'ana.souza@email.com', 'minhasenha', '98765432100', '1990-12-15', 'cliente'),
('Admin Master', 'admin@cinema.com', 'admin123', '11122233344', '1985-03-20', 'administrador');

INSERT INTO Filme (titulo, sinopse, ano_lancamento, duracao_minutos, classificacao_etaria, poster) VALUES
('Duna: Parte 2', 'Paul Atreides se une a Chani e aos Fremen enquanto busca vingança contra os conspiradores que destruíram sua família.', 2024, 166, '14', 'https://upload.wikimedia.org/wikipedia/pt/5/52/Dune_Part_Two_poster.jpeg?utm_source=pt.wikipedia.org&utm_campaign=index&utm_content=original'),
('Oppenheimer', 'A história do físico americano J. Robert Oppenheimer, seu papel no Projeto Manhattan e o desenvolvimento da bomba atômica.', 2023, 180, '16', 'https://upload.wikimedia.org/wikipedia/pt/5/5b/Oppenheimer_poster.jpg?utm_source=pt.wikipedia.org&utm_campaign=index&utm_content=original'),
('Divertidamente 2', 'Alegria, Tristeza, Raiva, Medo e Nojinho se encontram com novas Emoções na mente da agora adolescente Riley.', 2024, 96, 'LIVRE', 'https://upload.wikimedia.org/wikipedia/pt/b/b3/Inside_Out_2.png?utm_source=pt.wikipedia.org&utm_campaign=index&utm_content=original');

INSERT INTO Idioma (idioma, sigla) VALUES
('Português', 'PT-BR'),
('Inglês', 'EN'),
('Espanhol', 'ES');

INSERT INTO Filme_Idioma (id_filme, id_idioma) VALUES
(1, 1), (1, 2), -- Duna: Parte 2 (PT-BR, EN)
(2, 1), (2, 2), -- Oppenheimer (PT-BR, EN)
(3, 1), (3, 2), (3, 3); -- Divertidamente 2 (PT-BR, EN, ES)

INSERT INTO Sala (nome, capacidade, tipo) VALUES
('Sala IMAX 01', 100, 'IMAX'),
('Sala VIP 02', 50, 'VIP'),
('Sala Tradicional 03', 80, '2D');

INSERT INTO Assento (fileira, numero, tipo, id_sala, estado) VALUES
('A', 1, 'comum', 1, 'livre'),
('A', 2, 'comum', 1, 'livre'),
('A', 3, 'comum', 1, 'livre'),
('A', 4, 'comum', 1, 'livre'),
('A', 5, 'comum', 1, 'livre'),
('A', 6, 'comum', 1, 'livre'),
('A', 7, 'comum', 1, 'livre'),
('A', 8, 'comum', 1, 'livre'),
('A', 9, 'comum', 1, 'livre'),
('A', 10, 'comum', 1, 'livre'),
('B', 1, 'comum', 1, 'livre'),
('B', 2, 'comum', 1, 'livre'),
('B', 3, 'comum', 1, 'livre'),
('B', 4, 'comum', 1, 'livre'),
('B', 5, 'comum', 1, 'livre'),
('B', 6, 'comum', 1, 'livre'),
('B', 7, 'comum', 1, 'livre'),
('B', 8, 'comum', 1, 'livre'),
('B', 9, 'comum', 1, 'livre'),
('B', 10, 'comum', 1, 'livre'),
('C', 1, 'comum', 1, 'livre'),
('C', 2, 'comum', 1, 'livre'),
('C', 3, 'comum', 1, 'livre'),
('C', 4, 'comum', 1, 'livre'),
('C', 5, 'comum', 1, 'livre'),
('C', 6, 'comum', 1, 'livre'),
('C', 7, 'comum', 1, 'livre'),
('C', 8, 'comum', 1, 'livre'),
('C', 9, 'comum', 1, 'livre'),
('C', 10, 'comum', 1, 'livre');

INSERT INTO Sessao (data, horario, tipo, preco, status, id_filme, id_idioma, id_sala) VALUES
('2026-06-10', '19:30:00', 'IMAX Dublado', 45.00, 'em exibição', 1, 1, 1),
('2026-06-10', '21:00:00', 'Legendado', 35.00, 'em exibição', 2, 2, 2),
('2026-06-11', '15:00:00', 'Dublado 2D', 28.00, 'em exibição', 3, 1, 3);

INSERT INTO Ingresso (tipo, preco, status, id_sessao, id_assento) VALUES
('Inteira', 45.00, 'vendido', 1, 1),
('Meia', 22.50, 'disponivel', 1, 2),
('Inteira', 35.00, 'disponivel', 2, 3);

INSERT INTO CategoriaProduto (nome, descricao) VALUES
('Bebidas', 'Refrigerantes, sucos, água e chás'),
('Alimentos', 'Pipoca, chocolates, balas e salgadinhos');

INSERT INTO Produto (nome, descricao, preco, quant_estoque, status, foto, id_categoria) VALUES
('Pipoca Média', 'Pipoca salgada amanteigada tamanho médio', 20.00, 150, 'com estoque', 'https://cdn.awsli.com.br/2500x2500/2475/2475729/produto/366945305/1f5eeb14692d786c955a70858e0ac0e1-v2r51qobgi.jpg', 2),
('Refrigerante Lata 350ml', 'Coca-Cola, Guaraná Antarctica ou Sprite', 8.50, 200, 'com estoque', 'https://naturalterra.vtexassets.com/arquivos/ids/170802-1440-auto/Refrigerante-Guarana-Antarctica-350ml.webp?v=638671094703800000&format=webp&quality=8', 1),
('Chocolate M&Ms', 'Chocolate ao leite confeitado', 10.00, 80, 'com estoque', 'https://drconsulta.com/conteudo/wp-content/uploads/2017/07/shutterstock_567494008.jpg', 2);

INSERT INTO Venda (valor_total, forma_pagamento, status, id_usuario) VALUES
(65.00, 'Cartão de Crédito', 'concluído', 1),
(28.50, 'Pix', 'concluído', 2);

INSERT INTO Item_Venda (quantidade, preco_unitario, subtotal, id_venda, id_ingresso, id_produto) VALUES
-- Venda 1: Comprou 1 Ingresso (id 1) + 1 Pipoca Média (id 1)
(1, 45.00, 45.00, 1, 1, NULL),
(1, 20.00, 20.00, 1, NULL, 1),

(1, 8.50, 8.50, 2, NULL, 2),
(1, 10.00, 10.00, 2, NULL, 3);