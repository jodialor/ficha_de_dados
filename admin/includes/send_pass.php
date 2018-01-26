<?php
if($_GET['new']==1){
	$res = mysql_query("UPDATE dbo_tab_funcionarios SET EMAIL = '$_POST[email]' WHERE ID_FUNCIONARIO = $_GET[id]");

	function enviar_mail(){
		
		$res = mysql_query("SELECT NOME_COMP, EMAIL FROM dbo_tab_funcionarios where ID_FUNCIONARIO = $_GET[id]");
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
			
			$update = mysql_query("UPDATE dbo_tab_funcionarios SET PASSWORD='$pass' WHERE ID_FUNCIONARIO = $_GET[id]");
			
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
					$message .= 'Para voltar a aceder à  pagina por favor clique na ligação abaixo.<br>';
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
	
	if($_GET['b']==1){
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_func'>";
	}else{
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=func_filter'>";
	}
}
?>
<br>
<br>
<?php
echo"
<form action='index.php?mod=send_pass&b=1&id=". $_GET[id] ."&new=1' method='POST'>
";
?>
	<div class="row">
		<div class="col-xs-4">
		  <div class="form-group has-feedback">
			<input type="email" class="form-control" name="email" placeholder="E-mail">
			<span class="fa fa-envelope form-control-feedback"></span>
		  </div>
		</div>
	</div>
	<div class="row">
	  <div class="col-xs-2">
		<button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-floppy-o"></i> Guardar Email</button>
	  </div>
	  <?php
		if($_GET['b']==1){
		echo"
			<a href='index.php?mod=lista_func' type='button' class='btn btn-default btn-flat'><i class='fa fa-chevron-left'></i> Voltar</a>
		";
		}else{
			echo"
				<a href='index.php?mod=func_filter' type='button' class='btn btn-default btn-flat'><i class='fa fa-chevron-left'></i> Voltar</a>
			";	
		}
		
	  ?>
	</div>
</form>


<!-- jQuery 2.1.4 -->
<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>

<script>
  $(function () {
	$('input').iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	  radioClass: 'iradio_square-blue',
	  increaseArea: '20%' // optional
	});
  });
</script>