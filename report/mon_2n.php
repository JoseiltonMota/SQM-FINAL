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

	$select = "SELECT fu.nome as colaborador, rm.date_mon as date_mon, rm.sac as sac, rm.rec as rec, rm.lccc as lccc, rm.dsegd as dsegd, rm.iarc as iarc, rm.a_iad as a_iad, rm.a_ima as a_ima, 
	rm.ocob_ps as ocob_ps, rm.dr as dr, rm.atin as atin, rm.oepe as oepe, rm.ticket as ticket, rm.tipo_ticket as tipo_ticket, rm.obs as obs, rm.conceito as conceito, fuu.nome as monitora,  gr.nome as grupo

	FROM res_monitoria rm 

	INNER JOIN funcionario fu ON (fu.matricula = rm.matricula_func)
	INNER JOIN funcionario fuu ON (fuu.matricula = rm.mat_monitora)
	INNER JOIN grupo gr ON (gr.id = fu.id_grupo)

	WHERE  rm.date_mon BETWEEN '$dt_formatada_in' AND '$dt_formatada_end'
	AND fu.matricula = '$matricula'
	ORDER BY 2, 1";
} 

else {

	$select = "SELECT fu.nome as colaborador, rm.date_mon as date_mon, rm.sac as sac, rm.rec as rec, rm.lccc as lccc, rm.dsegd as dsegd, rm.iarc as iarc, rm.a_iad as a_iad, rm.a_ima as a_ima, 
	rm.ocob_ps as ocob_ps, rm.dr as dr, rm.atin as atin, rm.oepe as oepe, rm.ticket as ticket, rm.tipo_ticket as tipo_ticket, rm.obs as obs, rm.conceito as conceito, fuu.nome as monitora,  gr.nome as grupo

	FROM res_monitoria rm 

	INNER JOIN funcionario fu ON (fu.matricula = rm.matricula_func)
	INNER JOIN funcionario fuu ON (fuu.matricula = rm.mat_monitora)
	INNER JOIN grupo gr ON (gr.id = fu.id_grupo)

	WHERE  rm.date_mon BETWEEN '$dt_formatada_in' AND '$dt_formatada_end'
	ORDER BY 2, 1";

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



// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue("A2", "Tipo Demanda")
->setCellValue("B2", "N° Demanda")
->setCellValue('C2', 'Data do fechamento')
->setCellValue('D2', "Grupo")
->setCellValue("E2", "Monitor(a)")
->setCellValue('F2', "Analista")
->setCellValue('G2', "Status atualizados corretamente")
->setCellValue("H2", "Retornos enviados corretamente")
->setCellValue("I2", "Descrição sem erros gramaticais e de digitação")
->setCellValue("J2", "Demandas resolvidas")
->setCellValue("K2", "Logs claros, corretos e coerentes")
->setCellValue("L2", "Informações adicionais registradas corretamente")
->setCellValue("M2", "Atendeu ao IMA2")
->setCellValue("N2", "Atendeu ao IAD")
->setCellValue("O2", "Obteve conceito ÓTIMO/BOM na Pesquisa de Satisfação")
->setCellValue("P2", "Omissão ou esquiva em prestar esclarecimento")
->setCellValue("Q2", "Atitudes indevidas")
->setCellValue("R2", "Conceito")
->setCellValue("S2", "Observações");

$result = $conexao->prepare($select);
$result->execute();

$linha=3;

$dadosBanco = $result->fetchall(PDO::FETCH_ASSOC);
foreach ($dadosBanco as $value) {
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$linha, $value['tipo_ticket'])
	->setCellValue('B'.$linha, $value['ticket'])
	->setCellValue('C'.$linha, $value['date_mon'])
	->setCellValue('D'.$linha, $value['grupo'])
	->setCellValue('E'.$linha, $value['monitora'])
	->setCellValue('F'.$linha, $value['colaborador'])
	->setCellValue('G'.$linha, $value['sac'])
	->setCellValue('H'.$linha, $value['rec'])
	->setCellValue('I'.$linha, $value['dsegd'])
	->setCellValue('J'.$linha, $value['dr'])
	->setCellValue('K'.$linha, $value['lccc'])
	->setCellValue('L'.$linha, $value['iarc'])
	->setCellValue('M'.$linha, $value['a_ima'])
	->setCellValue('N'.$linha, $value['a_iad'])
	->setCellValue('O'.$linha, $value['ocob_ps'])
	->setCellValue('P'.$linha, $value['oepe'])
	->setCellValue('Q'.$linha, $value['atin'])
	->setCellValue('R'.$linha, $value['conceito'])
	->setCellValue('S'.$linha, $value['obs']);

	$linha++;
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

// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(25);

$header = 'A2:S2';
$objPHPExcel->getSheet(0)->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');
$style = array(
	'font' => array('bold' => true,),
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
$objPHPExcel->getSheet(0)->getStyle($header)->applyFromArray($style);



// Adicionamos um estilo de A1 até D1 
$objPHPExcel->getActiveSheet()->getStyle('A2:S2')->applyFromArray(
	array('fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => 'E0EEEE')
		),
	)
	);

			// NOME DA PLANILHA
$objPHPExcel->getActiveSheet()->setTitle('Report monitoria analistas');

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


?>