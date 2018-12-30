<?php

include_once("../conexao/conecta.php");

$id = $_GET['id'];

$update = "DELETE FROM res_monitoria WHERE id='$id' ";

//$resultado = $conexao->prepare($update);

//$sql = "SELECT id FROM falta WHERE id = $id";

$resultado = $conexao->prepare($update);
$resultado->execute();

echo '<div class="alert alert-success">
<button type="button" class="close" data-dimiss="alert">x</button>
<strong><b>Monitoria deletada!</b></strong></div>';

header("Refresh: 2, ../index.php?cod=7");

?>