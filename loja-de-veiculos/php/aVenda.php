<?php

require_once('conn.php');

session_start();

if (isset($_POST['sair'])) {
    $loca = 'location: login.php';
    exitSession($loca);
}

$countSearch  = 0;
$countStatusOn = 0;
if (isset($_POST['pesquisa'])) {
    $div_message = '';
    $pesquisar = $_POST['pesquisa_feita'];
    $id = $_SESSION['id_user'];

    if (empty($_POST['pesquisa_feita'])) {
        $div_message = "<div id='demo_0'></div>";
    } else {
        $pesquisar = $_POST['pesquisa_feita'];
        $id = $_SESSION['id_user'];
        $querySearch = "SELECT * FROM carros_car WHERE car_status = 'on'";
        $bindPesquisar = false;

        if (empty($_POST['s_fab']) && empty($_POST['s_mod']) && empty($_POST['s_ano'])) {
            $querySearch .= " AND car_nome LIKE :pesquisar";
            $bindPesquisar = true;
        } elseif (!empty($pesquisar)) {
            if (!empty($_POST['s_fab'])) {
                $querySearch .= " AND car_fabricante LIKE :pesquisar";
                $bindPesquisar = true;
            }
            if (!empty($_POST['s_mod'])) {
                $querySearch .= " AND car_modelo LIKE :pesquisar";
                $bindPesquisar = true;
            }
            if (!empty($_POST['s_ano'])) {
                $querySearch .= " AND car_ano LIKE :pesquisar";
                $bindPesquisar = true;
            }
        }

        $stmth = $connect->prepare($querySearch);

        if ($bindPesquisar) {
            $stmth->bindValue(":pesquisar", '%' . $pesquisar . '%', PDO::PARAM_STR);
        }

        $stmth->execute();
        $countSearch = $stmth->rowCount();
    }
} else {
    $div_message = '';
    $querySqlStatusOn = "SELECT * FROM carros_car WHERE car_status = 'on'";
    $stmth = $connect->prepare($querySqlStatusOn);
    // $stmth->bindValue(':id', $_SESSION['id_user']);
    $stmth->execute();
    $countStatusOn = $stmth->rowCount();
}

$idCompradorLogado = $_SESSION['id_user'];

$querySaldoComprador = 'SELECT user_saldo FROM usuarios_car WHERE id = :idCompradorLogado';
$stmthSaldoComprador = $connect->prepare($querySaldoComprador);
$stmthSaldoComprador->bindValue(":idCompradorLogado", $idCompradorLogado);
$stmthSaldoComprador->execute();
$resultSaldoComprador = $stmthSaldoComprador->fetch(PDO::FETCH_ASSOC);
$saldoComprador = $resultSaldoComprador['user_saldo'];

