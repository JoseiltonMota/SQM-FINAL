<?php
if(isset($_POST['cadGrupo'])){

		// PEGANDO OS DADOS DO FORM
	$grupo = trim(strip_tags($_POST['grupo']));
	$cod_grupo = trim(strip_tags($_POST['cod_grupo']));

		// VALIDANDO SE OS CAMPOS ESTÃO VAZIOS.
	if(empty($grupo) or empty($cod_grupo)){
		echo "Preencha todos os campos!";
	} else {
			// Selecionando do BD
		$sql_insert = "INSERT INTO grupo (cod_grupo,nome) VALUES ('$cod_grupo','$grupo')";
		$sql_select = "SELECT * FROM grupo WHERE cod_grupo=:cod_grupo OR nome=:grupo";

		try{
			$result_insert = $conexao->prepare($sql_insert);
			$result_insert->bindParam(':grupo', $grupo, PDO::PARAM_STR);
			$result_insert->bindParam(':cod_grupo', $cod_grupo, PDO::PARAM_INT);

			$result_select = $conexao->prepare($sql_select);
			$result_select->bindParam(':grupo', $grupo, PDO::PARAM_STR);
			$result_select->bindParam(':cod_grupo', $cod_grupo, PDO::PARAM_INT);
			
			$result_select->execute();

			if($result_select->rowCount() == 0){
				$result_insert->execute();
				echo "<script>alert(\"Grupo cadastrado!\");</script>";
			} else {
				echo "<script>alert(\"Já existe um grupo com esse nome e ou código.\");</script>";
			}

		} catch(PDOException $e){
			echo $e;
		}
	}
}
?>