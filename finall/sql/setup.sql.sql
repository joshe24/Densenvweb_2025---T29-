CREATE TABLE setores (
    id SERIAL PRIMARY KEY,
    nome TEXT NOT NULL
);

CREATE TABLE dispositivos (
    id SERIAL PRIMARY KEY,
    nome TEXT NOT NULL,
    status VARCHAR(10) DEFAULT 'ativo'
);

CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,
    texto TEXT NOT NULL,
    status VARCHAR(10) DEFAULT 'ativa'
);

CREATE TABLE respostas (
    id SERIAL PRIMARY KEY,
    id_setor INTEGER REFERENCES setores(id),
    id_pergunta INTEGER REFERENCES perguntas(id),
    id_dispositivo INTEGER REFERENCES dispositivos(id),
    resposta INTEGER NOT NULL CHECK (resposta BETWEEN 0 AND 10),
    feedback TEXT,
    datahora TIMESTAMP NOT NULL
);

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);
