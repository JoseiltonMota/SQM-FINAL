<?php
include_once("../conexao/conecta.php");

$sql ="SELECT fa.id as id
, fu.nome as colaborador
, fa.dt_falta as dt_falta
, gr.nome as grupamento
, mo.motivo as motivo
, fa.cid as cid
, fu.sex as sex
, fa.dt_insert as dt_insert
, fuu.nome as supervisor

FROM falta fa
INNER JOIN funcionario fu ON (fu.matricula = fa.mat_analista)
LEFT JOIN funcionario fuu ON (fuu.matricula = fa.usuario)	
INNER JOIN motivo mo ON (mo.id = fa.id_motivo)
INNER JOIN grupo gr ON (fu.id_grupo = gr.id)";

if (isset($_GET['id_grupo'])) {
	
	$dt_ini = $_GET['dt_ini'];
	$dt_fim = $_GET['dt_fim'];
	$id_grupo = $_GET['id_grupo'];

	$resul_sql = $sql . "WHERE fa.dt_falta BETWEEN '$dt_ini' AND '$dt_fim'
			AND fa.id_grupo = '$id_grupo' ";

} else if (isset($_GET['mat_analista'])) {
	
	$dt_ini = $_GET['dt_ini'];
	$dt_fim = $_GET['dt_fim'];
	$mat_analista = $_GET['mat_analista'];

	$resul_sql = $sql . "WHERE fa.dt_falta BETWEEN '$dt_ini' AND '$dt_fim'
			AND fa.mat_analista = '$mat_analista' ";
}

else if(isset($_GET['mat_analista']) and isset($_GET['id_grupo']) ){

	$dt_ini = $_GET['dt_ini'];
	$dt_fim = $_GET['dt_fim'];
	$mat_analista = $_GET['mat_analista'];
	$id_grupo = $_GET['id_grupo'];

	$resul_sql = $sql . "WHERE fa.dt_falta BETWEEN '$dt_ini' AND '$dt_fim' 
	AND fa.mat_analista = '$mat_analista' 
	AND fa.id_grupo = '$id_grupo' ";

}


else {

	$dt_ini = $_GET['dt_ini'];
	$dt_fim = $_GET['dt_fim'];

	$resul_sql = $sql . "WHERE fa.dt_falta BETWEEN '$dt_ini' AND '$dt_fim' ";

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


// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue("A2", "Colaborador")
->setCellValue("B2", "Data da falta")
->setCellValue('C2', 'Grupamento')
->setCellValue('D2', "Motivo")
->setCellValue("E2", "Cid")
->setCellValue("F2", "Sexo")
->setCellValue('G2', "Data de inserção")
->setCellValue('H2', "Responsável pela inserção");

$linha=3;

$result = $conexao->prepare($resul_sql);
$result->execute();
$dadosBanco = $result->fetchall(PDO::FETCH_ASSOC);


foreach ($dadosBanco as $value) {
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$linha, $value['colaborador'])
	->setCellValue('B'.$linha, $data = date('d/m/Y', strtotime($value['dt_falta'])))
	->setCellValue('C'.$linha, $value['grupamento'])
	->setCellValue('D'.$linha, utf8_encode($value['motivo'])) // Inserido o Encode pois estava apresentando como "FALSO"
	->setCellValue('E'.$linha, utf8_encode($value['cid'])) // Inserido o Encode pois estava apresentando como "FALSO"
	->setCellValue('F'.$linha, utf8_encode($value['sex'])) // Inserido o Encode pois estava apresentando como "FALSO"
	->setCellValue('G'.$linha, $dt = date('d/m/Y', strtotime($value['dt_insert'])))
	->setCellValue('H'.$linha, $value['supervisor']);

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


// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);

$header = 'A2:H2';
$objPHPExcel->getSheet(0)->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');
$style = array(
	'font' => array('bold' => true,),
	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
$objPHPExcel->getSheet(0)->getStyle($header)->applyFromArray($style);



// Adicionamos um estilo de A1 até D1 
$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray(
	array('fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => 'E0EEEE')
		),
	)
	);

			// NOME DA PLANILHA
$objPHPExcel->getActiveSheet()->setTitle('Report absenteismo');

			// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Report_absenteismo.xls"');
header('Cache-Control: max-age=0');
			// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

			// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

			// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 


?>