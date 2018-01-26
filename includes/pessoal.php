<style>
#errmsg
{
color: red;
}
</style>

<?php
	
	echo"
	<div class='panel panel-info'>
		<div class='panel-heading'>
			<h3 class='panel-title'><strong>DADOS PESSOAIS</strong></h3>
		</div>
		<form role='form' enctype='multipart/form-data' method='POST' action='index.php?mod=password&search=1'>
			<div class='panel-body'>
			<br>
				<div class='row'>
					<div class='col-md-5'>
						<strong>NIF</strong> - Número de Identificação Fiscal (contribuinte)
					</div>
				</div>
				<div class='row' style='margin-top: 5px;'>
					<div class='col-md-3'>
						<input class='form-control' name='nif' id='nif' type='text' required>
					</div>
					<div class='col-md-3' style='margin-top: 10px;'>
						<span id='errmsg'></span>
					</div>
				</div>
				<div class='row' style='margin-top: 4%;'>
					<div class='col-md-12'>
						<div class='alert alert-info'>
							<span class='glyphicon glyphicon-info-sign'></span>
							<strong>INFORMAÇÃO:</strong> <br>Introduza o seu Número de Identificação Fiscal (NIF) e clique em continuar, para verificar se já está registado na nossa base de dados.<br>Caso já se encontre registado terá apenas de atualizar os dados pessoais e inserir os dados professionais referentes ao próximo ano letivo.
						</div>
					</div>
				</div>
			</div>
			<div class='panel-footer clearfix'>
				<button type='submit' name='submit' class='btn btn-primary pull-right'> 	
					<span class='glyphicon glyphicon-search' aria-hidden='true'></span>
					Procurar e Continuar
					<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>
				</button>
			</div>
		</form>
	</div>
	";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script>
	$(document).ready(function () {
	  $("#nif").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			$("#errmsg").html("Introduza só números por favor!").show().fadeOut(2000);
			return false;
		}
	   });
	});
</script>