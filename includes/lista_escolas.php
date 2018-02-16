<?php
	$search = mysql_query("SELECT ID_FUNCIONARIO FROM dbo_tab_funcionarios WHERE NIF = $_SESSION[nif]");
	$row = mysql_fetch_object($search);
	$_SESSION[id_funcionario] = $row->ID_FUNCIONARIO;

	$id_anoletivo = utf8_decode($_POST[ano_letivo]);
	$res2 = mysql_query("SELECT * FROM dbo_tab_ano_letivo WHERE dbo_tab_ano_letivo.ANO_ATUAL = 1");
	$ano_atual = mysql_fetch_object($res2);

	//if($_GET['save']==1){
	//	$escola = utf8_decode($_POST[escola]);
	//	$municipio = utf8_decode($_POST[municipio]);
	//	$ano_letivo = utf8_decode($_POST[ano_letivo]);
	//	$res = mysql_query("INSERT INTO dbo_tab_escolas(ESCOLA, MUNICIPIO, ANO_LETIVO, TELEFONE, EMAIL, ID_FUNCIONARIO) VALUES ('$escola', '$municipio', '$ano_letivo', '$_POST[telefone]', '$_POST[email]', $_SESSION[id_funcionario])");
	//	echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_escolas'>";
	//}

if($_GET['save']==2 /*&& $id_anoletivo == $ano_atual->ID_ANO_LETIVO*/){
		$outra_escola = utf8_decode($_POST[outra_escola]);
		$telefone = $_POST[telefone];
		$email = $_POST[email];
		if($_POST[lista] == ''){
			$escola = 209;
		}else{
			$escola = $_POST[lista];
		}
		$res = mysql_query("UPDATE dbo_tab_escolas SET ESCOLA='$outra_escola', ID_ANO_LETIVO='$_POST[ano_letivo]', TELEFONE='$telefone', EMAIL='$email', ID_FUNCIONARIO=$_SESSION[id_funcionario], ID_LISTA_ESCOLAS='$escola', ID_MUNICIPIO='$_POST[municipio]' WHERE ID_ESCOLA=$_GET[id]");
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_escolas'>";
	}
	if($_GET['delete']==1){
		$search = mysql_query("SELECT ID_ANO_LETIVO FROM dbo_tab_escolas WHERE ID_FUNCIONARIO = $_SESSION[id_funcionario] and ID_ESCOLA = $_GET[id] ");
		$row = mysql_fetch_object($search);
		if($row->ID_ANO_LETIVO == $ano_atual->ID_ANO_LETIVO){
			$res2 = mysql_query("DELETE FROM dbo_tab_pre_escolar where ID_ESCOLA = $_GET[id]");
			$res2 = mysql_query("DELETE FROM dbo_tab_primeiro_ciclo where ID_ESCOLA = $_GET[id]");
			$res = mysql_query("DELETE FROM dbo_tab_escolas where ID_ESCOLA=$_GET[id]");
		}
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_escolas'>";
	}
	if($_GET['del_new']==1){
		$search = mysql_query("SELECT ID_ESCOLA FROM dbo_tab_escolas WHERE ID_FUNCIONARIO = $_SESSION[id_funcionario] order by ID_ESCOLA DESC LIMIT 1");
		$row = mysql_fetch_object($search);
		$res2 = mysql_query("DELETE FROM dbo_tab_pre_escolar where ID_ESCOLA = $row->ID_ESCOLA");
		$res3 = mysql_query("DELETE FROM dbo_tab_primeiro_ciclo where ID_ESCOLA = $row->ID_ESCOLA");
		$res = mysql_query("DELETE FROM dbo_tab_escolas where ID_FUNCIONARIO = $_SESSION[id_funcionario] order by ID_ESCOLA DESC LIMIT 1");
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_escolas'>";
	}
?>

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Dados Profissionais</strong></h3>
	</div>
	<div class="panel-body">
		<div class="row-fluid">
			<?php
				$res = mysql_query("SELECT * FROM dbo_tab_escolas, dbo_tab_lista_escolas, dbo_tab_municipios, dbo_tab_ano_letivo WHERE dbo_tab_escolas.ID_LISTA_ESCOLAS = dbo_tab_lista_escolas.ID_LISTA_ESCOLAS AND dbo_tab_escolas.ID_MUNICIPIO = dbo_tab_municipios.ID_MUNICIPIO AND dbo_tab_escolas.ID_ANO_LETIVO = dbo_tab_ano_letivo.ID_ANO_LETIVO AND dbo_tab_escolas.ID_FUNCIONARIO = $_SESSION[id_funcionario]");
				$res2 = mysql_query("SELECT * FROM dbo_tab_ano_letivo WHERE dbo_tab_ano_letivo.ANO_ATUAL = 1");
				$ano_atual = mysql_fetch_object($res2);
				$num = mysql_num_rows($res);
				if($num>0){
					echo"<div class='table-responsive'>
						<table class='table table-striped trHover'>
							<thead>
								<!-- MENU -->
								<tr>
									<th>
										Escola/Instituição
									</th>
									<th>
										Município
									</th>
									<th>
										Ano Letivo
									</th>
									<th style='text-align: center;'>
										Opções
									</th>
								</tr>
							</thead>
								<tbody>";
								while($row = mysql_fetch_object($res)){
									echo"
										<tr>
											<td>";
											if($row->ID_LISTA_ESCOLAS == 209){
												echo utf8_encode($row->ESCOLA);
											}else{
												echo utf8_encode($row->NOME_ESCOLA);
											}
											echo"</td>
											<td>
												" . utf8_encode($row->MUNICIPIO) . "
											</td>
											<td>
												" . utf8_encode($row->ANO_LETIVO) . "
											</td>
											<td style='text-align: center;'>";

											if($row->ID_ANO_LETIVO != $ano_atual->ID_ANO_LETIVO){
												$turnDisable = "disabled";
												$edit_href = "javascript:void(0)";
												$delete_href = "javascript:void(0)";
											}else{
												$turnDisable = "";
												$edit_href = "index.php?mod=edit_escola&id=$row->ID_ESCOLA";
												$delete_href = "index.php?mod=lista_escolas&delete=1&id=$row->ID_ESCOLA";
											}

											echo "<a href='".$edit_href."' class='btn btn-xs btn-warning' ".$turnDisable.">
													<span class='glyphicon glyphicon-pencil'></span>
													Editar
												</a> ";
											echo " <a href='".$delete_href."' class='btn btn-xs btn-danger' ".$turnDisable.">
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
						<div class='col-md-12'>
							<br>
							<div class='alert alert-info'>
								<span class='glyphicon glyphicon-info-sign'></span>
								Ainda não existem escolas registadas. Para registar clique em \"Adicionar escola\"
							</div>
						</div>";
				}
			?>
		</div>
	</div>
	<div class="panel-footer clearfix">
	<?php
		echo"<a class='btn btn-primary pull-right' href='index.php?mod=finish&save=1&id=". $_SESSION[id_funcionario] ."'>";
	?>
			<span class='glyphicon glyphicon-send' aria-hidden='true'></span>
			Enviar
		</a>
		<a href='index.php?mod=pessoal_2&search=3' class='btn btn-default pull-right' style='margin-right: 10px;'>
			<span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span>
			Voltar
		</a>
		<a class="btn btn-success" href="index.php?mod=nova_escola">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
			Adicionar Escola
		</a>
	</div>
</div>
