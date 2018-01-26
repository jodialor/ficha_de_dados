<?php
	function enviar_mail(){
		$res = mysql_query("select NOME_COMP, NIF, EMAIL from dbo_tab_funcionarios where ID_FUNCIONARIO = $_SESSION[id_funcionario]");
		$row = mysql_fetch_object($res);
		$emailFunc .= $row->EMAIL . ","; 
		
		$emails = mysql_query("select EMAIL from dbo_tab_utilizadores where EMAIL_SIMPLES = 1");
		while($row2 = mysql_fetch_object($emails)){
			$to      .= $row2->EMAIL . ","; 
		}		
		
		$subject = 'Registo de Dados: ' . $row->NOME_COMP;
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html' . "\r\n";		
		$headers .= 'From: DSEAM <informatica.dseam@gmail.com>'."\r\n".
			'X-Mailer: PHP/' . phpversion();
		
		$message = '<html><body>';	
			$message .= ' O docente/técnico <b>'. $row->NOME_COMP .'</b> com o contribuinte n.º <b>'. $row->NIF .'</b> acabou de atualizar os seus dados.<br><br>';
			$res = mysql_query("SELECT dbo_tab_escolas.*, dbo_tab_lista_escolas.NOME_ESCOLA, dbo_tab_municipios.*, dbo_tab_ano_letivo.* FROM dbo_tab_escolas, dbo_tab_lista_escolas, dbo_tab_municipios, dbo_tab_ano_letivo WHERE dbo_tab_escolas.ID_LISTA_ESCOLAS = dbo_tab_lista_escolas.ID_LISTA_ESCOLAS AND dbo_tab_escolas.ID_MUNICIPIO = dbo_tab_municipios.ID_MUNICIPIO AND dbo_tab_escolas.ID_ANO_LETIVO = dbo_tab_ano_letivo.ID_ANO_LETIVO AND dbo_tab_escolas.ID_FUNCIONARIO = $_GET[id]");
			$num = mysql_num_rows($res);
			if($num>0){
				$message .= '<h3>DADOS PROFISSIONAIS</h3>';
				while($row = mysql_fetch_object($res)){
					if($row->ID_LISTA_ESCOLAS == 209){
						$escola = $row->ESCOLA;
					}else{
						$escola = $row->NOME_ESCOLA;
					}
					$message .= '<b>ESCOLA:</b> '. $escola .' | <b>Municipio:</b> '.$row->MUNICIPIO.' | <b>Ano Letivo:</b> '.$row->ANO_LETIVO.' | <b>Tel:</b> '.$row->TELEFONE.' | <b>Email:</b> '.$row->EMAIL.'<br>';
					$id_escola = $row->ID_ESCOLA;
					$pre = mysql_query("select * from dbo_tab_pre_escolar, dbo_tab_tipo_pre where dbo_tab_pre_escolar.ID_ESCOLA = $id_escola AND dbo_tab_tipo_pre.ID_TIPO_PRE = dbo_tab_pre_escolar.ID_TIPO_PRE");
					$num = mysql_num_rows($pre);
					if($num>0){
						$message .='<br><b>PRÉ-ESCOLAR:</b><div class="table-responsive">
						<table border="1" border-style="solid" border-color="#777777" border-width="2px" cellpadding="5px" cellspacing="0px">
							<thead>
								<!-- MENU -->
								<tr>
									<th>
										Tipo de Pré
									</th>
									<th>
										Nº de Alunos
									</th>
								</tr>
							</thead>
							<tbody>
						';	
						while($row_pre = mysql_fetch_object($pre)){
							$message .='
							<tr>
								<td>
									' . $row_pre->TIPO_PRE . '
								</td>
								<td>
									' . $row_pre->NUM_ALUNOS . '
								</td>
							</tr>
							';
						}
						$message .=	'</tbody>
							</table>
						</div><br>';
					}else{
						$message .= '
							<br><b>PRÉ-ESCOLAR:</b><p>Não foram enviados dados sobre o pré-escolar.</p>
						';
					}
					$pciclo = mysql_query("select * from dbo_tab_primeiro_ciclo, dbo_tab_tipo_ciclo, dbo_tab_nivel where dbo_tab_primeiro_ciclo.ID_ESCOLA = $id_escola AND dbo_tab_tipo_ciclo.ID_TIPO_CICLO = dbo_tab_primeiro_ciclo.ID_TIPO_CICLO AND dbo_tab_nivel.ID_NIVEL = dbo_tab_primeiro_ciclo.ID_NIVEL");
					$num = mysql_num_rows($pciclo);
					if($num>0){
						$message .='<br><b>PRIMEIRO CICLO:</b><div class="table-responsive">
						<table border="1" border-style="solid" border-color="#777777" border-width="2px" cellpadding="5px" cellspacing="0px">
							<thead>
								<!-- MENU -->
								<tr>
									<th>
										Ano/Turma
									</th>
									<th>
										Nº de Alunos
									</th>
									<th>
										Tipo
									</th>
									<th>
										Outro Tipo/Grupo
									</th>
									<th>
										Nível
									</th>
								</tr>
							</thead>
							<tbody>
						';	
						while($row_pciclo = mysql_fetch_object($pciclo)){
							$message .='
							<tr>
								<td>
									' . $row_pciclo->ANO_TURMA . '
								</td>
								<td>
									' . $row_pciclo->NUM_ALUNOS . '
								</td>
								<td>
									' . $row_pciclo->TIPO_CICLO . '
								</td>
								<td>
									' . $row_pciclo->OUTRO_TIPO . '
								</td>
								<td>
									' . $row_pciclo->NIVEL . '
								</td>
							</tr>
						';					
						}
						$message .=	'</tbody>
							</table>
						</div><br>';
					}else{
						$message .= '
							<br><b>PRIMEIRO CICLO:</b>
							<p>Não foram enviados dados sobre o primeiro ciclo.</p>
						';
					}
					$message .= '<hr>';
				}
			}
		$message .= '</body></html>';
		
		mail($to, $subject, $message, $headers);	
		mail($emailFunc, $subject, $message, $headers);
	}

	if($_GET['save']==1){
		//$id = $_SESSION[id_funcionario];
		//$atividades = utf8_decode($_POST[atividades]);
		//$grupos = utf8_decode($_POST[grupos]);
		//$observacoes = utf8_decode($_POST[observacoes]);
		//$res1 = mysql_query("SELECT * FROM dbo_tab_outros_dados where ID_FUNCIONARIO = $_SESSION[id_funcionario]");
		//$num = mysql_num_rows($res1);
		//if($num>0){
		//	$res = mysql_query("UPDATE dbo_tab_outros_dados SET ATIVIDADES='$atividades', GRUPOS='$grupos', OBSERVACOES='$observacoes' WHERE ID_FUNCIONARIO = $_SESSION[id_funcionario]");
			enviar_mail();
			echo "
				<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=finish&m=2'>
			";
		//}else{
		//	$res = mysql_query("INSERT INTO dbo_tab_outros_dados(ID_FUNCIONARIO, ATIVIDADES, GRUPOS, OBSERVACOES) VALUES ($id, '$atividades', '$grupos', '$observacoes')");
		//	enviar_mail();
		//	echo "
		//		<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=finish&m=2'>
		//	";
		//}
	}
?>		