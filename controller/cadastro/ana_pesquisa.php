<?php
//include_once("../../conexao/conecta.php");

if(isset($_POST['ana_pesq'])){

		// PEGANDO OS DADOS DO FORM
	$id = $_GET['id'];
	
	$tipo_coment = trim(strip_tags($_POST['tipo_coment']));
	$tentativa_cont = trim(strip_tags($_POST['tentativa_cont']));
	$situacao = trim(strip_tags($_POST['situacao']));
	$analise = trim(strip_tags($_POST['analise']));
	$motivo_rec = trim(strip_tags($_POST['motivo_rec']));
	$obs_just = trim(strip_tags($_POST['obs_just']));
	$acao_super = trim(strip_tags($_POST['acao_super']));
	$causa_raiz = trim(strip_tags($_POST['causa_raiz']));

	if ( empty($situacao) OR empty($tipo_coment)) {
		echo "<script>alert(\"Preencha todos os campos!\");</script>";
	} else {

		$mat_monitora = $_SESSION['session_user'];
		
		date_default_timezone_set('America/Sao_Paulo');
		$dt_insert = date('Y-m-d H:i:s');

		$sql_select = "SELECT pesquisa_id FROM tb_analiseps WHERE pesquisa_id = '$id' AND STATUS = 0 "; 
		$sql_insert = "INSERT INTO tb_analiseps (pesquisa_id
		, tipo_coment
		, tentativa_cont
		, situacao
		, analise
		, motivo_rec
		, causa_raiz
		, obs_just
		, acao_super
		, mat_monitora
		, dt_insert )

		VALUES ( '$id'
		, '$tipo_coment'
		, '$tentativa_cont'
		, '$situacao'
		, '$analise'
		, '$motivo_rec'
		, '$causa_raiz'
		, '$obs_just'
		, '$acao_super'
		, '$mat_monitora'
		, '$dt_insert' )";

		try{
			$result_insert = $conexao->prepare($sql_insert);

			$result_select = $conexao->prepare($sql_select);
			$result_select->execute();

			if($result_select->rowCount() == 0){
				$result_insert->execute();
				echo '<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<span><strong>Salvo</strong> com sucesso.</span>
				</div>';
			} 

			else {	
				echo '<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<span><strong>Erro: </strong> Essa pesquisa já foi analisada.</span>
				</div>';
			}	

		} 
		catch(PDOException $e){
			echo '<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<span><strong>Erro: </strong> Ocorreu o seguinte erro ao cadastrar monitoria.
				' . $e .'</span>
				</div>';
		}
	} 	
}