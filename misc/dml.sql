-- DML: Data Modeling Language
-- Comandos dentro do SQL que tem a finalidade de manipular os dados.
-- Ex: INSERT, UPDATE e DELETE

DELETE FROM empresa WHERE 1;
INSERT INTO empresa (id, nome, cnpj, email, descricao, logo, endereco) VALUES
(1, 'IBM', '81289818000178', 'recursos.humanos@ibm.fake.com', 'Empresa de tecnologia', 'ibm.png', 'Av Paulista, 1000'),
(2, 'TechNew', '31960951000136', 'recursos.humanos@technew.com', 'Startup de tecnologia', 'tnew.png', 'Av Paulista, 1100'),
(3, 'FoodFinder', '46854682000234', 'rh@foodfinder.com', 'Empresa de desenvolvimento', 'ff.png', 'Av Paulista, 1200')
;

DELETE FROM usuario WHERE 1;
INSERT INTO usuario (empresa_id, cpf, nome, email, senha) VALUES
(1, '19143210066', 'Joao Silva', 'joao.silva@ibm.fake.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(1, '05322913017', 'Maria Mara', 'maria.mara@ibm.fake.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(2, '36988692096', 'Joana Silva', 'joana.silva@technew.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(2, '36234827063', 'Jose Silvio', 'jose.silvio@technew.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(2, '31386636053', 'Jota Jotinha', 'jota.jotinha@technew.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(3, '88783818022', 'Alana Silva', 'alana@empresa.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(3, '42166127096', 'Douglas Oliveira', 'douglas@empresa.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(3, '80383417082', 'Edyelgue Carneiro', 'edy@empresa.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(3, '00025166085', 'Kauan Nascimento', 'kauan@empresa.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY'),
(3, '22972285454', 'Thiago Abreu', 'thiago@empresa.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY')
;

DELETE FROM candidato_vaga WHERE 1;

DELETE FROM vaga WHERE 1;
INSERT INTO vaga (empresa_id, titulo, email, salario, beneficios, descricao, cargaHoraria, regimeContratacao, regimeTrabalho, nivelSenioridade, nivelHierarquia, `status`) VALUES
(1, 'Programador SAP ABAP', 'vaga-abap@ibm.fake.com', '10000', 'VR, VA, Plano de saude', 'Programador SAP academia ABAP', 120, '1', '1', '2', '1', 1),
(1, 'Programador TOTVS', 'vaga-totvs@ibm.fake.com', '10000', 'VR, VA, Plano de saude', 'Programador TOTVS', 120, '1', '1', '2', '1', 1),
(1, 'Programador TOTVS + Node', 'vaga-totvs@ibm.fake.com', '8000', 'VR, VA, Plano de saude', 'Programador TOTVS e Node.js', 120, '1', '1', '2', '1', 1),
(2, 'Analista QA', 'recrutamento@technew.com', '3000', 'Plano de saude', 'Analista de QA - qualquer nível', 120, '1', '1', '2', '1', 1),
(2, 'Tester', 'recrutamento@technew.com', '1000', 'Plano de saude', 'Tester - qualquer nível', 120, '1', '1', '1', '1', 1),
(3, 'Programador PHP Jr', 'contratacao@foodfinder.com', '3000', 'VR, VA, Plano de saude, Gympass', 'Programador PHP Jr', 'PHP', 120, '1', '1', '1', '1', 1),
(3, 'Programador PHP Pl', 'contratacao@foodfinder.com', '4500', 'VR, VA, Plano de saude, Gympass, Day off aniversario', 'Programador PHP 2', 120, '1', '1', '2', '1', 1),
(3, 'Programador PHP Sr', 'contratacao@foodfinder.com', '6000', 'VR, VA, Plano de saude, Gympass, Day off aniversario, Plano odonto', 'Programador PHP Senior', 120, '1', '1', '3', '1', 1)
;

DELETE FROM candidato WHERE 1;
INSERT INTO candidato (nome, email, senha, habilidades, cpf, nascimento, endereco, disponibilidade, sexo, genero, `status`) VALUES
('Alana Silva', 'alana@candidato.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY', 'PHP', '88783818022', '1990-01-01', 'Av Paulista, 1000', '1', 'Feminino', 'Cisgenero', 1),
('Douglas Oliveira', 'douglas@candidato.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY', 'PHP', '42166127096', '1990-01-01', 'Av Paulista, 1000', '1', 'Masculino', 'Cisgenero', 1),
('Edyelgue Carneiro', 'edy@candidato.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY', 'PHP', '80383417082', '1990-01-01', 'Av Paulista, 1000', '1', 'Masculino', 'Cisgenero', 1),
('Kauan Nascimento', 'kauan@candidato.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY', 'PHP', '00025166085', '1990-01-01', 'Av Paulista, 1000', '1', 'Masculino', 'Cisgenero', 1),
('Thiago Abreu', 'thiago@candidato.com', '$argon2id$v=19$m=65536,t=4,p=1$Aab6wOgF6HbEY/Q3J42ClA$BoFioL4aRuvWJllGa5nOFd5hGUL+X9/SA6j0YXFvTzY', 'PHP', '22972285454', '1990-01-01', 'Av Paulista, 1000', '1', 'Masculino', 'Cisgenero', 1)
;
