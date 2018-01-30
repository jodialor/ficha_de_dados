<?php
	//ligação á DB
	include("config/config.php");
	error_reporting(E_ALL & ~E_NOTICE);
	//Abre sessão
	session_start();
	//faz a verificação se já fez login, caso não tenha, o login.php é aberto.
	//if (!$_GET['mod']){
	//	if($_SESSION['login']) $mod="inicio";
	//	else{
	//		$mod="login";
	//	}
	//}else{
	//	$mod=$_GET['mod'];
	//}
	if (!$_GET['mod']){
		$mod = "pessoal";
	}else{
		$mod=$_GET['mod'];
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="css/favicon.ico">

    <title>Ficha de dados de pessoal e técnicos</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/starter-template.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
  </head>

  <body>

		<!-- Menu de navegação, que está disponivel em todas as páginas -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.recursosonline.org/fichadedados">Ficha de dados do Pessoal Docente e Técnicos</a>
        </div>
      </div>
    </nav>


    <div class="container" style="margin-top: 2%;">

		<div class="msg">
		<?php
			if ($_GET['m'] == 1) {
				echo "
				<div class='alert alert-info alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
					<p>Preencha todos os campos por favor.</p>
				</div>
				<meta HTTP-EQUIV='REFRESH' content='; url=index.php?mod=pessoal_2'>
				";
			}
			if ($_GET['m'] == 2) {
				echo"
				<div class='container' style='margin-top: 5%;'>
					<div class='col-md-12 col-xs-12 col-lg-12'>
						<div class='alert alert-success' style='text-align: center;padding-top: 4%;padding-bottom: 3%;'>
							<span class='glyphicon glyphicon-ok'></span>
							Os dados foram enviados com <strong>sucesso!</strong> Em breve irá receber um email de confirmação.<br><br>
							<a href='index.php' type='button' class='btn btn-default'>
								<span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>
								Voltar ao Início
							</a>
						</div>
					</div>
				</div>
				";
			}
			if ($_GET['m'] == 3) {
				echo "
				<div class='alert alert-info alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
					<p>Data está com o formato errado! Por favor insira-a com o formato (dd-mm-aaaa).</p>
				</div>
				<meta HTTP-EQUIV='REFRESH' content='; url=index.php?mod=pessoal_2'>
				";
			}
			if ($_GET['m'] == 4) {
				echo"
				<div class='container' style='margin-top: 5%;'>
					<div class='col-md-12 col-xs-12 col-lg-12'>
						<div class='alert alert-success' style='text-align: center;padding-top: 4%;padding-bottom: 3%;'>
							<p><span class='glyphicon glyphicon-ok'></span> Irá receber um email com a sua palavra-passe.</p><br>
							<a href='index.php' type='button' class='btn btn-default'>
								<span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>
								Voltar ao Início
							</a>
						</div>
					</div>
				</div>
				";
			}
			if ($_GET['m'] == 5) {
				echo "
				<div class='alert alert-danger alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
					<p>A palavra-passe que inseriu está errada!</p>
				</div>
				";
			}
			if ($_GET['m'] == 6) {
				echo "
				<div class='alert alert-danger alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
					<p>O Email que inseriu não coincide com o email na base de dados.</p>
				</div>
				";
			}
			if ($_GET['m'] == 7) {
				echo "
				<div class='alert alert-danger alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
					<p><span class='glyphicon glyphicon-remove-sign'></span> O Email que inseriu não coincide com o email na base de dados. <br>
					&nbsp;&nbsp;&nbsp;&nbsp; Para recuperar a palavra-passe terá de contactar o Dr. Sérgio Guimarães através do email <b> ser_guima@hotmail.com </b></p>
				</div>
				";
			}
			if ($_GET['m'] == 8) {
				echo "
				<div class='alert alert-danger alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
					<p><span class='glyphicon glyphicon-remove-sign'></span> O NIF que inseriu não é válido! Por favor insira um NIF que tenha 9 dígitos e que seja exclusivamente numérico.</p>
				</div>
				";
			}
			if ($_GET['m'] == 9) {
				echo "
				<div class='alert alert-danger alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
					<p>Palavra-passe antiga não está correta!</p>
				</div>
				";
			}
			if ($_GET['m'] == 10) {
				echo "
				<div class='alert alert-danger alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
					<p>Palavra-passes novas não coincidem!</p>
				</div>
				";
			}
		?>
	</div>

		<?php
			if($mod != "finish" && $mod != "password" && $mod != "rec_password" && $mod != "pessoal" && $mod != "change_pass"){
				echo"
					<div class='alert alert-warning'>
						<span class='glyphicon glyphicon-warning-sign'></span>
						<strong> NOTA:</strong> O preenchimento do presente formulário é da inteira responsabilidade do próprio.
					</div>
				";
			}
		?>

		<div id="wrapper">
			<?php
				//verifica se os ficheiros que estão a ser chamados existem
				if (file_exists("includes/$mod.php")) {
					include("includes/$mod.php");
				} else {
					echo "O ficheiro nao existe.";
				}
			?>
		</div>

    </div><!-- /.container -->
	<footer style="text-align: center; font-size: 12px;">
		<!-- To the right -->
		<!-- Default to the left -->
		<strong>Copyright &copy; 2016 <a href='http://www.madeira-edu.pt/dseam'>DSEAM</a>.</strong> Todos os direitos reservados.
	</footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- <script src="js/tether.min.js"></script> -->
	  <script src="js/bootstrap.min.js"></script>
  </body>
</html>
