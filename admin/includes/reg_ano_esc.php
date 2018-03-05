<?php
if($_GET['new']==1){
	if($_POST['ano_escolar'] != "" && $_POST['ref_ano'] != ""){
		$ano_escolar = $_POST['ano_escolar'];
		$ref_ano_esc = $_POST['ref_ano'];
		$res = mysql_query("INSERT INTO `dbo_tab_anos_escolares`(`ANO_ESCOLAR`,`REFERENCIA`) VALUES ('$ano_escolar',$ref_ano_esc)");
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=ano_escolar'>";
	}else{
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=reg_ano_esc&m=1'>";
	}
}
?>
<br>
<br>
<form action="index.php?mod=reg_ano_esc&new=1" id="reg_ano_esc_form" method="POST">
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
				<input type="text" class="form-control" name="ano_escolar" id="ano_esc" placeholder="Ano Escolar" >
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
				<input type="number" class="form-control" name="ref_ano" id="ref_ano_esc" placeholder="Referência numérica do Ano Escolar" >
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

	$("#ano_esc").keyup(function() {
		var value = $(this).val();
		var num_ref = value.match(/\d/g);
		$("#ref_ano_esc").val(num_ref);
	});

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

	$('#reg_ano_esc_form').on('submit', function (e) {
  if (e.isDefaultPrevented()) {
    // handle the invalid form...
  } else {
    // everything looks good!
  }
})

});
</script>
