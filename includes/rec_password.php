<?php	
	
	if($_GET['new_pass']==1){
		function enviar_mail(){
			
			$res = mysql_query("SELECT NOME_COMP, EMAIL FROM dbo_tab_funcionarios where NIF = $_SESSION[nif]");
			$row = mysql_fetch_object($res);
			$email = preg_replace('/\s+/', '', $row->EMAIL);
			
			if($_POST[email] == $email){
				
				function random($length) {
					$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
					$ref = substr( str_shuffle( $chars ), 0, $length );
					return $ref;
				}
				function give_name() {
					$name = random(5);
					return $name;
				}
			
				$pass = give_name();
				
				$update = mysql_query("UPDATE dbo_tab_funcionarios SET PASSWORD='$pass' WHERE NIF = $_SESSION[nif]");
				
				$to      = $_POST[email]; 
				$subject = 'Recuperação da Palavra-passe';
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html;' . "\r\n";		
				$headers .= 'From: DSEAM <informatica.dseam@gmail.com>'."\r\n".
					'Reply-To: JP <al213022@epcc.pt>'."\r\n" .
					'X-Mailer: PHP/' . phpversion();
				
				$message = '<html><body>';	
					$message .= '<p style="line-height: 190%">';
						$message .= 'Caro(a) '. $row->NOME_COMP . ',<br>';
						$message .= 'A sua palavra-passe é: <b>' . $pass . '</b><br>';	
						$message .= 'Poderá alterar a sua palavra-passe na opção "Alterar Palavra-Passe".<br>';
						$message .= 'Para voltar a aceder à  página por favor clique na ligação abaixo.<br>';
						$message .= 'http://www.recursosonline.org/fichadedados/';
						$message .= '<br><br>Cumprimentos, <br>DSEAM';
				$message .= '</body></html>';
			
				mail($to, $subject, $message, $headers);
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=finish&m=4'>";
			}else{
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=pessoal&m=7'>";
			}
		}
		enviar_mail();
	}	
	
	$res = mysql_query("select NOME_COMP from dbo_tab_funcionarios where NIF = $_SESSION[nif]");
	$row = mysql_fetch_object($res);
	
	echo"
		<div class='panel panel-info'>
			<div class='panel-heading'>
				<h3 class='panel-title'><strong>RECUPERAÃ‡ÃƒO DE PALAVRA-PASSE</strong></h3>
			</div>
			<form role='form' enctype='multipart/form-data' method='POST' action='index.php?mod=rec_password&new_pass=1'>
				<div class='panel-body'>
					<div class='row'>
						<div class='col-md-12'>
						<strong>Bem-Vindo </strong>". utf8_encode($row->NOME_COMP) ."!<br> Por favor insira o seu  <b>email</b> para poder receber a nova palavra-passe pelo mesmo.
						</div>
					</div>
					<div class='row' style='margin-top: 5px;'>
						<div class='col-md-3'>
							<input class='form-control' name='email' type='text' required>
						</div>
					</div>
				</div>
				<div class='panel-footer clearfix'>
					<button type='submit' name='submit' class='btn btn-primary pull-right'> 					
						<span class='glyphicon glyphicon-lock' aria-hidden='true'></span>
						Recuperar palavra-passe
					</button>
					<a href='index.php?mod=pessoal' class='btn btn-default pull-right' style='margin-right: 10px;'> 
						<span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span>
						Voltar
					</a>
				</div>
			</form>
		</div>
	";
?>