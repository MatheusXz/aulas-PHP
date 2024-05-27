CREATE DATABASE carros;

use carros;

CREATE TABLE `Usuarios_car` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_nome` varchar(20) NOT NULL,
    `user_sobre_nome` varchar(50) NOT NULL,
    `user_email` varchar(255) NOT NULL,
    `user_senha` varchar(128) NOT NULL,
    `user_saldo` DECIMAL(10,0) DEFAULT 50000,
    `user_tipo` varchar(10) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `Carros_car` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `car_nome` varchar(20) NOT NULL,
    `car_fabricante` varchar(20) NOT NULL,
    `car_cor` varchar(10) NOT NULL,
    `car_modelo` varchar(20) NOT NULL,
    `car_ano` int(11) NOT NULL,
    `car_preco` DECIMAL(10,2) NOT NULL,
    `car_status` varchar(3) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `Usuarios_car`(`id`)
);