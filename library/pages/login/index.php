<?php

require_once('../conn/index.php');

$div_message = "";

if (isset($_POST['cadastrar'])) {

    // VARIAVEIS

    $nome       =                                    $_POST['nome'];
    $s_nome     =                               $_POST['cpf'];
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
            $query_cadastrar = 'INSERT INTO `usuarios_car` (id, user_nome, user_sobre_nome, user_email, user_senha, user_tipo) VALUES (default, :nome, :cpf, :email, :psw, :tipo)';
            $stm = $connect->prepare($query_cadastrar);

            $stm->bindParam(':nome', $nome);
            $stm->bindParam(':cpf', $s_nome);
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
            background-image: url('https://cdn.wallpapersafari.com/91/90/Bmhy8U.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            -webkit-background-size: auto;
            -moz-background-size: auto;
            -o-background-size: auto;
        }
        
        

        /*  */

        

       
    </style>
</head>

<body>
    <?php echo $div_message; ?>


<!-- <div class="forms row container_login">
        <div class="form sign-up">
            <form action="" method="post">
                <h2 class="text-center">Cadastro</h2>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Carlos" required pattern=".{3,}">
                    <label for="sobrenome">Sobrenome:</label>
                    <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="Ex: Silva Soares" required pattern=".{3,}">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@exemplo.com" required pattern=".{7,}">
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
                <h2 class="text-center">Login</h2>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" id="myTextField" name="email" placeholder="name@exemplo.com" required pattern=".{7,}">
                    <label for="SENHA">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="*********" required pattern=".{8,}">
                    <div class="my-5 d-flex justify-content-between">
                        <button class="btn text-muted btn-outline-light link">Criar uma nova conta</button>
                        <button class="btn btn-primary login_user" name="login_user">Entrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div> -->


        <div class="forms row container_login">
            <div class=" form sign-up " style="background: rgba(0, 0, 0, 0.75); color: white;">
                <form action="" method="post">
                    <div class="row">
                        <h1 class="text-center" style="color: #BF9363;">Library System</h1>
                    </div>
                    <h5 class="text-center mt-5">Cadastro</h5>
                    <!-- user_cpf
                    user_logradouro
                    user_numero
                    user_bairro
                    user_cidade
                    user_estado
                    user_cep
                    user_telefone
                    user_data_nascimento
                    user_email
                    user_senha
                    user_data_cadastro
                    user_tipo -->
                    <div class="form-group">
                        <div class="row mb-3">
                            <div class="col-md-6 col-12">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome"
                                    placeholder="Ex: Carlos Almeida" required pattern=".{3,}">
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="cpf">CPF:</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14"
                                    placeholder="000.000.000-00" onkeypress="formatarCPF(event)"
                                    oninput="validarNumeros(this)" required pattern=".{14,}">

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 col-12">


                                <label for="email">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="name@exemplo.com" required pattern=".{7,}">
                            </div>
                        </div>
                        <label for="SENHA">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="*********"
                            required pattern=".{8,}">
                        <div class="my-5 d-flex justify-content-between">
                            <button class="btn text-muted btn-outline-light link ">Já tenho uma conta</button>
                            <button class="btn btn-primary criar_user" name="cadastrar">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="form sign-in" style="background: rgba(0, 0, 0, 0.75); color: white;">
                <form action="" method="post">
                    <div class="row">
                        <h1 class="text-center" style="color: #BF9363;">Library System</h1>
                    </div>
                    <h5 class="text-center  mt-5">Login</h5>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" id="myTextField" name="email"
                            placeholder="name@exemplo.com" required pattern=".{7,}">
                        <label for="SENHA">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="*********"
                            required pattern=".{8,}">
                        <div class="my-5 d-flex justify-content-between">
                            <button class="btn text-muted btn-outline-light link">Criar uma nova conta</button>
                            <button class="btn btn-primary login_user" name="login_user">Entrar</button>
                        </div>
                    </div>
                </form>
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

        function formatarCPF(event) {
            const inputCPF = document.querySelector("#cpf");
            let inputLength = inputCPF.value.length;

            if (inputLength == 3 || inputLength == 7) {
                inputCPF.value += ".";
            }
        }

        function validarNumeros(input) {
            input.value = input.value.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
        }
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