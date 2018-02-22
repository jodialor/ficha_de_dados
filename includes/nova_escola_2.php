<?php
	$search = mysql_query("select * from dbo_tab_escolas where ID_FUNCIONARIO = $_SESSION[id_funcionario] order by ID_ESCOLA DESC limit 1");
	$row = mysql_fetch_object($search);
	$id_escola = $row->ID_ESCOLA;

	$res2 = mysql_query("SELECT * FROM dbo_tab_ano_letivo WHERE dbo_tab_ano_letivo.ANO_ATUAL = 1");
	$ano_atual = mysql_fetch_object($res2);

	if($_GET['add']==1){
		$res = mysql_query("INSERT INTO dbo_tab_pre_escolar(ID_TIPO_PRE, NUM_ALUNOS, ID_ESCOLA) VALUES ($_POST[tipo_pre], $_POST[num_alunos_pre], $id_escola)");
	}
	if($_GET['add']==2){
		$ano_turma = utf8_decode($_POST[ano_turma]);
		$outro_tipo = utf8_decode($_POST[outro_tipo]);
		//adicionar o 1ºciclo
		$res = mysql_query("INSERT INTO dbo_tab_primeiro_ciclo(ANO_TURMA, NUM_ALUNOS, ID_TIPO_CICLO, OUTRO_TIPO, ID_NIVEL, ID_ESCOLA) VALUES ('$ano_turma', $_POST[num_alunos_1c], '$_POST[tipo_1ciclo]', '$outro_tipo', '$_POST[nivel]', $id_escola)");
	}
	if($_GET['del_pre']==1){
		$res = mysql_query("DELETE FROM dbo_tab_pre_escolar where ID_PRE_ESCOLAR=$_GET[id]");
	}
	if($_GET['del_ciclo']==1){
		$res = mysql_query("DELETE FROM dbo_tab_primeiro_ciclo where ID_PRIMEIRO_CICLO=$_GET[id]");
	}

	$turnDisable = ($ano_atual->ID_ANO_LETIVO > 0) ? "" : "disabled";
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Dados Profissionais</strong></h3>
	</div>
	<div class="panel-body">
		<form role='form' enctype='multipart/form-data' action='index.php?mod=lista_escolas&save=2&id="<?php echo $id_escola; ?>"' id='info_escola' method='POST'>
			<fieldset <?php echo $turnDisable; ?>>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Escola/Instituição*</label>
						<select class='form-control' name='lista' id='lista' required>
							<option value=''>-selecione-</option>
							<?php
							$res2=mysql_query("Select * from dbo_tab_lista_escolas ORDER BY NOME_ESCOLA ASC");
							while ($row2 = mysql_fetch_object($res2)){
								$esc_selected = ($row2->ID_LISTA_ESCOLAS == $row->ID_LISTA_ESCOLAS) ? "selected" : "";
								echo "<option value='$row2->ID_LISTA_ESCOLAS' ".$esc_selected.">".utf8_encode($row2->NOME_ESCOLA)."</option>";
							}
							mysql_free_result($res2);
							?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Outra Escola</label>
							<input type='text' class='form-control' name='outra_escola' id='outra_escola_campo' value='<?php echo utf8_encode($row->ESCOLA); ?>' placeholder='Nome da Escola' />
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2">
					<div class="form-group">
						<label>Município*</label>
						<select class='form-control' name='municipio' required>
							<option value=''>-selecione-</option>
							<?php
							$res2=mysql_query("Select * from dbo_tab_municipios");
							while ($row2 = mysql_fetch_object($res2)){
								$mun_selected = ($row2->ID_MUNICIPIO == $row->ID_MUNICIPIO) ? "selected" : "";
								echo "<option value='".$row2->ID_MUNICIPIO."' ".$mun_selected.">".utf8_encode($row2->MUNICIPIO)."</option>";
							}
							mysql_free_result($res2);
							?>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Ano Letivo*</label>
						<select class='form-control' name='ano_letivo_atual' id='ano_letivo' required disabled>
						<option value=''>-selecione-</option>
						<?php
							$res2=mysql_query("Select * from dbo_tab_ano_letivo ORDER BY ANO_LETIVO DESC");
							while ($row2 = mysql_fetch_object($res2)){
								$is_selected = ($row2->ANO_ATUAL) ? "selected" : "";
								echo"<option value='$row2->ID_ANO_LETIVO' $is_selected>".utf8_encode($row2->ANO_LETIVO)."</option>";
							}
							mysql_free_result($res2);
						?>
						</select>
						<input type="hidden" id="anoatual" name="ano_letivo"/>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Telefone</label>
						<?php
							echo"<input type='text' class='form-control' id='tel' name='telefone' value='".$row->TELEFONE."' placeholder='Introduza o número de telefone' />";
						?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Email</label>
						<?php
							echo"<input type='email' class='form-control' name='email' value='".$row->EMAIL."' placeholder='Introduza o email' />";
						?>
					</div>
				</div>
			</div>
		</fieldset>
		</form>


	<blockquote style="margin-top: 10px;">
		<p><strong>Dados do Pré-Escolar e/ou 1.º Ciclo</strong></p>
	</blockquote>


	<ul class="nav nav-tabs">
		<li id="tabPre" class="active"><a data-toggle="tab" href="#panePre" id="aPre" href="#panePre">Pré-Escolar</a></li>
		<li id="tab1c"><a data-toggle="tab" id="a1c" href="#pane1c">1º Ciclo</a></li>
	</ul>
	<div class="row" style="margin-bottom: 15px;">
		<div class="tab-content" style="margin-top: 10px;">
			<div id="panePre" class="tab-pane in active">
				<div class="container-fluid">

					<form role='form' action='index.php?mod=nova_escola_2&add=1&tab=pre' id='pre_escolas' method='POST'>
						<fieldset <?php echo $turnDisable; ?>>
						<div class="row col-md-12">
							<div class="col-md-3">
								<div class="form-group">
									<label>Tipo de Pré</label>
									<select id="tipo_pre" name="tipo_pre" class="form-control" required>
										<option value="">- selecione -</option>
										<?php
											$res2=mysql_query("Select * from dbo_tab_tipo_pre");
											while ($row2 = mysql_fetch_object($res2)){
												echo"<option value='$row2->ID_TIPO_PRE'>".utf8_encode($row2->TIPO_PRE)."</option>";
											}
											mysql_free_result($res);
											mysql_free_result($res2);
										?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Nº Alunos</label>
									<input id="num_alunos_pre" name="num_alunos_pre" type="text" class="form-control" placeholder="Nº Alunos" required/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<button type="submit" id="btn_adicionar_pre" class="btn btn-success" style="margin-top: 20%; margin-right: 0px;">
										<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
										Adicionar
									</button>
								</div>
							</div>
						</div>
					</fieldset>
					</form>
					<?php
						$id_escola = $row->ID_ESCOLA;
						$res = mysql_query("select * from dbo_tab_pre_escolar, dbo_tab_tipo_pre where dbo_tab_pre_escolar.ID_ESCOLA = $id_escola AND dbo_tab_tipo_pre.ID_TIPO_PRE = dbo_tab_pre_escolar.ID_TIPO_PRE");
						$num = mysql_num_rows($res);
						if($num>0){
							echo"
							<div class='row-fluid col-md-6'>
							<table id='registos_escola_pre' class='table table-striped trHover table-bordered'>
							<thead>
								<tr style='text-align: center;'>
									<th>
										Tipo de Pré
									</th>
									<th>
										Nº Alunos
									</th>
									<th>
										Eliminar
									</th>
								</tr>
							</thead>
							<tbody>";
							while($row2 = mysql_fetch_object($res)){
								echo"
								<tr>
									<td>
										" . utf8_encode($row2->TIPO_PRE) . "
									</td>
									<td>
										" . $row2->NUM_ALUNOS . "
									</td>
									<td style='text-align: center;'>
										<a href='index.php?mod=nova_escola_2&del_pre=1&id=$row2->ID_PRE_ESCOLAR' class='btn btn-xs btn-danger'>
											<span class='glyphicon glyphicon-trash'></span>
											Eliminar
										</a>
									</td>
								</tr>
								";
							}
							echo"</tbody>
							</table>
							</div>
							";
						}else{
							echo"
							<div class='row-fluid col-md-12'>
								<div class='alert alert-info'>
									<span class='glyphicon glyphicon-info-sign'></span>
									Ainda não existem dados de Pré-Escolar registados. Para registar clique em \"Adicionar\"
								</div>
							</div>
							";
						}
					?>
				</div>
			</div>

			<div id="pane1c" class="tab-pane">
				<div class="container-fluid">
					<div class="row col-md-12">
						<!-- <form role="form" enctype='multipart/form-data' action="index.php?mod=nova_escola_2&add=2" id="novo_registo_1c" method="POST"> -->

						<form role='form' action='index.php?mod=nova_escola_2&add=2&tab=1c' id='1c' method='POST'>
							<fieldset <?php echo $turnDisable; ?>>
							<div class="col-md-2">
								<div class="form-group">
									<label>Ano/Turma</label>
									<input id="ano_turma" name="ano_turma" type="text" class="form-control" placeholder="Ano/Turma" required/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Nºalunos</label>
									<input id="num_alunos_1c" id="num_alunos_1c" name="num_alunos_1c" type="text" class="form-control" placeholder="Nº alunos" required/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Tipo 1ºCiclo</label>
									<select id="tipo_1c" name="tipo_1ciclo" class="form-control" required>
										<option value="">- selecione -</option>
											<?php
												$res2=mysql_query("Select * from dbo_tab_tipo_ciclo ORDER BY TIPO_CICLO");
												while ($row2 = mysql_fetch_object($res2)){
													echo"<option value='$row2->ID_TIPO_CICLO'>".utf8_encode($row2->TIPO_CICLO)."</option>";
												}
												mysql_free_result($res);
												mysql_free_result($res2);
											?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Outro Tipo/Grupo</label>
									<input id="outro_tipo" name="outro_tipo" type="text" class="form-control" disabled/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Nível</label>
									<select id="nivel" name="nivel" class="form-control" required>
										<option value="">- selecione -</option>
											<?php
												$res2=mysql_query("Select * from dbo_tab_nivel");
												while ($row2 = mysql_fetch_object($res2)){
													echo"<option value='$row2->ID_NIVEL'>".utf8_encode($row2->NIVEL)."</option>";
												}
												mysql_free_result($res);
												mysql_free_result($res2);
											?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<button type="submit" id="btn_adicionar_1c" class="btn btn-success" style="margin-top: 20%; margin-right: 0px;">
										<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
											Adicionar
									</button>
								</div>
							</div>
						</fieldset>
						</form>
					</div>
					<?php
						$res = mysql_query("select * from dbo_tab_primeiro_ciclo, dbo_tab_tipo_ciclo, dbo_tab_nivel where dbo_tab_primeiro_ciclo.ID_ESCOLA = $id_escola AND dbo_tab_tipo_ciclo.ID_TIPO_CICLO = dbo_tab_primeiro_ciclo.ID_TIPO_CICLO AND dbo_tab_nivel.ID_NIVEL = dbo_tab_primeiro_ciclo.ID_NIVEL");
						$num = mysql_num_rows($res);
						if($num>0){
							echo"
								<div class='row-fluid col-md-12'>
									<table id='registos_escola_1C' class='table table-striped trHover table-bordered'>
										<thead>
											<tr style='text-align: center;'>
												<th>
													Ano/Turma
												</th>
												<th>
													Nº alunos
												</th>
												<th>
													Tipo 1ºCiclo
												</th>
												<th>
													Outro Tipo/Grupo
												</th>
												<th>
													Nível
												</th>
												<th>
													Eliminar
												</th>
											</tr>
										</thead>
										<tbody>";
											while($row2 = mysql_fetch_object($res)){
												echo"
													<tr>
														<td>
															" . utf8_encode($row2->ANO_TURMA) . "
														</td>
														<td>
															" . $row2->NUM_ALUNOS . "
														</td>
														<td>
															" . utf8_encode($row2->TIPO_CICLO) . "
														</td>
														<td>
															" . utf8_encode($row2->OUTRO_TIPO) . "
														</td>
														<td>
															" . utf8_encode($row2->NIVEL) . "
														</td>
														<td style='text-align: center;'>
															<a href='index.php?mod=nova_escola_2&del_ciclo=1&id=$row2->ID_PRIMEIRO_CICLO' class='btn btn-xs btn-danger'>
																<span class='glyphicon glyphicon-trash'></span>
																Eliminar
															</a>
														</td>
													</tr>
												";
											}
										echo"</tbody>
									</table>
								</div>
							";
						}else{
							echo"
							<div class='row-fluid col-md-12'>
								<div class='alert alert-info'>
									<span class='glyphicon glyphicon-info-sign'></span>
									Ainda não existem dados de Primeiro ciclo registados. Para registar clique em \"Adicionar\"
								</div>
							</div>
							";
						}
					?>
				</div>
			</div>
		</div>
	</div>
	</div>
	<div class="panel-footer clearfix">
		<button type="submit" form="info_escola" class="btn btn-primary pull-right">
			<span class="glyphicon glyphicon-floppy-disk"></span>
			Guardar e Continuar
			<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>
		</button>
		<a href="index.php?mod=lista_escolas&del_new=1" class="btn btn-default pull-right" style="margin-right: 10px;">
			<span class="glyphicon glyphicon-ban-circle"></span>
			Cancelar
		</a>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script>
