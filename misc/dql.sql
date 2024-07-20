-- DQL: Data Query Language
-- Logo no nome, notamos uma palavra bastante utilizada por profissionais desta área, Query (Consulta)
-- Este termo se refere a comandos dentro do SQL que tem a finalidade de consultar dados.
-- Ex: SELECT.

SELECT * FROM empresa;
SELECT * FROM filial;
SELECT * FROM vaga;
SELECT * FROM habilidade;
SELECT * FROM usuario;
SELECT * FROM candidato;
SELECT * FROM vaga_habilidade;
SELECT * FROM candidato_vaga;
SELECT * FROM candidato_habilidade;
SELECT * FROM beneficios;
SELECT * FROM vaga_beneficio;
SELECT * FROM candidato_beneficio;

-- empresas com filiais
SELECT *
FROM empresa e
INNER JOIN filial f ON f.empresa_id = e.id;

-- empresas com usuarios
SELECT *
FROM empresa e
INNER JOIN usuario u ON u.empresa_id = e.id;

-- empresas com vagas
SELECT *
FROM empresa e
INNER JOIN vaga v ON e.id = v.empresa_id;

-- vagas com candidatos
SELECT v.*, c.*
FROM vaga v
LEFT JOIN candidato_vaga cv ON cv.vaga_id = v.id
LEFT JOIN candidato c ON c.id = cv.candidato_id;

-- vagas com habilidades
SELECT v.*, h.*
FROM vaga v
LEFT JOIN vaga_habilidade vh ON vh.vaga_id = v.id
LEFT JOIN habilidade h ON h.id = vh.habilidade_id;


-- candidatos com habilidades
SELECT c.* , h.*
FROM candidato c
LEFT JOIN candidato_habilidade ch ON ch.candidato_id = c.id
LEFT JOIN habilidade h ON h.id = ch.habilidade_id

-- vagas com beneficios
SELECT v.*, b.* 
FROM vaga v
LEFT JOIN vaga_beneficio vb ON vb.vaga_id = v.id
LEFT JOIN beneficios b ON b.id = vb.beneficio_id


-- candidato com beneficios
SELECT c.*, b.*
FROM candidato c
LEFT JOIN candidato_beneficio cb ON cb.candidato_id = c.id
LEFT JOIN beneficios b ON b.id = cb.beneficio_id