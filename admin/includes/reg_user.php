<?php
if($_GET['new']==1){
	if($_POST['nome'] != "" && $_POST['email'] != "" && $_POST['pass1'] != "" && $_POST['pass2'] != ""){
		if($_POST['pass1'] == $_POST['pass2']){
			$nome = $_POST['nome'];
			$pass = $_POST['pass1'];
			$email = $_POST['email'];
			$res = mysql_query("INSERT INTO `dbo_tab_utilizadores`(`UTILIZADOR`, `PASSWORD`, `EMAIL`) VALUES ('$nome', '$pass', '$email')");
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_users'>";
		}else{
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=reg_user&m=4'>";
		}
	}else{
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=reg_user&m=1'>";
	}
}
?>
<br>
<br>
<form action="index.php?mod=reg_user&new=1" id="reg_user_form" method="POST">
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="text" class="form-control" name="nome" id="nome_user" placeholder="Nome Utilizador" required>
			<span class="glyphicon glyphicon-user form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="email" class="form-control" name="email" id="email_user" placeholder="Email Utilizador" required>
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="password" class="form-control" name="pass1" id="pass1" placeholder="Palavra-passe" required>
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="password" class="form-control" name="pass2" id="pass2" placeholder="Re-introduza a palavra-passe" required>
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
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>

<script>
$(document).ready(function() {
	$(":input").keyup(function() {
		var value = $(this).val();
		var parent = $(this).parent();
		if(value.length >= 1){
			parent.addClass("has-success");
			parent.removeClass("has-error");
		}else{
			parent.addClass("has-error");
			parent.removeClass("has-success");
		}
	});

	// Verificar se existem erros antes de submeter o formulario
	$("#reg_user_form").submit(function(){
		if($("#reg_user_form .has-error").length > 0){
			alert("Corrija os erros antes de submeter o formulário!");
			// para evitar que o formulario seja submetido
			return false;
		}
	});
});
</script>
