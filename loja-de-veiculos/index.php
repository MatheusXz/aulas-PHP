<?php

require_once('./php/conn.php');

if (isset($_POST['sair'])) {
    session_start();
    session_destroy();
    header('location: php/login.php');
}
if (isset($_POST['excluir'])) {

    $id = $_POST['id'];
    //Conexão com o banco de dados

    $queryUpdateOFF = "UPDATE carros_car SET car_status = 'off' WHERE id = :id_session";
    $stmth = $connect->prepare($queryUpdateOFF);
    $stmth->bindValue(":id_session", $id);
    $stmth->execute();
    $countStatusOFF = $stmth->rowCount();
}
session_start();

// Verifica se o usuário está logado, se não, redireciona para a página de login
if (!isset($_SESSION['id_user']) || !isset($_SESSION['nome_user'])) {
    header('Location: ./php/login.php');
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
    <style>
        .cta {
            display: flex;
            padding: 11px 33px;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-size: 25px;
            color: white;
            background: #6225E6;
            transition: 1s;
            box-shadow: 6px 6px 0 black;
            transform: skewX(-15deg);
            border: none;
        }

        .cta:focus {
            outline: none;
        }

        .cta:hover {
            transition: 0.5s;
            box-shadow: 10px 10px 0 #FBC638;
        }

        .cta .second {
            transition: 0.5s;
            margin-right: 0px;
        }

        .cta:hover .second {
            transition: 0.5s;
            margin-right: 45px;
        }

        .span {
            transform: skewX(15deg)
        }

        .second {
            width: 20px;
            margin-left: 30px;
            position: relative;
            top: 12%;
        }

        .one {
            transition: 0.4s;
            transform: translateX(-60%);
        }

        .two {
            transition: 0.5s;
            transform: translateX(-30%);
        }

        .cta:hover .three {
            animation: color_anim 1s infinite 0.2s;
        }

        .cta:hover .one {
            transform: translateX(0%);
            animation: color_anim 1s infinite 0.6s;
        }

        .cta:hover .two {
            transform: translateX(0%);
            animation: color_anim 1s infinite 0.4s;
        }

        @keyframes color_anim {
            0% {
                fill: white;
            }

            50% {
                fill: #FBC638;
            }

            100% {
                fill: white;
            }
        }
    </style>

</head>

<body>
    <nav style="background-color: #001e50;" class="navbar navbar-dark py-3">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="./img/volkswagen-logo-9.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
                Volkswagen
            </a>

            <a class="navbar-brand" href="php/cadVeiculo.php">Novo veiculo</a>
            <a class="navbar-brand" href="php/desativados.php">Veiculos desativados</a>


            <div class="ml-0">
                <form action="" method="POST">
                    <button class="cta" name="sair">
                        <span class="span">Sair</span>
                        <span class="second">
                            <a href="./php/logout.php">
                                <img src="./img/bot.svg" alt="Sair">
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
                <h1> Lista de veiculos cadastrados </h1>
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
                            <th scope="col">EDITAR</th>
                            <th scope="col">EXCLUIR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $querySqlStatusOn = "SELECT * FROM carros_car WHERE user_id = :id AND car_status = 'on'";
                        $stmth = $connect->prepare($querySqlStatusOn);
                        $stmth->bindValue(':id', $_SESSION['id_user']);
                        $stmth->execute();
                        $countStatusOn = $stmth->rowCount();



                        if ($countStatusOn > 0) {
                            $result = $stmth->fetchAll();
                            $i = 1;
                            foreach ($result as $row) {
                                echo "
                                    <tr>
                                        <th scope='row'>" . $i . "</th>
                                        <td>" . $row['car_nome'] . "</td>
                                        <td>" . $row['car_fabricante'] . "</td>
                                        <td>" . $row['car_cor'] . "</td>
                                        <td>" . $row['car_modelo'] . "</td>
                                        <td>" . $row['car_ano'] . "</td>
                                        <td>" . $row['car_preco'] . "</td>
                                        <td>
                                            <form action='php/edit.php' method='GET'>
                                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                                <button type='submit' name='alter'>Alterar</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action='' method='POST'>
                                                <input type='hidden' name='id' value='" . $row['id'] . "'>
                                                <button type='submit' name='excluir'>Excluir</button>
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

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>