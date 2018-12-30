<?php
ob_start();
session_start();

if(isset($_SESSION['session_user']) AND isset($_SESSION['session_senha']) AND isset($_SESSION['session_nivel']) ) {
	header("Location: index.php?cod=1");exit();
} 

if(isset($_POST['logar'])){
			// RECUPERAR DADOS FORM
	$usuario = trim(strip_tags($_POST['user']));
	$senha = trim(strip_tags($_POST['password']));

	$select = "SELECT usuario, nivel FROM login WHERE usuario=:user AND senha=:senha";

	try{
		$result = $conexao->prepare($select);
		$result->bindParam(':user', $usuario, PDO::PARAM_STR);
		$result->bindParam(':senha', $senha, PDO::PARAM_STR);
		$result->execute();
		$contar = $result->rowCount();

		//Pegando o valor do campo nivel
		$linha = $result->fetch(PDO::FETCH_ASSOC);
		$nivel = $linha['nivel'];

		if($contar>0){

					// Armazendando usuário e sennha em uma sessão
			$_SESSION['session_user'] = $usuario; 
			$_SESSION['session_senha'] = $senha;
			$_SESSION['session_nivel'] = $nivel;
			
			echo '<div class="alert alert-success">
			<button type="button" class="close" data-dimiss="alert">x</button>
			<strong>Bem vindo </strong></div>';
					// Redirecionando depois de 5 segundos.		
			header("Refresh: 2, index.php?cod=1");exit;

		}  else {
			echo '<div class="alert alert-danger">
			<button type="button" class="close" data-dimiss="alert">x</button>
			<strong>Usuário e ou senha inválido(s)!</strong> 
			</div>';
		}
	} catch(PDOException $e){
		echo $e;
	}
}
?>