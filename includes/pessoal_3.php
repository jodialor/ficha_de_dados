<?php
$id = $_SESSION[id_funcionario];
$query= "SELECT * FROM dbo_tab_outros_dados WHERE ID_FUNCIONARIO = $id";
$res = mysql_query($query);
$row = mysql_fetch_object($res);
echo"
<div class='panel panel-info'>
	<div class='panel-heading'>
		<h3 class='panel-title'><strong>Dados Pessoais</strong></h3>
	</div>
	<form role='form' enctype='multipart/form-data' method='POST' action='index.php?mod=finish&save=1'>
		<div class='panel-body'>
			<div class='row'>
				<div class='col-md-12'>
					<h5><strong>Atividade(s) que desenvolve:</strong></h5>
					<textarea class='form-control' name='atividades' rows='3'>".utf8_encode($row->ATIVIDADES)."</textarea>
				</div>
			</div>
			<br>
			<div class='row'>
				<div class='col-md-12'>
					<h5><strong>Grupo(s) artístico(s) à sua responsabilidade:</strong></h5>
					<textarea class='form-control' name='grupos' rows='3'>".utf8_encode($row->GRUPOS)."</textarea>
				</div>
			</div>
			<br>
			<div class='row'>
				<div class='col-md-12'>
					<h5><strong>Observações:</strong></h5>
					<textarea class='form-control' name='observacoes' rows='3'>".utf8_encode($row->OBSERVACOES)."</textarea>
				</div>
			</div>
		</div>
		<div class='panel-footer clearfix'>
			<button type='submit' name='submit' class='btn btn-primary pull-right'> 
				Enviar
				<span class='glyphicon glyphicon-send' aria-hidden='true'></span>
			</button>
			<a href='index.php?mod=lista_escolas' class='btn btn-default pull-right' style='margin-right: 10px;'> 
				<span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span>
				Voltar
			</a>
		</div>
	</form>
</div>
";
?>