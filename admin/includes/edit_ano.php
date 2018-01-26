<?php
	$res = mysql_query("SELECT * FROM dbo_tab_ano_letivo WHERE ID_ANO_LETIVO = $_GET[id]");
	$row = mysql_fetch_object($res);
	
	if($_GET['save'] == 1){
		$res = mysql_query("UPDATE `dbo_tab_ano_letivo` SET `ANO_LETIVO`='$_POST[ano_letivo]' WHERE ID_ANO_LETIVO = $_GET[id]");
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=ano_letivo'>";
	}
?>
<br>
<br>
<?php
echo"
<form action='index.php?mod=edit_ano&save=1&id=". $_GET[id] ."' method='POST'>
";
?>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<?php echo "<input type='text' class='form-control' value='". $row->ANO_LETIVO ."' name='ano_letivo' placeholder='Ano Letivo'>";?>
		  </div>
		</div>
	</div>
	<div class="row">
	  <div class="col-xs-2">
		<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-calendar-plus-o"></i> Guardar</button>
	  </div>
	  <a href="index.php?mod=ano_letivo" type="button" class="btn btn-default btn-flat"><i class="fa fa-chevron-left"></i> Voltar</a>
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