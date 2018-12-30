<?php
if(isset($_POST['cadUsuario'])){

		// PEGANDO OS DADOS DO FORM
	$matricula = trim(strip_tags($_POST['id_func']));
	//$usuario = trim(strip_tags($_POST['usuario']));
	$senha = trim(strip_tags($_POST['senha']));
	$nivel = trim(strip_tags($_POST['nivel']));

		// VALIDANDO SE OS CAMPOS ESTÃO VAZIOS.
	if(empty($matricula) ||  empty($senha) || empty($nivel) ){
		echo "<script>alert(\" Preencha todos os campos!\");</script>";
	} else {
			// Selecionando do BD
		$sql_insert = "INSERT INTO login (id_func,usuario,senha,nivel) VALUES ('$matricula','$matricula','$senha','$nivel')";
		$sql_select = "SELECT id_func FROM login WHERE id_func='$matricula' ";

		try{
			$result_insert = $conexao->prepare($sql_insert);

			$result_select = $conexao->prepare($sql_select);

			
			$result_select->execute();

			if($result_select->rowCount() == 0){
				$result_insert->execute();
				echo "<script>alert(\"Monitor(a) cadastrado!\");</script>";
			} else {
				echo "<script>alert(\">>> Esse(a) monitor(a) já está cadastrado(a)! <<<\");</script>";
			}

		} catch(PDOException $e){
			echo $e;
		}
	}
}
?>