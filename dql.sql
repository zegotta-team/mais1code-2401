SELECT * FROM empresa;
SELECT * FROM vaga;

SELECT empresa.nome, vaga.* FROM vaga
INNER JOIN empresa ON empresa.id = vaga.empresa_id
