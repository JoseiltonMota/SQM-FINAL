<?php
include_once("../conexao/conecta.php");

$dt_ini = $_GET['dt_in'];
$dt_fim = $_GET['dt_fim'];

// VALIDANDO SE OS CAMPOS ESTÃO VAZIOS
$timestamp1 = strtotime( $dt_ini );
$timestamp2 = strtotime( $dt_fim );

$dt_formatada_in = date('Y-m-d', $timestamp1);
$dt_formatada_end = date('Y-m-d', $timestamp2);

if(isset($_GET['matricula'])){

	$matricula = $_GET['matricula'];

	$sql_conceito = "SELECT fu.nome as analista
	, SUM(rm.dr) as dr
	, SUM(rm.sac) as sac
	, SUM(rm.dsegd) as dsegd
	, SUM(rm.rec) as rec
	, SUM(rm.lccc) as lccc
	, SUM(rm.iarc) as iarc
	, SUM(rm.a_iad) as a_iad

	FROM res_monitoria rm

	INNER JOIN funcionario fu ON (fu.matricula = rm.matricula_func)
	INNER JOIN grupo gr ON (gr.id = fu.id_grupo)

	WHERE rm.date_mon BETWEEN '$dt_formatada_in' AND '$dt_formatada_end'
	AND gr.id = 7004;
	AND fu.matricula = '$matricula' ";

// Incluimos a classe PHPExcel
include  ('../phpexcel/Classes/PHPExcel.php');

// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);


$objPHPExcel->setActiveSheetIndex(0)
->setCellValue("A1", "CONCEITO MENSAL: ");

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue("A2", "Utilização dos Scripts")
->setCellValue("A2", "Atualização do cadastro")
->setCellValue("A2", "Gentileza/Interação com o usuário")
->setCellValue("A2", "Dicção e timbre")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Ausência de vícios de linguagem")
->setCellValue("A2", "Personalização")
->setCellValue("A2", "Atenção")
->setCellValue("A2", "Argumentação")
->setCellValue("A2", "Demandas tratadas")
->setCellValue("A2", "TMA")
->setCellValue("A2", "Gramática correta")
->setCellValue("A2", "Fluxo correto/Existe Solução em 1º Nível/Solução bem elaborada")
->setCellValue("A2", "Registros coerentes")
->setCellValue("A2", "Resumo correto")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("A2", "Demandas resolvidas")
->setCellValue("B2", "Status atualizados corretamente")
->setCellValue('C2', 'Descrição sem erros gramaticais e de digitação')
->setCellValue('D2', "Retornos enviados corretamente")
->setCellValue("E2", "Logs claros, corretos e coerentes")
->setCellValue("F2", "Atendeu ao IAD")
->setCellValue("G2", "Informações adicionais registradas corretamente");

$result_conceito = $conexao->prepare($sql_conceito);
$result_conceito->execute();

$linha=3;

$dadosBanco = $result_conceito->fetchall(PDO::FETCH_ASSOC);
foreach ($dadosBanco as $value) {
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('B1', $value['analista'])

	->setCellValue('A'.$linha, $value['dr'])
	->setCellValue('B'.$linha, $value['sac'])
	->setCellValue('C'.$linha, $value['dsegd'])
	->setCellValue('D'.$linha, $value['rec'])
	->setCellValue('E'.$linha, $value['lccc'])
	->setCellValue('F'.$linha, $value['a_iad'])
	->setCellValue('G'.$linha, $value['iarc']);
}

	// Define a largura das colunas de modo automático
/*
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
*/
// QUEBRANDO TEXT AUTOMÁTICAMENTE
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);


// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);


$header = 'A2:G2';
$objPHPExcel->getSheet(0)->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff');
$style = array(
	'font' => array('bold' => true,),
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
$objPHPExcel->getSheet(0)->getStyle($header)->applyFromArray($style);



// Adicionamos um estilo de A1 até D1 
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray(
	array('fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => 'E0EEEE')
		),
	)
	);

			// NOME DA PLANILHA
$objPHPExcel->getActiveSheet()->setTitle('CONCEITO MENSAL ANALISTA');

			// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Report_monitoria_analistas.xls"');
header('Cache-Control: max-age=0');
			// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

			// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

			// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 

} else {
	echo "Preencha o campo Analista";
}

?>