<?php
$res = mysql_query("SELECT * FROM dbo_tab_utilizadores WHERE ID_UTILIZADOR = $_GET[id]");
$row = mysql_fetch_object($res);
$_SESSION['pass'] = $row->PASSWORD;

if($_GET['save']==1){
	if(($_POST[nome] != "") && ($_POST['pass'] != "") && ($_POST['pass1'] != "") && ($_POST['pass2'] != "")){
		if($_POST['pass'] == $_SESSION['pass']){
			if($_POST['pass1'] == $_POST['pass2']){
				$res = mysql_query("UPDATE dbo_tab_utilizadores SET UTILIZADOR='$_POST[nome]',`PASSWORD`='$_POST[pass1]', `EMAIL`= '$_POST[email]' WHERE ID_UTILIZADOR = $_GET[id]");
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_users'>";
			}else{
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=edit_user&m=4&id=". $_GET[id] ."'>";
			}
		}else{
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=edit_user&m=3&id=". $_GET[id] ."'>";
		}
	}else{
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=edit_user&m=1&id=". $_GET[id] ."'>";
	}
}
?>
<br>
<br>
<?php
echo "<form action='index.php?mod=edit_user&save=1&id=". $_GET[id] ."' method='POST'>";
?>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<?php
				echo"<input type='text' class='form-control' value='". $row->UTILIZADOR ."' name='nome' placeholder='Nome Utilizador'>";
			?>
			<span class="glyphicon glyphicon-user form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<?php
				echo"<input type='email' class='form-control' value='". $row->EMAIL ."' name='email' placeholder='Email Utilizador'>";
			?>
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="password" class="form-control" name="pass" placeholder="Palavra-passe antiga">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="password" class="form-control" name="pass1" placeholder="Introduza a palavra-passe">
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
		<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-floppy-o"></i> Guardar</button>
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
  $(function () {
	$('input').iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	  radioClass: 'iradio_square-blue',
	  increaseArea: '20%' // optional
	});
  });
</script>
