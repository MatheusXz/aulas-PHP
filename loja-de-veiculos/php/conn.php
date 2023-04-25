<?php

$config = array(
    'host' => '10.0.0.101',
    'dbname' => 'loja_de_carros',
    'user' => 'root',
    'pass' => 'some_pass',
);

function exitSession($loc)
{
    session_start();
    session_destroy();
    header($loc);
}
function conectar($config)
{
    try {
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8';
        $pdo = new PDO($dsn, $config['user'], $config['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
    }
}

$connect = conectar($config);
