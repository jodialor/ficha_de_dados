<?php
	if($_GET['add']==1){
		$telefone = $_POST[telefone];
		$email = $_POST[email];
		$outra_escola = utf8_decode($_POST[outra_escola]);

		if($_POST[lista] == ''){
			$escola = 209;
		}else{
			$escola = $_POST[lista];
		}
		$res2 = mysql_query("SELECT * FROM dbo_tab_ano_letivo WHERE dbo_tab_ano_letivo.ANO_ATUAL = 1");
		$ano_atual = mysql_fetch_object($res2);

		//permitir apenas registar escola se o ano letivo atual estiver definido e seleccionado
		if($_POST[ano_letivo_atual] == $ano_atual->ID_ANO_LETIVO && $ano_atual->ID_ANO_LETIVO > 0){
			$res = mysql_query("INSERT INTO dbo_tab_escolas(ID_LISTA_ESCOLAS, ESCOLA, ID_MUNICIPIO, ID_ANO_LETIVO, TELEFONE, EMAIL, ID_FUNCIONARIO) VALUES ('$escola', '$outra_escola', '$_POST[municipio]', '$_POST[ano_letivo_atual]', '$telefone', '$email', $_SESSION[id_funcionario])");
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=nova_escola_2'>";
		}else{
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_escolas&erro=1'>";
		}
	}
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Dados Profissionais</strong></h3>
	</div>
	<form role="form" enctype='multipart/form-data' action="index.php?mod=nova_escola&add=1" id="info_escola" method="POST">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Escola/Instituição*</label>
						<?php
							echo"
							<select class='form-control' name='lista' id='lista' required>
							<option value=''>-selecione-</option>";
							$res2=mysql_query("Select * from dbo_tab_lista_escolas ORDER BY NOME_ESCOLA ASC");
							while ($row2 = mysql_fetch_object($res2)){
								echo"<option value='$row2->ID_LISTA_ESCOLAS'>".utf8_encode($row2->NOME_ESCOLA)."</option>";
							}
							mysql_free_result($res);
							echo"
							</select>";
						?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Outra Escola</label>
						<input type="text" class="form-control" name="outra_escola" id='outra_escola_campo' placeholder='Para indicar outra escola seleccione a opção "OUTRA ESCOLA"' />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2">
					<div class="form-group">
						<label>Município*</label>
						<?php
							echo"
							<select class='form-control' name='municipio' required>
							<option value=''>-selecione-</option>";
							$res2=mysql_query("Select * from dbo_tab_municipios");
							while ($row2 = mysql_fetch_object($res2)){
								echo"<option value='$row2->ID_MUNICIPIO'>".utf8_encode($row2->MUNICIPIO)."</option>";
							}
							mysql_free_result($res);
							echo "</select>";
						?>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Ano Letivo*</label>
						<?php
							echo"
							<select class='form-control' name='ano_letivo' id='ano_letivo' required disabled>
							<option value=''>-selecione-</option>";
							$res2=mysql_query("Select * from dbo_tab_ano_letivo ORDER BY ANO_LETIVO DESC");
							while ($row2 = mysql_fetch_object($res2)){
								$is_selected = ($row2->ANO_ATUAL) ? "selected" : "";
								echo"<option value='$row2->ID_ANO_LETIVO' $is_selected>".utf8_encode($row2->ANO_LETIVO)."</option>";
							}
							mysql_free_result($res2);
							echo "</select>";
						?>
						<input type="hidden" id="anoatual" name="ano_letivo_atual"/>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Telefone</label>
						<input type="text" id="tel" class="form-control" name="telefone" placeholder="Introduza o número de telefone" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" name="email" placeholder="Introduza o email" />
					</div>
				</div>
			</div>
		</div>
	</form>
	<div class="panel-footer clearfix">
		<button type="submit" form="info_escola" class="btn btn-primary pull-right">
			<span class="glyphicon glyphicon-floppy-disk"></span>
			Guardar e Continuar
			<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>
		</button>
		<a href="index.php?mod=lista_escolas" class="btn btn-default pull-right" style="margin-right: 10px;">
			<span class="glyphicon glyphicon-ban-circle"></span>
			Cancelar
		</a>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script>
function onlyNum(id){
	id.keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
}

$( document ).ready(function() {
	//copiar o valor do ano letivo selecionado na select box para o input hidden
	var option = $('#ano_letivo option:selected').val();
	$('#anoatual').val(option);

	if($('#lista').val() != 209){
		$("#outra_escola_campo").prop('disabled', true);
	}else{
		$("#outra_escola_campo").prop('disabled', false);
	}
  $("#lista").change(function () {
		if($('#lista').val() != 209){
			$("#outra_escola_campo").prop('disabled', true);
			$("#outra_escola_campo").val("");
		}else{
			$("#outra_escola_campo").prop('disabled', false);
		}
		return false;
	});

	onlyNum($("#tel"));


});
</script>
