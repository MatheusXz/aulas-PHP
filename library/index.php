<?php

require_once('pages/conn/index.php');

session_start();

if (isset($_GET['sair']) || !isset($_SESSION['nome']) || !isset($_SESSION['id'])) {
    $loca = 'location: pages/login/index.php';
    exitSession($loca);
}

try {
    if ($_SESSION['nivel_acesso'] == 'funcionario') {
        header('Location: pages/employee/index.html');
    }
} catch (PDOException $e) {
    // Aqui, você pode adicionar um tratamento adicional, como registrar o erro em um arquivo de log
    echo 'Erro: ' . $e->getMessage();
}

// para apagar aqui em baixo

$diretorio = "pages/imgs/"; //define o diretorio para onde enviaremos o arquivo

$id = $_SESSION['id']; // ARMAZENHO O ID QUE VEIO DO VALUE

$stmt = $connect->prepare('SELECT * FROM usuarios WHERE id = :id');
$stmt->bindValue(':id', $id);

if ($stmt->execute() == true) {
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
        //             unlink($diretorio . $row['user_caminho_imagem']); // DELETA DA PASTA A IMAGEM REFERENTE AO NOME (se quiser)
        
        }
        // COMANDO DE EXCLUIR DEPOIS
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
    </style>

</head>

