<?php
	$res = mysql_query("SELECT * FROM dbo_tab_ano_letivo WHERE ID_ANO_LETIVO = $_GET[id]");
	$row = mysql_fetch_object($res);

	if($_GET['save'] == 1){
		if($_POST['ano_letivo'] != ""){
			$res = mysql_query("UPDATE `dbo_tab_ano_letivo` SET `ANO_LETIVO`='$_POST[ano_letivo]',`ANO_ATUAL`='$_POST[atual]' WHERE ID_ANO_LETIVO = $_GET[id]");
			// Garantir que apenas pode estar selecionado um ano letivo atual
			if ($_POST['atual']==1){
				$res1 = mysql_query("UPDATE `dbo_tab_ano_letivo` SET `ANO_ATUAL`='0' WHERE ID_ANO_LETIVO != $_GET[id]");
			}
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=ano_letivo'>";
		}else{
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=edit_ano&m=1&id=".$_GET[id]."'>";
		}
	}
?>
<br>
<br>
<form class="form-inline" action='index.php?mod=edit_ano&save=1&id=<?php echo $_GET[id]; ?>' id="edit_ano_form" method='POST'>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
				<input type='text' class='form-control' value='<?php echo $row->ANO_LETIVO;?>' name='ano_letivo' id='ano_letivo' placeholder='Ano Letivo' required>
		  </div>
		</div>
	</div>
	<br>
	<div class="row">
	  <div class="col-xs-4">
			<?php
			$isChecked = ($row->ANO_ATUAL) ? "checked" : "";
			?>
		  <div class="form-group form-check form-check-inline has-feedback">
				<label class="form-check-label" for="ano_atual"> Ano Letivo Atual &nbsp;</label>
				<input type="checkbox" class="form-check-input" id="ano_atual" name="ano_atual" <?php echo $isChecked; ?> >
				<input type="hidden" id="atual" name="atual" value="">
			</div>
		</div>
	</div>
	<br>
	<div class="row">
	  <div class="col-xs-2">
		<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-floppy-o"></i> Guardar</button>
	  </div>
	  <a href="index.php?mod=ano_letivo" type="button" class="btn btn-default btn-flat"><i class="fa fa-chevron-left"></i> Voltar</a>
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
		if( $('#ano_atual').is(':checked') ){
			$('#atual').val("1");
		}else{
			$('#atual').val("0");
		}

		$('#ano_atual').change( function(){
			if( $(this).is(':checked') ){
				$('#atual').val("1");
			}else{
				$('#atual').val("0");
			}
		});

		$("#ano_letivo").keyup(function() {
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
		$("#edit_ano_form").submit(function(){
			if($("#edit_ano_form .has-error").length > 0){
				alert("Corrija os erros antes de submeter o formulário!");
				// para evitar que o formulario seja submetido
				return false;
			}
		});

	});
</script>
