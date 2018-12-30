<?php
include_once("../conexao/conecta.php");

$dt_ini = $_GET['dt_in'];
$dt_fim = $_GET['dt_fim'];
//$grupo = $_GET['grupo'];

if (isset($_GET['matricula'])) {

	$matricula = $_GET['matricula'];

	$select = "SELECT rm.id as id
	,fu.nome as colaborador
	,rm.date_mon as date_mon
	,gr.nome as grupo
	,rm.ort_form as ort_form
	,rm.reg_c as reg_c
	,rm.resu_c as resu_c
	,rm.causa_inc as causa_inc
	,rm.solic_inf as solic_inf
	,rm.dem_tra as dem_tra
	,rm.dr as dr
	,rm.solu_oneNivel_elabora as solu_oneNivel_elabora
	,rm.fluxo as fluxo
	,rm.categ_correto as categ_correto
	,rm.enc_correto as enc_correto
	,rm.sicrp as sicrp
	,rm.qoai as qoai
	,rm.obs as obs
	,rm.ticket as ticket
	,rm.tipo_ticket as tipo_ticket
	,rm.conceito as conceito
	,fuu.nome as monitor
	,rm.dt_insert as dt_insert


	FROM res_mon_web rm 

	INNER JOIN funcionario fu ON (fu.matricula = rm.matricula_func)
	LEFT JOIN funcionario fuu ON (fuu.matricula = rm.mat_monitora)
	INNER JOIN grupo gr ON (gr.id = fu.id_grupo)

	WHERE  rm.date_mon BETWEEN '$dt_ini' AND '$dt_fim'
	AND rm.id_grupo = 7004
	AND fu.matricula = '$matricula'
	ORDER BY 1, 2";

} else {

	$select = "SELECT rm.id as id
	,fu.nome as colaborador
	,rm.date_mon as date_mon
	,gr.nome as grupo
	,rm.ort_form as ort_form
	,rm.reg_c as reg_c
	,rm.resu_c as resu_c
	,rm.causa_inc as causa_inc
	,rm.solic_inf as solic_inf
	,rm.dem_tra as dem_tra
	,rm.dr as dr
	,rm.solu_oneNivel_elabora as solu_oneNivel_elabora
	,rm.fluxo as fluxo
	,rm.categ_correto as categ_correto
	,rm.enc_correto as enc_correto
	,rm.sicrp as sicrp
	,rm.qoai as qoai
	,rm.obs as obs
	,rm.ticket as ticket
	,rm.tipo_ticket as tipo_ticket
	,rm.conceito as conceito
	,fuu.nome as monitor
	,rm.dt_insert as dt_insert

	FROM res_mon_web rm 

	INNER JOIN funcionario fu ON (fu.matricula = rm.matricula_func)
	LEFT JOIN funcionario fuu ON (fuu.matricula = rm.mat_monitora)
	INNER JOIN grupo gr ON (gr.id = fu.id_grupo)

	WHERE rm.date_mon BETWEEN '$dt_ini' AND '$dt_fim'
	AND rm.id_grupo = 7004
	ORDER BY 1, 2";
}


// Incluindo a classe PHPExcel
include  ('../phpexcel/Classes/PHPExcel.php');

// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('S1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('T1')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue("A1", "Tipo de demanda")
->setCellValue("B1", "N° demanda")
->setCellValue("C1", "Data fechamento")
->setCellValue("D1", "Grupo")
->setCellValue("E1", "Monitor(a)")
->setCellValue('F1', "Analista")
->setCellValue('G1', "Ortografia/Formalidade")
->setCellValue("H1", "Registros coerentes")
->setCellValue("I1", "Demandas tratadas")
->setCellValue("J1", "Demandas resolvidas")
->setCellValue("K1", "Causa raiz/Incidente pai/Tipo de demanda")
->setCellValue("L1", "Resumo correto")
->setCellValue("M1", "Categorização correta")
->setCellValue("N1", "Solicitação das informações necessárias")
->setCellValue("O1", "Encaminhamento correto")
->setCellValue("P1", "Existe Solução em 1º Nível/Solução bem elaborada")
->setCellValue("Q1", "Fluxo correto")
->setCellValue("R1", "Solução incoerente com a resolução do problema")
->setCellValue("S1", "Quaisquer outras atitudes indevidas")
->setCellValue("T1", "Conceito")
->setCellValue("U1", "Observações");


$result = $conexao->prepare($select);
$result->execute();

$linha=2;
$dadosBanco = $result->fetchall(PDO::FETCH_ASSOC);
foreach ($dadosBanco as $value) {
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$linha, $value['tipo_ticket'])    
	->setCellValue('B'.$linha, $value['ticket'])   
	->setCellValue('C'.$linha, $value['date_mon'])    
	->setCellValue('D'.$linha, $value['grupo'])    
	->setCellValue('E'.$linha, $value['monitor'])    
	->setCellValue('F'.$linha, $value['colaborador'])    
	->setCellValue('G'.$linha, $value['ort_form'])    
	->setCellValue('H'.$linha, $value['reg_c'])
	->setCellValue('I'.$linha, $value['dem_tra'])    
	->setCellValue('J'.$linha, $value['dr'])    
	->setCellValue('K'.$linha, $value['fluxo'])    
	->setCellValue('L'.$linha, $value['resu_c'])    
	->setCellValue('M'.$linha, $value['categ_correto'])    
	->setCellValue('N'.$linha, $value['solic_inf'])    
	->setCellValue('O'.$linha, $value['enc_correto'])    
	->setCellValue('P'.$linha, $value['solu_oneNivel_elabora'])    
	->setCellValue('Q'.$linha, $value['fluxo'])    
	->setCellValue('R'.$linha, $value['sicrp'])    
	->setCellValue('S'.$linha, $value['qoai'])   
	->setCellValue('T'.$linha, $value['conceito'])
	->setCellValue('U'.$linha, $value['obs']);    

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
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('I1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('K1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('L1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('M1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('N1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('O1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('P1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('Q1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('R1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('S1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('T1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('U1')->getAlignment()->setWrapText(true);

// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(23);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(24);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(34);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(28);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(18);

$header = 'A1:U1';
$objPHPExcel->getSheet(0)->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');
$style = array(
	'font' => array('bold' => true,),
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
$objPHPExcel->getSheet(0)->getStyle($header)->applyFromArray($style);

// Adicionamos um estilo de A2 até q2 
$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->applyFromArray(
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