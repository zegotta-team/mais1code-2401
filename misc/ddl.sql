-- DDL: Data Definition Language
-- Comandos dentro do SQL que tem a finalidade de definir e/ou redefinir atributos de um objeto.
-- Ex: CREATE, ALTER e DROP

CREATE TABLE empresa
(
    id        INTEGER PRIMARY KEY AUTOINCREMENT,
    nome      TEXT    NOT NULL,
    cnpj      TEXT    NOT NULL,
    email     TEXT    NOT NULL,
    descricao TEXT    NOT NULL,
    logo      TEXT
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
    cargaHoraria INTEGER NOT NULL,
    regimeContratacao INTEGER NOT NULL,
    regimeTrabalho INTEGER NOT NULL,
    nivelSenioridade INTEGER NOT NULL,
    nivelHierarquia INTEGER NOT NULL,
    `status`       INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE usuario
(
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    empresa_id  INTEGER NOT NULL,
    cpf         TEXT NOT NULL,
    nome        TEXT NOT NULL,
    email       TEXT NOT NULL,
    senha       TEXT NOT NULL
);

CREATE TABLE candidato
(
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    nome            TEXT NOT NULL,
    email           TEXT NOT NULL,
    senha           TEXT NOT NULL,
    habilidades     TEXT NOT NULL,
    cpf             TEXT NOT NULL,
    nascimento      TEXT NOT NULL,
    endereco        TEXT NOT NULL,
    disponibilidade TEXT NOT NULL,
    sexo            TEXT NOT NULL,
    genero          TEXT NOT NULL,
    `status`        INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE candidato_vaga (
    candidato_id       INTEGER NOT NULL,
    vaga_id            INTEGER NOT NULL,
    ultima_desistencia TEXT NULL,
    `status`           INTEGER NOT NULL,
    PRIMARY KEY (candidato_id, vaga_id)
);

CREATE TABLE filial
(
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    empresa_id  INTEGER NOT NULL,
    nome        TEXT NOT NULL,
    cep         TEXT NOT NULL,
    logradouro   TEXT,
    numero      TEXT,
    complemento TEXT,
    bairro      TEXT,
    cidade      TEXT NOT NULL,
    estado      TEXT NOT NULL   
);
