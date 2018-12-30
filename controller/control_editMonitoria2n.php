<?php
//include_once("../../conexao/conecta.php");

if(isset($_POST['Editmon_n2'])){

	//$utf = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $_POST['obs']));    // retiranto acentos
	//$obs = trim(strip_tags(strtoupper($utf))); // Colocando em caixa ALTA
	
	$id = $_GET['id'];
	//$dt_ini = trim(strip_tags($_POST['date_mon']));
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
	$obs =  trim(strip_tags($_POST['obs']));
	$ticket = trim(strip_tags($_POST['ticket']));


	/*$timestamp1 = strtotime( $dt_ini );
	$date_mon = date('Y-m-d', $timestamp1);*/

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

	if (empty($id) OR empty($ticket)){
		echo "<script>alert(\"Preencha todos os campos!\");</script>";

	} else {
		$mat_monitora = $_SESSION['session_user'];

		date_default_timezone_set('America/Sao_Paulo');
		$dt_insert = date('Y-m-d H:i:s');

		$sql_update ="UPDATE res_monitoria SET rec='$rec'
		, ticket='$ticket'
		, dsegd='$dsegd'
		, dr='$dr'
		, lccc='$lccc'
		, iarc='$iarc'
		, a_ima='$a_ima'
		, a_iad='$a_iad'
		, ocob_ps='$ocob_ps'
		, oepe='$oepe'
		, atin='$atin'
		, obs='$obs'
		, conceito='$conceito'
		, last_mod_dt='$dt_insert'
		, mat_last_mod='$mat_monitora' 

		WHERE id='$id' ";

		try{
			
			$result_insert = $conexao->prepare($sql_update);
			$result_insert->execute();

			echo "<script>alert(\"Monitoria alterada com sucesso!\");</script>";
		} 
		catch(PDOException $e){
			echo 'Ocorreu o seguinte erro ao editar a monitoria: ';
			echo $e;
		}
	} 	
}