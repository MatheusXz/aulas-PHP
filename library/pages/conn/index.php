<?php

$config = array(
    'host' => '10.67.22.216',
    'dbname' => 's222_matheus35',
    'user' => 's222_bda',
    'pass' => 's22022',
);

// $config = array(
//     'host' => '10.0.0.101',
//     'dbname' => 'loja_de_carros',
//     'user' => 'root',
//     'pass' => 'some_pass',
// );

function exitSession($loc)
{
    session_start();
    session_destroy();
    header($loc);
}

function mostrarPrimeiroNome($nomeCompleto) {
    // Divide o nome completo em partes separadas por espaço
    $partesNome = explode(' ', $nomeCompleto);
    
    // Pega a primeira parte, que é o primeiro nome
    $primeiroNome = $partesNome[0];
    
    // Exibe o primeiro nome
    echo $primeiroNome;
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
