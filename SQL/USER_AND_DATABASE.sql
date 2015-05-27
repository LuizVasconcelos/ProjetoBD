CREATE USER 'projetobd'@'localhost' IDENTIFIED BY 'projetobd';
GRANT ALL PRIVILEGES ON * . * TO 'projetobd'@'localhost';
FLUSH PRIVILEGES;

CREATE DATABASE IF NOT EXISTS projetobd;
