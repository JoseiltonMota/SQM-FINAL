<?php
include_once("conexao/conecta.php");

if(isset($_POST['consulta_monitoria'])){

	$dt_ini = trim(strip_tags($_POST['dt_ini']));
	$dt_fim = trim(strip_tags($_POST['dt_fim']));
	//$grupo = trim(strip_tags($_POST['id_grupo']));
	$matricula = trim(strip_tags($_POST['matricula']));


	if(empty($matricula)){
		$consulta_matricula = 0;
	} else {
		$consulta_matricula = 1;
	}

		// VALIDANDO SE OS CAMPOS ESTÃO VAZIOS.
	if(empty($dt_ini) || empty($dt_fim) ){
		echo "<script>alert(\"Preencha todos os campos!\");</script>";
	}
	
	else{

		$timestamp1 = strtotime( $dt_ini );
		$timestamp2 = strtotime( $dt_fim );

		$dt_formatada_in = date('Y-m-d', $timestamp1);
		$dt_formatada_end = date('Y-m-d', $timestamp2);

		// SE FOR 0, realiza a consulta sem filtar por analista, se for 1 filtra por analista

		if ($consulta_matricula == 0) {

			$select = "SELECT rm.id as id, fu.nome as colaborador, rm.date_mon as date_mon, rm.sac as sac, rm.rec as rec, rm.lccc as lccc, rm.dsegd as dsegd, rm.iarc as iarc, rm.a_iad as a_iad, rm.a_ima as a_ima, 
			rm.ocob_ps as ocob_ps, rm.dr as dr, rm.atin as atin, rm.oepe as oepe, rm.obs as obs, rm.conceito as conceito,  rm.ticket as ticket, fuu.nome as monitora,  gr.nome as grupo

			FROM res_monitoria rm 

			LEFT JOIN funcionario fu ON (fu.matricula = rm.matricula_func)
			LEFT JOIN funcionario fuu ON (fuu.matricula = rm.mat_monitora)
			INNER JOIN grupo gr ON (gr.id = fu.id_grupo)

			WHERE  rm.date_mon BETWEEN '$dt_formatada_in' AND '$dt_formatada_end'
			AND gr.id <> 7004
			";
			?>
			
			<a style="background-color: #008349; border-color: white;" href="report/mon_2n.php?dt_in=<?php echo $dt_formatada_in; ?>&dt_fim=<?php echo $dt_formatada_end; ?>" class="btn btn-default" style="float:right">Exportar monitoria completa</a> 

 <?php } // fim consulta por matricula

 else {
 	$select = "SELECT rm.id as id, fu.nome as colaborador, rm.date_mon as date_mon, rm.sac as sac, rm.rec as rec, rm.lccc as lccc, rm.dsegd as dsegd, rm.iarc as iarc, rm.a_iad as a_iad, rm.a_ima as a_ima, 
 	rm.ocob_ps as ocob_ps, rm.dr as dr, rm.atin as atin, rm.oepe as oepe, rm.obs as obs, rm.conceito as conceito, rm.ticket as ticket, fuu.nome as monitora,  gr.nome as grupo

 	FROM res_monitoria rm 

 	LEFT JOIN funcionario fu ON (fu.matricula = rm.matricula_func)
 	LEFT JOIN funcionario fuu ON (fuu.matricula = rm.mat_monitora)
 	INNER JOIN grupo gr ON (gr.id = fu.id_grupo)

 	WHERE  rm.date_mon BETWEEN '$dt_formatada_in' AND '$dt_formatada_end'
 	AND fu.matricula = '$matricula'
 	ORDER BY rm.date_mon, fu.nome, gr.nome";
 	?>

 	<a style="background-color: #008349; border-color: #00682E;" href="report/mon_2n.php?dt_in=<?php echo $dt_formatada_in;?>&dt_fim=<?php echo $dt_formatada_end;?>&matricula=<?php echo $matricula;?>" class="btn btn-default" style="float:right">Exportar monitoria completa</a> 

 	<?php } // fim consulta sem amtricula ?>

 	<br></br>

 	<div class="row-fluid sortable">
 		<div class="box span12">
 			<div class="box-header" data-original-title>
 				<h2><i class="icon-align-justify"></i><span class="break"> Resumo da monitoria</span></h2>
 				<div class="box-icon">
 					<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
 				</div>
 			</div>
 			<div class="box-content">

 				<!-- Botão que chama a função exportar_excel -->

 				<table class="table table-striped table-bordered bootstrap-datatable datatable dataTable">
 					<thead>
 						<th class="center" title="Nome do colaborador">Colaborador</th>
 						<th class="center" title="Numero do Ticket">Nº da Demanda</th>
 						<th title="Data da monitoria realizada">Data monitoria</th>
 						<th title="Observação">Observação</th>
 						<th title="Conceito">Conceito</th>
 						<th title="Grupamento do colaborador">Grupamento</th>
 						<th title="Nome do(a) monitor(a)">Monitora(o)</th>
 						<th></th>
 					</thead>

 					<tbody>						
 						<?php try{
 							$result = $conexao->prepare($select);
 							$result->execute();

 							$linha = $result->fetchall(PDO::FETCH_ASSOC);
 							if (empty($linha)) {
 								echo "<script>alert(\"Não foram encontrados registros no período selecionado!\");</script>";
 							} else {
 								foreach ($linha as $value) { ?>
 								<tr>
 									<td><?php echo $value['colaborador']?></td>
 									<td><?php echo $value['ticket']?></td>
 									<td><?php echo $value['date_mon']?></td>
 									<td><?php echo $value['obs']?></td>
 									<td><?php echo $value['conceito']?></td>
 									<td><?php echo utf8_encode($value['grupo'])?></td>
 									<td><?php echo $value['monitora']?></td>
 									
 									<!-- Icone de editar -->
 									<td>
 										<a class="btn btn-info" href="index.php?cod=12&id=<?php echo $value['id']; ?>">
 											<i class="halflings-icon white edit"></i>  
 										</a>

 										<a href="controller/inativar_monitoria.php?id=<?php echo $value['id'];?>" class="btn btn-danger" onclick="return confirm('Deseja mesmo excluir este registro?');" >
 											<i class="icon-trash white trash"></i>  
 										</a>
 									</td> 

 								</tr>
 								<?php
								} // fim foreach 
							} //?>


								<?php } // fim Try
								

								catch(PDOException $e){
									echo $e;
								}

								?>
								<!-- <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>-->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div> <!-- Table -->

	</div> <!-- Container -->

	<?php
	 } // Fim do Else
} // Fim do IF 

?>