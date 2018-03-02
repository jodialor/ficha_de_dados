<?php
	$res_ano_atual = mysql_query("SELECT * FROM dbo_tab_ano_letivo WHERE dbo_tab_ano_letivo.ANO_ATUAL = 1");
	$ano_atual = mysql_fetch_object($res_ano_atual);

	$search = mysql_query("select * from dbo_tab_escolas where ID_ESCOLA = $_GET[id]");
	$row_search = mysql_fetch_object($search);
	$id_escola = $row_search->ID_ESCOLA;
	$id_anoletivo = $row_search->ID_ANO_LETIVO;

	if($_GET['add']==1){
		$new_pre = mysql_query("INSERT INTO dbo_tab_pre_escolar(ID_TIPO_PRE, NUM_ALUNOS, ID_ESCOLA) VALUES ($_POST[tipo_pre], $_POST[num_alunos_pre], $id_escola)");
	}
	if($_GET['add']==2){
		$new_pciclo = mysql_query("INSERT INTO dbo_tab_primeiro_ciclo(ID_ANO_ESCOLAR, TURMA, NUM_ALUNOS, ID_TIPO_CICLO, OUTRO_TIPO, ID_NIVEL, ID_ESCOLA)
															 VALUES ($_POST[ano_escolar], '$_POST[turma]', $_POST[num_alunos_1c], '$_POST[tipo_1ciclo]', '$_POST[outro_tipo]', '$_POST[nivel]', $id_escola)");
	}
	if($_GET['del_pre']==1 && $id_anoletivo == $ano_atual->ID_ANO_LETIVO){
		$del_pre = mysql_query("DELETE FROM dbo_tab_pre_escolar where ID_PRE_ESCOLAR=$_GET[id_pre]");
	}
	if($_GET['del_ciclo']==1 && $id_anoletivo == $ano_atual->ID_ANO_LETIVO){
		$del_pciclo = mysql_query("DELETE FROM dbo_tab_primeiro_ciclo where ID_PRIMEIRO_CICLO=$_GET[id_1c]");
	}

	$turnDisable = ($id_anoletivo != $ano_atual->ID_ANO_LETIVO) ? "disabled" : "";
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Dados Profissionais</strong></h3>
	</div>
	<div class="panel-body">
		<form role='form' action='index.php?mod=lista_escolas&save=2&id=<?php echo $id_escola;?>' id='info_escola' method='POST'>
			<fieldset <?php echo $turnDisable; ?>>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Escola/Instituição*</label>
							<?php
								echo"
								<select class='form-control' name='lista' id='lista' required>
								<option value=''>-selecione-</option>";
								$res_l_escolas=mysql_query("Select * from dbo_tab_lista_escolas ORDER BY NOME_ESCOLA ASC");
								while ($row_l_escolas = mysql_fetch_object($res_l_escolas)){
									if($row_l_escolas->ID_LISTA_ESCOLAS == $row_search->ID_LISTA_ESCOLAS){
										echo"<option value='$row_l_escolas->ID_LISTA_ESCOLAS' selected>".utf8_encode($row_l_escolas->NOME_ESCOLA)."</option>";
									}else{
										echo"<option value='$row_l_escolas->ID_LISTA_ESCOLAS'>".utf8_encode($row_l_escolas->NOME_ESCOLA)."</option>";
									}
								}
								mysql_free_result($res_l_escolas);
								echo"
								</select>";
							?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Outra Escola</label>
								<input type='text' class='form-control' name='outra_escola' id='outra_escola_campo' value='<?php echo utf8_encode($row_search->ESCOLA)?>' placeholder='Nome da Escola' />
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
								$res_municipios=mysql_query("Select * from dbo_tab_municipios");
								while ($row_municipios = mysql_fetch_object($res_municipios)){
									if($row_municipios->ID_MUNICIPIO == $row_search->ID_MUNICIPIO){
										echo"<option value='$row_municipios->ID_MUNICIPIO' selected>".utf8_encode($row_municipios->MUNICIPIO)."</option>";
									}else{
										echo"<option value='$row_municipios->ID_MUNICIPIO'>".utf8_encode($row_municipios->MUNICIPIO)."</option>";
									}
								}
								mysql_free_result($res_municipios);
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
								$res_anos_let=mysql_query("Select * from dbo_tab_ano_letivo ORDER BY ANO_LETIVO DESC");
								while ($row_anos_let = mysql_fetch_object($res_anos_let)){
									$is_selected = ($row_anos_let->ANO_ATUAL) ? "selected" : "";
									echo"<option value='$row_anos_let->ID_ANO_LETIVO' $is_selected>".utf8_encode($row_anos_let->ANO_LETIVO)."</option>";
								}
								mysql_free_result($res_anos_let);
							?>
							</select>
							<input type="hidden" id="anoatual" name="ano_letivo"/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Telefone</label>
							<input type='text' id='tel' class='form-control' name='telefone' value='<?php echo $row_search->TELEFONE?>' placeholder='Introduza o número de telefone'/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Email</label>
							<input type='email' class='form-control' name='email' value='<?php echo $row_search->EMAIL?>' placeholder='Introduza o email'/>
						</div>
					</div>
				</div>
			</fieldset>
		</form>

	<blockquote style="margin-top: 10px;">
		<p><strong>Dados do Pré-Escolar e/ou 1.º Ciclo</strong></p>
	</blockquote>

	<ul class="nav nav-tabs">
		<li id="tabPre" class="active"><a id="aPre" data-toggle="tab" href="#panePre">Pré-Escolar</a></li>
		<li id="tab1c"><a id="a1c" data-toggle="tab" href="#pane1c">1º Ciclo</a></li>
	</ul>
	<div class="row" style="margin-bottom: 15px;">
		<div class="tab-content" style="margin-top: 10px;">
			<div id="panePre" class="tab-pane in active">
				<div class="container-fluid">
					<form role='form' action='index.php?mod=edit_escola&add=1&id=<?php echo $id_escola;?>&tab=pre' id='pre_escolas' method='POST'>
						<fieldset <?php echo $turnDisable; ?>>
							<div class="row col-md-12">
								<div class="col-md-3">
									<div class="form-group">
										<label>Tipo de Pré</label>
										<select id="tipo_pre" name="tipo_pre" class="form-control" required>
											<option value="">- selecione -</option>
											<?php
												$res_tip_pre=mysql_query("Select * from dbo_tab_tipo_pre ORDER BY TIPO_PRE");
												while ($row_tip_pre = mysql_fetch_object($res_tip_pre)){
													echo"<option value='$row_tip_pre->ID_TIPO_PRE'>".utf8_encode($row_tip_pre->TIPO_PRE)."</option>";
												}
												mysql_free_result($res_tip_pre);
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
						$res_pres = mysql_query("select * from dbo_tab_pre_escolar, dbo_tab_tipo_pre where dbo_tab_pre_escolar.ID_ESCOLA = $id_escola AND dbo_tab_tipo_pre.ID_TIPO_PRE = dbo_tab_pre_escolar.ID_TIPO_PRE");
						$num_pres = mysql_num_rows($res_pres);
						if($num_pres>0){
					?>
					<div class='row-fluid col-md-6'>
						<table id='registos_escola_pre' class='table table-striped trHover table-bordered'>
							<thead>
								<tr style='text-align: center;'>
									<th> Tipo de Pré </th>
									<th> Nº Alunos </th>
									<th> Eliminar </th>
								</tr>
							</thead>
							<tbody>
							<?php
							while($row_pres = mysql_fetch_object($res_pres)){
								$del_pre_onoff = ($id_anoletivo != $ano_atual->ID_ANO_LETIVO) ? "javascript:void(0)" : "index.php?mod=edit_escola&del_pre=1&id_pre=$row_pres->ID_PRE_ESCOLAR&id=$id_escola&tab=pre";
								echo"
								<tr>
									<td>". utf8_encode($row_pres->TIPO_PRE) ."</td>
									<td>". $row_pres->NUM_ALUNOS ."</td>
									<td style='text-align: center;'>
										<a href='$del_pre_onoff' class='btn btn-xs btn-danger' $turnDisable>
											<span class='glyphicon glyphicon-trash'></span>
											Eliminar
										</a>
									</td>
								</tr>";
							}
							echo"</tbody>
							</table>
							</div>";
						}else{
							echo"
							<div class='row-fluid col-md-12'>
								<div class='alert alert-info'>
									<span class='glyphicon glyphicon-info-sign'></span>
									Ainda não existem dados de Pré-Escolar registados. Para registar clique em \"Adicionar\"
								</div>
							</div>";
						}
					?>
				</div>
			</div>

			<div id="pane1c" class="tab-pane">
				<div class="container-fluid">
					<div class="row col-md-12">
						<form role='form' action='index.php?mod=edit_escola&add=2&id=<?php echo $id_escola?>&tab=1c' id='1c' method='POST'>
							<fieldset <?php echo $turnDisable; ?>>
								<div class="col-md-4">
									<div class="form-group">
										<label>Ano Escolar</label>
										<select id="ano_esc" name="ano_escolar"class="form-control" required>
											<option value="">- selecione -</option>
												<?php
													$res_anos = mysql_query("Select * from dbo_tab_anos_escolares");
													while ($row_anos = mysql_fetch_object($res_anos)){
														echo"<option value='$row_anos->ID_ANO_ESCOLAR'>".$row_anos->ANO_ESCOLAR."</option>";
													}
													mysql_free_result($res_anos);
												?>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Turma</label>
										<input id="turma" name="turma" type="text" class="form-control" placeholder="Turma" required/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Nº Alunos</label>
										<input id="num_alunos_1c" name="num_alunos_1c" type="text" class="form-control" placeholder="Nº alunos" required/>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Tipo 1º Ciclo</label>
										<select id="tipo_1c" name="tipo_1ciclo" class="form-control" required>
											<option value="">- selecione -</option>
												<?php
													$res_t_ciclo=mysql_query("Select * from dbo_tab_tipo_ciclo ORDER BY TIPO_CICLO");
													while ($row_t_ciclo = mysql_fetch_object($res_t_ciclo)){
														echo"<option value='$row_t_ciclo->ID_TIPO_CICLO'>".utf8_encode($row_t_ciclo->TIPO_CICLO)."</option>";
													}
													mysql_free_result($res_t_ciclo);
												?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Outro Tipo/Grupo</label>
										<input id="outro_tipo" name="outro_tipo" type="text" class="form-control" disabled/>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Nível</label>
										<select id="nivel" name="nivel" class="form-control" required>
											<option value="">- selecione -</option>
												<?php
													$res_nivel=mysql_query("Select * from dbo_tab_nivel");
													while ($row_nivel = mysql_fetch_object($res_nivel)){
														echo"<option value='$row_nivel->ID_NIVEL'>".utf8_encode($row_nivel->NIVEL)."</option>";
													}
													mysql_free_result($res_nivel);
												?>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<button type="submit" id="btn_adicionar_1c" class="btn btn-success" style="margin-top: 16%;">
											<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
												Adicionar
										</button>
									</div>
								</div>
							</fieldset>
						</form>
						</div>
					<?php
						$res_old = mysql_query("select * from dbo_tab_primeiro_ciclo, dbo_tab_tipo_ciclo, dbo_tab_nivel where dbo_tab_primeiro_ciclo.ID_ESCOLA = $id_escola AND dbo_tab_tipo_ciclo.ID_TIPO_CICLO = dbo_tab_primeiro_ciclo.ID_TIPO_CICLO AND dbo_tab_nivel.ID_NIVEL = dbo_tab_primeiro_ciclo.ID_NIVEL AND ID_ANO_ESCOLAR IS NULL");
						$num_old = mysql_num_rows($res_old);
						// query que devolve os dados do 1º ciclo ja considerando os dados da tabela "dbo_tab_anos_escolares"
						$res_1ciclo = mysql_query("select * from dbo_tab_primeiro_ciclo, dbo_tab_tipo_ciclo, dbo_tab_nivel, dbo_tab_anos_escolares where dbo_tab_primeiro_ciclo.ID_ESCOLA = $id_escola AND dbo_tab_tipo_ciclo.ID_TIPO_CICLO = dbo_tab_primeiro_ciclo.ID_TIPO_CICLO AND dbo_tab_nivel.ID_NIVEL = dbo_tab_primeiro_ciclo.ID_NIVEL AND dbo_tab_anos_escolares.ID_ANO_ESCOLAR = dbo_tab_primeiro_ciclo.ID_ANO_ESCOLAR");
						$num = mysql_num_rows($res_1ciclo);
						if($num_old>0 || $num>0){
						?>
							<div class='row-fluid col-md-12'>
								<table id='registos_escola_1C' class='table table-striped trHover table-bordered'>
									<thead>
										<tr style='text-align: center;'>
											<th> Ano / Turma </th>
											<th> Nº Alunos </th>
											<th> Tipo 1º Ciclo </th>
											<th> Outro Tipo/Grupo </th>
											<th> Nível </th>
											<th> Eliminar	</th>
										</tr>
									</thead>
									<tbody>
									<?php
									// registos do 1ºciclo já existentes aquando da criaçao da tabela "dbo_tab_anos_escolares"
									while($row_res_old = mysql_fetch_object($res_old)) {
										$del_ciclo_onoff = ($id_anoletivo != $ano_atual->ID_ANO_LETIVO) ? "javascript:void(0)" : "index.php?mod=edit_escola&del_ciclo=1&id_1c=$row_res_old->ID_PRIMEIRO_CICLO&id=$id_escola&tab=1c";
										echo"
											<tr>
												<td>" . $row_res_old->TURMA . "</td>
												<td>" . $row_res_old->NUM_ALUNOS . "</td>
												<td>" . utf8_encode($row_res_old->TIPO_CICLO) . "</td>
												<td>" . utf8_encode($row_res_old->OUTRO_TIPO) . "</td>
												<td>" . utf8_encode($row_res_old->NIVEL) . "</td>
												<td style='text-align: center;'>
													<a href='$del_ciclo_onoff' class='btn btn-xs btn-danger' $turnDisable>
														<span class='glyphicon glyphicon-trash'></span>
														Eliminar
													</a>
												</td>
											</tr>";
									}
									mysql_free_result($res_old);
									// registos do 1ºciclo adicionados apos criaçao da tabela "dbo_tab_anos_escolares"
									while($row_1ciclo = mysql_fetch_object($res_1ciclo)) {
										$del_ciclo_onoff = ($id_anoletivo != $ano_atual->ID_ANO_LETIVO) ? "javascript:void(0)" : "index.php?mod=edit_escola&del_ciclo=1&id_1c=$row_1ciclo->ID_PRIMEIRO_CICLO&id=$id_escola&tab=1c";
										echo"
											<tr>
												<td>" . $row_1ciclo->ANO_ESCOLAR." / ".$row_1ciclo->TURMA . "</td>
												<td>" . $row_1ciclo->NUM_ALUNOS . "</td>
												<td>" . utf8_encode($row_1ciclo->TIPO_CICLO) . "</td>
												<td>" . utf8_encode($row_1ciclo->OUTRO_TIPO) . "</td>
												<td>" . utf8_encode($row_1ciclo->NIVEL) . "</td>
												<td style='text-align: center;'>
													<a href='$del_ciclo_onoff' class='btn btn-xs btn-danger' $turnDisable>
														<span class='glyphicon glyphicon-trash'></span>
														Eliminar
													</a>
												</td>
											</tr>";
									}
									mysql_free_result($res_1ciclo);
									echo"</tbody>
								</table>
							</div>";
						}else{
							echo"
							<div class='row-fluid col-md-12'>
								<div class='alert alert-info'>
									<span class='glyphicon glyphicon-info-sign'></span>
									Ainda não existem dados de Primeiro ciclo registados. Para registar clique em \"Adicionar\"
								</div>
							</div>";
						}
					?>
				</div>
			</div>
		</div>
	</div>
	</div>
	<div class="panel-footer clearfix">
		<button type="submit" form="info_escola" class="btn btn-primary pull-right" <?php echo $turnDisable; ?>>
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

	$(document).ready(function() {
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

		$( document ).ready(function() {
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
		});

		onlyNum($("#tel"));
		onlyNum($("#num_alunos_pre"));
		onlyNum($("#num_alunos_1c"));
	});

</script>
