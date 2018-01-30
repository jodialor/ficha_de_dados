<?php
//if($_GET['search']==1){
//	$_SESSION[nif]=$_POST[nif];
//	$res = mysql_query("select * from dbo_tab_funcionarios where NIF = $_POST[nif]");
//	$num = mysql_num_rows($res);
//	if($num>0){
//		$row = mysql_fetch_object($res);
//	}else{
//		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=pessoal_2&m=1'>";
//	}
//}

if($_GET['search']==2){
	$nif = $_SESSION[nif];
	$res1 = mysql_query("select PASSWORD from dbo_tab_funcionarios where NIF = $nif");
	$row1 = mysql_fetch_object($res1);
	if($_POST[password] == $row1->PASSWORD){
		$res = mysql_query("select * from dbo_tab_funcionarios where NIF = $nif");
		$row = mysql_fetch_object($res);
		$_SESSION[id_funcionario] = $row->ID_FUNCIONARIO;
	}else{
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=pessoal&m=5'>";
		return;
	}
}
if($_GET['search']==3){
	$nif = $_SESSION[nif];
	$res = mysql_query("select * from dbo_tab_funcionarios where NIF = $nif");
	$row = mysql_fetch_object($res);
	$_SESSION[id_funcionario] = $row->ID_FUNCIONARIO;
}

