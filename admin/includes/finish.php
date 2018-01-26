<?php
	function enviar_mail(){
		$res = mysql_query("select * from dbo_tab_funcionarios where ID_FUNCIONARIO = $_GET[id]");
		$row = mysql_fetch_object($res);

		$emails = mysql_query("select EMAIL from dbo_tab_utilizadores where EMAIL_COMPLETO = 1");
		while($row2 = mysql_fetch_object($emails)){
			$to      .= $row2->EMAIL . ","; 
		}
		$subject = 'Dados Pessoais/Profissionais: '. $row->NOME_COMP .'';
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html' . "\r\n";		
		$headers .= 'From: DSEAM <informatica.dseam@gmail.com>'."\r\n".
			'X-Mailer: PHP/' . phpversion();
		
		$message = '<html><body>';	
			$message .= '<h4>DADOS PESSOAIS</h4>';
			$message .= '<p style="line-height: 190%">';
				$message .= '<b>Nome: </b>' . $row->NOME_COMP . '<br>';
				$message .= '<b>Morada: </b>' . $row->MORADA . '<br>';
				$message .= '<b>Código Postal: </b>' . $row->COD_POSTAL."-".$row->IND_CODPOSTAL . '<br>';
				$message .= '<b>Localidade: </b>' . $row->LOCALIDADE . '<br>';
				$message .= '<b>Destrito: </b>' . $row->DESTRITO . '<br>';
				$res2=mysql_query("Select * from dbo_tab_municipios");
				while ($row2 = mysql_fetch_object($res2)){
					if($row2->ID_MUNICIPIO == $row->ID_MUNICIPIO){
						$message .= '<b>Município: </b>' . $row2->MUNICIPIO . '<br>';
					}
				}
				$message .= '<b>Freguesia: </b>' . $row->FREGUESIA . '<br>';
				$message .= '<b>Banco: </b>' . $row->BANCO . '<br>';
				$res2=mysql_query("Select * from dbo_tab_lista_escolas");
				while ($row2 = mysql_fetch_object($res2)){
					if($row2->ID_LISTA_ESCOLAS == $row->ID_ESCOLA_TITULAR){
						if($row->ID_ESCOLA_TITULAR==''){
							$message .= '<b>Escola Titular: </b>' . $row->ESCOLA_TITULAR . '<br>';
						}else{
							$message .= '<b>Escola Titular: </b>' . $row2->NOME_ESCOLA . '<br>';
						}
					}
				}
				$message .= '<b>Codigo Recrutamento: </b>' . $row->COD_RECRUTAMENTO . '<br>';
				$myDateTimei = DateTime::createFromFormat('Y-m-d', $row->INICIO_FUNCOES);
				$INICIO_FUNCOES = $myDateTimei->format('d-m-Y');
				$message .= '<b>Início de Funções: </b>' . $INICIO_FUNCOES . '<br>';
				$message .= '<b>Telefone: </b>' . $row->TEL . '<br>';
				$message .= '<b>Telemovel: </b>' . $row->TLM . '<br>';
				$myDateTimea = DateTime::createFromFormat('Y-m-d', $row->DATA_NASC);
				$DATA_NASC = $myDateTimea->format('d-m-Y');
				$message .= '<b>Data de Nascimento: </b>' . $DATA_NASC . '<br>';
				$message .= '<b>Nº Identificação Civil: </b>' . $row->BI . '<br>';
				$myDateTimeb = DateTime::createFromFormat('Y-m-d', $row->DATA_VALIDADE);
				$DATA_VALIDADE = $myDateTimeb->format('d-m-Y');
				$message .= '<b>Data de Validade: </b>' . $DATA_VALIDADE . '<br>';
				$message .= '<b>NIB: </b>' . $row->NIB . '<br>';
				$message .= '<b>NISS: </b>' . $row->NISS . '<br>';
				$message .= '<b>ADSE: </b>' . $row->ADSE . '<br>';
				$message .= '<b>CGA: </b>' . $row->CGA . '<br>';
				$message .= '<b>Nº dependentes: </b>' . $row->NUM_DEPENDENTES . '<br>';
			$message .= '</p>';
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
										Outro Tipo
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
		
		$mudar = mysql_query("UPDATE dbo_tab_funcionarios SET ENVIADO = 1 WHERE ID_FUNCIONARIO = $_GET[id]");
		
		mail($to, $subject, $message, $headers);	
		echo "
				<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_func'>
			";
	}

			enviar_mail();

?>		