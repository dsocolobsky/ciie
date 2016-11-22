CREATE DATABASE IF NOT EXISTS cie;
USE cie;

DROP TABLE IF EXISTS admin;
CREATE TABLE IF NOT EXISTS admin (
    user VARCHAR(64),
    password VARCHAR(512)
);

DROP TABLE IF EXISTS alumnos;
CREATE TABLE IF NOT EXISTS alumnos (
    dni VARCHAR(8) NOT NULL PRIMARY KEY,
    nombre VARCHAR(64),
    apellido VARCHAR(64),
    telefono VARCHAR(32),
    mail VARCHAR(128),
    espera BOOLEAN
);

DROP TABLE IF EXISTS profesores;
CREATE TABLE IF NOT EXISTS profesores (
    dni VARCHAR(8) NOT NULL PRIMARY KEY,
    nombre VARCHAR(64),
    apellido VARCHAR(64),
    telefono VARCHAR(32),
    mail VARCHAR(128),
    observaciones TEXT
);

DROP TABLE IF EXISTS cursos;
CREATE TABLE IF NOT EXISTS cursos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(256),
    profesor VARCHAR(256),
    puntaje FLOAT(3, 2),
    inicio DATE,
    horario TEXT,
    observaciones TEXT,
    disponible BOOLEAN
);

INSERT INTO admin (user, password) VALUES ('admin', 'password');