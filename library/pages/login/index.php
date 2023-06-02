<?php

require_once('../conn/index.php');

$div_message = "";

if (isset($_POST['cadastrar'])) {

    // VARIAVEIS

    $nome       =                                    $_POST['nome'];
    $s_nome     =                               $_POST['sobrenome'];
    $user_tipo  =                                           'comum';
    $email      =                       strtolower($_POST['email']);
    $senha      =  password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // VERIFICAR SE EMAIL JÁ EXISTE
    $query_verfi_email = 'SELECT `user_email` FROM `usuarios_car` WHERE `user_email` = :email';
    $statement_email = $connect->prepare($query_verfi_email);
    $check_email = array(':email' => $email);
    $div_message = "";

    if ($statement_email->execute($check_email)) {
        if ($statement_email->rowCount() > 0) {
            $div_message = "<div id='demo_0'></div>";
        } else {
            $query_cadastrar = 'INSERT INTO `usuarios_car` (id, user_nome, user_sobre_nome, user_email, user_senha, user_tipo) VALUES (default, :nome, :sobrenome, :email, :psw, :tipo)';
            $stm = $connect->prepare($query_cadastrar);

            $stm->bindParam(':nome', $nome);
            $stm->bindParam(':sobrenome', $s_nome);
            $stm->bindParam(':email', $email);
            $stm->bindParam(':psw', $senha);
            $stm->bindParam(':tipo', $user_tipo);

            // VERIFICA SE EXECUTOU TUDO CERTO
            // mysqli_query($connect, $stm);
            if ($stm->execute()) {
                $div_message = "<div id='demo_1'></div>";
            } else {
                $div_message = "<div id='demo_2'></div>";
            }
        }
    }
} else if (isset($_POST['login_user'])) {
    $email              =                                 strtolower($_POST["email"]);
    // PUXANDO DADOS DO LOGIN
    $query_login        =  "SELECT * FROM `usuarios_car` WHERE `user_email` = :email";

    $stm                =                             $connect->prepare($query_login);
    $stm->execute(array(':email'    =>                                       $email));
    $count = $stm->rowCount();
    if ($count > 0) {
        $result = $stm->fetchAll();
        foreach ($result as $row) {
            if (password_verify($_POST["senha"], $row["user_senha"])) {
                session_start();
                $_SESSION['id_user']              =                       $row['id'];
                $_SESSION['nome_user']            =                $row['user_nome'];
                $_SESSION['email_user']           =               $row['user_email'];
                $_SESSION['nivel_acesso']         =                             '0';
                $_SESSION['login']                =                           'yes';
                header('location: ../index.php');
            }
        }
        // PUXANDO HORAS EXTRAS

        $div_message = "<div id='demo_3'></div>";
    } else {
        $div_message = "<div id='demo_4'></div>";
    }
};
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>


    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">

    <!--  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../../css/main.css" rel="stylesheet">
    <style>
        body {
            /* height: 100vh; */
            background-image: url('https://cdn.wallpapersafari.com/91/90/Bmhy8U.jpg');
            /* background-size: cover; */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            -webkit-background-size: auto;
            -moz-background-size: auto;
            -o-background-size: auto;
            /* Centraliza verticalmente */
        }
    </style>
</head>

<body>
    <?php echo $div_message; ?>


    <div class="container">
        <!-- Title -->

        <!-- insertion section -->
        <div class="">
            <div class="forms row d-flex justify-content-center">
                <div class=" form sign-up " style="background: rgba(0, 0, 0, 0.75);">
                    <form action="" method="post">
                        <div class="row">
                            <h1 class="text-primary text-center">Library System</h1>
                        </div>
                        <h5 class="text-center mt-5">Cadastro</h5>
                        <div class="form-group">
                            <!-- NOME -->
                            <label for="nome">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Carlos" required pattern=".{3,}">
                            <!-- SOBRENOME -->
                            <label for="sobrenome">Sobrenome:</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Ex: Silva Soares" required pattern=".{3,}">
                            <!-- EMAIL -->
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@exemplo.com" required pattern=".{7,}">
                            <!-- SENHA -->
                            <label for="SENHA">Senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="*********" required pattern=".{8,}">
                            <div class="my-5 d-flex justify-content-between">
                                <button class="btn text-muted btn-outline-light link ">Já tenho uma conta</button>
                                <button class="btn btn-primary criar_user" name="cadastrar">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="form sign-in">
                    <form action="" method="post">
                        <div class="row">
                            <h1 class="text-center text-primary">Library System</h1>
                        </div>
                        <h5 class="text-center  mt-5">Login</h5>
                        <div class="form-group">
                            <!-- EMAIL -->
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control" id="myTextField" name="email" placeholder="name@exemplo.com" required pattern=".{7,}">
                            <!-- SENHA -->
                            <label for="SENHA">Senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="*********" required pattern=".{8,}">
                            <div class="my-5 d-flex justify-content-between">
                                <button class="btn text-muted btn-outline-light link">Criar uma nova conta</button>
                                <button class="btn btn-primary login_user" name="login_user">Entrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        const forms = document.querySelector(".forms"),
            links = document.querySelectorAll(".link");
        links.forEach(link => {
            link.addEventListener("click", e => {
                e.preventDefault();
                forms.classList.toggle("show-signup");
            })
        })
    </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>
        let x = document.getElementById('demo_0');
        let y = document.getElementById('demo_1');
        let z = document.getElementById('demo_2');
        let a = document.getElementById('demo_3');
        let b = document.getElementById('demo_4');
        if (x) {
            swal({
                icon: 'error',
                title: 'Ooops! Email já existente',
                text: 'Tente novamente com outro email'
            });
        } else if (y) {
            swal({
                icon: 'success',
                title: 'Conta criada com sucesso! ✔',
                text: 'Seja bem-vindo 😃'
            });
        } else if (a) {
            swal({
                icon: 'error',
                title: 'Credenciais inválidas ☠',
                text: 'Tente novamente'
            });
        } else if (z) {
            swal({
                icon: 'error',
                title: 'Erro na criação',
                text: 'Tente novamente mais tarde!.'
            });
        } else if (b) {
            swal({
                icon: 'error',
                title: 'Conta não encontrada!',
                text: 'Caso não tenha um cadastro faça um agora mesmo!'
            });
        }
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>