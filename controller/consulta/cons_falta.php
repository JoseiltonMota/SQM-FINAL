<?php

if(isset($_POST['cons_falta'])) {

	$dt_ini = trim(strip_tags($_POST['dt_ini']));
	$dt_fim = trim(strip_tags($_POST['dt_fim']));
	$grupo = trim(strip_tags($_POST['grupo']));
	$mat_analista = trim(strip_tags($_POST['mat_analista']));
	
	if (empty($_SESSION['session_user'])){
		echo '<div class="alert alert-error">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<span>Ocorreu um erro ao cadastrar, gentileza faça logoff e tente novamente.</span>
		</div>';
	}

	else {

		$timestamp1 = strtotime( $dt_ini );
		$timestamp2 = strtotime( $dt_fim );

		$dt_formatada_in = date('Y-m-d', $timestamp1);
		$dt_formatada_end = date('Y-m-d', $timestamp2);

		$sql="SELECT fa.id as id, fu.nome as colaborador, fa.dt_falta as dt_falta, gr.nome as grupamento, mo.motivo as motivo, fa.cid as cid, fa.dt_insert as dt_insert, fuu.nome as supervisor
		FROM falta fa
		INNER JOIN funcionario fu ON (fu.matricula = fa.mat_analista)
		LEFT JOIN funcionario fuu ON (fuu.matricula = fa.usuario)	
		INNER JOIN motivo mo ON (mo.id = fa.id_motivo)
		INNER JOIN grupo gr ON (fu.id_grupo = gr.id)";


		if ( empty($dt_ini) AND empty($dt_fim) AND empty($grupo) AND empty($mat_analista) ) {
			echo '<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<span>Preencha um dos campos</span>
			</div>';

		}

		else if(empty($grupo) AND empty($mat_analista)){
			$resul_sql = $sql . "WHERE fa.dt_falta BETWEEN '$dt_formatada_in' AND '$dt_formatada_end' ";
			$result = $conexao->prepare($resul_sql);
			$result->execute(); ?>

			<a style="background-color: #008349; border-color: white;" href="report/report_falta.php?dt_ini=<?php echo $dt_formatada_in; ?>&dt_fim=<?php echo $dt_formatada_end; ?>"class="btn btn-default" style="float:right">Exportar consulta completa</a>

			<?PHP
		}

		else if(empty($mat_analista) AND isset($dt_ini) AND isset($dt_fim) AND isset($grupo)){
			$resul_sql = $sql . "WHERE fa.dt_falta BETWEEN '$dt_formatada_in' AND '$dt_formatada_end'
			AND fa.id_grupo = '$grupo' ";
			$result = $conexao->prepare($resul_sql);
			$result->execute(); ?>

			<a style="background-color: #008349; border-color: white;" href="report/report_falta.php?dt_ini=<?php echo $dt_formatada_in; ?>&dt_fim=<?php echo $dt_formatada_end; ?>&id_grupo=<?PHP echo $grupo; ?>"class="btn btn-default" style="float:right">Exportar consulta completa</a>

			<?php

		}

		else if(empty($grupo) AND isset($dt_ini) AND isset($dt_fim) AND isset($mat_analista)){
			$resul_sql = $sql . "WHERE fa.dt_falta BETWEEN '$dt_formatada_in' AND '$dt_formatada_end' 
			AND fa.mat_analista = '$mat_analista' ";
			$result = $conexao->prepare($resul_sql);
			$result->execute(); ?>

			<a style="background-color: #008349; border-color: white;" href="report/report_falta.php?dt_ini=<?php echo $dt_formatada_in; ?>&dt_fim=<?php echo $dt_formatada_end; ?>&mat_analista=<?PHP echo $mat_analista; ?>"class="btn btn-default" style="float:right">Exportar consulta completa</a>

			<?php	} 

			else {
				$resul_sql = $sql . "WHERE fa.id_grupo = $grupo
				AND fa.mat_analista = '$mat_analista'
				AND fa.dt_falta BETWEEN '$dt_formatada_in' AND '$dt_formatada_end' ";
				$result = $conexao->prepare($resul_sql);
				$result->execute();
				?>
				<a style="background-color: #008349; border-color: white;" href="report/report_falta.php?dt_ini=<?php echo $dt_formatada_in; ?>&dt_fim=<?php echo $dt_formatada_end; ?>&mat_analista=<?PHP echo $mat_analista; ?>&grupo=<?PHP echo $grupo; ?>"class="btn btn-default" style="float:right">Exportar consulta completa</a>

				<?php } ?>


				<br></br>

				<div class="row-fluid sortable">
					<div class="box span12" style="border: 2px solid #469CB1;">
						<div class="box-header" style="background: #469CB1;" data-original-title>
							<h2><i class="icon-align-justify"></i><span class="break"> Resultado da Consulta</span></h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							</div>
						</div>
						<div class="box-content">

							<!-- Botão que chama a função exportar_excel -->

							<table class="table table-striped table-bordered bootstrap-datatable datatable dataTable">
								<thead>
									<th>Colaborador</th>
									<th>Grupamento</th>
									<th>Data da Falta</th>
									<th>Motivo</th>
									<th>Cid</th>
									<th>Usuário que inseriu</th>
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
												<td><?php echo $value['colaborador']?></td>
												<td><?php echo $value['grupamento']?></td>
												<td><?php echo $value['dt_falta']?></td>
												<td><?php echo utf8_encode($value['motivo'])?></td>
												<td><?php echo $value['cid']?></td>
												<td><?php echo $value['supervisor']?></td>
												
												<td>
													<a href="controller/inativar_falta.php?id=<?php echo $value['id'];?>" class="btn btn-danger" onclick="return confirm('Deseja mesmo excluir este registro?');" >
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

			<?php 
		}
	} ?>
