<?php
	$res = mysql_query("SELECT * FROM dbo_tab_anos_escolares WHERE ID_ANO_ESCOLAR = $_GET[id]");
	$row = mysql_fetch_object($res);
?>
<br>
<br>
<form class="form-inline" action='index.php?mod=ano_escolar&save=1&id=<?php echo $_GET[id]; ?>' method='POST'>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
				<input type='text' class='form-control' value='<?php echo utf8_encode($row->ANO_ESCOLAR);?>' name='ano_escolar' placeholder='Ano Escolar'>
		  </div>
		</div>
	</div>
	<br>
	<div class="row">
	  <div class="col-xs-4">
		  <div class="form-group has-feedback">
				<input type="number" class='form-control' value='<?php echo $row->REFERENCIA;?>' name="ref_ano" placeholder='Referência numérica'>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
	  <div class="col-xs-2">
			<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-graduation-cap"></i> Guardar</button>
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
		$('#ano_atual').change( function(){
			if( $(this).is(':checked') ){
				$('#atual').val("1");
			}else{
				$('#atual').val("0");
			}
		});
	});

</script>
