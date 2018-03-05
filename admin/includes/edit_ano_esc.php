<?php
	$res = mysql_query("SELECT * FROM dbo_tab_anos_escolares WHERE ID_ANO_ESCOLAR = $_GET[id]");
	$row = mysql_fetch_object($res);

	if($_GET['save'] == 1){
		if($_POST['ano_escolar'] != "" && $_POST['ref_ano'] != ""){
			$ano_escolar = $_POST[ano_escolar];
			$ref = $_POST[ref_ano];
			$res = mysql_query("UPDATE `dbo_tab_anos_escolares` SET `ANO_ESCOLAR`='$ano_escolar',`REFERENCIA`='$ref' WHERE ID_ANO_ESCOLAR = $_GET[id]");
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=ano_escolar'>";
		}else{
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=edit_ano_esc&m=1&id=".$_GET[id]."'>";
		}
	}
?>
<br>
<br>
<form class="form-inline" action='index.php?mod=edit_ano_esc&save=1&id=<?php echo $_GET[id]; ?>' method='POST'>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
				<input type='text' class='form-control' value='<?php echo $row->ANO_ESCOLAR;?>' name='ano_escolar' id="ano_esc" placeholder='Ano Escolar' required>
		  </div>
		</div>
	</div>
	<br>
	<div class="row">
	  <div class="col-xs-4">
		  <div class="form-group has-feedback">
				<input type="number" class='form-control' value='<?php echo $row->REFERENCIA;?>' name="ref_ano" id="ref_ano_esc" placeholder='Referência numérica' required>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
	  <div class="col-xs-2">
			<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-floppy-o"></i> Guardar</button>
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
	});
</script>
