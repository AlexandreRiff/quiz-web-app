use quiz;

INSERT INTO
	quiz_user (email, password)
VALUES
	(
		'admin@email.com',
		'$2y$10$mzw1V73G1qSTzomtH3TrJeadauqn4kA7yA.hz5rtVAsPsJhE1PvWu' -- admin
	);

INSERT INTO
	quiz_question (
		id,
		question_text,
		category,
		correct_answer_alternative
	)
VALUES
	-- HTML
	(
		1,
		'Como que todo código de HTML começa ?',
		'HTML',
		'A'
	),
	(
		2,
		'Escolha o elemento HTML correto para o maior cabeçalho:',
		'HTML',
		'A'
	),
	(
		3,
		'Escolha o elemento HTML correto para definir o texto importante:',
		'HTML',
		'D'
	),
	(
		4,
		'Como você pode fazer uma lista numerada?',
		'HTML',
		'B'
	),
	(
		5,
		'Qual é o HTML correto para fazer uma caixa de seleção?',
		'HTML',
		'A'
	),
	-- CSS
	(6, 'Qual é a sintaxe CSS correta?', 'CSS', 'A'),
	(
		7,
		'Como você faz com que cada palavra em um texto comece com uma letra maiúscula?',
		'CSS',
		'A'
	),
	(
		8,
		'Qual propriedade CSS controla o tamanho do texto?',
		'CSS',
		'B'
	),
	(
		9,
		'Qual é a sintaxe CSS correta para tornar todos os elementos <p> em negrito?',
		'CSS',
		'D'
	),
	(
		10,
		'Como você exibe hiperlinks sem um sublinhado?',
		'CSS',
		'B'
	);

INSERT INTO
	quiz_answer_alternatives (question_id, alternative, answer)
VALUES
	(1, 'A', '<!DOCTYPE html>'),
	(1, 'B', '<start>'),
	(1, 'C', '<head>'),
	(1, 'D', '<html>'),
	(2, 'A', '<h1>'),
	(2, 'B', '<head>'),
	(2, 'C', '<h6>'),
	(2, 'D', '<heading>'),
	(3, 'A', '<i>'),
	(3, 'B', '<b>'),
	(3, 'C', '<important>'),
	(3, 'D', '<strong>'),
	(4, 'A', '<dl>'),
	(4, 'B', '<ol>'),
	(4, 'C', '<ul>'),
	(4, 'D', '<list>'),
	(5, 'A', '<input type="checkbox">'),
	(5, 'B', '<check>'),
	(5, 'C', '<input type="check">'),
	(5, 'D', '<checkbox>'),
	(6, 'A', 'body { color: black; }'),
	(6, 'B', '{ body: color=black; }'),
	(6, 'C', '{ body; color: black; }'),
	(6, 'D', 'body: color=black;'),
	(7, 'A', 'text-transform: capitalize'),
	(7, 'B', 'transform: capitalize'),
	(7, 'C', 'text-style: capitalize'),
	(7, 'D', 'font-transform: capitalize'),
	(8, 'A', 'text-size'),
	(8, 'B', 'font-size'),
	(8, 'C', 'text-style'),
	(8, 'D', 'font-style'),
	(9, 'A', '<p style="text-size: bold;">'),
	(9, 'B', 'p { text-size: bold; }'),
	(9, 'C', '<p style="font-size: bold;">'),
	(9, 'D', 'p { font-weight: bold; }'),
	(10, 'A', 'a { decoration: no-underline; }'),
	(10, 'B', 'a { text-decoration: none; }'),
	(10, 'C', 'a { underline: none; }'),
	(10, 'D', 'a { text-decoration: no-underline; }');
