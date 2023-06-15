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

        .card-img-overlay {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.2) 100%);
            padding: 10px;
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
                            <a href="#" class="nav-link my-3 text-white active">
                                Início
                            </a>
                        </li>
                        <li>
                            <a href="../book/index.php" class="nav-link my-3 text-white-50">
                                Cadastrar Livro
                            </a>
                        </li>
                        <li>
                            <a href="../autor/index.php" class="nav-link my-3 text-white-50">
                                Cadastrar Autor
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
                    <div class="col-md-10">
                        <h6 class="">Altere aqui os livros cadastrados</h6>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <a class="btn btn-block btn-secondary" href="#!">
                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
                        </a>
                    </div>
                    <div class="row">
                        <div class="d-flex">
                            <nav class="nav">
                                <a class="nav-link mx-2" id="navLinks0" href="#" onclick="mostrarDiv('div1')">Livros</a>
                                <!-- <a class="nav-link mx-2" id="navLinks1" href="#" onclick="mostrarDiv('div2')">Categoria</a> -->
                                <a class="nav-link mx-2" id="navLinks2" href="#" onclick="mostrarDiv('div3')">Autor</a>
                            </nav>
                        </div>
                    </div>

                    <!-- <div id="allBooksContainer"></div> -->


                    <div class="row hidden" id="div1">
                        <?php
                        $query_livros = 'SELECT livros.*, autores.aut_nome_completo FROM livros INNER JOIN autores ON livros.autor_id = autores.id';
                        $stm = $connect->prepare($query_livros);
                        if ($stm->execute()) {
                            if ($stm->rowCount() > 0) {
                                $result = $stm->fetchAll();
                                foreach ($result as $row) {
                        ?>
                                    <div class="col-md-3 col-12 my-3 d-flex">
                                        <a href="../details/book/index.php?id=<?php echo $row['id'] ?>">
                                            <div class="card">
                                                <img src="../imgs/<?php echo $row['lib_caminho_imagem'] ?>" class="card-img" alt="...">
                                                <div class="card-img-overlay">
                                                    <div class="card-content">
                                                        <h5 class="card-title text-white" style=""><?php echo $row['lib_nome_obra'] ?></h5>
                                                        <p class="card-text text-truncate text-white"><?php echo $row['aut_nome_completo'] ?></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </a>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>

                    <div class="row my-5 hidden" id="div2">
                        <div class="col-lg-2 col-md-2 col-12 d-flex align-items-center justify-content-center">
                            <img src="https://fakeimg.pl/100x80/" style="border-radius: 10px;" class="" alt="...">
                        </div>
                        <div class="col-lg-8 col-md-8 col-10">
                            <div class="text">
                                <h5 class="text-white">Titulo</h5>
                                <p class="text-white-50">Autor</p>
                                <p class="text-white-50 text-truncate">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis dolores
                                    architecto tempora nisi quia amet, quam aspernatur possimus, corrupti itaque
                                    repellendus perferendis ullam asperiores nobis veniam ex earum temporibus illo?
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-2 d-flex justify-content-end align-self-center">
                            <a class="btn btn-block btn-secondary" href="#!">
                                <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
                            </a>
                        </div>
                        <hr>
                    </div>

                    <div class="row my-5 hidden" id="div3">

                        <?php
                        $query_autores = 'SELECT * FROM autores';
                        $stm = $connect->prepare($query_autores);
                        if ($stm->execute()) {
                            if ($stm->rowCount() > 0) {
                                $result = $stm->fetchAll();
                                foreach ($result as $row) {
                        ?>
                                    <div class="col-lg-12 col-md-12 col-12 d-flex align-items-center justify-content-center my-2">
                                        <div class="col-lg-2 col-md-2 col-2 d-flex align-items-center justify-content-center">
                                            <img src="../imgs/<?php echo $row['aut_caminho_imagem'] ?>" style="border-radius: 50px;" class="image-mask" alt="...">
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-9 mx-3">
                                            <div class="text">
                                                <h5 class="text-white m-0"><?php echo $row['aut_nome_completo'] ?></h5>
                                                <p class="text-white-50">Data de nascimento: <?php echo $row['aut_data_nascimento'] ?></p>
                                                <p class="text-white-50 text-truncate m-0">Biografia:
                                                    <?php echo $row['aut_biografia'] ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-1">
                                            <a href="../details/autor/index.php?id=<?php echo $row['id'] ?>">

                                            Saiba +

                                            </a>
                                        </div>
                                        <hr class="mt-0">
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
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
        const navLinks0 = document.querySelector('#navLinks0');
        // const navLinks1 = document.querySelector('#navLinks1');
        const navLinks2 = document.querySelector('#navLinks2');

        navLinks0.classList.remove('fw-bolder');
        // navLinks1.classList.remove('fw-bolder');
        navLinks2.classList.remove('fw-bolder');

        navLinks0.classList.add('text-white-50');
        // navLinks1.classList.add('text-white-50');
        navLinks2.classList.add('text-white-50');

        // inicialização
        div1.classList.remove("hidden");
        navLinks0.classList.remove('text-white-50');
        navLinks0.classList.add('text-white', 'fw-bolder');

        function mostrarDiv(divId) {
            var div = document.getElementById(divId);
            // var div2 = document.getElementById('div2');
            var div3 = document.getElementById('div3');

            // div1.classList.remove("hidden");



            if (divId === 'div1') {
                div1.classList.remove("hidden");
                // div2.classList.add("hidden");
                div3.classList.add("hidden");

                navLinks0.classList.remove('text-white-50');
                // navLinks1.classList.remove('text-white-50', 'fw-bolder');
                navLinks2.classList.remove('text-white-50', 'fw-bolder');

                navLinks0.classList.add('text-white', 'fw-bolder');
                // navLinks1.classList.add('text-white-50');
                navLinks2.classList.add('text-white-50');

            // } else if (divId === 'div2') {
            //     div2.classList.remove("hidden");
            //     div1.classList.add("hidden");
            //     div3.classList.add("hidden");

            //     navLinks1.classList.remove('text-white-50');
            //     navLinks0.classList.remove('text-white-50', 'fw-bolder');
            //     navLinks2.classList.remove('text-white-50', 'fw-bolder');

            //     navLinks1.classList.add('text-white', 'fw-bolder');
            //     navLinks0.classList.add('text-white-50');
            //     navLinks2.classList.add('text-white-50');

            } else if (divId === 'div3') {
                div3.classList.remove("hidden");
                div2.classList.add("hidden");
                div1.classList.add("hidden");

                navLinks2.classList.remove('text-white-50');
                navLinks0.classList.remove('text-white-50', 'fw-bolder');
                // navLinks1.classList.remove('text-white-50', 'fw-bolder');

                navLinks2.classList.add('text-white', 'fw-bolder');
                navLinks0.classList.add('text-white-50');
                // navLinks1.classList.add('text-white-50');
            }


        }


        // function handleNavButtonClick(value) {
        // const allBooksContainer = document.getElementById('allBooksContainer');

        // Remove a classe 'text-white-50' e adiciona a classe 'text-white fw-bolder'




        // } else if (value == 'Categoria') {


        // allBooksContainer.innerHTML = `


        // `;
        // } else if (value == 'Autor') {
        // navLinks2.classList.remove('text-white-50');
        // navLinks2.classList.add('text-white', 'fw-bolder');
        // allBooksContainer.innerHTML = `

        // `;
        // }
        // }
        // // Executar a função handleNavButtonClick com o valor 'Todos' ao carregar a página
        // document.addEventListener('DOMContentLoaded', function() {
        // handleNavButtonClick('Todos');
        // });
    </script>



</body>

</html>