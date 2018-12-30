<?php
if(isset($_POST['cadFalta'])){
		// PEGANDO OS DADOS DO FORM
	$aux = 0;
	
	$mat_analista = trim(strip_tags($_POST['mat_analista']));
	$id_grupo = trim(strip_tags($_POST['grupamento']));
	$dt_ini = trim(strip_tags($_POST['dt_ini']));
	$dt_fim = trim(strip_tags($_POST['dt_fim']));
	$id_motivo = trim(strip_tags($_POST['motivo']));
	$cid = trim(strip_tags($_POST['cid']));

	$data = date('Y-m-d H:i:s');

	$usuario = $_SESSION['session_user'];

	$timestamp1 = strtotime( $dt_ini );
	$timestamp2 = strtotime( $dt_fim );
	$timestamp3 = strtotime("01/01/2000");

		// VALIDANDO SE OS CAMPOS ESTÃO VAZIOS.
	if(empty($mat_analista) OR empty($dt_ini) OR empty($dt_fim) OR empty($id_motivo) OR empty($id_grupo)){
		echo '<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span>Preencha todos os campos.</span>
		</div>';
	}

	else if($timestamp1 > $timestamp2){
		echo "<script>alert(\"Data final menor que a incial\");</script>";
	}

	else if($timestamp1 < $timestamp3){
		echo "<script>alert(\"O formato de data está errado, ou você inseriu uma data inferior à '01/01/2000'. \");</script>";
	}

	else if($timestamp2 < $timestamp3){
		echo "<script>alert(\"O formato de data está errado, ou você inseriu uma data inferior à '01/01/2000'. \");</script>";
	}

	else if(!(strlen($dt_ini) == 10)){
		echo "<script>alert(\"O formato de data está errado! Correto: dia/mês/ano. \");</script>";
	}

	else {

		while ( $timestamp1 <= $timestamp2 ){
			$diasemana = date("w", $timestamp1);
			if (($diasemana != 6) and ($diasemana != 0)) {
				
				$dt_formatada = date('Y/m/d', $timestamp1);

				$sql_select = "SELECT mat_analista, dt_falta FROM falta WHERE mat_analista=:mat_analista AND dt_falta=:dt_formatada"; 
				$sql_insert = "INSERT INTO falta (mat_analista, id_grupo, dt_falta, id_motivo, cid, usuario, dt_insert) VALUES ('$mat_analista', '$id_grupo','$dt_formatada', '$id_motivo', '$cid', '$usuario', '$data')";

				try{
					$result_insert = $conexao->prepare($sql_insert);

					$result_select = $conexao->prepare($sql_select);
					$result_select->bindParam(':mat_analista', $mat_analista, PDO::PARAM_STR);
					$result_select->bindParam(':dt_formatada', $dt_formatada);

					$result_select->execute();
					
					if($result_select->rowCount() == 0){
						$result_insert->execute();

						
						if($aux==0){
							echo '<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<span> Falta salva com sucesso.</span>
							</div>';
							$aux++;
						}
					} 

					else {
						
						if ($aux == 0) {
							echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<span><strong>Erro: </strong> Já existe uma falta cadastrada neste dia para este analista.</span>
							</div>';
							$aux++;
						}	
					}
					
				} 
				catch(PDOException $e){
					echo '<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<span><strong>Ocorreu o seguinte erro ao tentar salvar os dados: </strong> '. $e .'.</span>
					</div>';
				}
			}

			$timestamp1 += 86400; //incrementando o dia
		}
	}
}