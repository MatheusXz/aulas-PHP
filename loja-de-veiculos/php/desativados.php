<?php

require_once('conn.php');

if (isset($_POST['sair'])) {
    $loca = 'location: login.php';
    exitSession($loca);
}

if (isset($_POST['ativar'])) {

    $id = $_POST['id'];
    //Conexão com o banco de dados

    $queryUpdateON = "UPDATE carros_car SET car_status = 'on' WHERE id = :id_session";
    $stmth = $connect->prepare($queryUpdateON);
    $stmth->bindValue(":id_session", $id);
    $stmth->execute();
    $countStatusOFF = $stmth->rowCount();
}

session_start();

// Verifica se o usuário está logado, se não, redireciona para a página de login
if (!isset($_SESSION['id_user']) || !isset($_SESSION['nome_user'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Loja de Carros </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../css/main.css" rel="stylesheet" >

</head>

<body>
    <nav style="background-color: #001e50;" class="navbar navbar-dark py-3">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="../img/volkswagen-logo-9.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
                Volkswagen
            </a>

            <a class="navbar-brand" href="../index.php">Lista</a>
            <a class="navbar-brand" href="cadVeiculo.php">Novo</a>
            <a class="navbar-brand" href="#">Veiculos desativados</a>


            <div class="ml-0">
                <form action="" method="POST">
                    <button class="cta" name="sair">
                        <span class="span">Sair</span>
                        <span class="second">
                            <a href="#">
                                <img src="../img/bot.svg" alt="Sair">
                            </a>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="my-5">
        <div class="container">
            <div class="row text-center">
                <h1> Lista de veiculos DESATIVADOS </h1>
            </div>
            <div class="row">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Cod.</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Fabricante</th>
                            <th scope="col">Cor</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Ano</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Ativar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $querySqlStatusOff = "SELECT * FROM carros_car WHERE user_id = :id AND car_status = 'off'";
                        $stmth = $connect->prepare($querySqlStatusOff);
                        $stmth->bindValue(':id', $_SESSION['id_user']);
                        $stmth->execute();
                        $countStatusOff = $stmth->rowCount();



                        if ($countStatusOff > 0) {
                            $result = $stmth->fetchAll();
                            $i = 1;
                            foreach ($result as $row) {
                                if ($row['car_status'] == 'off') {
                                    $cor = 'red';
                                }
                                echo "
                                <tr style='color:".$cor."'>
                                    <th scope='row'>" . $i . "</th>
                                    <td>" . $row['car_nome'] . "</td>
                                    <td>" . $row['car_fabricante'] . "</td>
                                    <td>" . $row['car_cor'] . "</td>
                                    <td>" . $row['car_modelo'] . "</td>
                                    <td>" . $row['car_ano'] . "</td>
                                    <td>" . $row['car_preco'] . "</td>
                                    <td>
                                        <form action='' method='POST'>
                                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                                            <button type='submit' name='ativar' class='noselect ativar'><span class='text'>Ativar</span><span class='icon'><img src='../img/verificado.svg' alt=''></span></button>

                                        </form>
                                    </td>

                                </tr>
                                ";
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</body>

</html>