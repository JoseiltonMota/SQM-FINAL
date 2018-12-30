<?php
include_once("../conexao/conecta.php");

$dt_ini = $_GET['dt_in'];
$dt_fim = $_GET['dt_fim'];

$timestamp1 = strtotime( $dt_ini );
$timestamp2 = strtotime( $dt_fim );

$dt_formatada_in = date('Y-m-d', $timestamp1);
$dt_formatada_end = date('Y-m-d', $timestamp2);

// O RESULTADO DA CONSULTA ABAIXO SERÁ EXIBIDO PARA O USUÁRIO DENTRO DA TABELA 

if (isset($_GET['matricula'])) {

	$matricula = $_GET['matricula'];
	
	$select = "SELECT fu.nome as colaborador
	,rm.date_mon as date_mon
	,rm.us as us
	,rm.atu_cad as atu_cad
	,rm.gent_usu as gent_usu
	,rm.dic_tim as dic_tim
	,rm.aus_ling as aus_ling
	,rm.person as person
	,rm.atencao as atencao
	,rm.argu as argu
	,rm.dem_tra as dem_tra
	,rm.dr as dr
	,rm.tma as tma
	,rm.iaas as iaas
	,rm.sicrp as sicrp
	,rm.qoai as qoai
	,rm.perd_host as perd_host
	,rm.oepe as oepe
	,rm.fluxo_soluc as fluxo_soluc
	,rm.gr_co as gr_co
	,rm.reg_c as reg_c
	,rm.resu_c as resu_c
	,rm.causa_inc as causa_inc
	,rm.solic_inf as solic_inf
	,rm.categ_correto as categ_correto
	,rm.tipo_dem as tipo_dem
	,rm.enc_correto as enc_correto
	,rm.ticket as ticket
	,rm.tipo_ticket as tipo_ticket
	,rm.tipo_ligacao as tipo_ligacao
	,rm.temp_ligacao as temp_ligacao
	,rm.hora_inicio as hora_inicio
	,rm.obs as obs
	,rm.conceito as conceito
	,fuu.nome as monitor
	,gr.nome as grupamento
	,rm.dt_insert as dt_insert

	FROM res_mon_tel rm 

	INNER JOIN funcionario fu ON (fu.matricula = rm.matricula_func)
	LEFT JOIN funcionario fuu ON (fuu.matricula = rm.mat_monitora)
	INNER JOIN grupo gr ON (gr.id = rm.id_grupo)

	WHERE  rm.date_mon BETWEEN '$dt_ini' AND '$dt_fim'
	AND fu.matricula = '$matricula'
	ORDER BY 1, 2 ";

} else {
	$select = "SELECT fu.nome as colaborador
	,rm.date_mon as date_mon
	,rm.us as us
	,rm.atu_cad as atu_cad
	,rm.gent_usu as gent_usu
	,rm.dic_tim as dic_tim
	,rm.aus_ling as aus_ling
	,rm.person as person
	,rm.atencao as atencao
	,rm.argu as argu
	,rm.dem_tra as dem_tra
	,rm.dr as dr
	,rm.tma as tma
	,rm.iaas as iaas
	,rm.sicrp as sicrp
	,rm.qoai as qoai
	,rm.perd_host as perd_host
	,rm.oepe as oepe
	,rm.fluxo_soluc as fluxo_soluc
	,rm.gr_co as gr_co
	,rm.reg_c as reg_c
	,rm.resu_c as resu_c
	,rm.causa_inc as causa_inc
	,rm.solic_inf as solic_inf
	,rm.categ_correto as categ_correto
	,rm.tipo_dem as tipo_dem
	,rm.enc_correto as enc_correto
	,rm.ticket as ticket
	,rm.tipo_ticket as tipo_ticket
	,rm.tipo_ligacao as tipo_ligacao
	,rm.temp_ligacao as temp_ligacao
	,rm.hora_inicio as hora_inicio
	,rm.obs as obs
	,rm.conceito as conceito
	,fuu.nome as monitor
	,gr.nome as grupamento
	,rm.dt_insert as dt_insert


	FROM res_mon_tel rm 

	INNER JOIN funcionario fu ON (fu.matricula = rm.matricula_func)
	LEFT JOIN funcionario fuu ON (fuu.matricula = rm.mat_monitora)
	INNER JOIN grupo gr ON (gr.id = rm.id_grupo)

	WHERE  rm.date_mon BETWEEN '$dt_ini' AND '$dt_fim'
	AND rm.id_grupo = 7004
	ORDER BY 1, 2 ";
}

