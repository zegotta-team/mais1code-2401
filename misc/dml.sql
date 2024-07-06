-- DML: Data Modeling Language
-- Comandos dentro do SQL que tem a finalidade de manipular os dados.
-- Ex: INSERT, UPDATE e DELETE

DELETE FROM empresa WHERE 1;
INSERT INTO empresa (id, nome, cnpj, email, descricao, logo) VALUES
(1, 'IBM', '81289818000178', 'recursos.humanos@ibm.fake.com', 'Empresa de tecnologia', 'ibm.png'),
(2, 'TechNew', '31960951000136', 'recursos.humanos@technew.com', 'Startup de tecnologia', 'tnew.png'),
(3, 'FoodFinder', '46854682000234', 'rh@foodfinder.com', 'Empresa de desenvolvimento', 'ff.png')
;

DELETE FROM filial WHERE 1;
INSERT INTO filial (id, empresa_id, nome, cep, logradouro, numero, complemento, bairro, cidade, estado) VALUES
(1, 1, 'Matriz', '05615190', 'Av Paulista', '1100', '', 'Centro', 'São Paulo', 'SP'),
(2, 1, 'Unidade Liberdade', '01905615', 'Av Liberdade', '1234', '', 'Liberdade', 'São Paulo', 'SP'),
(3, 2, 'Sede', '22222222', 'Av Belo Horizonte', '123', '2 andar', 'Pampulha', 'Belo Horizonte', 'MG'),
(4, 3, 'Central', '33333333', 'Lagoa de Freitas', '3987', 'Asa Sul', 'Tijuca', 'Rio de Janeiro', 'RJ'),
(5, 3, 'Niterói', '85236987', 'Via Amarela', '357', '', 'Maré', 'Niterói', 'RJ'),
(6, 3, 'Salvador', '12345678', 'Av Salvador', '56', '', 'Pelourinho', 'Salvador', 'BA')
;

