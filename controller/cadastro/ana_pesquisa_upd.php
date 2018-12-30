<?php
//include_once("../../conexao/conecta.php");

function nota($get_valor) {

	$source = array('.', ','); 

	$replace = array('.', '.');

		$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto

		return $valor; //retorna o valor formatado para gravar no banco

	}

	if(isset($_POST['ana_pesq_upd'])){

	$utf = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $_POST['user']));    // retiranto acentos
	$user = trim(strip_tags(strtoupper($utf))); // Colocando em caixa ALTA


		// PEGANDO OS DADOS DO FORM
	$id = $_GET['id'];
	
	$ticket = trim(strip_tags($_POST['ticket']));
	$comentario_user = trim(strip_tags($_POST['comentario_user']));
	$clareza = trim(strip_tags($_POST['clareza']));
	$inter_atend = trim(strip_tags($_POST['inter_atend']));
	$qualid_soluc = trim(strip_tags($_POST['qualid_soluc']));
	$tempo_atend = trim(strip_tags($_POST['tempo_atend']));
	$nota_final = nota($_POST['nota_final']); //chamando a funcção
	$num_relatorio = trim(strip_tags($_POST['num_relatorio']));

	$tipo_coment = trim(strip_tags($_POST['tipo_coment']));
	$tentativa_cont = trim(strip_tags($_POST['tentativa_cont']));
	$situacao = trim(strip_tags($_POST['situacao']));
	$analise = trim(strip_tags($_POST['analise']));
	$motivo_rec = trim(strip_tags($_POST['motivo_rec']));
	$obs_just = trim(strip_tags($_POST['obs_just']));
	$acao_super = trim(strip_tags($_POST['acao_super']));
	$causa_raiz = trim(strip_tags($_POST['causa_raiz']));

	if (empty($ticket) OR empty($user) OR empty($clareza) OR empty($inter_atend) OR empty($qualid_soluc) OR empty($tempo_atend)) {
		echo "<script>alert(\"Preencha todos os campos!\");</script>";
	} else {

		$mat_monitora = $_SESSION['session_user'];

		date_default_timezone_set('America/Sao_Paulo');
		$dt_insert = date('Y-m-d H:i:s');

		$sql_update = "UPDATE tb_pesquisa 
		SET  ticket = '$ticket'
		, user = '$user'
		, comentario_user = '$comentario_user'
		, clareza = '$clareza'
		, inter_atend = '$inter_atend'
		, qualid_soluc = '$qualid_soluc'
		, tempo_atend = '$tempo_atend'
		, nota_final = '$nota_final'
		, tipo_coment = '$tipo_coment'
		, tentativa_cont = '$tentativa_cont'
		, situacao = '$situacao'
		, analise = '$analise'
		, motivo_rec = '$motivo_rec'
		, causa_raiz = '$causa_raiz'
		, obs_just = '$obs_just'
		, num_relatorio = '$num_relatorio'
		, acao_super = '$acao_super'
		, last_mod_dt = '$dt_insert' 
		, last_mod_monitora = '$mat_monitora'

		WHERE id = '$id' ";

		try{
			$result = $conexao->prepare($sql_update);
			$result->execute();
			echo '<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<span><strong>Salvo</strong> com sucesso.</span>
			</div>';

		} catch (PDOException $e){
			echo '<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<span><strong>Erro: </strong> Ocorreu o seguinte erro ao cadastrar monitoria.
			' . $e .'</span>
			</div>';
		}
	} 	
}