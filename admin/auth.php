<?php
	ini_set( 'default_charset', 'utf-8');
	include("config/config.php");
	
	if($_GET['a']==1){ // login para preencher todos os campos
		if(empty($_POST['login']) || empty($_POST['password'] )){
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?m=1'>";
			return;
		}
		//se não estiver nenhum campo vazio, então verifica os dados para ser efectuado o login
		$login = $_POST['login'];
		$password = $_POST['password'];
		$res = mysql_query("select * from dbo_tab_utilizadores where UTILIZADOR = '$login' AND PASSWORD = '$password'");

		$numReg = mysql_num_rows($res); 	
		
		if($numReg > 0){
			session_start();
			$_SESSION['login'] = $login;
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_func'>";
		}else{
		//se estiverem errados, então dá mensagem de erro e tem de ser feito o login de novo
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?m=2'>";
			return;
		}
	}
?>
