<?php
//include_once("../../conexao/conecta.php");

if(isset($_POST['mon_1N_web'])){
	

	$aux = 0;
	
	// PEGANDO OS DADOS DO FORM
	$matricula_func = trim(strip_tags($_POST['matricula_func']));
	$data = trim(strip_tags($_POST['date_mon']));
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

	$id_grupo = 7004;

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

	if (empty($matricula_func) OR (empty($data))){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span>Preencha todos os campos.</span>
		</div>';

	} else {
		$mat_monitora = $_SESSION['session_user'];

		$timestamp1 = strtotime( $data );
		$date_mon = date('Y-m-d', $timestamp1);

		date_default_timezone_set('America/Sao_Paulo');
		$dt_insert = date('Y-m-d H:i:s');

		$sql_select = "SELECT matricula_func, ticket FROM res_mon_web WHERE matricula_func='$matricula_func' AND ticket='$ticket'"; 

		$sql_insert = "INSERT INTO res_mon_web (
			matricula_func
			,date_mon
			,id_grupo
			,ort_form
			,reg_c
			,resu_c
			,causa_inc
			,solic_inf
			,dem_tra
			,dr
			,solu_oneNivel_elabora
			,fluxo
			,categ_correto
			,enc_correto
			,sicrp
			,qoai
			,obs
			,ticket
			,tipo_ticket
			,conceito
			,mat_monitora
			,dt_insert)

VALUES (
	'$matricula_func'
	,'$date_mon'
	,'$id_grupo'
	,'$ort_form'
	,'$reg_c'
	,'$resu_c'
	,'$causa_inc'
	,'$solic_inf'
	,'$dem_tra'
	,'$dr'
	,'$solu_oneNivel_elabora'
	,'$fluxo'
	,'$categ_correto'
	,'$enc_correto'
	,'$sicrp'
	,'$qoai'
	,'$obs'
	,'$ticket'
	,'$tipo_ticket'
	,'$conceito'
	,'$mat_monitora'
	,'$dt_insert') ";


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
	} else {	
		echo '<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span><strong>Erro: </strong> Já existe uma monitoria cadastrada com esse ticket para este analista.</span>
		</div>';
	}

} catch(PDOException $e){
	echo '<div class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<span><strong>Ocorreu o seguinte erro ao tentar cadastrar:</strong>'. $e .'</span></div>';
}

}
} 	
