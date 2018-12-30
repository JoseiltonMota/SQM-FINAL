<?php
include_once("conexao/conecta.php");

if(isset($_POST['consulta_analista'])){

	$matricula = trim(strip_tags($_POST['id_func']));
	$id_grupo = trim(strip_tags($_POST['id_grupo']));

	// O RESULTADO DA CONSULTA ABAIXO SERÁ EXIBIDO PARA O USUÁRIO DENTRO DA TABELA 

	$select = "SELECT fu.nome as colaborador, fu.matricula as matricula, gr.nome as grupo, fu.sex as sexo

	FROM funcionario fu 

	INNER JOIN grupo gr ON (gr.id = fu.id_grupo)";
	?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">

					<table id="mytable" class="table table-bordred table-striped">
						<thead>
							<th></th>
							<th title="Nome do colaborador">Colaborador</th>
							<th title="Nome do colaborador">Matricula</th>
							<th title="Grupamento do colaborador">Grupamento</th>
							<th title="Nome do(a) monitor(a)">Sexo</th>
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
										<td></td>
										<td><?php echo $value['colaborador']?></td>
										<td><?php echo utf8_encode($value['matricula'])?></td>
										<td><?php echo utf8_encode($value['grupo'])?></td>
										<td><?php echo $value['sexo']?></td>
										<td>
											<p data-placement="top" data-toggle="tooltip" title="Edit">
												<button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit"><span class="glyphicon glyphicon-pencil"></span></button>
											</p>
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
			</div> <!-- Table -->

		</div> <!-- Container -->

		<?php
} // Fim do IF 
?>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				<h4 class="modal-title custom_align" id="Heading">Editar dados (EM DESENVOLVIMENTO)</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<input class="form-control " type="text" placeholder="Nome do colaborador">
					</div>
					
					<div class="form-group">
						<input class="form-control " type="text" placeholder="Matricula">
					</div>
					
				<div class="form-group">
						<input class="form-control " type="text" placeholder="Sexo">
				</div>

			</div>
			<div class="modal-footer ">
				<button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Atualizar</button>
			</div>
		</form>
	</div>
	<!-- /.modal-content --> 
</div>
<!-- /.modal-dialog --> 
</div>