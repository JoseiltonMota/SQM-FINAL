<?php
//Bloco que faz conexão

	try{
	$conexaoABS = new PDO('mysql:host=localhost;dbname=abs', 'central3121', 'central3121');
	$conexaoABS->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo 'Deu erro na conexão com o banco ';
		echo 'ERROR: '	. $e->getMessage();
	}
?>