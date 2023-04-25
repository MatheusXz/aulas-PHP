<?php

require_once('conn.php');

if (isset($_POST['sair'])) {
    $loca = 'location: login.php';
    exitSession($loca);
}
if (isset($_GET['alter'])) {

    $id = $_GET['id'];
    //Conexão com o banco de dados

    $queryUpdate = "SELECT * FROM carros_car WHERE id = :id_session";
    $stmth = $connect->prepare($queryUpdate);
    $stmth->bindValue(":id_session", $id);
    $stmth->execute();
    $countUp = $stmth->rowCount();
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
    <link href="../css/main.css" rel="stylesheet">
    <style>

    </style>
</head>

<body>
    <?php
    if ($countUp > 0) {
        $result = $stmth->fetchAll();
        foreach ($result as $row) {
            echo '
    <div class="forms row container_login">
        
                
        <div class="form">
            <form action="" method="post">
                <h2 class="text-center">Cadastro de veiculos</h2>
                <div class="form-group">
                    <!-- NOME -->
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="' . $row['car_nome'] . '" placeholder="Ex: Gol" maxlength="18" required pattern=".{3,}">

                    <!-- FABRICANTE -->
                    <label for="fabricante">Fabricante:</label>
                    <input type="text" class="form-control" id="fabricante" name="fabricante" value="' . $row['car_fabricante'] . '" placeholder="Ex: Volkswagen" maxlength="18" required pattern=".{3,}">

                    <!-- EMAIL -->
                    <label for="cor">Cor:</label>
                    <select class="form-control"  required name="cor">
                        <option value="' . $row['car_cor'] . '">'. $row['car_cor'] . '</option>
                        <option value="vermelho">Vermelho</option>
                        <option value="azul">Azul</option>
                        <option value="verde">Verde</option>
                        <option value="amarelo">Amarelo</option>
                        <option value="preto">Preto</option>
                        <option value="branco">Branco</option>
                        <option value="prata">Prata</option>
                        <option value="cinza">Cinza</option>
                        <option value="roxo">Roxo</option>
                        <option value="laranja">Laranja</option>
                    </select>

                    <!-- SENHA -->
                    <label for="modelo">Modelo:</label>
                    <input type="text" class="form-control" id="modelo" name="modelo" value="' . $row['car_modelo'] . '" placeholder="Ex: Hatch" maxlength="18" required pattern=".{3,}">

                    <label for="ano">Ano:</label>
                    <input type="text" class="form-control" id="ano" name="ano" value="' . $row['car_ano'] . '" placeholder="Ex: 2021" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="4" required pattern=".{4,4}">

                    <label for="preco">Preço:</label>
                    <input type="text" class="form-control" id="preco" name="preco" value="' . $row['car_preco'] . '" placeholder="somente números" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="8" required pattern=".{2,}">

                    <div class="my-5 d-flex justify-content-between">
                    
                        <a href="../index.php" class="btn">Voltar</a>
                        <button class="btn btn-primary " name="cadastrar">Cadastrar</button>
                    </div>
                </div>
            </form>
            </div>
             
    </div>

    ';
        }
    } ?>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        let a = document.getElementById('demo_0');
        let y = document.getElementById('demo_1');
        let z = document.getElementById('demo_2');
        let x = document.getElementById('demo_3');
        let b = document.getElementById('demo_4');
        if (x) {
            swal({
                icon: 'error',
                title: 'Ooops! Algum campo esta vazio!',
                text: 'Tente novamente.'
            });
        } else if (y) {
            swal({
                icon: 'success',
                title: 'Veiculo cadastrado com sucesso! ✔',
                text: '😃'
            });
        } else if (a) {
            swal({
                icon: 'error',
                title: 'Alguma variavel não foi definida ☠',
                text: 'Tente novamente'
            });
        } else if (z) {
            swal({
                icon: 'error',
                title: 'Erro #007',
                text: 'Tente novamente mais tarde!'
            });
        } else if (b) {
            swal({
                icon: 'error',
                title: 'Todas VARIAVEIS estão vazias!',
                text: 'Tente novamente!'
            });
        }
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>