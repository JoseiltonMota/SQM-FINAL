<?php
include_once("../conexao/conecta.php");

$select = "SELECT ps.ticket AS TICKET
, ps.dt_pesquisa AS DT_PESQUISA
, ps.user AS USER
, fu.nome AS ANALISTA
, gr.nome AS GRUPO
, ps.comentario_user AS COMENTARIO_USER
, ps.clareza AS CLAREZA
, ps.inter_atend AS INTER_ATEND
, ps.qualid_soluc AS QUALID_SOLUC
, ps.tempo_atend AS TEMPO_ATEND
, ps.nota_final as NOTA_FINAL
, fuu.nome AS MONITORA
, ps.tipo_coment AS TIPO_COMENT
, ps.tentativa_cont AS TENTATIVA_CONT
, ps.situacao AS SITUACAO
, ps.analise AS ANALISE
, ps.motivo_rec AS MOTIVO_REC
, ps.obs_just AS OBS_JUST
, ps.acao_super AS ACAO_SUPER 
, ps.num_relatorio as NUM_RELATORIO
, fuu.nome AS monitor

FROM tb_pesquisa ps

LEFT JOIN funcionario fu ON (fu.matricula = ps.mat_analista)
LEFT JOIN funcionario fuu ON (fuu.matricula = ps.mat_monitora)
INNER JOIN grupo gr ON (ps.id_grupo = gr.id)";

if( (isset($_GET['dt_ini'])) AND (isset($_GET['dt_fim'])) AND (isset($_GET['monitor'])) ){

	$dt_ini = $_GET['dt_ini'];
	$dt_fim = $_GET['dt_fim'];
	$monitor = $_GET['monitor'];

	$sql = $select . "WHERE ps.dt_pesquisa BETWEEN '$dt_ini' AND '$dt_fim' 
	AND ps.mat_monitora LIKE '$monitor' ";

} else if ( (isset($_GET['dt_ini'])) AND (isset($_GET['dt_fim'])) ) {
	
	$dt_ini = $_GET['dt_ini'];
	$dt_fim = $_GET['dt_fim'];
	
	$sql = $select . "WHERE ps.dt_pesquisa BETWEEN '$dt_ini' AND '$dt_fim'";
	
} else if ( isset($_GET['monitor']) ) {
	
	$monitor = $_GET['monitor'];

	$sql = $select . "WHERE ps.mat_monitora LIKE '$monitor'";
}

else {

	echo "ERRO: ";

}

// Incluimos a classe PHPExcel
include  ('../phpexcel/Classes/PHPExcel.php');

// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('M2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('N2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('O2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('P2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('Q2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('R2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('S2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('T2')->getFont()->setBold(true);


// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue("A2", "Ticket")
->setCellValue("B2", "Data da pesquisa")
->setCellValue('C2', 'Usuário')
->setCellValue('D2', "Analista")
->setCellValue("E2", "Grupo")
->setCellValue('F2', "Comentário do usuário")
->setCellValue('G2', "Clareza nas informações fornecidas")
->setCellValue("H2", "Interesse demonstrado no atendimento")
->setCellValue("I2", "Qualidade da solução apresentada")
->setCellValue("J2", "Tempo de Atendimento")
->setCellValue("K2", "Nota Final")
->setCellValue("L2", "Responsável pela análise")
->setCellValue("M2", "Tipo de comentário")
->setCellValue("N2", "Tentativa de contato")
->setCellValue("O2", "Situação")
->setCellValue("P2", "Análise")
->setCellValue("Q2", "Motivo da reclamação")
->setCellValue("R2", "Observações e justificativas")
->setCellValue("S2", "Ação do supervisão")
->setCellValue("T2", "Numero do relatório");

$linha=3;

$result = $conexao->prepare($sql);
$result->execute();
$dadosBanco = $result->fetchall(PDO::FETCH_ASSOC);

foreach ($dadosBanco as $value) {
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$linha, $value['TICKET'])
	->setCellValue('B'.$linha, $value['DT_PESQUISA'])
	->setCellValue('C'.$linha, $value['USER'])
	->setCellValue('D'.$linha, $value['ANALISTA'])
	->setCellValue('E'.$linha, $value['GRUPO'])
	->setCellValue('F'.$linha, $value['COMENTARIO_USER'])
	->setCellValue('G'.$linha, $value['CLAREZA'])
	->setCellValue('H'.$linha, $value['INTER_ATEND'])
	->setCellValue('I'.$linha, $value['QUALID_SOLUC'])
	->setCellValue('J'.$linha, $value['TEMPO_ATEND'])
	->setCellValue('K'.$linha, $value['NOTA_FINAL'])
	->setCellValue('L'.$linha, $value['MONITORA'])
	->setCellValue('M'.$linha, $value['TIPO_COMENT'])
	->setCellValue('N'.$linha, $value['TENTATIVA_CONT'])
	->setCellValue('O'.$linha, $value['SITUACAO'])
	->setCellValue('P'.$linha, $value['ANALISE'])
	->setCellValue('Q'.$linha, $value['MOTIVO_REC'])
	->setCellValue('R'.$linha, $value['OBS_JUST'])
	->setCellValue('S'.$linha, $value['ACAO_SUPER'])
	->setCellValue('T'.$linha, $value['NUM_RELATORIO']);

	$linha++;
}

// QUEBRANDO TEXT AUTOMÁTICAMENTE
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('L2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('M2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('N2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('O2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('P2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('Q2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('R2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('S2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('T2')->getAlignment()->setWrapText(true);


// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(24);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(13);

$header = 'A2:T2';
$objPHPExcel->getSheet(0)->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');
$style = array(
	'font' => array('bold' => true,),
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
$objPHPExcel->getSheet(0)->getStyle($header)->applyFromArray($style);



// Adicionamos um estilo de A1 até D1 
$objPHPExcel->getActiveSheet()->getStyle('A2:T2')->applyFromArray(
	array('fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => 'E0EEEE')
		),
	)
	);

			// NOME DA PLANILHA
$objPHPExcel->getActiveSheet()->setTitle('Análise pesquisa de satisfação');

			// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Report_analise_pesquisa.xls"');
header('Cache-Control: max-age=0');
			// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

			// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

			// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 


?>