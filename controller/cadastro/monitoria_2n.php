<?php
//include_once("../../conexao/conecta.php");

if(isset($_POST['mon_n2'])){

	//$utf = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $_POST['obs']));    // retiranto acentos
	//$obs = trim(strip_tags(strtoupper($utf))); // Colocando em caixa ALTA

		// PEGANDO OS DADOS DO FORM
	$aux = 0;
	
	$matricula_func = trim(strip_tags($_POST['matricula_func']));
	$id_grupo = trim(strip_tags($_POST['grupamento']));
	$dt_ini = trim(strip_tags($_POST['date_mon'])); // Implementado recentemente devido mudanças de analistas para outros grupos  
	$sac = trim(strip_tags($_POST['sac']));
	$rec = trim(strip_tags($_POST['rec']));
	$dr = trim(strip_tags($_POST['dr']));
	$dsegd = trim(strip_tags($_POST['dsegd']));
	$lccc = trim(strip_tags($_POST['lccc']));
	$iarc = trim(strip_tags($_POST['iarc']));
	$a_ima = trim(strip_tags($_POST['a_ima']));
	$a_iad = trim(strip_tags($_POST['a_iad']));
	$ocob_ps = trim(strip_tags($_POST['ocob_ps']));
	$oepe = trim(strip_tags($_POST['oepe']));
	$atin = trim(strip_tags($_POST['atin']));
	$obs = trim(strip_tags($_POST['obs']));

	$tipo_ticket = trim(strip_tags($_POST['tipo_ticket']));
	$ticket = trim(strip_tags($_POST['ticket']));


	$timestamp1 = strtotime( $dt_ini );
	$date_mon = date('Y-m-d', $timestamp1);


	$soma = $sac+$rec+$dr+$dsegd+$lccc+$iarc+$a_ima+$a_iad+$ocob_ps;

	if ($atin == 'SIM' OR $oepe == 'SIM') {
		$conceito = 'DESCLASSIFICADO';
	} else if ($ocob_ps == 0) {
		$conceito = 'RUIM';
	} 	else {
		
		if ($soma <= 50){
			$conceito = 'RUIM';
		} elseif ($soma > 50 AND $soma <= 70) {
			$conceito = 'REGULAR';
		} elseif ($soma > 70 AND $soma <= 80 ){
			$conceito = 'BOM';
		} elseif ($soma > 80 AND $soma <= 94 ){
			$conceito = 'OTIMO';
		} elseif ($soma > 94 ){
			$conceito = 'EXCELENTE';
		}
	}

	if ( empty($matricula_func) OR empty($dt_ini) OR empty($obs) OR empty($id_grupo) OR empty($matricula_func)){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span>Preencha todos os campos.</span>
		</div>';

	} else {
		$mat_monitora = $_SESSION['session_user'];

		date_default_timezone_set('America/Sao_Paulo');
		$dt_insert = date('Y-m-d H:i:s');

		$sql_select = "SELECT matricula_func, ticket FROM res_monitoria WHERE matricula_func='$matricula_func' AND ticket='$ticket' AND status = 0"; 

		$sql_insert = "INSERT INTO res_monitoria (matricula_func, id_grupo, date_mon, sac, rec, dsegd, dr, lccc, iarc, a_ima, a_iad, ocob_ps, oepe, atin, ticket, tipo_ticket, obs, conceito, mat_monitora, dt_insert)
		VALUES ('$matricula_func', '$id_grupo','$date_mon', '$sac', '$rec', '$dsegd', '$dr', '$lccc', '$iarc', '$a_ima', '$a_iad', '$ocob_ps', '$oepe', '$atin', '$ticket', '$tipo_ticket', '$obs', '$conceito','$mat_monitora', '$dt_insert')";

		try{
			$result_insert = $conexao->prepare($sql_insert);

			$result_select = $conexao->prepare($sql_select);

			$result_select->execute();

			if($result_select->rowCount() == 0){
				$result_insert->execute();
				echo '<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<span>Monitoria cadastrada com sucesso.</span>
				</div>';
			} 

			else {	
				echo '<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<span><strong>Erro: </strong> Já existe uma monitoria cadastrada com esse ticket para este analista.</span>
				</div>';
			}	

		} 
		catch(PDOException $e){
			echo '<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<span><strong>Ocorreu o seguinte erro ao tentar cadastrar:</strong>'. $e .'</span></div>';
		}
	} 	
}