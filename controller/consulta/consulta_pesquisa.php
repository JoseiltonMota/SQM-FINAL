<?php
include_once("conexao/conecta.php");

if(isset($_POST['consulta_monitoria'])){

	$dt_ini = trim(strip_tags($_POST['dt_ini']));
	$dt_fim = trim(strip_tags($_POST['dt_fim']));
	//$grupo = trim(strip_tags($_POST['id_grupo']));
	$monitor = trim(strip_tags($_POST['monitor']));


		// VALIDANDO SE OS CAMPOS ESTÃO VAZIOS.
	if (empty($dt_fim) AND empty($dt_ini) AND empty($monitor)) {
		echo "<script>alert(\"Preencha um dos campos!\");</script>";		
	} else {

		$timestamp1 = strtotime( $dt_ini );
		$timestamp2 = strtotime( $dt_fim );

		$dt_formatada_in = date('Y-m-d', $timestamp1);
		$dt_formatada_end = date('Y-m-d', $timestamp2);

		$sql = "SELECT ps.id as id
		, ps.ticket as ticket
		, ps.dt_pesquisa as dt_pesquisa
		, ps.user as user
		, fu.nome as analista
		, gr.nome as grupo
		, ps.comentario_user as comentario
		, ps.clareza as clareza
		, ps.inter_atend as interesse 
		, ps.qualid_soluc as qualidade
		, ps.tempo_atend as tempo
		, ps.nota_final as nota_final
		, ps.tipo_coment AS TIPO_COMENT
		, ps.tentativa_cont AS TENTATIVA_CONT
		, ps.situacao AS SITUACAO
		, ps.analise AS ANALISE
		, ps.motivo_rec AS MOTIVO_REC
		, ps.obs_just AS OBS_JUST
		, fuu.nome AS monitor

		FROM tb_pesquisa ps

		LEFT JOIN funcionario fu ON (fu.matricula = ps.mat_analista)
		LEFT JOIN funcionario fuu ON (fuu.matricula = ps.mat_monitora)
		INNER JOIN grupo gr ON (gr.id = ps.id_grupo)";

		if (empty($dt_ini) OR empty($dt_fim)) {
			$sql_dt = $sql . "WHERE ps.mat_monitora = '$monitor' ";

			$result = $conexao->prepare($sql_dt);
			$result->execute();
			?>
			<!-- Exportar monitoria -->
			<a style="background-color: #008349; border-color: white;" href="report/report_pesquisa.php?monitor=<?php echo $monitor; ?>" class="btn btn-default" style="float:right">Exportar pesquisa completa</a> 

			<?PHP } 

			else if (empty($user)) {
				$sql_user = $sql . "WHERE ps.dt_pesquisa BETWEEN '$dt_formatada_in' AND '$dt_formatada_end' ";

				$result = $conexao->prepare($sql_user);
				$result->execute();

				?>
				<a style="background-color: #008349; border-color: white;" href="report/report_pesquisa.php?dt_ini=<?php echo $dt_formatada_in; ?>&dt_fim=<?php echo $dt_formatada_end; ?>" class="btn btn-default" style="float:right">Exportar pesquisa completa</a> 

				<?PHP	}	

				else if ( !(empty($dt_fim) AND empty($dt_ini) AND empty($user)) ) {

					$sql_all = $sql . "WHERE ps.dt_pesquisa BETWEEN '$dt_formatada_in' AND '$dt_formatada_end' AND ps.mat_monitora = '$monitor' ";

					$result = $conexao->prepare($sql_all);
					$result->execute();
					?>
					
					<a style="background-color: #008349; border-color: white;" href="report/report_pesquisa.php?dt_ini=<?php echo $dt_formatada_in; ?>&dt_fim=<?php echo $dt_formatada_end; ?>&monitor=<?PHP echo $monitor; ?>" class="btn btn-default" style="float:right">Exportar pesquisa completa</a> 

					<?PHP } ?>

					<br></br>

					<div class="row-fluid sortable">
						<div class="box span12" style="border: 2px solid #243CB9;">
							<div class="box-header" style="background: #384FC9;" data-original-title>
								<h2><i class="icon-align-justify"></i><span class="break"> Resultado da Pesquisa de Satisfação</span></h2>
								<div class="box-icon">
									<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
								</div>
							</div>
							<div class="box-content">

								<!-- Botão que chama a função exportar_excel -->

								<table class="table table-striped table-bordered bootstrap-datatable datatable dataTable">
									<thead>
										<th class="center" title="Numero do Ticket">Ticket</th>
										<th class="center" title="Data da pesquisa">Data</th>
										<th class="center" title="Nome do usuário">Usuário</th>
										<th class="center" title="Nome do analista">Analista</th>
										<th class="center" title="Tipo de comentário">TIPO_COMENT</th>
										<th class="center" title="Tentativa de contato">Tentativa de contato</th>
										<th class="center" title="Situação">Situação</th>
										<th class="center" title="Análise">Análise</th>
										<th class="center" title="Nota Final">Nota Final</th>
										<th class="center" title="Monitor(a)">Monitor(a)</th>
										<th></th>
										<th></th>
									</thead>

									<tbody>						
										<?php try{

											$linha = $result->fetchall(PDO::FETCH_ASSOC);
											if (empty($linha)) {
												echo "<script>alert(\"Não foram encontrados registros no período selecionado!\");</script>";
											} else {
												foreach ($linha as $value) { ?>
												<tr>
													<td><?php echo $value['ticket']?></td>
													<td><?php echo $value['dt_pesquisa']?></td>
													<td><?php echo $value['user']?></td>
													<td><?php echo $value['analista']?></td>
													<td><?php echo $value['TIPO_COMENT']?></td>
													<td><?php echo $value['TENTATIVA_CONT']?></td>
													<td><?php echo $value['SITUACAO']?></td>
													<td><?php echo $value['ANALISE']?></td>
													<td><?php echo $value['nota_final']?></td>
													<td><?php echo $value['monitor']?></td>

													<td>
														<a class="label label-success" target="_blank" href="index.php?cod=16&id=<?php echo $value['id']; ?>">Edit</a>
													</td>

													<td>
														<a href="controller/inativar_pesquisa.php?id=<?php echo $value['id'];?>" class="btn btn-danger" onclick="return confirm('Deseja mesmo excluir este registro?');" >
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
