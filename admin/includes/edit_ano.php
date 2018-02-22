<?php
	$res = mysql_query("SELECT * FROM dbo_tab_ano_letivo WHERE ID_ANO_LETIVO = $_GET[id]");
	$row = mysql_fetch_object($res);
?>
<br>
<br>
<form class="form-inline" action='index.php?mod=ano_letivo&save=1&id=<?php echo $_GET[id]; ?>' method='POST'>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
				<?php echo "<input type='text' class='form-control' value='". utf8_encode($row->ANO_LETIVO) ."' name='ano_letivo' placeholder='Ano Letivo'>";?>
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
		<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-calendar-plus-o"></i> Guardar</button>
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
	});

  $(function () {
		$('input').iCheck({
		  checkboxClass: 'icheckbox_square-blue',
		  radioClass: 'iradio_square-blue',
		  increaseArea: '20%' // optional
		});
  });


</script>
