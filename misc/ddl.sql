-- DDL: Data Definition Language
-- Comandos dentro do SQL que tem a finalidade de definir e/ou redefinir atributos de um objeto.
-- Ex: CREATE, ALTER e DROP

DROP TABLE empresa;
CREATE TABLE empresa
(
    id        INTEGER PRIMARY KEY AUTOINCREMENT,
    nome      TEXT    NOT NULL,
    cnpj      TEXT    NOT NULL,
    email     TEXT    NOT NULL,
    descricao TEXT    NOT NULL,
    logo      TEXT
);

DROP TABLE vaga;
CREATE TABLE vaga
(
    id                INTEGER PRIMARY KEY AUTOINCREMENT,
    filial_id         INTEGER NOT NULL,
    empresa_id        INTEGER NOT NULL,
    titulo            TEXT    NOT NULL,
    email             TEXT    NOT NULL,
    salario           INTEGER NOT NULL,
    descricao         TEXT    NOT NULL,
    cargaHoraria      INTEGER NOT NULL,
    regimeContratacao INTEGER NOT NULL,
    regimeTrabalho    INTEGER NOT NULL,
    nivelSenioridade  INTEGER NOT NULL,
    nivelHierarquia   INTEGER NOT NULL,
    `status`          INTEGER NOT NULL DEFAULT 1
);

DROP TABLE usuario;
CREATE TABLE usuario
(
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    empresa_id  INTEGER NOT NULL,
    cpf         TEXT    NOT NULL,
    nome        TEXT    NOT NULL,
    email       TEXT    NOT NULL,
    senha       TEXT    NOT NULL,
    tipo        INTEGER NOT NULL DEFAULT 2
);

DROP TABLE candidato;
CREATE TABLE candidato
(
    id                INTEGER   PRIMARY KEY AUTOINCREMENT,
    nome              TEXT      NOT NULL,
    email             TEXT      NOT NULL,
    senha             TEXT      NOT NULL,
    cpf               TEXT      NOT NULL,
    nascimento        TEXT      NOT NULL,
    endereco          TEXT      NOT NULL,
    disponibilidade   TEXT      NOT NULL,
    sexo              TEXT      NOT NULL,
    genero            TEXT      NOT NULL,
    `status`          INTEGER   NOT NULL DEFAULT 1,
    regimeContratacao INTEGER,
    regimeTrabalho    INTEGER,
    nivelSenioridade  INTEGER,
    nivelHierarquia   INTEGER
);

DROP TABLE candidato_vaga;
CREATE TABLE candidato_vaga (
    candidato_id       INTEGER NOT NULL,
    vaga_id            INTEGER NOT NULL,
    ultima_desistencia TEXT    NULL,
    `status`           INTEGER NOT NULL,
    PRIMARY KEY (candidato_id, vaga_id)
);

DROP TABLE notificacoes;
CREATE TABLE notificacoes
(
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    candidato_id INTEGER NOT NULL,
    empresa_id   INTEGER NOT NULL,
    titulo       TEXT    NOT NULL,
    descricao    TEXT,
    `status`     INTEGER NOT NULL,
    data_hora    TEXT    NOT NULL
);

DROP TABLE filial;
CREATE TABLE filial
(
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    empresa_id  INTEGER NOT NULL,
    nome        TEXT    NOT NULL,
    cep         TEXT    NOT NULL,
    logradouro  TEXT,
    numero      TEXT,
    complemento TEXT,
    bairro      TEXT,
    cidade      TEXT    NOT NULL,
    estado      TEXT    NOT NULL
);

DROP TABLE habilidade;
CREATE TABLE habilidade
(
    id           INTEGER   NOT NULL,
    habilidade   TEXT      NULL,
    categoria_id INTEGER   NOT NULL,
    PRIMARY KEY (id)
);

DROP TABLE vaga_habilidade;
CREATE TABLE vaga_habilidade
(
    vaga_id       INTEGER NOT NULL,
    habilidade_id INTEGER NOT NULL,
    PRIMARY KEY (vaga_id, habilidade_id)
);

DROP TABLE candidato_habilidade;
CREATE TABLE candidato_habilidade
(
    candidato_id INTEGER NOT NULL,
    habilidade_id INTEGER NOT NULL,
    PRIMARY KEY( candidato_id, habilidade_id)
);

DROP TABLE categoria_habilidade;
CREATE TABLE categoria_habilidade
(
    id   INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT    NOT NULL
);

DROP TABLE beneficios;
CREATE TABLE beneficios
(
    id      INTEGER PRIMARY KEY AUTOINCREMENT,
    nome    TEXT NOT NULL
);

DROP TABLE vaga_beneficio;
CREATE TABLE vaga_beneficio
(
    vaga_id         INTEGER NOT NULL,
    beneficio_id    INTEGER NOT NULL,
    informacao      TEXT,
    PRIMARY KEY (vaga_id, beneficio_id)
);

DROP TABLE candidato_beneficio;
CREATE TABLE candidato_beneficio
(
    candidato_id INTEGER NOT NULL,
    beneficio_id INTEGER NOT NULL,
    PRIMARY KEY (candidato_id, beneficio_id)
);

DROP TABLE propostas;
CREATE TABLE propostas
(
    id_vaga INTEGER NOT NULL,
    id_candidato INTEGER NOT NULL,
    salario INTEGER NOT NULL,
    regime_contratacao INTEGER NOT NULL ,
    regime_trabalho INTEGER NOT NULL,
    nivel_hierarquico INTEGER NOT NULL,
    nivel_senioridade INTEGER NOT NULL,
    cargo TEXT NOT NULL,
    endereco TEXT NOT NULL,
    expediente TEXT NOT NULL,
    data_inicio TEXT NULL,
    aceite INTEGER NOT NULL,
    PRIMARY KEY(id_vaga, id_candidato)
);

DROP TABLE depoimentos;
CREATE TABLE depoimentos
(
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    empresa_id   INTEGER NOT NULL,
    candidato_id INTEGER NOT NULL,
    depoimento   TEXT    NOT NULL,
    avaliacao    INTEGER NOT NULL DEFAULT 1
);
