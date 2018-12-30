<?php
if(isset($_POST['cadUser'])){

		// PEGANDO OS DADOS DO FORM
	$nome = trim(strip_tags($_POST['nome']));
	$usuario = trim(strip_tags($_POST['usuario']));
	$senha = trim(strip_tags($_POST['senha']));
	$nivel = trim(strip_tags($_POST['nivel']));

		// VALIDANDO SE OS CAMPOS ESTÃO VAZIOS.
	if(empty($nome) || empty($usuario) || empty($senha) || $nivel == "Selecione o nivel"){
		echo "Preencha todos os campos!";
	} else {
			// Selecionando do BD
		$sql_insert = "INSERT INTO login (nome,usuario,senha,nivel) VALUES ('$nome','$usuario','$senha','$nivel')";
		$sql_select = "SELECT usuario, nivel FROM login WHERE usuario=:usuario AND nivel=:nivel";

		try{
			$result_insert = $conexao->prepare($sql_insert);
			$result_insert->bindParam(':nome', $nome, PDO::PARAM_STR);
			$result_insert->bindParam(':usuario', $usuario, PDO::PARAM_STR);
			$result_insert->bindParam(':senha', $senha, PDO::PARAM_STR);
			$result_insert->bindParam(':nivel', $nivel, PDO::PARAM_INT);


			$result_select = $conexao->prepare($sql_select);
			$result_select->bindParam(':usuario', $usuario, PDO::PARAM_STR);
			$result_select->bindParam(':nivel', $nivel, PDO::PARAM_INT);
			
			$result_select->execute();

			if($result_select->rowCount() == 0){
				$result_insert->execute();
				echo "<script>alert(\"Usuário cadastrado!\");</script>";
			} else {
				echo "<script>alert(\"Já existe um usuário com esse nome!\");</script>";
			}

		} catch(PDOException $e){
			echo $e;
		}
	}
}
?>