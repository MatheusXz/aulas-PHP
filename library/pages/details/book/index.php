<?php
require_once('../../conn/index.php');

session_start();

if (isset($_GET['sair']) || !isset($_SESSION['nome']) || !isset($_SESSION['id'])) {
    $loca = 'location: ../../login/index.php';
    exitSession($loca);
}

$id = $_GET['id'];

// Validação do ID (exemplo)
if (!is_numeric($id)) {
    // Lógica para lidar com um ID inválido, como exibir uma mensagem de erro ou redirecionar para outra página
    // Por exemplo:
    echo '<div style="background-color: #FFCCCC; padding: 10px; border: 1px solid #FF0000; color: #FF0000;">ID inválido</div>';
    exit;
}
echo $id;

// Sanitização do ID (exemplo usando a função filter_var)
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

$stmt = $connect->prepare('SELECT livros.*, autores.aut_nome_completo FROM livros INNER JOIN autores ON livros.autor_id = autores.id WHERE livros.id = :id');
$stmt->bindValue(':id', $id);
$stmt->execute();

if ($stmt->execute() == true) {
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
        }
        
    } else {
        echo '<div style="background-color: #FFCCCC; padding: 10px
        ; border: 1px solid #FF0000; color: #FF00
        00;">Livro não encontrado</div>';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library by Matheus - Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../css/details.css">
    <script src="https://kit.fontawesome.com/9fd4de5623.js" crossorigin="anonymous"></script>
    <script src="../../../src/js/main.js"></script>
</head>

<body class="text-white bg-fundo-img">
    <div class="overlay-fundo" style="height: 100vh;">
        <div class="container">
            <div class="row pt-5">
                <div class="col-md-6 col-12">
                    <div class="row">
                        <a onclick="goBack()" href="#" class="nav-link"><i class="fa-solid fa-arrow-left mx-3"></i>Voltar a lista</a>
                    </div>
                    <div class="box-img">
                        <div class="row card-book" style="position: relative; height: 80vh;">
                            <div class="col-12 mx-auto d-flex justify-content-center align-items-center">
                                <div class="image-mask">
                                    <img class="" style="border-radius: 20px;" src="../../imgs/<?php echo $row['lib_caminho_imagem']?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 flex-column">
                    <div class="row col-12 d-sm-block justify-content-center mx-auto">
                        <small class=" text-center bg-danger btn-danger btn-sm col-12" style="border-radius: 20px; font-size: .8rem;">Novo</small>
                    </div>
                    <div class="row col-12">
                        <h6 class="text-left display-6 fw-bold mt-3"><?php echo $row['lib_nome_obra']?></h6>
                    </div>
                    <div class="row">
                        <p class="text-left fw-bold">por <span class="fw-normal text-decoration-underline"><a class="link-info" href="../autor/index.php?id=<?php echo $row['autor_id']?>"><?php echo $row['aut_nome_completo']?></a></span> (Autor)
                    </div>
                    <div class="row">
                        <p class="text-left text-white-50 fw-bolder mt-2">Descrição</p>
                    </div>
                    <div class="row">
                        <p class="text-left text-white"><?php echo $row['lib_edicao']?></p>
                    </div>
                    <div class="row">
                        <p class="text-left text-white">A obra tem sido publicada em <span class="aqui-vou por o ano"><?php echo $row['lib_ano_publicacao']?></span>.
                        <div class="col-6">
                            <p>Editora <span class="" style="color: #BF9363;"><?php echo $row['lib_editora']?></span></p>
                        </div>
                        <div class="col-3">
                            <p><?php echo $row['lib_edicao']?>ª Edição</p>
                        </div>
                        <div class="col-3">
                            <p>Páginas <?php echo $row['lib_numero_paginas']?></p>
                        </div>
                    </div>
                    <div class="row">
                        <p>ISBN | <?php echo $row['lib_codigo_isbn']?></p>
                    </div>
                    <div class="row my-5">
                        <div class="col-6">
                            <p class="btn w-100 text-white-50">Disponível (<?php echo $row['lib_quantidade']?> unidades)</p>
                        </div>
                        <div class="col-6">
                            <a class="btn btn-success w-100" href="https://www.google.com/search?q=Clarice+Goulart+Livro+de+Amor+e+Misterias+de+Clarice+Goulart+Liv" target="_blank">Retirar na Biblioteca!</a>
                            <!-- DEIXAR RETIRAR SOMENTE UM LIVRO - SE TENTAR TIRAR OUTRO FALAR QUE PRECISA DEVOLVER ESTE QUE AINDA SE ENCONTRA COM ELE SE JPA FEZ A RETIRADA - NO SISTAMA
                            DO FUNCIONARIO VAI TER UM BOTÃO CONSTANDO SE O ALUNO TAL JÁ RETIROU O LIVRO SOLICITADO, E A DATA DA SOLICITAÇÃO DO MESMO -->
                        </div>
                    </div>
                </div>
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