if (isset($_POST['compra'])) {
    $div_message = '';
    $idVeiculo = $_POST['id'];
    $user_id = $_POST['user_id'];
    $precoVeiculo = $_POST['precoVeiculo'];
    $idCompradorLogado = $_SESSION['id_user'];

    $querySaldoComprador = 'SELECT user_saldo FROM usuarios_car WHERE id = :idCompradorLogado';
    $stmthSaldoComprador = $connect->prepare($querySaldoComprador);
    $stmthSaldoComprador->bindValue(":idCompradorLogado", $idCompradorLogado);
    $stmthSaldoComprador->execute();
    $resultSaldoComprador = $stmthSaldoComprador->fetch(PDO::FETCH_ASSOC);
    $saldoComprador = $resultSaldoComprador['user_saldo'];

    if ($saldoComprador < $precoVeiculo) {
        $div_message = '<div id="demo_4"></div>';
    } else {
        $query_compra = 'UPDATE `carros_car` SET
        user_id  = :idCompradorLogado WHERE id = :idVeiculo';
        $stmth = $connect->prepare($query_compra);
        $stmth->bindValue(":idCompradorLogado", $idCompradorLogado);
        $stmth->bindValue(":idVeiculo", $idVeiculo);
        $stmth->execute();
        $countCompra = $stmth->rowCount();
        if ($countCompra > 0) {
            // Atualiza o saldo do comprador
            $novoSaldoComprador = $saldoComprador - $precoVeiculo;
            $queryAtualizarSaldoComprador = 'UPDATE usuarios_car SET user_saldo = :novoSaldoComprador WHERE id = :idCompradorLogado';
            $stmthAtualizarSaldoComprador = $connect->prepare($queryAtualizarSaldoComprador);
            $stmthAtualizarSaldoComprador->bindValue(":novoSaldoComprador", $novoSaldoComprador);
            $stmthAtualizarSaldoComprador->bindValue(":idCompradorLogado", $idCompradorLogado);
            $stmthAtualizarSaldoComprador->execute();

            // Atualiza o saldo do vendedor
            $querySaldoVendedor = 'SELECT user_saldo FROM usuarios_car WHERE id = :idVendedor';
            $stmthSaldoVendedor = $connect->prepare($querySaldoVendedor);
            $stmthSaldoVendedor->bindValue(":idVendedor", $user_id);
            $stmthSaldoVendedor->execute();
            $resultSaldoVendedor = $stmthSaldoVendedor->fetch(PDO::FETCH_ASSOC);
            $saldoVendedor = $resultSaldoVendedor['user_saldo'];
            $novoSaldoVendedor = $saldoVendedor + $precoVeiculo;
            $queryAtualizarSaldoVendedor = 'UPDATE usuarios_car SET user_saldo = :novoSaldoVendedor WHERE id = :idVendedor';
            $stmthAtualizarSaldoVendedor = $connect->prepare($queryAtualizarSaldoVendedor);
            $stmthAtualizarSaldoVendedor->bindValue(":novoSaldoVendedor", $novoSaldoVendedor);
            $stmthAtualizarSaldoVendedor->bindValue(":idVendedor", $user_id);
            $stmthAtualizarSaldoVendedor->execute();

            $div_message = "<div id='demo_2'></div>";
            echo "
            <script>
                setTimeout(function(){
                    window.location.href = 'aVenda.php';
                }, 2000);
            </script>";
        } else {
            $div_message = "<div id='demo_3'></div>";
        }
    }
}


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
    <script src="https://kit.fontawesome.com/9fd4de5623.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="../css/main.css" rel="stylesheet">

</head>

