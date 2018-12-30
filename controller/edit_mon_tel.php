<?php

if(isset($_POST['edit_mon_tel'])){
	

	$id = $_GET['id'];

	$us = trim(strip_tags($_POST['us']));
	$atu_cad = trim(strip_tags($_POST['atu_cad']));
	$gent_usu = trim(strip_tags($_POST['gent_usu']));
	$dic_tim = trim(strip_tags($_POST['dic_tim']));
	$aus_ling = trim(strip_tags($_POST['aus_ling']));
	$person = trim(strip_tags($_POST['person']));
	$atencao = trim(strip_tags($_POST['atencao']));
	$argu = trim(strip_tags($_POST['argu']));
	$dem_tra = trim(strip_tags($_POST['dem_tra']));
	$dr = trim(strip_tags($_POST['dr']));
	$tma = trim(strip_tags($_POST['tma']));
	$gr_co = trim(strip_tags($_POST['gr_co']));
	$fluxo_soluc = trim(strip_tags($_POST['fluxo_soluc']));
	$reg_c = trim(strip_tags($_POST['reg_c']));
	$resu_c = trim(strip_tags($_POST['resu_c']));
	$causa_inc = trim(strip_tags($_POST['causa_inc']));
	$solic_inf = trim(strip_tags($_POST['solic_inf']));
	$categ_correto = trim(strip_tags($_POST['categ_correto']));
	$tipo_dem = trim(strip_tags($_POST['tipo_dem']));
	$enc_correto = trim(strip_tags($_POST['enc_correto']));

	$iaas = trim(strip_tags($_POST['iaas']));
	$sicrp = trim(strip_tags($_POST['sicrp']));
	$oepe = trim(strip_tags($_POST['oepe']));
	$perd_host = trim(strip_tags($_POST['perd_host']));
	$qoai = trim(strip_tags($_POST['qoai']));
	$ticket = trim(strip_tags($_POST['ticket']));
	$tipo_ticket = trim(strip_tags($_POST['tipo_ticket']));
	$tipo_ligacao = trim(strip_tags($_POST['tipo_ligacao']));
	$temp_ligacao = trim(strip_tags($_POST['temp_ligacao']));
	$hora_inicio = trim(strip_tags($_POST['hora_inicio']));
	$obs = trim(strip_tags($_POST['obs']));

	// CALCULANDO CONCEITO

	if (empty($obs)){

		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span>Preencha todos os campos.</span>
		</div>';

	}

	else {

		$soma = $us+$atu_cad+$gent_usu+$dic_tim+$aus_ling+$person+$atencao+$argu+$dem_tra+$dr+$tma+$gr_co+$fluxo_soluc+$reg_c+$resu_c+$causa_inc+$solic_inf+$categ_correto+$tipo_dem+$enc_correto;

		if ($sicrp == 'SIM' OR $qoai == 'SIM' OR $iaas == 'SIM' OR $perd_host == 'SIM' OR $oepe == 'SIM') {
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

		$last_mod_mat = $_SESSION['session_user'];

		date_default_timezone_set('America/Sao_Paulo');
		$last_mod_dt = date('Y-m-d H:i:s');


		$sql_update = "UPDATE res_mon_tel SET us='$us'
		,atu_cad='$atu_cad'
		,gent_usu='$gent_usu'
		,dic_tim='$dic_tim'
		,aus_ling='$aus_ling'
		,person='$person'
		,atencao='$atencao'
		,argu='$argu'
		,dem_tra='$dem_tra'
		,dr='$dr'
		,tma='$tma'
		,iaas='$tma'
		,sicrp='$sicrp'
		,oepe='$oepe'
		,perd_host='$perd_host'
		,qoai='$qoai'
		,gr_co='$gr_co'
		,fluxo_soluc='$fluxo_soluc'
		,reg_c='$reg_c'
		,resu_c='$resu_c'
		,causa_inc='$causa_inc'
		,solic_inf='$solic_inf'
		,categ_correto='$categ_correto'
		,tipo_dem='$tipo_dem'
		,enc_correto='$enc_correto'
		,ticket='$ticket'
		,tipo_ticket='$tipo_ticket'
		,tipo_ligacao='$tipo_ligacao'
		,temp_ligacao='$temp_ligacao'
		,hora_inicio='$hora_inicio'
		,conceito='$conceito'
		,obs='$obs'
		,last_mod_mat='$last_mod_mat'
		,last_mod_dt='$last_mod_dt' 

		WHERE id = '$id' ";

		try{

			$result = $conexao->prepare($sql_update);
			$result->execute();

			echo '<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<span>Monitoria cadastrada com sucesso.</span>
			</div>';

		} catch(PDOException $e){
			echo '<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<span><strong>Ocorreu o seguinte erro ao tentar cadastrar:</strong>'. $e .'</span></div>';
		}


	}

}