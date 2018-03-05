<?php
if($_GET['new']==1){
	if($_POST['ano_letivo'] != ""){
		$ano_let = $_POST['ano_letivo'];
		$atual_year = 0;
		if (isset($_POST["ano_atual"])) {
			$atual_year = $_POST["ano_atual"];
		}
		$res = mysql_query("INSERT INTO `dbo_tab_ano_letivo`(`ANO_LETIVO`,`ANO_ATUAL`) VALUES ('$ano_let',$atual_year)");

		// Garantir que apenas pode estar selecionado um ano letivo atual
		if($atual_year == "1"){
			$res1 = mysql_query("UPDATE `dbo_tab_ano_letivo` SET `ANO_ATUAL`='0' WHERE ANO_LETIVO != $_POST[ano_letivo]");
		}
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=ano_letivo'>";
	}else{
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=reg_ano&m=1'>";
	}
}
?>
<br>
<br>
<form action="index.php?mod=reg_ano&new=1" id="reg_ano_form" method="POST">
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="text" class="form-control" name="ano_letivo" id="ano_letivo" placeholder="Ano Letivo" required>
		  </div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group form-check has-feedback">
					<label class="form-check-label" for="ano_atual"> Ano Letivo Atual &nbsp;</label>
					<input type="checkbox" class="form-check-input" id="ano_atual" name="ano_atual" value="1">
			</div>
		 </div>
	</div>
	<div class="row">
	  <div class="col-xs-2">
		<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-calendar-plus-o"></i> Registar</button>
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
	$("#reg_ano_form").submit(function(){
		if($("#reg_ano_form .has-error").length > 0){
			alert("Corrija os erros antes de submeter o formulário!");
			// para evitar que o formulario seja submetido
			return false;
		}
	});
});
</script>
