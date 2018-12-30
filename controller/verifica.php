<?php
	session_start();
	if(!(isset($_SESSION['session_user']) and isset($_SESSION['session_senha']) and isset($_SESSION['session_nivel']))){

	echo "<script>alert(\"Faça logon antes de iniciar!\");</script>";
	//header("Location: ");
	header("Location: login.php");
	//echo "<script>location.href='./index.php?cod=3'</script>";
}
?>