if($_GET['save']==1){

	if(!empty($_POST['COD_POSTAL'])){
		$postcode = $_POST['COD_POSTAL'];
		$codechunks = explode("-", $postcode);
	}else{
		$codechunks[0] = 0;
		$codechunks[1] = 0;
	}
	//1º Ao guardar, tem de verificar se já existe o nif
	$res = mysql_query("select * from dbo_tab_funcionarios where NIF = $_SESSION[nif]");
	$num = mysql_num_rows($res);
	$NOME_COMP = utf8_decode($_POST[NOME_COMP]);
	$CGA = utf8_decode($_POST[CGA]);
	$MORADA = utf8_decode($_POST[MORADA]);
	$LOCALIDADE  = utf8_decode($_POST[LOCALIDADE]);
	$DESTRITO = utf8_decode($_POST[DESTRITO]);
	$FREGUESIA = utf8_decode($_POST[FREGUESIA]);
	$TEL = utf8_decode($_POST[TEL]);
	$TLM = utf8_decode($_POST[TLM]);
	$EMAIL = utf8_decode($_POST[EMAIL]);
	$BI = utf8_decode($_POST[BI]);
	$DATA_VALIDADE = utf8_decode($_POST[DATA_VALIDADE]);
	$NISS = utf8_decode($_POST[NISS]);
	$ADSE = utf8_decode($_POST[ADSE]);
	$NIB = utf8_decode($_POST[NIB]);
	$BANCO = utf8_decode($_POST[BANCO]);
	$COD_RECRUTAMENTO = utf8_decode($_POST[COD_RECRUTAMENTO]);
	$ESCOLA_TITULAR = utf8_decode($_POST[ESCOLA]);

	$date_regex = "/[0-9]{2}\-[0-9]{2}\-[0-9]{4}/";
	if ((preg_match($date_regex, $_POST[DATA_NASC], $teste))==false) {
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=pessoal_2&search=2&m=3'>";
	}
	if ((preg_match($date_regex, $_POST[DATA_VALIDADE], $teste))==false) {
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=pessoal_2&search=2&m=3'>";
	}
	if ((preg_match($date_regex, $_POST[INICIO_FUNCOES], $teste))==false) {
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=pessoal_2&search=2&m=3'>";
	}
	$myDateTime1 = DateTime::createFromFormat('d-m-Y', $_POST[DATA_NASC]);
	$DATA_NASC = $myDateTime1->format('Y-m-d');
	$myDateTime2 = DateTime::createFromFormat('d-m-Y', $_POST[DATA_VALIDADE]);
	$DATA_VALIDADE = $myDateTime2->format('Y-m-d');
	$myDateTime3 = DateTime::createFromFormat('d-m-Y', $_POST[INICIO_FUNCOES]);
	$INICIO_FUNCOES = $myDateTime3->format('Y-m-d');

	if($num>0){
		//2º Caso isso se confirme, o registo é alterado onde com base no nif
		$res2 = mysql_query("UPDATE dbo_tab_funcionarios SET DATA_UPDATE=CURDATE(), COD_POSTAL='$codechunks[0]', IND_CODPOSTAL='$codechunks[1]',NOME_COMP='$NOME_COMP', NUM_FUNCIONARIO=$_POST[NUM_FUNCIONARIO], CGA='$CGA', MORADA='$MORADA', LOCALIDADE = '$LOCALIDADE', DESTRITO='$DESTRITO', ID_MUNICIPIO='$_POST[MUNICIPIO]', FREGUESIA='$FREGUESIA', DATA_NASC='$DATA_NASC', TEL='$TEL', TLM='$TLM', EMAIL='$EMAIL', ID_ESTADO_CIVIL='$_POST[EST_CIVIL]', NUM_DEPENDENTES=$_POST[NUM_DEPENDENTES], BI='$BI', DATA_VALIDADE='$DATA_VALIDADE', NISS='$NISS', ADSE='$ADSE', NIB='$NIB', BANCO='$BANCO', ID_HABLITERARIA='$_POST[HABLITERARIA]', ID_CATEGORIA='$_POST[CATEGORIA]', INICIO_FUNCOES='$INICIO_FUNCOES', COD_RECRUTAMENTO='$COD_RECRUTAMENTO', ID_SITUACAO='$_POST[SITUACAO_PROF]', ID_ESCOLA_TITULAR='$_POST[lista]',ID_TIPO_FUNC=1, ESCOLA_TITULAR='$ESCOLA_TITULAR' WHERE NIF = $_SESSION[nif]");
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_escolas'>";
	}else{
		//3º Senão, é criado um novo registo.
		$res3 = mysql_query("INSERT INTO dbo_tab_funcionarios(NIF, DATA_REG, DATA_UPDATE, NUM_FUNCIONARIO, NOME_COMP, MORADA, COD_POSTAL, IND_CODPOSTAL, LOCALIDADE, DESTRITO, ID_MUNICIPIO, FREGUESIA, BANCO, ID_ESCOLA_TITULAR, COD_RECRUTAMENTO, INICIO_FUNCOES, TEL, TLM, EMAIL, DATA_NASC, ID_ESTADO_CIVIL, ID_SITUACAO, ID_HABLITERARIA, ID_CATEGORIA, BI, DATA_VALIDADE, NIB, NISS, ADSE, CGA, NUM_DEPENDENTES, ID_TIPO_FUNC, ESCOLA_TITULAR, ENVIADO, PASSWORD) VALUES ($_SESSION[nif], CURDATE(), CURDATE(), $_POST[NUM_FUNCIONARIO], '$NOME_COMP', '$MORADA', '$codechunks[0]', '$codechunks[1]', '$LOCALIDADE', '$DESTRITO', '$_POST[MUNICIPIO]', '$FREGUESIA', '$BANCO', '$_POST[lista]', '$COD_RECRUTAMENTO', '$INICIO_FUNCOES', '$TEL', '$TLM', '$EMAIL', '$DATA_NASC', '$_POST[EST_CIVIL]', '$_POST[SITUACAO_PROF]', '$_POST[HABLITERARIA]', '$_POST[CATEGORIA]', '$BI', '$DATA_VALIDADE', '$NIB', '$NISS', '$ADSE', '$CGA', $_POST[NUM_DEPENDENTES], 1, '$ESCOLA_TITULAR', 0, '')");

		function enviar_mail(){

			$res = mysql_query("select * from dbo_tab_funcionarios where NIF = $_SESSION[nif]");
			$row = mysql_fetch_object($res);

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

			$to      = $row->EMAIL;
			$subject = 'Palavra-passe de acesso ao sistema';

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html' . "\r\n";
			$headers .= 'From: DSEAM <informatica.dseam@gmail.com>'."\r\n".
				'Reply-To: JP <al213022@epcc.pt>'."\r\n" .
				'X-Mailer: PHP/' . phpversion();

			$message = '<html><body>';
				$message .= '<p style="line-height: 190%">';
					$message .= 'Caro(a) ' . $row->NOME_COMP . ',<br> Os seus dados de acesso são os seguintes: ';
					$message .= '<br><b>NIF: </b>' . $row->NIF . '<br>';
					$message .= '<b>Palavra-passe: ' . $pass . '</b><br><br>';
					$message .= 'Poderá alterar a sua palavra-passe na opção "Alterar Palavra-Passe".<br>';
					$message .= 'Cumprimentos,<br> DSEAM';
			$message .= '</body></html>';

			mail($to, $subject, $message, $headers);
		}
		enviar_mail();
		echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=lista_escolas'>";
	}

}

