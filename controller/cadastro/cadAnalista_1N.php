<?php
if(isset($_POST['cadAnalista_1N'])){

	// Retirando acentos
	$aux = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $_POST['nome']));

	// PEGANDO OS DADOS DO FORM
	$nome = trim(strip_tags(strtoupper($aux)));
	$id_grupo = 7004;
	$matricula = trim(strip_tags($_POST['matricula']));
	$tipo_atend = trim(strip_tags($_POST['tipo_atend']));
	$sex = trim(strip_tags($_POST['sex']));

		// VALIDANDO SE OS CAMPOS ESTÃO VAZIOS.
	if(empty($nome) or empty($tipo_atend) or empty($matricula)) {
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dimiss="alert">x</button>
		<strong>Preencha todos os campos!</strong> 
		</div>';
	} else {

		$matr_monitor = $_SESSION['session_user']; // PEGANDO A MATRICULA DA PESSOA QUE ESTÁ LOGADA

		date_default_timezone_set('America/Sao_Paulo'); 
		$date_create = date('Y-m-d H:i:s'); // PEGANDO DATA E HORA SÃO PAULO

		// Selecionando do BD
		$sql_insert = "INSERT INTO funcionario (matricula, nome, id_grupo, tipo_atend, sex, matr_monitor, date_create) VALUES ('$matricula','$nome','$id_grupo','$tipo_atend', '$sex', '$matr_monitor', '$date_create')";
		$sql_select = "SELECT matricula FROM funcionario WHERE matricula=:matricula";

		try{
			$result_insert = $conexao->prepare($sql_insert);
			$result_insert->bindParam(':matricula', $matricula, PDO::PARAM_STR);

			$result_select = $conexao->prepare($sql_select);
			$result_select->bindParam(':matricula', $matricula, PDO::PARAM_STR);
			
			$result_select->execute();

			if($result_select->rowCount() == 0){
				$result_insert->execute();
				echo '<div class="alert alert-success">
				<button type="button" class="close" data-dimiss="alert">x</button>
				<strong>Funcionario cadastrado!</strong> 
				</div>';

			} else {
				echo '<div class="alert alert-warning">
				<button type="button" class="close" data-dimiss="alert">x</button>
				<strong>Já existe funcionario cadastrado com essa matrícula!</strong> 
				</div>';
			}

			

		} catch(PDOException $e){
			echo $e;
		}
	}

}
?>