<body class="text-white" style="background-color: #000000;">
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3 col-12">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="image-mask">
                            <img class="img-thumbnail" src="<?php echo "pages/imgs/" . $row['user_caminho_imagem'] . ""; ?>" alt="photoProfile">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-12 d-flex flex-column my-3">
                    <h5>Olá, <strong><?php echo mostrarPrimeiroNome($_SESSION['nome']); ?></strong></h5>
                    <p>Bem-vindo(a) a Library Management System (LMS).</p>


                    <ul class="navbar-nav flex-column mb-5">
                        <li class="nav-item">
                            <a href="#" class="nav-link my-3 text-white active">
                                Início
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link my-3 text-white-50">
                                Minha Biblioteca
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link my-3 text-white-50">
                                Prazos
                                <span class="ml-0 notification-badge">1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link my-3 text-white-50 ">
                                Lendo
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link my-3 text-white-50">
                                Lidos
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
                        <h6 class="">Explore e embarque em uma jornada literária 🥳</h6>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <a class="btn btn-block btn-secondary" href="#!">
                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
                        </a>
                    </div>
                    <div class="row">
                        <div class="d-flex">
                            <nav class="nav">
                                <a class="nav-link mx-2" id="navLinks0" href="#" onclick="handleNavButtonClick('Todos')">Todos</a>
                                <a class="nav-link mx-2" id="navLinks1" href="#" onclick="handleNavButtonClick('Categoria')">Categoria</a>
                                <a class="nav-link mx-2" id="navLinks2" href="#" onclick="handleNavButtonClick('Autor')">Autor</a>
                            </nav>
                        </div>
                    </div>

                    <div id="allBooksContainer"></div>

                </div>

                <nav class="my-nav">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                        </li>
                        <li class="page-item text-white"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Próximo</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <!-- <p>Este é um Sistema de Gerenciamento de Biblioteca (LMS) que gerencia livros, autor, editora,
        gênero, status do livro, empréstimo de livro, devolução de livro</p>
    <p>Este LMS foi feito com o objetivo de auxiliar o gerenciamento de biblioteca e facilitar
        a vida dos alunos e professores.</p>
    <p>Este LMS é gratuito e livre de custo e tem como objetivo auxiliar o gerenciamento de
        biblioteca e facilitar a vida dos alunos e professores.</p> -->



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Adicionar o React. -->
    <script src="https://cdn.jsdelivr.net/npm/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://cdn.jsdelivr.net/npm/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>

    <script>
        function handleNavButtonClick(value) {
            const allBooksContainer = document.getElementById('allBooksContainer');

            // Remove a classe 'text-white-50' e adiciona a classe 'text-white fw-bolder'
            const navLinks0 = document.querySelector('#navLinks0');
            const navLinks1 = document.querySelector('#navLinks1');
            const navLinks2 = document.querySelector('#navLinks2');

            navLinks0.classList.remove('fw-bolder');
            navLinks1.classList.remove('fw-bolder');
            navLinks2.classList.remove('fw-bolder');

            navLinks0.classList.add('text-white-50');
            navLinks1.classList.add('text-white-50');
            navLinks2.classList.add('text-white-50');


            if (value == 'Todos') {
                navLinks0.classList.remove('text-white-50');
                navLinks0.classList.add('text-white', 'fw-bolder');
                allBooksContainer.innerHTML = `
                <div class="row">
                    <div class="col-md-3 col-12 my-3 d-flex align-items-center">
                        <a class="" href="pages/details/">
                            <div class="card">
                                <img src="https://fakeimg.pl/330x600?font=bebas" class="card-img" alt="...">
                                <div class="card-img-overlay">
                                    <h5 class="card-title">Titulo</h5>
                                    <p class="card-text">Autor</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-12 my-3 d-flex align-items-center">
                        <div class="card">
                            <img src="https://fakeimg.pl/330x600?font=bebas" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <h5 class="card-title">Titulo</h5>
                                <p class="card-text">Autor</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 my-3 d-flex align-items-center">
                        <div class="card">
                            <img src="https://fakeimg.pl/330x600?font=bebas" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <h5 class="card-title">Titulo</h5>
                                <p class="card-text">Autor</p>
                            </div>
                        </div>
                    </div>
                </div>`;
            } else if (value == 'Categoria') {
                navLinks1.classList.remove('text-white-50');
                navLinks1.classList.add('text-white', 'fw-bolder');

                allBooksContainer.innerHTML = `
                <div class="row my-5">
                    <div class="col-lg-2 col-md-2 col-12 d-flex align-items-center justify-content-center">
                        <img src="https://fakeimg.pl/100x80/" style="border-radius: 10px;" class="" alt="...">
                    </div>
                    <div class="col-lg-8 col-md-8 col-10">
                        <div class="text">
                            <h5 class="text-white">Titulo</h5>
                            <p class="text-white-50">Autor</p>
                            <p class="text-white-50 text-truncate">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis dolores architecto tempora nisi quia amet, quam aspernatur possimus, corrupti itaque repellendus perferendis ullam asperiores nobis veniam ex earum temporibus illo?
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-2 d-flex justify-content-end align-self-center">
                        <a class="btn btn-block btn-secondary" href="#!">
                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
                        </a>
                    </div>
                </div>
                <hr>
                
                `;
            } else if (value == 'Autor') {
                navLinks2.classList.remove('text-white-50');
                navLinks2.classList.add('text-white', 'fw-bolder');
                allBooksContainer.innerHTML = `
                <div class="row my-5">
                    <div class="col-lg-2 col-md-2 col-2 d-flex align-items-center justify-content-center">
                        <img src="https://fakeimg.pl/80x80/" style="border-radius: 50px;" class="" alt="...">
                    </div>
                    <div class="col-lg-10 col-md-10 col-10">
                        <div class="text">
                            <h5 class="text-white m-0">Nome Autor</h5>
                            <p class="text-white-50 m-2">idade</p>
                            <p class="text-white-50 text-truncate m-0">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis dolores architecto tempora nisi quia amet, quam aspernatur possimus, corrupti itaque repellendus perferendis ullam asperiores nobis veniam ex earum temporibus illo?
                            </p>
                        </div>
                    </div>
                </div>
                <hr class="mt-0">
                <div class="row my-5">
                    <div class="col-lg-2 col-md-2 col-2 d-flex align-items-center justify-content-center">
                        <img src="https://fakeimg.pl/80x80/" style="border-radius: 50px;" class="" alt="...">
                    </div>
                    <div class="col-lg-10 col-md-10 col-10">
                        <div class="text">
                            <h5 class="text-white m-0">Nome Autor</h5>
                            <p class="text-white-50 m-2">idade</p>
                            <p class="text-white-50 text-truncate m-0">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis dolores architecto tempora nisi quia amet, quam aspernatur possimus, corrupti itaque repellendus perferendis ullam asperiores nobis veniam ex earum temporibus illo?
                            </p>
                        </div>
                    </div>
                </div>
                <hr class="mt-0">
                `;
            }
        }
        // Executar a função handleNavButtonClick com o valor 'Todos' ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            handleNavButtonClick('Todos');
        });
    </script>

</body>

</html>