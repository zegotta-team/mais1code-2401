-- DQL: Data Query Language
-- Logo no nome, notamos uma palavra bastante utilizada por profissionais desta área, Query (Consulta)
-- Este termo se refere a comandos dentro do SQL que tem a finalidade de consultar dados.
-- Ex: SELECT.

SELECT * FROM empresa;
SELECT * FROM usuario;
SELECT * FROM vaga;
SELECT * FROM candidato;

-- vagas com empresa
SELECT e.nome, v.*
FROM vaga v
INNER JOIN empresa e ON e.id = v.empresa_id;

-- candidato com vagas
SELECT c.*, v.*
FROM candidato c
LEFT JOIN candidato_vaga cv ON cv.candidato_id = c.id
LEFT JOIN vaga v ON v.id = cv.vaga_id
