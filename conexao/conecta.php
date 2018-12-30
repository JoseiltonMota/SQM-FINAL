<?php
//Bloco que faz conexão

	try{
	$conexao = new PDO('mysql:host=localhost;dbname=qem', 'central3121', 'central3121');
	$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo 'Deu erro na conexão com o banco ';
		echo 'ERROR: '	. $e->getMessage();
	}
?>