<?php

	if($_GET['change']==1){
		if($_POST['nova'] == $_POST['re_nova']){
			$res = mysql_query("SELECT * FROM dbo_tab_funcionarios WHERE ID_FUNCIONARIO = $_SESSION[id_funcionario]");
			$row = mysql_fetch_object($res);
			if($_POST[antiga] == $row->PASSWORD){
				$res = mysql_query("UPDATE `dbo_tab_funcionarios` SET `PASSWORD` = '$_POST[nova]' WHERE ID_FUNCIONARIO = $_SESSION[id_funcionario]");
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=pessoal'>";
			}else{
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=change_pass&m=9'>";
			}
		}else{
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=change_pass&m=10'>";
		}
	}
	?>
	
	<div class='panel panel-info'>
		<div class='panel-heading'>
			<h3 class='panel-title'><strong>ALTERAÇÃO DE PALAVRA-PASSE</strong></h3>
		</div>
		<form role='form' enctype='multipart/form-data' method='POST' action='index.php?mod=change_pass&change=1'>
			<div class='panel-body'>
				<div class='row' style='margin-top: 5px;'>
					<div class='col-md-3'>
						<input class='form-control' name='antiga' type='password' placeholder='Palavra-passe antiga' required>
					</div>
					<div class='col-md-3'>
						<input class='form-control' name='nova' type='password' placeholder='Nova Palavra-passe' required>
					</div>
					<div class='col-md-3'>
						<input class='form-control' name='re_nova' type='password' placeholder='Re-introduza a Palavra-passe' required>
					</div>
				</div>
			</div>
			<div class='panel-footer clearfix'>
				<button type='submit' name='submit' class='btn btn-primary pull-right'>
					<span class='glyphicon glyphicon-lock' aria-hidden='true'></span>
					Alterar
				</button>
				<a href='index.php?mod=pessoal_2&search=3' class='btn btn-default pull-right' style='margin-right: 10px;'>
					<span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span>
					Voltar
				</a>
			</div>
		</form>
	</div>
