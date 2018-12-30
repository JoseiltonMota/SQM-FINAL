<?php
if(isset($_POST['cadFunc'])){

		// PEGANDO OS DADOS DO FORM
	$nome = trim(strip_tags($_POST['nome']));
	$grupo = trim(strip_tags($_POST['grupo']));

		// VALIDANDO SE OS CAMPOS ESTÃO VAZIOS.
	if(empty($nome) or ($grupo == "Selecione o Grupo")){
		echo "Preencha todos os campos!";
	} else {
			// Selecionando do BD
		$sql_insert = "INSERT INTO funcionario (nome, grupo) VALUES ('$nome','$grupo')";
		$sql_select = "SELECT nome, grupo FROM funcionario WHERE nome=:nome AND grupo=:grupo";

		try{
			$result_insert = $conexao->prepare($sql_insert);
			$result_insert->bindParam(':nome', $nome, PDO::PARAM_STR);
			$result_insert->bindParam(':grupo', $grupo, PDO::PARAM_INT);

			$result_select = $conexao->prepare($sql_select);
			$result_select->bindParam(':nome', $nome, PDO::PARAM_STR);
			$result_select->bindParam(':grupo', $grupo, PDO::PARAM_INT);
			
			$result_select->execute();

			if($result_select->rowCount() == 0){
				$result_insert->execute();
				echo '<div class="alert alert-success">
					<button type="button" class="close" data-dimiss="alert">x</button>
					<strong>Funcionario cadastrado!</strong> 
					</div>';
				header("Refresh: 1"); exit;

			} else {
				echo '<div class="alert alert-warning">
					<button type="button" class="close" data-dimiss="alert">x</button>
					<strong>Este funcionario já está cadastrado!</strong> 
					</div>';
					header("Refresh: 1"); exit;

			}

		} catch(PDOException $e){
			echo $e;
		}
	}
}
?>