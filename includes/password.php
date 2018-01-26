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
				$subject = 'Requisição da palavra-passe';
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html;' . "\r\n";		
				$headers .= 'From: DSEAM <informatica.dseam@gmail.com>'."\r\n".
					'Reply-To: JP <al213022@epcc.pt>'."\r\n" .
					'X-Mailer: PHP/' . phpversion();
				
				$message = '<html><body>';	
					$message .= '<p style="line-height: 190%">';
						$message .= 'Caro(a) '. $row->NOME_COMP . ',<br>';
						$message .= 'A sua palavra-passe é: <b>' . $pass . '</b><br><br>';
						$message .= 'Poderá alterar a sua palavra-passe na opção "Alterar Palavra-Passe".<br>';						
						$message .= 'para voltar a aceder á pagina por favor clique na ligação abaixo.<br>';
						$message .= 'http://www.recursosonline.org/fichadedados/';
						$message .= '<br>Cumprimentos, <br>DSEAM';
				$message .= '</body></html>';
			
				mail($to, $subject, $message, $headers);
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=password&m=4'>";
			}else{
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=pessoal&m=6'>";
			}
		}
		enviar_mail();
	}
	
	if($_GET['search']==1){
		$nif = $_POST[nif];
		if(!is_numeric($nif) || strlen($nif)!=9){
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=pessoal&m=8'>";
			return;
		}
		$_SESSION[nif]=$_POST[nif];
		$res = mysql_query("select NOME_COMP, PASSWORD from dbo_tab_funcionarios where NIF = $_POST[nif]");
		$num = mysql_num_rows($res);
		if($num>0){
			$row = mysql_fetch_object($res);
			if(empty($row->PASSWORD)){
				echo"
					<div class='panel panel-info'>
						<div class='panel-heading'>
							<h3 class='panel-title'><strong>DADOS PESSOAIS</strong></h3>
						</div>
						<form role='form' enctype='multipart/form-data' method='POST' action='index.php?mod=password&new_pass=1'>
							<div class='panel-body'>
							<br>
								<div class='row'>
									<div class='col-md-12'>
									<strong>Bem-Vindo </strong>". utf8_encode($row->NOME_COMP) ."!<br> Por favor insira o seu  <b>email</b> para poder receber a palavra-passe pelo mesmo.
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
									<span class='glyphicon glyphicon-search' aria-hidden='true'></span>
									Procurar e Continuar
									<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>
								</button>
							</div>
						</form>
					</div>
				";
			}else{
				echo"
					<div class='panel panel-info'>
						<div class='panel-heading'>
							<h3 class='panel-title'><strong>DADOS PESSOAIS</strong></h3>
						</div>
						<form role='form' enctype='multipart/form-data' method='POST' action='index.php?mod=pessoal_2&search=2'>
							<div class='panel-body'>
							<br>
								<div class='row'>
									<div class='col-md-12'>
										<strong>Bem-Vindo </strong>". utf8_encode($row->NOME_COMP) ."!<br> Por favor insira a <b>palavra-passe</b>.
									</div>
								</div>
								<div class='row' style='margin-top: 5px;'>
									<div class='col-md-3'>
										<input class='form-control' name='password' type='password' required>
									</div>
								</div>
								<br>
							</div>
							<div class='panel-footer clearfix'>
								<button type='submit' name='submit' class='btn btn-primary pull-right'> 	
									<span class='glyphicon glyphicon-log-in' aria-hidden='true'></span>
									Entrar
								</button>
								<a href='index.php?mod=pessoal' class='btn btn-default pull-right' style='margin-right: 10px;'> 
									<span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span>
									Voltar
								</a>
								<a href='index.php?mod=rec_password' type='button' class='btn btn-default pull-right' style='margin-right: 10px;'> 	
									<span class='glyphicon glyphicon-lock' aria-hidden='true'></span>
									Recuperar a palavra-passe
								</a>
							</div>
						</form>
					</div>
				";
			}
		}else{
			echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=pessoal_2&m=1'>";
		}
	}
?>