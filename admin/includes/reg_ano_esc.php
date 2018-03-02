<?php
if($_GET['new']==1){

	$ano_escolar = $_POST[ano_escolar];
	$res = mysql_query("INSERT INTO `dbo_tab_anos_escolares`(`ANO_ESCOLAR`,`REFERENCIA`) VALUES ('$ano_escolar',$_POST[ref_ano])");

	echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=ano_escolar'>";
}
?>
<br>
<br>
<form action="index.php?mod=reg_ano_esc&new=1" method="POST">
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
				<input type="text" class="form-control" name="ano_escolar" id="ano_esc" placeholder="Ano Escolar">
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
				<input type="number" class="form-control" name="ref_ano" id="ref_ano_esc" placeholder="Referência numérica do Ano Escolar">
			</div>
		 </div>
	</div>
	<div class="row">
	  <div class="col-xs-2">
			<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-plus"></i> Registar</button>
	  </div>
	  <a href="index.php?mod=ano_escolar" type="button" class="btn btn-default btn-flat"><i class="fa fa-chevron-left"></i> Voltar</a>
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

	$("#ano_esc").keypress(function() {
		var text = $(this).val();
		var num_ref = text.match(/\d/g);
		$("#ref_ano_esc").val(num_ref);
	});

});
</script>