//Função para obter valores das variaveis do URL
function ObterValorVariavelURL(key) {
	key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx control chars
	var match = location.search.match(new RegExp("[?&]" + key + "=([^&]+)(&|$)"));
	return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

function onlyNum(id){
	id.keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
}

$( document ).ready(function() {
	//Obter valor da variavel 'tab' do URL
	var tabSel = ObterValorVariavelURL("tab");
	//alert("Valor da variavel: " + tabSel)

	//Ativar o separador do Pré-escolar
	if(tabSel == "pre"){
		$("#tab1c").removeClass("active");
		$("#tabPre").addClass("active");
		$("#a1c").attr("aria-expanded","false");
		$("#aPre").attr("aria-expanded","true");
		$("#pane1c").removeClass("active");
		$("#panePre").addClass("active");
	}
	//Ativar o separador do 1º Ciclo
	if(tabSel == "1c"){
		$("#tabPre").removeClass("active");
		$("#tab1c").addClass("active");
		$("#aPre").attr("aria-expanded","false");
		$("#a1c").attr("aria-expanded","true");
		$("#panePre").removeClass("active");
		$("#pane1c").addClass("active");
	}

	//copiar o valor do ano letivo selecionado na select box para o input hidden
	var option = $('#ano_letivo option:selected').val();
	$('#anoatual').val(option);

	$("#tipo_1c").change(function () {
			if($('#tipo_1c').val() == 12 || $('#tipo_1c').val() == 13){
				$("#outro_tipo").prop('disabled', false);
				$("#outro_tipo").attr('placeholder', 'Tipo de Ciclo');
			}else{
				$("#outro_tipo").prop('disabled', true);
				$("#outro_tipo").removeAttr('placeholder');
			}
		});

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
	onlyNum($("#num_alunos_pre"));
	onlyNum($("#num_alunos_1c"));
});
</script>