<body>
    <nav style="background-color: #001e50;" class="navbar navbar-dark py-3">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="../img/volkswagen-logo-9.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
                Volkswagen
            </a>

            <a class="navbar-brand" href="../index.php">Meus veiculos <i class="fa-solid fa-car" style="color: #ffffff;"></i></a>
            <a class="navbar-brand" href="aVenda.php">Carros a venda <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></a>
            <a class="navbar-brand" href="cadVeiculo.php">Cadastrar <i class="fa-solid fa-plus" style="color: #ffffff;"></i></a>
            <a class="navbar-brand" href="desativados.php">Veiculos desativados <i class="fa-solid fa-skull-crossbones" style="color: #ffffff;"></i></a>

            <div class="ml-0">
                <form action="" method="POST">
                    <button class="cta" name="sair">
                        <span class="span">Sair</span>
                        <span class="second">
                            <a href="#">
                                <img src="../img/bot.svg" alt="Sair">
                            </a>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-12 col-12">
                    <form action="" method="POST">
                        <div class="flex-shrink-0 my-5">
                            <div class="input-group ">
                                <input type="text" class="form-control" placeholder="O que você procura..." name="pesquisa_feita" aria-label="Text" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit" name="pesquisa"> <img src="../img/pesquisar.svg"></button>
                                </div>
                            </div>
                            <div class="my-3">
                                <label class="text-center form-check-label">
                                    Filtrar por:
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="fab" name="s_fab" id="s-fab">
                                    <label class="form-check-label" for="s-fab">
                                        Fabricante
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="mod" name="s_mod" id="s-mod">
                                    <label class="form-check-label" for="s-mod">
                                        Modelo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="ano" name="s_ano" id="s-ano">
                                    <label class="form-check-label" for="s-ano">
                                        Ano
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-9 col-md-12 col-12">
                    <div class="flex-shrink-0 px-3">

                        <div class="row text-center">
                            <h1> Lista de veiculos cadastrados </h1>
                            <h6 class='text-danger'>O veiculos que são seus estão com (*) e com cor diferente</h6>
                        </div>
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
                                    <th scope="col">Comprar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                echo $div_message;

                                if ($countSearch > 0) {
                                    $resultado = $stmth->fetchAll();
                                    $i = 1;
                                    foreach ($resultado as $row) {
                                        echo "
                                    <tr>
                                        <th scope='row'>" . $i . "</th>
                                        <td>" . $row['car_nome'] . "</td>
                                        <td>" . $row['car_fabricante'] . "</td>
                                        <td>" . $row['car_cor'] . "</td>
                                        <td>" . $row['car_modelo'] . "</td>
                                        <td>" . $row['car_ano'] . "</td>
                                        <td>R$ " . number_format($row['car_preco'], 2, ',', '.') . "</td>";
                                        if ($row['user_id'] == $_SESSION['id_user']) {
                                            echo "
                                        <td class='text-centercompra'><span class='text'>Meu veiculo (*)</span></td>
                                    </tr>";
                                        } else {
                                            echo "
                                        <td>
                                        <form action='' method='POST'>
                                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                                            <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                                            <input type='hidden' name='precoVeiculo' value='" . $row['car_preco'] . "'>
                                            <button type='submit' name='compra' class='noselect compra'><span class='text'>Comprar</span><span class='icon'><img src='../img/compra.svg' alt=''>
                                            </span></button>
                                        </form>
                                        </td>
                                    </tr>
                                    ";
                                        }
                                        $i++;
                                    }
                                }
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
                                        <td>R$ " . number_format($row['car_preco'], 2, ',', '.') . "</td>
                                        ";
                                        if ($row['user_id'] == $_SESSION['id_user']) {
                                            echo "
                                        <td class='text-centercompra'><span class='text'>Meu veiculo (*)</span></td>
                                    </tr>";
                                        } else {
                                            echo "
                                        <td>
                                        <form action='' method='POST'>
                                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                                            <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                                            <input type='hidden' name='precoVeiculo' value='" . $row['car_preco'] . "'>
                                            <button type='submit' name='compra' class='noselect compra'><span class='text'>Comprar</span><span class='icon'><img src='../img/compra.svg' alt=''>
                                            </span></button>
                                        </form>
                                        </td>
                                    </tr>
                                    ";
                                        }
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <footer class="fixed-bottom bg-warning py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>SALDO <?php echo "R$ " . number_format($saldoComprador, 2, ',', '.') ?></h1>
                        </div>
                    </div>
                </div>
            </footer>

        </div>

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
                    title: 'Ooops! Este veículo não esta disponivel!',
                    text: 'Tente novamente.'
                });
            } else if (y) {
                swal({
                    icon: 'error',
                    title: 'Nenhum filtro selecionado!',
                    text: 'Tente novamente'
                });
            } else if (a) {
                swal({
                    icon: 'error',
                    title: 'Campo de pesquisa não preenchido',
                    text: 'Tente novamente'
                });
            } else if (z) {
                swal({
                    icon: 'success',
                    title: 'MEUS PAREBÉNS! 😁',
                    text: 'Veículo comprado com sucesso!'
                });
            } else if (b) {
                swal({
                    icon: 'error',
                    title: 'Saldo insuficiente!',
                    text: 'que pena...'
                });
            }
        </script>


    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>