<?php

//upload.php

require_once('./conn/index.php');
$msg = false; // APRESENTO ESSA MENSAGEM SE FOI ENVIADA OU NÃO NO HTML

if (isset($_FILES['arquivo'])) { //VERIFICA SE O ARRAY $_FILLES ESTA VAZIO, SE ESTA COM O ARQUIVO JÁ PARA ENVIO
	$foto = $_FILES['arquivo']; // ARAZENO EM UMA VAR
	if (!preg_match('/^image\/(gif|bmp|png|jpg|jpeg)+$/', $foto["type"])) { // VERIFICO SE ESTA DE ACORDO COMO UMA IMAGEM A EXTENÇÃO
		echo 'Formato de imagem invalido';
	} else {
		$extensao = '.jpg'; //pega a extensao do arquivo
		$novo_nome = md5(time()) . $extensao; //define o nome do arquivo, criptografando a data do envio atual como o nome da imagem
		$diretorio = "upload/"; //define o diretorio para onde enviaremos o arquivo

		move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio . $novo_nome); //efetua o upload

		$stmt = $connect->prepare("INSERT INTO motorista (id, foto_perfil_m, data_de_up) VALUES(DEFAULT, '$novo_nome', NOW())");
		if ($stmt->execute() == true) {
			$msg = "Arquivo enviado com sucesso!";
			header('location:upload.php');
		} else {
			$msg = "Falha ao enviar arquivo.";
		}
	}
}

$stmt = $connect->prepare('SELECT * FROM usuarios');
$stmt->execute();

if (isset($_POST['deletar'])) { // VERIFICO SE O USUARIO APERTOU O BOTÃP DELETAR
	$diretorio = "upload/"; //define o diretorio para onde enviaremos o arquivo

	$id = $_POST['deletar']; // ARMAZENHO O ID QUE VEIO DO VALUE

	$stmt = $connect->prepare('SELECT * FROM motorista WHERE ID = :getId');
	$stmt->bindValue(':getId', $id);

	if ($stmt->execute() == true) {

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			unlink($diretorio . $row['foto_perfil_m']); // DELETA DA PASTA A IMAGEM REFERENTE AO NOME
		}

		$delete = $connect->prepare('DELETE FROM MOTORISTA WHERE ID = :getId'); // E SE DELETADO NA PASTA QUERO QUE DELETE NO BANCO TAMBEM
		$delete->bindValue(':getId', $id);
		if ($delete->execute()) {
			header('location: upload.php'); // SE DELETADO VOLTA PRO INICIO
		}
	}
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // TRAZ AS INFORMAÇÕES DO BANCO E PUXA O CAMINHO E NOME DA IMGEM E APRESETA NA TELA
	echo '
				<form action="" method="POST"  style="display: inline-block">
					<div class="">
						<img src="upload/' . $row['foto_perfil_m'] . '" style="width: 100px" alt=""><br>
						<button type="submit" name="deletar" value="' . $row['id'] . '">DELETE  </button>
					</div>
				</form>';
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>

<body>

	<h1>Upload de Arquivos</h1>

	<?php if (isset($msg) && $msg != false) echo "<p> $msg </p>"; ?>

	<form action="" method="POST" enctype="multipart/form-data">
		Arquivo para envio: <input type="file" required name="arquivo"><br>
		<input type="submit" style="size: 50px" value="Salvar">
	</form>


</body>

</html>