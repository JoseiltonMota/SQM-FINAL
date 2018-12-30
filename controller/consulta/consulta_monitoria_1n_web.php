<?php
include_once("conexao/conecta.php");

if(isset($_POST['consulta_monitoria_1n_web'])){

	$dt_ini = trim(strip_tags($_POST['dt_ini']));
	$dt_fim = trim(strip_tags($_POST['dt_fim']));
	$matricula = trim(strip_tags($_POST['id_func']));

		// VALIDANDO SE OS CAMPOS ESTÃO VAZIOS.
	if(empty($dt_ini) || empty($dt_fim)) {
		echo "<script>alert(\"Preencha todos os campos!\");</script>";
	}

	else {

		$timestamp1 = strtotime( $dt_ini );
		$timestamp2 = strtotime( $dt_fim );

		$dt_formatada_in = date('Y-m-d', $timestamp1);
		$dt_formatada_end = date('Y-m-d', $timestamp2);

		if(empty($matricula)){
			$consulta_matricula = 0;
		} else {
			$consulta_matricula = 1;
		}

		if ($consulta_matricula == 0) {

			$select = 
			"SELECT rm.id as id
			,fu.nome as colaborador
			,gr.nome as grupo
			,rm.date_mon as date_mon
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

			WHERE  rm.date_mon BETWEEN '$dt_formatada_in' AND '$dt_formatada_end'
			AND rm.id_grupo = 7004
			ORDER BY 1, 2";	
			?>
			<a style="background-color: #008349; border-color: #00682E;" href="report/mon_1n_web.php?dt_in=<?php echo $dt_formatada_in;?>&dt_fim=<?php echo $dt_formatada_end;?>" class="btn btn-default" style="float:right">Exportar monitoria completa</a> 
<?PHP } // FIM ELSE 

else {

	$select = 
	"SELECT rm.id as id
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

	WHERE  rm.date_mon BETWEEN '$dt_formatada_in' AND '$dt_formatada_end'
	AND fu.matricula = '$matricula'
	AND rm.id_grupo = 7004
	ORDER BY 1, 2";
	?>
	
	<a style="background-color: #008349; border-color: #00682E;" href="report/mon_1n_web.php?dt_in=<?php echo $dt_formatada_in; ?>&dt_fim=<?php echo $dt_formatada_end; ?>&matricula=<?php echo $matricula; ?>" class="btn btn-default" style="float:right">Exportar monitoria completa</a> 
	<a style="background-color: #D3A900; border-color: #D3A900;" href="report/conceito_mensal_web.php?dt_in=<?php echo $dt_formatada_in; ?>&dt_fim=<?php echo $dt_formatada_end; ?>&matricula=<?php echo $matricula; ?>" class="btn btn-default" style="float:right">Gerar conceito mensal</a> 

	<?PHP } ?>


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
						<th class="center" title="Nome do colaborador">Analista</th>
						<th title="">Demanda</th>
						<th class="center" title="Data da monitoria realizada">Data monitoria</th>
						<th title="">Observação</th>
						<th title="">Conceito</th>
						<th title="">Grupamento</th>
						<th title="">Monitor(a)</th>
						<th title=""></th>
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
									<td><?php echo utf8_encode($value['conceito'])?></td>
									<td><?php echo $value['grupo']?></td>
									<td><?php echo $value['monitor']?></td>
									
									<td>
										<a class="btn btn-info" target="_blank" href="index.php?cod=23&id=<?php echo $value['id']; ?>">
											<i class="halflings-icon white edit"></i>  
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