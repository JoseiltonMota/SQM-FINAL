<?php 
include_once("conexao/conecta.php");

if(isset($_POST['alteraSenha'])){

	$senhaAtual = trim(strip_tags($_POST['senhaAtual']));
	$novaSenha = trim(strip_tags($_POST['novaSenha']));
	$usuario = $_SESSION['session_user'];

	if(empty($senhaAtual) OR empty($novaSenha)){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dimiss="alert">x</button>
		<strong>Preencha todos os campos!</strong> 
		</div>';
	}

	else if($senhaAtual != $novaSenha){

		$update = "UPDATE login SET senha=:novaSenha WHERE usuario=:usersession";

		$select = "SELECT senha FROM login WHERE usuario=:usersession";

		$stmt = $conexao->prepare($update);
		$stmt->bindParam('usersession', $usuario, PDO::PARAM_STR);
		$stmt->bindParam('novaSenha', $novaSenha, PDO::PARAM_STR);
		
		$stmt2 = $conexao->prepare($select);
		$stmt2->bindParam('usersession', $usuario, PDO::PARAM_STR);
		$stmt2->execute();

		$aux = $stmt2->fetch(PDO::FETCH_ASSOC);

		if($aux['senha'] == $senhaAtual){
			$stmt->execute();
				echo '<div class="alert alert-success">
		<button type="button" class="close" data-dimiss="alert">x</button>
		<strong>Senha alterada com sucesso!</strong> 
		</div>';
		}

		else {
			echo '<div class="alert alert-danger">
		<button type="button" class="close" data-dimiss="alert">x</button>
		<strong>Senha atual não confere!</strong>
		</div>';
		}

	}

	else {
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dimiss="alert">x</button>
		<strong>A nova senha precisa ser diferente da atual!</strong> 
		</div>';
	}
}

?>