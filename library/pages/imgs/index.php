<?php

require_once('../conn/index.php');

session_start();

if (isset($_GET['sair']) || !isset($_SESSION['nome']) || !isset($_SESSION['id'])) {
    $loca = 'location: ../login/index.php';
    exitSession($loca);
}

if ($_SESSION['nivel_acesso'] != 'funcionario') {
    header('location: ../../index.php');
}
?>