<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ambiente de teste</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
  <div class="container text-center">

    <h1 class="my-5">Variáveis em PHP</h1>
    <?php

    $idade = 22;
    $peso = 65;
    $altura = 1.87;

    $nome = "Matheus";
    $sobreNome = "Aureliano";

    echo "Meu nome é <strong>" . $nome . " " . $sobreNome . "</strong>, tenho <strong>" . $idade . " anos</strong> minha altura é de <strong>" . $altura . "M</strong> e peso de <strong>" . $peso . "</strong>";

    $cores = array("Vermelho", "Verde", "Preto");
    $rgb = array("red", "green", "black");

    for ($k = 0; $k < count($cores); $k++) {
      echo "<div> <span style='color: " . $rgb[$k] . "'>" . $cores[$k] . "</span></div>";
    }
    $soma = $peso + $altura;
    $subt = $peso - $altura;
    $mult = $peso * $altura;
    $div = $peso / $altura;
    $mod = fmod($peso, $altura);

    $imc = $peso / ($altura * $altura);

    echo "
    <div class='mt-5'><h5><strong>PESO</strong> e <strong>ALTURA</strong><h5></div>
    <div class='my-1'><strong>Soma</strong>          : " . $soma . "</div>
    <div class='my-1'><strong>Subtração</strong>     : " . $subt . "</div>
    <div class='my-1'><strong>Multiplicação</strong> : " . $mult . "</div>
    <div class='my-1'><strong>Divisão</strong>       : " . $div . "</div>
    <div class='my-1'><strong>Resto da div</strong>  : " . $mod . "</div>
    <div class='my-1'><strong>IMC</strong>           : " . $imc . "</div>";

    ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>