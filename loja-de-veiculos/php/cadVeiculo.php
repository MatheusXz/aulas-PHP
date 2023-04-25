<?php
require_once('conn.php');

if (isset($_POST['sair'])) {
    session_start();
    session_destroy();
    header('location: login.php');
}

session_start();

// Verifica se o usuário está logado, se não, redireciona para a página de login
if (!isset($_SESSION['id_user']) || !isset($_SESSION['nome_user'])) {
    header('Location: login.php');
    exit();
}

$div_message = "";

if (isset($_POST['cadastrar'])) {
    // VARIAVEIS
    $nome_car           = $_POST['nome'];
    $fabricante_car     = $_POST['fabricante'];
    $cor_car            = $_POST['cor'];
    $modelo_car         = $_POST['modelo'];
    $ano_car            = $_POST['ano'];
    $preco_car          = $_POST['preco'];

    if (!isset($nome_car, $fabricante_car, $cor_car, $modelo_car, $ano_car, $preco_car)) {
        // Alguma variável não foi definida
        $div_message = "<div id='demo_0'></div>";
    } elseif (empty($nome_car) || empty($fabricante_car) || empty($cor_car) || empty($modelo_car) || empty($ano_car) || empty($preco_car)) {
        // Alguma variável está vazia
        $div_message = "<div id='demo_3'></div>";
    } else {
        // VERIFICAR SE EMAIL JÁ EXISTE
        $query_cadastrar = 'INSERT INTO `carros_car` (
            id,
            user_id,
            car_nome,
            car_fabricante,
            car_cor,
            car_modelo,
            car_ano,
            car_preco,
            car_status
        ) VALUES (
            default,
            :id_session,
            :nome,
            :fabricante,
            :cor,
            :modelo,
            :ano,
            :preco,
            default
        )';
        $stm = $connect->prepare($query_cadastrar);

        $stm->bindParam(':id_session',  $_SESSION['id_user']);
        $stm->bindParam(':nome',        $nome_car);
        $stm->bindParam(':fabricante',  $fabricante_car);
        $stm->bindParam(':cor',         $cor_car);
        $stm->bindParam(':modelo',      $modelo_car);
        $stm->bindParam(':ano',         $ano_car);
        $stm->bindParam(':preco',       $preco_car);

        // VERIFICA SE EXECUTOU TUDO CERTO
        if ($stm->execute()) {
            $div_message = "<div id='demo_1'></div>";
        } else {
            $div_message = "<div id='demo_2'></div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de veiculos</title>


    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">

    <!--  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        :root {
            --step--2: clamp(0.69rem, calc(0.58rem + 0.60vw), 1.00rem);
            --step--1: clamp(0.83rem, calc(0.67rem + 0.81vw), 1.25rem);
            --step-0: clamp(1.00rem, calc(0.78rem + 1.10vw), 1.56rem);
            --step-1: clamp(1.20rem, calc(0.91rem + 1.47vw), 1.95rem);
            --step-2: clamp(1.44rem, calc(1.05rem + 1.95vw), 2.44rem);
            --step-3: clamp(1.73rem, calc(1.21rem + 2.58vw), 3.05rem);
            --step-4: clamp(2.07rem, calc(1.39rem + 3.40vw), 3.82rem);
            --step-5: clamp(2.49rem, calc(1.60rem + 4.45vw), 4.77rem);
            --ff-primary: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            --color-primary: #0092ca;
            --color-secondary: #6dd5ed;
            --color-primary-dark: #192294;
            --color-error: #cc3333;
            --color-success: #4bb544;
            --color-link: #606470;
            --color-link-dark: #3c4245;
            --color-background: #f5f9ee;
            --color-border-sc: #ececec;
            --color-border-focus: #a9d7f6;
            --color-border: #eeeeee;
            --bs: #ffa857;
            --color-dark-grey: #a4a3a3;
            --gradient: linear-gradient(135deg var(--color-primary), var(--color-secondary));
        }

        .container_login {
            position: relative;
            width: 100%;
            height: 80%;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form {
            position: absolute;
            width: 80%;
            max-width: 480px;
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
            padding: 3em 2.2em;
            transition: all .3s ease-in-out;
        }

        /* Criar */



        .forms.show-signup .form.sign-up {
            opacity: 1;
            pointer-events: auto;
        }

        .forms.show-signup .form.sign-in {
            opacity: 0;
            pointer-events: none;
        }

        /* Validação */

        .form input:focus,
        .forum input:not(:placeholder-shown) {
            background-color: var(--color-background);
            border-color: var(--color-border-focus);
        }

        .form input:focus,
        .forum input:placeholder-shown {
            box-shadow: 0 0 0 2px var(--color-border-focus);
        }

        .form input:focus:valid {
            box-shadow: 0 0 0 2px var(--color-success);
        }

        .form input:valid:not(:placeholder-shown) {
            border-color: var(--color-success);
        }

        .form input:focus:invalid {
            box-shadow: 0 0 0 2px var(--color-error);
        }

        .form input:invalid:not(:placeholder-shown) {
            border-color: var(--color-error);
        }
    </style>

</head>

<body>
    <?php echo $div_message; ?>
    <div class="forms row container_login">
        <div class="form sign-up">
            <form action="" method="post">
                <h2 class="text-center">Cadastro de veiculos</h2>
                <div class="form-group">
                    <!-- NOME -->
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Gol" maxlength="18" required pattern=".{3,}">

                    <!-- FABRICANTE -->
                    <label for="fabricante">Fabricante:</label>
                    <input type="text" class="form-control" id="fabricante" name="fabricante" placeholder="Ex: Volkswagen" maxlength="18" required pattern=".{3,}">

                    <!-- EMAIL -->
                    <label for="cor">Cor:</label>
                    <select class="form-control" required name="cor">
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
                    <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Ex: Hatch" maxlength="18" required pattern=".{3,}">

                    <label for="ano">Ano:</label>
                    <input type="text" class="form-control" id="ano" name="ano" placeholder="Ex: 2021" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="4" required pattern=".{4,4}">

                    <label for="preco">Preço:</label>
                    <input type="text" class="form-control" id="preco" name="preco" placeholder="somente números" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="8" required pattern=".{2,}">

                    <div class="my-5 d-flex justify-content-between">
                    
                        <a href="../index.php" class="btn">Voltar</a>
                        <button class="btn btn-primary " name="cadastrar">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
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