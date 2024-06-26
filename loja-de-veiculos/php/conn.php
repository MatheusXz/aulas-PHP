<?php

$config = array(
    'host' => 'localhost',
    'dbname' => 'carros',
    'user' => 'root',
    'pass' => '',
);

function exitSession($loc)
{
    session_start();
    session_destroy();
    header($loc);
}

function HeaderLocal($loc)
{
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
function getCompradorSaldo($connect, $idCompradorLogado)
{
    $querySaldoComprador = 'SELECT user_saldo FROM usuarios_car WHERE id = :idCompradorLogado';
    $stmthSaldoComprador = $connect->prepare($querySaldoComprador);
    $stmthSaldoComprador->bindValue(":idCompradorLogado", $idCompradorLogado);
    $stmthSaldoComprador->execute();
    $resultSaldoComprador = $stmthSaldoComprador->fetch(PDO::FETCH_ASSOC);
    $saldoComprador = $resultSaldoComprador['user_saldo'];
    return $saldoComprador;
}

$connect = conectar($config);
