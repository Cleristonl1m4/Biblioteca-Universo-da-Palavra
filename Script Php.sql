DROP DATABASE IF EXISTS universodaspalavras;
CREATE DATABASE universodaspalavras;
USE universodaspalavras;

select * from autor;

DROP TABLE autor;
CREATE TABLE autor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    DataNascimento DATE,
    Biografia TEXT
);

INSERT INTO livros (titulo, autor, capa, ano_publicacao, editora)
VALUES 
('O Alquimista', 'Paulo Coelho', 'alquimista.jpg', 1988, 'Rocco'),
('Dom Casmurro', 'Machado de Assis', 'DomMachado.jpg', 1899, 'Editora Garnier'),
('Grande Sertão: Veredas', 'Guimarães Rosa', 'GrandeSertao.jpg', 1956, 'José Olympio');

drop table livros;


truncate livros;

CREATE TABLE livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    ano_publicacao INT,        
    editora VARCHAR(255),
    capa VARCHAR(255)          
);

ALTER TABLE livros ADD COLUMN categoria VARCHAR(100) AFTER editora;


CREATE TABLE editoras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    pais VARCHAR(100),
    cidade VARCHAR(100),
    ano_fundacao INT,
    site VARCHAR(255),
    email VARCHAR(150),
    telefone VARCHAR(20),
    UNIQUE KEY (nome)
);


CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    telefone VARCHAR(15) NOT NULL,
    cep VARCHAR(10) NOT NULL,
    estado VARCHAR(25) NOT NULL,
    cidade VARCHAR(50) NOT NULL,
    endereco VARCHAR(200) NOT NULL,
    bairro VARCHAR(200) NOT NULL,
    email VARCHAR(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao TEXT
);

INSERT INTO categorias (nome, descricao) VALUES
('Romance', 'Livros focados em relacionamentos e histórias de amor'),
('Ficção Científica', 'Histórias baseadas em ciência e tecnologia futurista'),
('Suspense', 'Narrativas que mantêm o leitor em tensão'),
('Terror', 'Histórias de medo e horror'),
('Fantasia', 'Mundos imaginários com magia e criaturas místicas'),
('Biografia', 'Histórias reais sobre a vida de pessoas'),
('Autoajuda', 'Livros de desenvolvimento pessoal'),
('História', 'Narrativas sobre eventos históricos'),
('Poesia', 'Obras literárias em verso'),
('Infantil', 'Livros para crianças');