echo"
<div class='panel panel-info'>
	<div class='panel-heading'>
		<h3 class='panel-title'><strong>Dados Pessoais</strong></h3>
	</div>
	<form role='form' enctype='multipart/form-data' action='index.php?mod=pessoal_2&save=1' method='POST'>
		<div class='panel-body'>
			<div class='row'>
				<!-- NOME COMPLETO -->
				<div class='col-md-6'>
					<strong>Nome Completo*</strong>
					<input class='form-control' value='".utf8_encode($row->NOME_COMP)."' name='NOME_COMP' required>
				</div>
				<!-- Nº MECANOGRÁFICO -->
				<div class='col-md-3'>
					<strong>Número mecanográfico*</strong>
					<input class='form-control' type='text' value='$row->NUM_FUNCIONARIO' id='num_func' name='NUM_FUNCIONARIO' required>
				</div>
				<div class='col-md-3'>
					<strong>CGA</strong>
					<input class='form-control' value='".utf8_encode($row->CGA)."' id='cga' name='CGA' >
				</div>
			</div>
			<!-- Nova Linha -->
			<div class='row margin-row'>
				<!-- MORADA -->
				<div class='col-md-6'>
					<strong>Morada*</strong>
					<input class='form-control' value='".utf8_encode($row->MORADA)."' name='MORADA' required>
				</div>
				<!-- CÓDIGO POSTAL -->
				<div class='col-md-3'>
					<strong>Código Postal*</strong>";
					if(empty($row->COD_POSTAL)){
						echo"<input class='form-control' name='COD_POSTAL' required>";
					}else{
						echo"<input class='form-control' value='$row->COD_POSTAL-$row->IND_CODPOSTAL' name='COD_POSTAL' required>";
					}

				echo"
				</div>
				<!-- LOCALIDADE -->
				<div class='col-md-3'>
					<strong>Localidade*</strong>
					<input class='form-control' value='".utf8_encode($row->LOCALIDADE)."' name='LOCALIDADE' required>
				</div>
			</div>
			<!-- Nova Linha -->
			<div class='row margin-row'>
				<!-- Freguesia -->
				<div class='col-md-3'>
					<strong>Distrito*</strong>
					<input class='form-control' value='".utf8_encode($row->DESTRITO)."' name='DESTRITO' required>
				</div>
				<!-- CONCELHO -->
				<div class='col-md-3'>
					<strong>Município*</strong>
					<select class='form-control' name='MUNICIPIO' required>
						<option value=''>-selecione-</option>";
						$res2=mysql_query("Select * from dbo_tab_municipios ORDER BY MUNICIPIO");
						while ($row2 = mysql_fetch_object($res2)){
							if($row2->ID_MUNICIPIO == $row->ID_MUNICIPIO){
								echo"<option value='$row2->ID_MUNICIPIO' selected>".utf8_encode($row2->MUNICIPIO)."</option>";
							}else{
								echo"<option value='$row2->ID_MUNICIPIO'>".utf8_encode($row2->MUNICIPIO)."</option>";
							}
						}
						mysql_free_result($res);
				echo"
					</select>
				</div>
				<!-- DISTRITO -->
				<div class='col-md-3'>
					<strong>Freguesia*</strong>
					<input class='form-control' value='".utf8_encode($row->FREGUESIA)."' name='FREGUESIA' required>
				</div>
				<!-- DATA DE NASCIMENTO -->
				<div class='col-md-3'>
					<strong>Data Nascimento*</strong>";
					$DATA_NASC = $row->DATA_NASC;
					if(($DATA_NASC=='0000-00-00') || !isset($row->DATA_NASC)){
						$DATA_NASC = '';
					}else{
						$myDateTimei = DateTime::createFromFormat('Y-m-d', $row->DATA_NASC);
						$DATA_NASC = $myDateTimei->format('d-m-Y');
					}
					echo"<input class='form-control' type='text' value='$DATA_NASC' name='DATA_NASC' placeholder='dd-mm-aaaa' required>
				</div>
			</div>
			<!-- Nova Linha -->
			<div class='row margin-row'>
				<!-- Nº TELEFONE -->
				<div class='col-md-3'>
					<strong>Telefone</strong>
					<input class='form-control' type='text' maxlength='9' id='tel' value='".utf8_encode($row->TEL)."' name='TEL' >
				</div>
				<!-- Nº TELEMOVEL -->
				<div class='col-md-3'>
					<strong>Telemóvel*</strong>
					<input class='form-control' type='text' maxlength='9' id='tlm' value='".utf8_encode($row->TLM)."' name='TLM' required>
				</div>
				<!-- EMAIL -->
				<div class='col-md-6'>
					<strong>Email*</strong>
					<input class='form-control' value='".utf8_encode($row->EMAIL)."' name='EMAIL' required>
				</div>
			</div>
			<!-- Nova Linha -->
			<div class='row margin-row'>
				<div class='col-md-3'>
					<strong>Estado Civil*</strong>
					<select class='form-control' name='EST_CIVIL' required>
						<option value=''>-selecione-</option>";
						$res2=mysql_query("Select * from dbo_tab_estado_civil ORDER BY ESTADO_CIVIL");
						while ($row2 = mysql_fetch_object($res2)){
							if($row2->ID_ESTADO_CIVIL == $row->ID_ESTADO_CIVIL){
								echo"<option value='$row2->ID_ESTADO_CIVIL' selected>".utf8_encode($row2->ESTADO_CIVIL)."</option>";
							}else{
								echo"<option value='$row2->ID_ESTADO_CIVIL'>".utf8_encode($row2->ESTADO_CIVIL)."</option>";
							}
						}
						mysql_free_result($res);
						echo"
					</select>
				</div>
				<!-- Nº DEPENDENTES -->
				<div class='col-md-3'>
					<strong>Nº Dependentes*</strong>
					<input class='form-control' type='text' id='dependentes' value='".utf8_encode($row->NUM_DEPENDENTES)."' name='NUM_DEPENDENTES' required>
				</div>
				<!-- Nº Identificação Civil -->
				<div class='col-md-3'>
					<strong>Nº Identificação Civil (BI/CC)*</strong>
					<input class='form-control' type='text' id='bi' value='".utf8_encode($row->BI)."' name='BI' required>
				</div>
				<!-- DATA DE EMISSÃO/VALIDADE -->
				<div class='col-md-3'>
					<strong>Data de Validade*</strong>";
					$DATA_VALIDADE = $row->DATA_VALIDADE;
					if(($DATA_VALIDADE=='0000-00-00') || !isset($row->DATA_VALIDADE)){
						$DATA_VALIDADE = '';
					}else{
						$myDateTimei = DateTime::createFromFormat('Y-m-d', $row->DATA_VALIDADE);
						$DATA_VALIDADE = $myDateTimei->format('d-m-Y');
					}
					echo"<input class='form-control' type='text' value='$DATA_VALIDADE' name='DATA_VALIDADE'  placeholder='dd-mm-aaaa' required>
				</div>
			</div>
			<!-- Nova Linha -->
			<div class='row margin-row'>
				<div class='col-md-3'>
					<strong>Nº NISS</strong>
					<input class='form-control' type='text' id='niss' name='NISS' value='".utf8_encode($row->NISS)."' >
				</div>
				<!-- Nº DEPENDENTES -->
				<div class='col-md-3'>
					<strong>Nº ADSE</strong>
					<input class='form-control' type='text' id='adse' name='ADSE' value='".utf8_encode($row->ADSE)."' >
				</div>
				<!-- Nº Identificação Civil -->
				<div class='col-md-3'>
					<strong>IBAN</strong>
					<input class='form-control' type='text' id='nib' name='NIB' value='".utf8_encode($row->NIB)."' >
				</div>
				<!-- DATA DE EMISSÃO/VALIDADE -->
				<div class='col-md-3'>
					<strong>Banco</strong>
					<input class='form-control' type='text' name='BANCO' value='".utf8_encode($row->BANCO)."' >
				</div>
			</div>
			<!-- Nova Linha -->
			<div class='row margin-row'>
				<div class='col-md-3'>
					<strong>Habilitação Académica*</strong>
					<select class='form-control' name='HABLITERARIA' required>
						<option value=''>-selecione-</option>";
						$res2=mysql_query("Select * from dbo_tab_habliterarias ORDER BY HABLITERARIA");
						while ($row2 = mysql_fetch_object($res2)){
							if($row2->ID_HABLITERARIA == $row->ID_HABLITERARIA){
								echo"<option value='$row2->ID_HABLITERARIA' selected>".utf8_encode($row2->HABLITERARIA)."</option>";
							}else{
								echo"<option value='$row2->ID_HABLITERARIA'>".utf8_encode($row2->HABLITERARIA)."</option>";
							}
						}
						echo"
					</select>
				</div>
				<!-- CATEGORIA/CARGO -->
				<div class='col-md-3'>
					<strong>Categoria/Cargo*</strong>
					<select class='form-control' name='CATEGORIA' required>
						<option value=''>-selecione-</option>";
						$res2=mysql_query("Select * from dbo_tab_categorias ORDER BY CATEGORIA");
						while ($row2 = mysql_fetch_object($res2)){
							if($row2->ID_CATEGORIA == $row->ID_CATEGORIA){
								echo"<option value='$row2->ID_CATEGORIA' selected>".utf8_encode($row2->CATEGORIA)."</option>";
							}else{
								echo"<option value='$row2->ID_CATEGORIA'>".utf8_encode($row2->CATEGORIA)."</option>";
							}
						}
						mysql_free_result($res);
						echo"
					</select>
				</div>";
				$INICIO_FUNCOES = $row->INICIO_FUNCOES;
				if(($INICIO_FUNCOES=='0000-00-00') || !isset($row->INICIO_FUNCOES)){
					$INICIO_FUNCOES = '';
				}else{
					$myDateTimei = DateTime::createFromFormat('Y-m-d', $row->INICIO_FUNCOES);
					$INICIO_FUNCOES = $myDateTimei->format('d-m-Y');
				}
				echo"<div class='col-md-3'>
					<strong>Início de Funções*</strong>
					<input class='form-control' type='text' name='INICIO_FUNCOES' value='$INICIO_FUNCOES' placeholder='dd-mm-aaaa' required>
				</div>
				<div class='col-md-3'>
					<strong>Código Recrutamento*</strong>
					<input class='form-control' type='text' value='".utf8_encode($row->COD_RECRUTAMENTO)."' name='COD_RECRUTAMENTO' required>
				</div>
			</div>
			<div class='row margin-row'>
				<!-- SITUAÇÃO PROFICIONAL -->
				<div class='col-md-3'>
					<strong>Situação Profissional*</strong>
					<select class='form-control' name='SITUACAO_PROF' required>
						<option value=''>-selecione-</option>";
						$res2=mysql_query("Select * from dbo_tab_situacoes_prof ORDER BY SITUACAO");
						while ($row2 = mysql_fetch_object($res2)){
							if($row2->ID_SITUACAO == $row->ID_SITUACAO){
								echo"<option value='$row2->ID_SITUACAO' selected>".utf8_encode($row2->SITUACAO)."</option>";
							}else{
								echo"<option value='$row2->ID_SITUACAO'>".utf8_encode($row2->SITUACAO)."</option>";
							}
						}
						mysql_free_result($res);
						echo"
					</select>
				</div>
				<div class='col-md-4'>
					<strong>Escola Titular*</strong>";
					echo"
					<select class='form-control' name='lista' id='lista' required>
					<option value=''>-selecione-</option>";
					$res2=mysql_query("Select * from dbo_tab_lista_escolas ORDER BY NOME_ESCOLA ASC");
					while ($row2 = mysql_fetch_object($res2)){
						if($row2->ID_LISTA_ESCOLAS == $row->ID_ESCOLA_TITULAR){
							echo"<option value='$row2->ID_LISTA_ESCOLAS' selected>".utf8_encode($row2->NOME_ESCOLA)."</option>";
						}else{
							echo"<option value='$row2->ID_LISTA_ESCOLAS'>".utf8_encode($row2->NOME_ESCOLA)."</option>";
						}

					}
					mysql_free_result($res);
					echo"
					</select>
				</div>
				<div class='col-md-5'>
					<strong>Outra Escola</strong>
					<input class='form-control' type='text' name='ESCOLA' id='outra_escola_campo' placeholder='Para indicar outra escola seleccione a opção \"OUTRA ESCOLA\"' value='".utf8_encode($row->ESCOLA_TITULAR)."' >
				</div>
			</div>
		</div>
		<div class='panel-footer clearfix'>
			<button type='submit' name='submit' class='btn btn-primary pull-right'>
				<span class='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span>
				Guardar e Continuar
				<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>
			</button>
			<a href='index.php?mod=pessoal' class='btn btn-default pull-right' style='margin-right: 10px;'>
				<span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span>
				Voltar
			</a>
			<a href='index.php?mod=change_pass' class='btn btn-default'>
				<span class='glyphicon glyphicon-lock' aria-hidden='true'></span>
				Alterar Palavra-passe
			</a>
		</div>
	</form>
</div>
";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script>
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

	onlyNum($("#num_func"));
	onlyNum($("#cga"));
	onlyNum($("#tel"));
	onlyNum($("#tlm"));
	onlyNum($("#dependentes"));
	onlyNum($("#bi"));
	onlyNum($("#niss"));
	onlyNum($("#adse"));
	onlyNum($("#nib"));
});

function onlyNum(id){
	id.keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
}
</script>
