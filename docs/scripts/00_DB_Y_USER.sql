
CREATE DATABASE ProductosDigitales
    DEFAULT CHARACTER SET = 'utf8mb4';


CREATE USER 'ProductosDigitales'@'%' IDENTIFIED BY 'ProductosDigitales';


GRANT SELECT, INSERT, UPDATE, DELETE ON ProductosDigitales.* TO 'ProductosDigitales'@'%';
