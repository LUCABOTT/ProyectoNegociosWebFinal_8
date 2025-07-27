
CREATE SCHEMA `ProductosDigitales` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


CREATE USER 'ProductosDigitales'@'%' IDENTIFIED BY 'ProductosDigitales';


GRANT SELECT, INSERT, UPDATE, DELETE ON ProductosDigitales.* TO 'ProductosDigitales'@'%';
