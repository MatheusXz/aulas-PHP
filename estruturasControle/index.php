<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/cover/">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">



</head>

<body>
  <!-- 001 -->
  <!-- Desenvolva um algoritmo PHP que tenha 2 variáveis
  numéricas e realize a adição. Caso o valor somado seja
  maior que 20, este deverá ser apresentando somando-se a
  ele mais 8; caso o valor somado seja menor ou igual a 20,
  este deverá ser apresentado subtraindo-se 5 -->

  <div class='container my-5'>
    <section>
      <div>
        <h3>Resultado de Adição EX - 001</h3>
        <?php
        $value0 = 10;
        $value1 = 0;

        $sum = $value0 + $value1;

        $add = $sum + 8;
        $sub = $sum - 5;

        $result = $sum > 20 ? $add : $sub;

        echo "
        <p>
          Valor da soma   : " . $sum . "
        </p>
        <p>
          Resultado final :" . $result . "
        </p>
     "; ?>
      </div>
    </section>

    <!-- 002 -->
    <!-- Crie um programa PHP que exiba os números primos
    existentes entre 0 e 1555. -->

    <section class=''>
      <div>
        <h3>Resultado dos Números Primos EX - 002</h3>
        <p>Entre 0 e 1555</p>
      </div>

      <?php

      function Primo($number)
      {
        if ($number <= 1) {
          return false;
        }

        for ($i = 2; $i <= sqrt($number); $i++) {
          if ($number % $i == 0) {
            return false;
          }
        }

        return true;
      }

      for ($i = 1; $i <= 1555; $i++) {
        if (Primo($i)) {
          echo "<small class='form-text text-muted'>- $i </small>";
        }
      }

      ?>
    </section>

    <section class='my-5'>
      <!-- 003 -->
      <!-- Desenvolva um algoritmo PHP que exiba a sequência de
      Fibonacci até 5288 -->

      <h3>Resultado Fibonacci até 5288</h3>
      <?php
      $antes = 0;
      $atual = 1;

      while ($atual <= 5288) {
        echo $atual . " - ";
        $proximo = $antes + $atual;
        $antes = $atual;
        $atual = $proximo;
      }
      ?>

    </section>

    <!-- 4 - Programe um algoritmo PHP para calcular e exibir o fatorial de 144. O
     cálculo também deverá ser exibido. Exemplo:
     4. 4! =4 · 3 · 2 · 1 = 24 -->

    <?php

    $num = 144;
    $fatorial = 1;

    for ($i = $num; $i >= 1; $i--) {
      $fatorial *= $i;
    }

    echo $num . "! = ";
    for ($i = $num; $i >= 1; $i--) {
      echo $i;
      if ($i > 1) {
        echo " · ";
      }
    }
    echo " = " . $fatorial;
    ?>


    <section>
      <?php
      // $n = 0;
      // while($n < 144){
      //   $v = $v * ($v - $n);
      //   echo $n;
      // };
      ?>
    </section>

    <!-- 5. Faça um programa PHP para calcular quantas ferraduras são
     necessárias para equipar todos os 255 cavalos comprados para um
     haras.-->
    <section class='my-5'>

      <h3>Resultado 255 cavalos - (ferraduras)</h3>
      <?php
      $cont = 0;
      while ($cont <= 255) {
        $total += 4;
        $cont++;
      }
      echo "Total de ferraduras " . $total . " ";

      ?>
    </section>

    <!--6. Crie dois vetor que contenha 5 componentes. Em seguida, crie um
     terceiro vetor que receba: a multiplicação dos dois vetores se o
     conteúdo do primeiro vetor for par, ou a divisão dos valores se o
     conteúdo do primeiro vetor for ímpar. Por fim, exiba o resultado do
     terceiro vetor -->


    <?php

    $vetor1 = [1, 2, 3, 4, 5];
    $vetor2 = [6, 7, 8, 9, 10];
    $result = [];

    $somaV1 = 0;
    for ($i = 0; $i < count($vetor1); $i++) {
      $somaV1 += $vetor1[$i];
    }

    if ($somaV1 % 2 == 0) {
      //  a multiplicação dos dois vetores se o
      //  conteúdo do primeiro vetor for par
      for ($i = 0; $i < count($vetor1); $i++) {
        $result[] = $vetor1[$i] * $vetor2[$i];
      }
    } else {
      //  a divisão dos valores se o
      //  conteúdo do primeiro vetor for ímpar
      for ($i = 0; $i < count($vetor1); $i++) {
        $result[] = $vetor1[$i] / $vetor2[$i];
      }
    }
    for ($i = 0; $i < count($vetor1); $i++) {
      echo $result[$i] . " - ";
    }

    ?>



  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>

</html>