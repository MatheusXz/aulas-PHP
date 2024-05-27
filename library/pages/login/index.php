<?php

require_once('../conn/index.php');

$div_message = "";

if (isset($_POST['cadastrar'])) {

    // VARIAVEIS
    $nome                =                                    $_POST['nome'];
    $cpf                 =                                    $_POST['cpf'];
    $logradouro          =                                    $_POST['logradouro'];
    $num_casa            =                                    $_POST['numero_casa'];
    $bairro              =                                    $_POST['bairro'];
    $cidade              =                                    $_POST['cidade'];
    $estado              =                                    $_POST['estado'];
    $cep                 =                                    $_POST['cep'];
    $telefone            =                                    $_POST['telefone'];
    $data_de_nascimento  =                                    $_POST['data_de_nascimento'];
    $foto  =                                                  $_FILES['foto'];
    $tipo                =                                    'usuario';
    $email               =                                    strtolower($_POST['email']);
    $senha               =                                    password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // VERIFICAR SE EMAIL JÁ EXISTE
    $query_verfi_email = 'SELECT `user_email` FROM `usuarios` WHERE `user_email` = :email';
    $statement_email = $connect->prepare($query_verfi_email);
    $check_email = array(':email' => $email);
    $div_message = "";

    $query_verfi_cpf = 'SELECT `user_cpf` FROM `usuarios` WHERE `user_cpf` = :cpf';
    $statement_cpf = $connect->prepare($query_verfi_cpf);
    $check_cpf = array(':cpf' => $cpf);
    $div_message = "";
    $div_message = "<div class='bg-danger'>Erroooooooooooooo</div>";

    try {
        // Executar a query para cadastrar o usuário
        if (true) {
            $statement_email->execute($check_email);
            $statement_cpf->execute($check_cpf);
            if ($statement_email->rowCount() > 0) {
                $div_message = "<div id='demo_0'></div>";
            } else if ($statement_cpf->rowCount() > 0) {
                $div_message = "<div id='demo_5'></div>";
            } else {
                $query_cadastrar = 'INSERT INTO `usuarios` (
                    id,user_nome,user_cpf,user_logradouro,user_numero,user_bairro,user_cidade,user_estado,user_cep,user_telefone,user_data_nascimento,user_caminho_imagem,user_email,user_senha,user_tipo,user_data_cadastro
                ) VALUES (
                    default,:nome,:cpf,:logradouro,:num_casa,:bairro,:cidade,:estado,:cep,:telefone,:data_de_nascimento,:foto,:email,:senha,:tipo,
                    NOW()
                )';




                // ARAZENO EM UMA VAR
                if (isset($foto)) {
                    if (!preg_match('/^image\/(gif|bmp|png|jpg|jpeg)+$/', $foto["type"])) { // VERIFICO SE ESTA DE ACORDO COMO UMA IMAGEM A EXTENÇÃO
                        $div_message = "<div id='demo_6'></div>";
                    } else {
                        $extensao = '.jpg'; //pega a extensao do foto
                        $novo_nome = md5(time()) . $extensao; //define o nome do foto, criptografando a data do envio atual como o nome da imagem
                        $diretorio = "../imgs/"; //define o diretorio para onde enviaremos o foto

                        move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio . $novo_nome); //efetua o upload

                    }
                }

                $statement_cadastrar = $connect->prepare($query_cadastrar);
                $statement_cadastrar->bindParam(':nome', $nome);
                $statement_cadastrar->bindParam(':cpf', $cpf);
                $statement_cadastrar->bindParam(':logradouro', $logradouro);
                $statement_cadastrar->bindParam(':num_casa', $num_casa);
                $statement_cadastrar->bindParam(':bairro', $bairro);
                $statement_cadastrar->bindParam(':cidade', $cidade);
                $statement_cadastrar->bindParam(':estado', $estado);
                $statement_cadastrar->bindParam(':cep', $cep);
                $statement_cadastrar->bindParam(':telefone', $telefone);
                $statement_cadastrar->bindParam(':data_de_nascimento', $data_de_nascimento);
                $statement_cadastrar->bindParam(':foto', $novo_nome);
                $statement_cadastrar->bindParam(':email', $email);
                $statement_cadastrar->bindParam(':senha', $senha);
                $statement_cadastrar->bindParam(':tipo', $tipo);

                if ($statement_cadastrar->execute()) {
                    $div_message = "<div id='demo_1'></div>";
                } else {
                    $div_message = "<div id='demo_2'></div>";
                }
            }
        }
    } catch (PDOException $e) {
        // Tratar a exceção gerada
        $error_message = $e->getMessage();
        $div_message = "<div class='bg-danger''>$error_message</div>";
    }
} elseif (isset($_POST['login_user'])) {

    $email = strtolower($_POST["email"]);
    $query_login = "SELECT * FROM `usuarios` WHERE `user_email` = :email";
    $stm = $connect->prepare($query_login);
    $stm->execute(array(':email' => $email));
    $count = $stm->rowCount();

    if ($count > 0) {
        $result = $stm->fetchAll();
        foreach ($result as $row) {
            if (password_verify($_POST["senha"], $row["user_senha"])) {
                session_start();
                $_SESSION['id']              =                            $row['id'];
                $_SESSION['nome']            =                     $row['user_nome'];
                $_SESSION['email']           =                    $row['user_email'];
                $_SESSION['nivel_acesso']    =                     $row['user_tipo'];

                header('location: ../../index.php');
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

        .image-mask {
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 30px;
        }

        .image-mask img {
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
            width: 100%;
            height: 100%;
        }


        /*  */
    </style>
</head>

<body>
    <?php echo $div_message; ?>
    <div class="container">
        <div class="forms row container_login">
            <div class=" form sign-up " style="background: rgba(0, 0, 0, 0.75); color: white;">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <h1 class="text-center" style="color: #BF9363;">Library System</h1>
                    </div>
                    <h5 class="text-center">Cadastro</h5>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <label for="nome">Nome completo</label>
                                <input type="text" onpaste="return false" ondrop="return false" class="form-control" id="nome" name="nome" maxlength="100" autocomplete="off" onkeypress="return soTexto(event)" placeholder="Ex: Carlos Almeida" required pattern=".{3,}">
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="cpf">CPF:</label>
                                <input type="text" onpaste="return false" ondrop="return false" class="form-control" id="cpf" name="cpf" maxlength="11" placeholder="1234568901" autocomplete="off" onkeypress="return soNumeros(event)" autocomplete="off" required pattern=".{11,}">
                                <small class="text-muted fw-bold">somente números</small>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6 col-12">
                                <label for="data_de_nascimento">Data de nascimento:</label>
                                <input type="date" class="form-control text-uppercase" id="data_de_nascimento" name="data_de_nascimento" maxlength="8" required pattern=".{2,}">
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="telefone">Telefone:</label>
                                <input type="text" onpaste="return false" ondrop="return false" class="form-control" id="telefone" name="telefone" placeholder="Ex: 11 9 9999 9999" maxlength="11" autocomplete="off" onkeypress="return soNumeros(event)" required pattern=".{11,}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <label for="logradouro">Endereço (Rua/Av):</label>
                                <input type="text" onpaste="return false" ondrop="return false" class="form-control" id="logradouro" name="logradouro" maxlength="150" placeholder="Ex: Av. Brasil" autocomplete="off" onkeypress="return soTexto(event)" required pattern=".{3,}">
                            </div>
                            <div class="col-md-4 col-12">
                                <label for="numero_casa">Número:</label>
                                <input type="text" onpaste="return false" ondrop="return false" class="form-control" id="numero_casa" name="numero_casa" maxlength="10" placeholder="Ex: 175" autocomplete="off" onkeypress="return soNumeros(event)" required pattern=".{1,}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <label for="bairro">Bairro:</label>
                                <input type="text" onpaste="return false" ondrop="return false" class="form-control" id="bairro" name="bairro" placeholder="Ex: Centro" maxlength="100" autocomplete="off" onkeypress="return soTexto(event)" required pattern=".{1,}">
                            </div>

                            <div class="col-md-4 col-12">
                                <label for="estado">Estado:</label>
                                <input type="text" onpaste="return false" ondrop="return false" class="form-control text-uppercase" id="estado" name="estado" maxlength="2" autocomplete="off" onkeypress="return soTexto(event)" placeholder="Ex: SP" required pattern=".{2,}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 col-12">
                                <label for="cidade">Cicade:</label>
                                <input type="text" onpaste="return false" ondrop="return false" class="form-control" id="cidade" name="cidade" maxlength="100" autocomplete="off" onkeypress="return soTexto(event)" placeholder="Ex: Luiziânia" required pattern=".{1,}">
                            </div>
                            <div class="col-md-5 col-12">
                                <label for="cep">CEP:</label>
                                <input type="text" onpaste="return false" ondrop="return false" class="form-control" id="cep" name="cep" placeholder="Ex: 16340000" maxlength="8" autocomplete="off" onkeypress="return soNumeros(event)" required pattern=".{8,}">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 col-12">
                                <label for="email">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@exemplo.com" maxlength="100" required pattern=".{7,}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <label for="SENHA">Senha:</label>
                                <input type="password" class="form-control" id="senha" maxlength="100" name="senha" placeholder="*********" required pattern=".{8,}">
                                <small class="text-muted fw-bold">certifique-se de ter pelo menos 8 caracteres pelo menos, incluindo um número e uma letra maiúscula.</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 d-flex  justify-content-center">
                                <img id="img" class="image-mask" src="../../src/img/Gallery-PNG.png">
                            </div>
                            <div class="col-md-8 ">
                                <label for="foto">Foto para perfil:</label>
                                <input type="file" class="form-control d-flex align-content-end my-2 " id="inputImg" required name="foto">
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-between">
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
                    <h5 class="text-center">Login</h5>
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
        </div>
    </div>

    <script>
        let forms = document.querySelector(".forms"),
            links = document.querySelectorAll(".link");
        links.forEach(link => {
            link.addEventListener("click", e => {
                e.preventDefault();
                forms.classList.toggle("show-signup");
            })
        })

        soNumeros = event => {
            const codigoTecla = event.which || event.keyCode;

            // Verifica se o código da tecla digitada está dentro do intervalo dos números ASCII (48-57)
            if (codigoTecla >= 48 && codigoTecla <= 57) {
                return true; // Permite a entrada
            } else {
                return false; // Bloqueia a entrada
            }
        }

        soTexto = event => {
            const codigoTecla = event.which || event.keyCode;

            // Verifica se o código da tecla digitada está dentro do intervalo dos números ASCII (48-57)
            if (codigoTecla >= 65 && codigoTecla <= 90 || codigoTecla >= 97 && codigoTecla <= 122 || codigoTecla == 94 || codigoTecla == 32) {
                return true; // Permite a entrada
            } else {
                return false; // Bloqueia a entrada
            }
        }
        let img = document.getElementById('img');
        let inputImg = document.getElementById('inputImg');

        inputImg.onchange = (e) => {
            if (inputImg.files[0]) {
                img.src = URL.createObjectURL(inputImg.files[0]);
            }
        }
    </script>


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>
        let x = document.getElementById('demo_0');
        let y = document.getElementById('demo_1');
        let z = document.getElementById('demo_2');
        let a = document.getElementById('demo_3');
        let b = document.getElementById('demo_4');
        let d = document.getElementById('demo_5');
        let f = document.getElementById('demo_6');
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
        } else if (d) {
            swal({
                icon: 'error',
                title: 'Ooops! CPF já existente',
                text: 'Tente novamente ou acesse sua conta!'
            });
        } else if (f) {
            swal({
                icon: 'error',
                title: 'Formato de imagem invalido',
                text: 'Tente novamente!'
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