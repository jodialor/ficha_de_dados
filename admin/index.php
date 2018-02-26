<?php
	//ligação á DB
	session_start();
	include("config/config.php");
	error_reporting(E_ALL & ~E_NOTICE);
	//faz a verificação se já fez login, caso não tenha, o login.php é aberto.
	if (!$_GET['mod']){
		if($_SESSION['login']){
			$mod="lista_func";
		}else{
			$mod="login";
		}
	}else{
		$mod=$_GET['mod'];
	}
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
		<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Página de Gestão</title>
	<link rel="icon" href="dist/img/favicon.ico">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->



	<div class="wrapper">
		<?php
			//verifica se os ficheiros que estão a ser chamados existem
			if (file_exists("includes/$mod.php")) {
				if($mod != 'login'){
		?>
				  <header class='main-header'>
				    <a href='#' class='logo'>
					  <!-- logo for regular state and mobile devices -->
					  <span class='logo-lg'><b>DSEAM</b></span>
					</a>
					<!-- Header Navbar -->
					<nav class='navbar navbar-static-top' role='navigation'>
					  <!-- Navbar Right Menu -->
					  <div class='navbar-custom-menu'>
						<ul class='nav navbar-nav'>
						  <!-- Control Sidebar Toggle Button -->
						  <li>
							<a href='logoff.php'><i class='fa fa-sign-out'></i> Sair</a>
						  </li>
						</ul>
					  </div>
					</nav>
				  </header>
				  <!-- Left side column. contains the logo and sidebar -->
				  <aside class='main-sidebar'>
						<!-- sidebar: style can be found in sidebar.less -->
						<section class='sidebar'>
						  <!-- Sidebar Menu -->
						  <ul class='sidebar-menu'>
							<li class='header'>OPÇÕES</li>
							<!-- Optionally, you can add icons to the links -->
							<li><a href='index.php?mod=lista_func'><i class='fa fa-list'></i> <span>Filtro de Dados Pessoais</span></a></li>
							<li><a href='index.php?mod=func_filter'><i class='fa fa-list'></i> <span>Filtro de Dados Profissionais</span></a></li>
							<li><a href='index.php?mod=lista_users'><i class='fa fa-user'></i> <span>Gerir Utilizadores</span></a></li>
							<li><a href='index.php?mod=ano_letivo'><i class='fa fa-calendar'></i> <span>Gerir Anos Letivos</span></a></li>
						  </ul><!-- /.sidebar-menu -->
						</section>
						<!-- /.sidebar -->
				  </aside>

				  <!-- Content Wrapper. Contains page content -->
					<div class='content-wrapper' style='padding-bottom: 3%;'>
						<!-- Content Header (Page header) -->
						<section class='content-header'>
							<h1>
							<?php
							if($mod=='lista_func'){
								echo"<i class='fa fa-list'></i> Lista de Funcionários";
							}else{
								if($mod=='reg_user'){
									echo"<i class='fa fa-user-plus'></i> Novo Utilizador";
								}else{
									if($mod=='ano_letivo'){
										echo"<i class='fa fa-calendar'></i> Gestão de Ano Letivo";
									}else{
										if($mod=='lista_users'){
											echo"<i class='fa fa-user'></i> Lista de Utilizadores";
										}else{
											if($mod=='reg_ano'){
												echo"<i class='fa fa-calendar'></i> Registo Novo Ano Letivo";
											}else{
												if($mod=='edit_ano'){
													echo"<i class='fa fa-calendar'></i> Editar Ano Letivo";
												}else{
													if($mod=='edit_user'){
														echo"<i class='fa fa-user'></i> Editar Utilizador";
													}else{
														if($mod=='edit_pessoal'){
															echo"<i class='fa fa-user'></i> Editar Funcionário";
														}else{
															if($mod=='send_pass'){
																echo"<i class='fa fa-lock'></i> Nova Palavra-Passe";
															}else{
																if($mod=='func_filter'){
																	echo"<i class='fa fa-list'></i> Filtro de Dados Profissionais";
																}else{
																	if($mod=='dados'){
																		echo"<i class='fa fa-search'></i> Ficha de Dados";
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
							?>
							</h1>
						</section>

						<!-- Main content -->
						<section class='content'>
						<?php
							if($mod != 'login'){
								echo " <body class='hold-transition skin-blue sidebar-mini'>";
							}else{
								echo " <body>";
							}

							if ($_GET['m'] == 1) {
								echo "
								<div class='alert alert-danger alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
									<p>Preencha todos os campos por favor.</p>
								</div>";
							}
							if ($_GET['m'] == 2) {
								echo "
								<div class='alert alert-danger alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
									<p>O utilizador ou a palavra-passe não estão corretos.</p>
								</div>";
							}
							if ($_GET['m'] == 3) {
								echo "
								<div class='alert alert-danger alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
									<p>A palavra-passe antiga não está correta.</p>
								</div>";
							}
							if ($_GET['m'] == 4) {
								echo "
								<div class='alert alert-danger alert-dismissible fade in' style='margin-bottom: 10px;'  role='alert'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>
									<p>A palavra-passe não coincide com a re-introduzida.</p>
								</div>";
							}
							//verifica se os ficheiros que estão a ser chamados existem
							if (file_exists("includes/$mod.php")) {
								if($_SESSION['login'] != NULL){
									include("includes/$mod.php");
								}else{
									echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php'>";
								}
							} else {
								echo "O ficheiro nao existe.";
							}
						?>
						</section><!-- /.content -->
					</div><!-- /.content-wrapper -->

				  <!-- Main Footer -->
				  <footer class='main-footer'>
						<!-- To the right -->
						<div class='pull-right hidden-xs'>
						  DSEAM
						</div>
						<!-- Default to the left -->
						<strong>Copyright &copy; 2018 <a href='http://www.madeira-edu.pt/dseam'>DSEAM</a>.</strong> Todos os direitos reservados.
				  </footer>
			<?php
				} else{
					include("includes/$mod.php");
				}
			} else {
				echo "O ficheiro nao existe.";
			}
			?>
	</div>

   <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
  </body>
</html>