// Incluimos a classe PHPExcel
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
$objPHPExcel->getActiveSheet()->getStyle('U1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('V1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('W1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('X1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('Y1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('Z1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AA1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AB1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AC1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AD1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AE1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AF1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AG1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AH1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AI1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('AJ1')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue("A1", "Tipo de demanda")
->setCellValue("B1", "N° demanda")
->setCellValue("C1", "Data fechamento")
->setCellValue("D1", "Grupo")
->setCellValue("E1", "Monitor(a)")
->setCellValue("F1", 'Analista')
->setCellValue("G1", "Utilização dos Scripts")
->setCellValue("H1", "Atualização do cadastro")
->setCellValue("I1", "Gentileza/Interação com o usuário")
->setCellValue("J1", "Dicção e timbre")
->setCellValue("K1", "Ausência de vícios de linguagem")
->setCellValue("L1", "Personalização")
->setCellValue("M1", "Atenção")
->setCellValue("N1", "Argumentação")
->setCellValue("O1", "Demandas tratadas")
->setCellValue("P1", "Demandas resolvidas")
->setCellValue("Q1", "TMA")
->setCellValue("R1", "Iniciar o atendimento após 10 segundos")
->setCellValue("S1", "Solução incoerente com a resolução do problema")
->setCellValue("T1", "Quaisquer outras atitudes indevidas")
->setCellValue("U1", "Perda ou abandono da ligação devido a hostilidade do atendente")
->setCellValue("V1", "Omissão ou esquiva em prestar esclarecimento")
->setCellValue("W1", "Fluxo correto/Existe Solução em 1º Nível/Solução bem elaborada")
->setCellValue("X1", "Gramática correta")
->setCellValue("Y1", "Registros coerentes")
->setCellValue("Z1", "Resumo correto")
->setCellValue("AA1", "Causa raiz/Incidente pai")
->setCellValue("AB1", "Solicitação das informações necessárias")
->setCellValue("AC1", "Categorização correta")
->setCellValue("AD1", "Alteração de tipo de demanda correto")
->setCellValue("AE1", "Encaminhamento correto")
->setCellValue("AF1", "Tipo ligação")
->setCellValue("AG1", "Tempo de ligação")
->setCellValue("AH1", "Hora de inicio do atendimento")
->setCellValue("AI1", "Conceito")
->setCellValue("AJ1", "Observações");


$result = $conexao->prepare($select);
$result->execute();

$linha=2;
$dadosBanco = $result->fetchall(PDO::FETCH_ASSOC);
foreach ($dadosBanco as $value) {
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$linha, $value['tipo_ticket'])    
	->setCellValue('B'.$linha, $value['ticket'])   
	->setCellValue('C'.$linha, $value['date_mon'])    
	->setCellValue('D'.$linha, $value['grupamento'])    
	->setCellValue('E'.$linha, $value['monitor'])    
	->setCellValue('F'.$linha, $value['colaborador'])    
	->setCellValue('G'.$linha, $value['us'])    
	->setCellValue('H'.$linha, $value['atu_cad'])    
	->setCellValue('I'.$linha, $value['gent_usu'])    
	->setCellValue('J'.$linha, $value['dic_tim'])    
	->setCellValue('K'.$linha, $value['aus_ling'])    
	->setCellValue('L'.$linha, $value['person'])    
	->setCellValue('M'.$linha, $value['atencao'])    
	->setCellValue('N'.$linha, $value['argu'])    
	->setCellValue('O'.$linha, $value['dem_tra'])    
	->setCellValue('P'.$linha, $value['dr'])
	->setCellValue('Q'.$linha, $value['tma'])
	->setCellValue('R'.$linha, $value['iaas'])
	->setCellValue('S'.$linha, $value['sicrp'])
	->setCellValue('T'.$linha, $value['qoai'])
	->setCellValue('U'.$linha, $value['perd_host'])
	->setCellValue('V'.$linha, $value['oepe'])
	->setCellValue('W'.$linha, $value['fluxo_soluc'])
	->setCellValue('X'.$linha, $value['gr_co'])
	->setCellValue('Y'.$linha, $value['reg_c'])
	->setCellValue('Z'.$linha, $value['resu_c'])
	->setCellValue('AA'.$linha, $value['causa_inc'])
	->setCellValue('AB'.$linha, $value['solic_inf'])
	->setCellValue('AC'.$linha, $value['categ_correto'])
	->setCellValue('AD'.$linha, $value['tipo_dem'])
	->setCellValue('AE'.$linha, $value['enc_correto'])
	->setCellValue('AF'.$linha, $value['tipo_ligacao'])
	->setCellValue('AG'.$linha, $value['temp_ligacao']) 
	->setCellValue('AH'.$linha, $value['hora_inicio']) 
	->setCellValue('AI'.$linha, $value['conceito'])
	->setCellValue('AJ'.$linha, $value['obs']);    

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
$objPHPExcel->getActiveSheet()->getStyle('V1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('W1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('X1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('Y1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('Z1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('AA1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('AB1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('AC1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('AD1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('AE1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('AF1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('AG1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('AH1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('AI1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('AJ1')->getAlignment()->setWrapText(true);

// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(21);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(18);

$header = 'A1:AJ1';
$objPHPExcel->getSheet(0)->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');
$style = array(
	'font' => array('bold' => true,),
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
$objPHPExcel->getSheet(0)->getStyle($header)->applyFromArray($style);

// Adicionamos um estilo de A1 até D1 
$objPHPExcel->getActiveSheet()->getStyle('A1:AJ1')->applyFromArray(
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