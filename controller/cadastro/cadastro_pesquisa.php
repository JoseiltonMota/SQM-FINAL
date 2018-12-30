<?php


// Função que tira as virgulas.

/*function nota($get_valor) {

		$source = array('.', ','); 

		$replace = array('', '.');

		$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto

		return $valor; //retorna o valor formatado para gravar no banco

	}*/

	if(isset($_POST['cad_pesquisa'])){

	$utf = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $_POST['user']));    // retiranto acentos
	$user = trim(strip_tags(strtoupper($utf))); // Colocando em caixa ALTA

	$ticket = trim(strip_tags($_POST['ticket']));
	$dt = trim(strip_tags($_POST['dt_pesquisa']));
	$mat_analista = trim(strip_tags($_POST['mat_analista']));
	$grupamento = trim(strip_tags($_POST['grupamento']));
	$comentario = trim(strip_tags($_POST['comentario']));
	$clareza = trim(strip_tags($_POST['clareza']));
	$inter_atend = trim(strip_tags($_POST['inter_atend']));
	$qualid_soluc = trim(strip_tags($_POST['qualid_soluc']));
	$tempo_atend = trim(strip_tags($_POST['tempo_atend']));
	//$nota_final = nota($_POST['nota_final']); //chamando a funcção

	$tipo_coment = trim(strip_tags($_POST['tipo_coment']));
	$tentativa_cont = trim(strip_tags($_POST['tentativa_cont']));
	$situacao = trim(strip_tags($_POST['situacao']));
	$analise = trim(strip_tags($_POST['analise']));
	$motivo_rec = trim(strip_tags($_POST['motivo_rec']));
	$obs_just = trim(strip_tags($_POST['obs_just']));
	$acao_super = trim(strip_tags($_POST['acao_super']));
	$causa_raiz = trim(strip_tags($_POST['causa_raiz']));
	$num_relatorio = trim(strip_tags($_POST['num_relatorio']));

	//Calculando nota final
	$nota_final = (($clareza*3)+($inter_atend*1)+($qualid_soluc*5)+($tempo_atend*1))/10;

	$timestamp1 = strtotime( $dt );
	$dt_pesquisa = date('Y-m-d', $timestamp1);

	if ( empty($ticket) OR empty($dt) OR empty($grupamento) OR empty($user) OR empty($clareza) OR empty($inter_atend) OR empty($qualid_soluc) OR empty($tempo_atend)){
		echo '<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span>Preencha todos os campos.</span>
		</div>';

	} else {

		$mat_monitora = $_SESSION['session_user'];

		date_default_timezone_set('America/Sao_Paulo');
		$dt_insert = date('Y-m-d H:i:s');

		$sql_select = "SELECT ticket FROM tb_pesquisa WHERE ticket = '$ticket' ";

		$sql_insert = "INSERT INTO tb_pesquisa (ticket
			, dt_pesquisa
			, user
			, mat_analista
			, id_grupo
			, comentario_user
			, clareza
			, inter_atend
			, qualid_soluc
			, tempo_atend
			, nota_final
			, tentativa_cont
			, tipo_coment
			, situacao
			, analise
			, motivo_rec
			, causa_raiz
			, obs_just
			, acao_super
			, num_relatorio
			, mat_monitora
			, dt_insert) 

VALUES ('$ticket'
	, '$dt_pesquisa'
	, '$user'
	, '$mat_analista'
	, '$grupamento'
	, '$comentario'
	, '$clareza'
	, '$inter_atend'
	, '$qualid_soluc'
	, '$tempo_atend'
	, '$nota_final'
	, '$tentativa_cont'
	, '$tipo_coment'
	, '$situacao'
	, '$analise'
	, '$motivo_rec'
	, '$causa_raiz'
	, '$obs_just'
	, '$acao_super'
	, '$num_relatorio'
	, '$mat_monitora'
	, '$dt_insert')";

try{
	$result_insert = $conexao->prepare($sql_insert);

	$result_select = $conexao->prepare($sql_select);
	$result_select->execute();

	if($result_select->rowCount() == 0){
		$result_insert->execute();
		echo '<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span> Pesquisa salva com sucesso.</span>
		</div>';
	} 

	else {	
		echo '<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span><strong>Erro: </strong> Já existe uma pesquisa cadastrada com este ticket.</span>
		</div>';
	}	

} 
catch(PDOException $e){
	echo '<div class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<span><strong>Reporte esse erro ao Administrador da ferramenta: </strong>' . $e . '</span>
	</div>';
}
} 	
}

?>