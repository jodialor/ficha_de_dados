<?php
if($_GET['new']==1){
	if($_POST['pass1'] == $_POST['pass2']){
		$nome = $_POST['nome'];
		$pass = $_POST['pass1'];
		$email = $_POST['email'];
		$res = mysql_query("INSERT INTO `dbo_tab_utilizadores`(`UTILIZADOR`, `PASSWORD`, `EMAIL`) VALUES ('$nome', '$pass', '$email')");
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_users'>";
	}else{
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=reg_user&m=4'>";
	}
}
?>
<br>
<br>
<form action="index.php?mod=reg_user&new=1" method="POST">
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="text" class="form-control" name="nome" placeholder="Nome Utilizador">
			<span class="glyphicon glyphicon-user form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="email" class="form-control" name="email" placeholder="Email Utilizador">
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="password" class="form-control" name="pass1" placeholder="Palavra-passe">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="password" class="form-control" name="pass2" placeholder="Re-introduza a palavra-passe">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
	  <div class="col-xs-2">
		<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-user-plus"></i> Registar</button>
	  </div>
	  <a href="index.php?mod=lista_users" type="button" class="btn btn-default btn-flat"><i class="fa fa-chevron-left"></i> Voltar</a>
	</div>
</form>


<!-- jQuery 2.1.4 -->
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>

<script>
  $(function () {
	$('input').iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	  radioClass: 'iradio_square-blue',
	  increaseArea: '20%' // optional
	});
  });
</script>