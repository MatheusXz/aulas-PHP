<?php

require_once('../conn/index.php');

session_start();

if (isset($_GET['sair']) || !isset($_SESSION['nome']) || !isset($_SESSION['id'])) {
    $loca = 'location: pages/login/index.php';
    exitSession($loca);
}

$div_message = "";


if (isset($_POST['cadastrar_autor'])) {

    // VARIAVEIS
    $nome_autor                 =                                    $_POST['nome_autor'];
    $nacionalidade              =                                    $_POST['nacionalidade'];
    $biografia                  =                                    $_POST['biografia'];
    $data_nascimento            =                                    $_POST['data_nascimento'];
    $foto                       =                                    $_FILES['foto'];

    // VERIFICAR SE EMAIL JÁ EXISTE
    $query_verfi_nome = 'SELECT `aut_nome_completo` FROM `autores` WHERE `aut_nome_completo` = :nome_autor';
    $statement_nome = $connect->prepare($query_verfi_nome);
    $check_nome = array(':nome_autor' => $nome_autor);
    $div_message = "";





    try {
        // Executar a query para cadastrar o usuário
        if (true) {
            $statement_nome->execute($check_nome);
            if ($statement_nome->rowCount() > 0) {
                $div_message = "<div id='demo_0'></div>";
            } else {
                $query_cadastrar = 'INSERT INTO `autores` (
                    id,
                    aut_nome_completo,
                    aut_data_nascimento,
                    aut_nacionalidade,
                    aut_biografia,
                    aut_caminho_imagem,
                    aut_data_cadastro
                    ) VALUES (
                    DEFAULT,
                    :nome_autor,
                    :data_nascimento,
                    :nacionalidade,
                    :biografia,
                    :foto,
                    NOW()
                    )';

                echo '<div class="bg-danger">' . $nome_autor . '</div>';
                echo '<div class="bg-danger">' . $nacionalidade . '</div>';
                echo '<div class="bg-danger">' . $biografia . '</div>';
                echo '<div class="bg-danger">' . $data_nascimento . '</div>';
                echo '<div class="bg-danger">' . $foto . '</div>';

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

                $statement = $connect->prepare($query_cadastrar);
                if ($statement->execute(array(
                    ':nome_autor' => $nome_autor,
                    ':data_nascimento' => $data_nascimento,
                    ':nacionalidade' => $nacionalidade,
                    ':biografia' => $biografia,
                    ':foto' => $novo_nome
                ))) {
                    $div_message = "<div id='demo_1'></div>";
                } else {
                    $div_message = "<div id='demo_2'></div>";
                }

                // ARAZENO EM UMA VAR

                // $statement_cadastrar = $connect->prepare($query_cadastrar);
                // $statement_cadastrar->bindParam(':nome_autor', $nome_autor);
                // $statement_cadastrar->bindParam(':data_nascimento', $data_nascimento);
                // $statement_cadastrar->bindParam(':nacionalidade', $nacionalidade);
                // $statement_cadastrar->bindParam(':biografia', $biografia);
                // $statement_cadastrar->bindParam(':foto', $novo_nome);
                echo '<div class="bg-danger">' . $novo_nome . '</div>';

                // $statement_cadastrar->execute()) {
                // } 
            }
        }
    } catch (PDOException $e) {
        // Tratar a exceção gerada
        $error_message = $e->getMessage();
        $div_message = "<div class='bg-danger''>$error_message</div>";
    }
}

$diretorio = "../imgs/"; //define o diretorio para onde enviaremos o arquivo

$id = $_SESSION['id']; // ARMAZENHO O ID QUE VEIO DO VALUE

$stmt = $connect->prepare('SELECT * FROM usuarios WHERE id = :id');
$stmt->bindValue(':id', $id);

