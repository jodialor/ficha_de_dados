<?php
if($_GET['new']==1){
	$res = mysql_query("INSERT INTO `dbo_tab_ano_letivo`(`ANO_LETIVO`) VALUES ('$_POST[ano_letivo]')");
	echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=ano_letivo'>";
}
?>
<br>
<br>
<form action="index.php?mod=reg_ano&new=1" method="POST">
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="text" class="form-control" name="ano_letivo" placeholder="Ano Letivo">
			<span class="fa fa-calendar form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
	  <div class="col-xs-2">
		<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-calendar-plus-o"></i> Registar</button>
	  </div>
	  <a href="index.php?mod=ano_letivo" type="button" class="btn btn-primary btn-flat"><i class="fa fa-ban"></i> Voltar</a>
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