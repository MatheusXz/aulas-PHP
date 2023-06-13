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

// Sanitização do ID (exemplo usando a função filter_var)
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
$stmt = $connect->prepare('SELECT livros.*, autores.* FROM livros INNER JOIN autores ON livros.autor_id = autores.id WHERE autores.id = :id');
$stmt->bindValue(':id', $id);
$stmt->execute();

if ($stmt->execute() == true) {
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll();
        foreach ($result as $row2) {
        }
    } else {
        echo '<div style="background-color: #FFCCCC; padding: 10px
        ; border: 1px solid #FF0000; color: #FF00
        00;">Autor não encontrado</div>';
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
    <title>Library by Matheus - Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../css/details.css">
    <script src="https://kit.fontawesome.com/9fd4de5623.js" crossorigin="anonymous"></script>
    <script src="../../../src/js/main.js"></script>

    <style>
        .mask {
            border: 3px solid #fff;
            max-width: 200px;
            min-width: 200px;
            width: 100%;
            height: auto;
            border-radius: 50%;
            overflow: hidden;
        }

        .mask img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
    </style>

</head>

<body class="text-white bg-fundo-img">
    <div class="overlay-fundo">
        <div class="container">
            <div class="row py-5">

                <div class="col-md-3 col-12">
                    <div class="row">
                        <a onclick="goBack()" href="#" class="nav-link"><i class="fa-solid fa-arrow-left mx-3"></i>Voltar ao livro</a>
                    </div>
                    <nav>
                        <ol class="nav">
                            <li class="breadcrumb-item text-light"><a href="../../../" class="text-white-50">Início&nbsp;</a></li>
                            <li class="breadcrumb-item text-light active" aria-current="page">&nbsp;Autor</li>
                        </ol>
                    </nav>
                    <div class="d-flex justify-content-center my-5">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <img class="mask" src="../../imgs/<?php echo $row2['aut_caminho_imagem'] ?>" alt="photoProfile">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-12 d-flex flex-column mb-3">
                        <div class="text-center">
                            <h6>Autor</h6>
                            <h5><strong><?php echo $row2['aut_nome_completo'] ?></strong></h5>
                            <p>
                                <i class="fas fa-map-marker-alt"></i> <strong><?php echo $row2['aut_nacionalidade'] ?></strong>
                            </p>
                            <p class="text-white-50"><?php echo $row2['aut_data_nascimento'] ?></p>

                        </div>
                        <div class="row">
                            <h4 class="text-center mt-5">Biografia</h4>
                            <p class="" style="text-align: justify;">
                                <?php echo $row2['aut_biografia'] ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-12 mb-5">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="">Livros escritos por esse autor</h3>
                        </div>
                        <div class="row">
                            <div class="d-flex">
                                <div class="row">
                                    <?php
                                    $query_livros_id = 'SELECT livros.*, autores.* FROM livros INNER JOIN autores ON livros.autor_id = :id';
                                    $stmt = $connect->prepare($query_livros_id);
                                    $stmt->bindValue(':id', $id);


                                    if ($stmt->execute()) {
                                        if ($stmt->rowCount() > 0) {
                                            $result = $stmt->fetchAll();
                                            foreach ($result as $rows) {


                                    // $query_livros = 'SELECT livros.*, autores.* FROM livros INNER JOIN autores ON livros.autor_id = autores.id WHERE livros.autor_id = :id';
                                    // $stmt = $connect->prepare($query_livros);
                                    // $stmt->bindValue(':id', $id);
                                    // if ($stmt->execute()) {
                                    //     if ($stmt->rowCount() > 0) {
                                    //         $result = $stmt->fetchAll();
                                    //         foreach ($result as $rows) {
                                    ?>
                                                <div class="col-md-3 col-12 my-3 d-flex align-items-center">
                                                    <a href="../../details/book/index.php?id=<?php echo $rows['id'] ?>">
                                                        <div class="card">
                                                            <img src="../../imgs/<?php echo $rows['lib_caminho_imagem'] ?>" class="card-img" alt="...">
                                                            <div class="card-img-overlay">
                                                                <div class="card-content">
                                                                    <h5 class="card-title"><?php echo $rows['lib_nome_obra'] ?></h5>
                                                                    <p class="card-text"><?php echo $rows['aut_nome_completo'] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                    <?php
                                            }
                                        } else {
                                            echo '<div class="col-12">Nenhum livro encontrado.</div>';
                                        }
                                    } else {
                                        echo '<div class="col-12">Erro ao executar a consulta.</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
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

</body>

</html>