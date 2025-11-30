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


CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao TEXT
);
