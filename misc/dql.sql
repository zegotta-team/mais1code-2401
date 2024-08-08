-- DQL: Data Query Language
-- Logo no nome, notamos uma palavra bastante utilizada por profissionais desta área, Query (Consulta)
-- Este termo se refere a comandos dentro do SQL que tem a finalidade de consultar dados.
-- Ex: SELECT.

SELECT * FROM empresa;
SELECT * FROM filial;
SELECT * FROM vaga;
SELECT * FROM habilidade;
SELECT * FROM usuario;
SELECT * FROM administradores;
SELECT * FROM candidato;
SELECT * FROM notificacoes;
SELECT * FROM vaga_habilidade;
SELECT * FROM candidato_vaga;
SELECT * FROM candidato_habilidade;
SELECT * FROM beneficios;
SELECT * FROM vaga_beneficio;
SELECT * FROM categoria_habilidade;
SELECT * FROM propostas;

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
LEFT JOIN habilidade h ON h.id = ch.habilidade_id;

-- vagas com beneficios
SELECT v.*, b.* 
FROM vaga v
LEFT JOIN vaga_beneficio vb ON vb.vaga_id = v.id
LEFT JOIN beneficios b ON b.id = vb.beneficio_id;

-- categorias com habilidades
SELECT *
FROM categoria_habilidade ch
INNER JOIN habilidade h ON ch.id = h.categoria_id;

-- notificaoes com candidatos
SELECT *
FROM notificacoes n
INNER JOIN candidato c ON n.candidato_id = c.id;

-- notificacoes com empresas
SELECT *
FROM notificacoes n
INNER JOIN empresa e ON n.empresa_id = e.id;

-- empresas com depoimentos e candidatos
SELECT *
FROM empresa e
INNER JOIN depoimentos d ON d.empresa_id = e.id
INNER JOIN candidato c ON d.candidato_id = c.id