if ($stmt->execute() == true) {
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            //             unlink($diretorio . $row['user_caminho_imagem']); // DELETA DA PASTA A IMAGEM REFERENTE AO NOME (se quiser)
            // COMANDO DE EXCLUIR DEPOIS
        }
    } else {
        echo 'erro 003';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library by Matheus - Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://kit.fontawesome.com/9fd4de5623.js" crossorigin="anonymous"></script>
    <style>
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

        .hidden {
            display: none;
        }
    </style>

</head>

<body class="text-white" style="background-color: #000000;">
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3 col-12">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="image-mask">
                            <img class="img-thumbnail" src="<?php echo " ../imgs/" . $row['user_caminho_imagem'] . ""; ?>" alt="photoProfile">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-12 d-flex flex-column my-3">
                    <h5>Olá, <strong>
                            <?php echo mostrarPrimeiroNome($_SESSION['nome']); ?>
                        </strong></h5>
                    <p>Bem-vindo(a) a Library Management System (LMS).</p>


                    <ul class="navbar-nav flex-column mb-5">
                        <li class="nav-item">
                            <a href="../employee/index.php" class="nav-link my-3 text-white-50 ">
                                Início
                            </a>
                        </li>
                        <li>
                            <a href="../book/index.php" class="nav-link my-3 text-white-50">
                                Cadastrar Livro
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link my-3 text-white active">
                                Cadastrar Autor
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link my-3 text-white-50 ">
                                Cadastrar Funcionarios
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link my-3 text-white-50">
                                Lista de Usuarios
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link my-3 text-white-50">
                                Lista de Funcionarios
                            </a>
                        </li>
                        <li>
                            <div class="dropdown">
                                <a href="#" class="nav-link my-3 text-white-50 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <strong>Conta</strong>
                                </a>
                                <form action="" method="get">
                                    <ul class="dropdown-menu text-small shadow">
                                        <li><a class="dropdown-item" href="#">Configurações</a></li>
                                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><button class="dropdown-item" name="sair" href="#">Sair</button></li>
                                    </ul>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9 col-12 my-5">
                <div class="row">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <h1 class="text-center" style="color: #BF9363;">Informações do Autor</h1>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <label for="nome_autor">Nome do Autor:</label>
                                    <input type="text" class="form-control" id="nome_autor" name="nome_autor" maxlength="100" onkeypress="return soTexto(event)" placeholder="Ex: Carlos Almeida" required pattern=".{3,}">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="nacionalidade">Nacionalidade:</label>
                                    <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" maxlength="100" placeholder="Ex: Brasileiro" onkeypress="return soTexto(event)" required pattern=".{3,}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <label for="biografia">Biografia:</label>
                                    <textarea name="biografia" class="form-control p-2" id="biografia" placeholder="Colocamos em uma biografia dados importantes sobre a vida da pessoa de quem estamos falando." cols="10" rows="4" maxlength="300" required pattern=".{10,}"></textarea>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-md-6 col-12">
                                    <label for="data_nascimento">Data de nascimento:</label>
                                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" maxlength="8" required pattern=".{8,}">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="foto">Foto do livro:</label>
                                    <input type="file" class="form-control" required name="foto">
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 d-flex justify-content-center">
                            <button class="btn btn-primary cadastrar_autor" name="cadastrar_autor">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Adicionar o React. -->
    <script src="https://cdn.jsdelivr.net/npm/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://cdn.jsdelivr.net/npm/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>

    <script>
        var div1 = document.getElementById('div1');
        div1.classList.remove("hidden");

        const navLinks0 = document.querySelector('#navLinks0');
        const navLinks1 = document.querySelector('#navLinks1');
        const navLinks2 = document.querySelector('#navLinks2');

        navLinks0.classList.remove('fw-bolder');
        navLinks1.classList.remove('fw-bolder');
        navLinks2.classList.remove('fw-bolder');

        navLinks0.classList.add('text-white-50');
        navLinks1.classList.add('text-white-50');
        navLinks2.classList.add('text-white-50');

        function mostrarDiv(divId) {
            var div = document.getElementById(divId);
            var div2 = document.getElementById('div2');
            var div3 = document.getElementById('div3');

            // div1.classList.remove("hidden");



            if (divId === 'div1') {
                div1.classList.remove("hidden");
                div2.classList.add("hidden");
                div3.classList.add("hidden");

                navLinks0.classList.remove('text-white-50');
                navLinks1.classList.remove('text-white-50', 'fw-bolder');
                navLinks2.classList.remove('text-white-50', 'fw-bolder');

                navLinks0.classList.add('text-white', 'fw-bolder');
                navLinks1.classList.add('text-white-50');
                navLinks2.classList.add('text-white-50');

            } else if (divId === 'div2') {
                div2.classList.remove("hidden");
                div1.classList.add("hidden");
                div3.classList.add("hidden");

                navLinks1.classList.remove('text-white-50');
                navLinks0.classList.remove('text-white-50', 'fw-bolder');
                navLinks2.classList.remove('text-white-50', 'fw-bolder');

                navLinks1.classList.add('text-white', 'fw-bolder');
                navLinks0.classList.add('text-white-50');
                navLinks2.classList.add('text-white-50');

            } else if (divId === 'div3') {
                div3.classList.remove("hidden");
                div2.classList.add("hidden");
                div1.classList.add("hidden");

                navLinks2.classList.remove('text-white-50');
                navLinks0.classList.remove('text-white-50', 'fw-bolder');
                navLinks1.classList.remove('text-white-50', 'fw-bolder');

                navLinks2.classList.add('text-white', 'fw-bolder');
                navLinks0.classList.add('text-white-50');
                navLinks1.classList.add('text-white-50');
            }

        }
    </script>

    <script>
        const forms = document.querySelector(".forms"),
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
                title: 'Autor já existente',
                text: 'Tente novamente!'
            });
        } else if (y) {
            swal({
                icon: 'success',
                title: 'Autor cadastrado com sucesso! ✔',
                text: 'Parabéns 😃🥳'
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
                title: 'Erro no cadastro do Autor',
                text: 'Error: 002.'
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
                title: 'Formato de imagem inválido',
                text: 'Tente novamente!'
            });
        }
    </script>



</body>

</html>