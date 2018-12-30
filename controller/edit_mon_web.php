<?php
//include_once("../../conexao/conecta.php");

if(isset($_POST['Edit_mon_web'])){

	$ort_form = trim(strip_tags($_POST['ort_form']));
	$reg_c = trim(strip_tags($_POST['reg_c']));
	$resu_c = trim(strip_tags($_POST['resu_c']));
	$causa_inc = trim(strip_tags($_POST['causa_inc']));
	$solic_inf = trim(strip_tags($_POST['solic_inf']));
	$dem_tra = trim(strip_tags($_POST['dem_tra']));
	$dr = trim(strip_tags($_POST['dr']));
	$solu_oneNivel_elabora = trim(strip_tags($_POST['solu_oneNivel_elabora']));
	$fluxo = trim(strip_tags($_POST['fluxo'])); //solução 
	$categ_correto = trim(strip_tags($_POST['categ_correto']));
	$enc_correto = trim(strip_tags($_POST['enc_correto']));

	$sicrp = trim(strip_tags($_POST['sicrp']));
	$qoai = trim(strip_tags($_POST['qoai']));
	$obs = trim(strip_tags($_POST['obs']));
	$ticket = trim(strip_tags($_POST['ticket']));
	$tipo_ticket = trim(strip_tags($_POST['tipo_ticket']));

	// CALCULANDO CONCEITO
	$soma = $ort_form+$reg_c+$resu_c+$causa_inc+$solic_inf+$dem_tra+$dr+$solu_oneNivel_elabora+$fluxo+$categ_correto+$enc_correto;

	if ($sicrp == 'SIM' OR $qoai == 'SIM') {
		$conceito = 'DESCLASSIFICADO';
	} else {
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

	if (empty($ort_form) OR empty($reg_c) ){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span>Preencha todos os campos.</span>
		</div>';

	} else {
		$last_mod_mat = $_SESSION['session_user'];

		date_default_timezone_set('America/Sao_Paulo');
		$last_mod_dt = date('Y-m-d H:i:s');

		$sql_update = "UPDATE res_mon_web SET ort_form = '$ort_form'
		,reg_c = '$reg_c'
		,resu_c =' $resu_c'
		,causa_inc = '$causa_inc'
		,solic_inf = '$solic_inf'
		,dem_tra = '$dem_tra'
		,dr = '$dr'
		,solu_oneNivel_elabora = '$solu_oneNivel_elabora'
		,fluxo = '$fluxo'
		,categ_correto = '$categ_correto'
		,enc_correto = '$enc_correto'
		,sicrp = '$sicrp'
		,qoai = '$qoai'
		,obs = '$obs'
		,ticket = '$ticket'
		,tipo_ticket = '$tipo_ticket'
		,conceito = '$conceito'
		,last_mod_mat = '$last_mod_mat'
		,last_mod_dt = '$last_mod_dt' ";

		try{
			$result_insert = $conexao->prepare($sql_update);

			$result_insert->execute();

			echo '<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<span>Monitoria alterada com sucesso.</span>
			</div>';
		} 

		catch(PDOException $e){
			echo '<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<span><strong>Ocorreu o seguinte erro ao tentar cadastrar:</strong>'. $e .'</span></div>';
		}

	}
} 	