DELETE FROM usuario WHERE 1;
INSERT INTO usuario (id, empresa_id, cpf, nome, email, senha) VALUES
(1, 1, '19143210066', 'Joao Silva', 'joao.silva@ibm.fake.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(2, 1, '05322913017', 'Maria Mara', 'maria.mara@ibm.fake.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(3, 2, '36988692096', 'Joana Silva', 'joana.silva@technew.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(4, 2, '36234827063', 'Jose Silvio', 'jose.silvio@technew.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(5, 2, '31386636053', 'Jota Jotinha', 'jota.jotinha@technew.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(6, 3, '88783818022', 'Alana Silva', 'alana@empresa.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(7, 3, '42166127096', 'Douglas Oliveira', 'douglas@empresa.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(8, 3, '80383417082', 'Edyelgue Carneiro', 'edy@empresa.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(9, 3, '00025166085', 'Kauan Nascimento', 'kauan@empresa.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(10, 3, '22972285454', 'Thiago Abreu', 'thiago@empresa.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY')
;

DELETE FROM vaga WHERE 1;
INSERT INTO vaga (id, filial_id, empresa_id, titulo, email, salario, beneficios, descricao, cargaHoraria, regimeContratacao, regimeTrabalho, nivelSenioridade, nivelHierarquia, `status`) VALUES
(1, 1, 1, 'Programador SAP ABAP', 'vaga-abap@ibm.fake.com', '10000', 'VR, VA, Plano de saude', 'Programador SAP academia ABAP', 120, '1', '1', '2', '1', 1),
(2, 1, 1, 'Programador TOTVS', 'vaga-totvs@ibm.fake.com', '10000', 'VR, VA, Plano de saude', 'Programador TOTVS', 120, '1', '1', '2', '1', 1),
(3, 1, 1, 'Programador TOTVS + Node', 'vaga-totvs@ibm.fake.com', '8000', 'VR, VA, Plano de saude', 'Programador TOTVS e Node.js', 120, '1', '1', '2', '1', 1),
(4, 2, 2, 'Analista QA', 'recrutamento@technew.com', '3000', 'Plano de saude', 'Analista de QA - qualquer nível', 120, '1', '1', '2', '1', 1),
(5, 2, 2, 'Tester', 'recrutamento@technew.com', '1000', 'Plano de saude', 'Tester - qualquer nível', 120, '1', '1', '1', '1', 1),
(6, 3, 3, 'Programador PHP Jr', 'contratacao@foodfinder.com', '3000', 'VR, VA, Plano de saude, Gympass', 'Programador PHP Jr', 120, '1', '1', '1', '1', 1),
(7, 3, 3, 'Programador PHP Pl', 'contratacao@foodfinder.com', '4500', 'VR, VA, Plano de saude, Gympass, Day off aniversario', 'Programador PHP 2', 120, '1', '1', '2', '1', 1),
(8, 3, 3, 'Programador PHP Sr', 'contratacao@foodfinder.com', '6000', 'VR, VA, Plano de saude, Gympass, Day off aniversario, Plano odonto', 'Programador PHP Senior', 120, '1', '1', '3', '1', 1)
;

DELETE FROM habilidade WHERE 1;
INSERT INTO habilidade (id, habilidade) VALUES
(1, 'PHP'),
(2, 'MySQL'),
(3, 'SQLite'),
(4, 'JavaScript'),
(5, 'Node.js'),
(6, 'HTML'),
(7, 'CSS'),
(8, 'Metodologias ágeis'),
(9, 'DotNet (.NET)'),
(10, 'C#'),
(11, 'C'),
(12, 'C++'),
(13, 'React'),
(14, 'ReactNative'),
(15, 'Vue'),
(16, 'Angular'),
(17, 'GoLang (Go)'),
(18, 'Python'),
(19, 'Elixir'),
(20, 'POO (Orientação a Objetos)'),
(21, 'Paradigma MVC'),
(22, 'Design Patterns (Padrões de projeto)'),
(23, 'Framework Laravel'),
(24, 'Next.js'),
(25, 'Framework Zend'),
(26, 'Nuxt')
;

DELETE FROM vaga_habilidade WHERE 1;
INSERT INTO vaga_habilidade (vaga_id, habilidade_id) VALUES
(4, 4),
(4, 6),
(4, 7),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(6, 4),
(6, 6),
(6, 7),
(6, 1),
(7, 4),
(7, 6),
(7, 7),
(7, 1),
(7, 2),
(8, 4),
(8, 6),
(8, 7),
(8, 1),
(8, 2),
(8, 20),
(8, 21),
(8, 22)
;

DELETE FROM candidato WHERE 1;
INSERT INTO candidato (id, nome, email, senha, habilidades, cpf, nascimento, endereco, disponibilidade, sexo, genero, `status`) VALUES
(1, 'Alana Silva', 'alana@candidato.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY', 'PHP', '88783818022', '1990-01-01', 'Av Paulista, 1000', '1', 'Feminino', 'Cisgenero', 1),
(2, 'Douglas Oliveira', 'douglas@candidato.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY', 'PHP', '42166127096', '1990-01-01', 'Av Paulista, 1000', '1', 'Masculino', 'Cisgenero', 1),
(3, 'Edyelgue Carneiro', 'edy@candidato.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY', 'PHP', '80383417082', '1990-01-01', 'Av Paulista, 1000', '1', 'Masculino', 'Cisgenero', 1),
(4, 'Kauan Nascimento', 'kauan@candidato.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY', 'PHP', '00025166085', '1990-01-01', 'Av Paulista, 1000', '1', 'Masculino', 'Cisgenero', 1),
(5, 'Thiago Abreu', 'thiago@candidato.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY', 'PHP', '22972285454', '1990-01-01', 'Av Paulista, 1000', '1', 'Masculino', 'Cisgenero', 1)
;

DELETE FROM candidato_vaga WHERE 1;
INSERT INTO candidato_vaga (candidato_id, vaga_id, ultima_desistencia, status) VALUES
(5, 1, '', 1),
(5, 2, '2024-07-06 00:00:00', 0),
(1, 6, '', 1),
(1, 7, '', 1),
(1, 8, '', 1),
(2, 6, '', 1),
(2, 7, '', 1),
(2, 8, '', 1),
(3, 6, '', 1),
(3, 7, '', 1),
(3, 8, '', 1),
(4, 6, '', 1),
(4, 7, '', 1),
(4, 8, '', 1)
;