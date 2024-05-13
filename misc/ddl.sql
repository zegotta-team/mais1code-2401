CREATE TABLE empresa
(
    id        INTEGER PRIMARY KEY AUTOINCREMENT,
    nome      TEXT    NOT NULL,
    cnpj      TEXT    NOT NULL,
    usuario   TEXT    NOT NULL,
    email     TEXT    NOT NULL,
    senha     INTEGER NOT NULL,
    descricao TEXT    NOT NULL,
    logo      TEXT,
    endereco  TEXT    NOT NULL
);

CREATE TABLE vaga
(
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    empresa_id   INTEGER NOT NULL,
    titulo       TEXT    NOT NULL,
    email        TEXT    NOT NULL,
    salario      INTEGER NOT NULL,
    beneficios   TEXT,
    descricao    TEXT    NOT NULL,
    requisitos   TEXT    NOT NULL,
    cargaHoraria INTEGER NOT NULL
);

