
<!DOCTYPE html>
<html lang="pt-br">
<head>

	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>SQM - Sistema de Qualidade e Monitoria</title>
	<meta name="description" content="Bootstrap Metro Dashboard">
	<meta name="author" content="Dennis Ji">
	<meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
	<!-- end: Meta -->

	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->

	<!-- start: CSS -->
	<link id="bootstrap-style" href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="../css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="../css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>


</head>

<body>
	<?php

	include_once("../conexao/conecta.php");

	$id = $_GET['id'];

	$update_ps = "DELETE FROM tb_pesquisa WHERE id='$id' ";

	$resultado_one = $conexao->prepare($update_ps);

	$resultado_one->execute();

	echo '<div class="alert alert-success">
	<button type="button" class="close" data-dimiss="alert">x</button>
	<strong>Monitoria deletada!</strong></div>';

	header("Refresh: 2, ../index.php?cod=14");

	?>

</body>
</html>