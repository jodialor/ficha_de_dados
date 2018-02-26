<div class="row">
	<div class="col-xs-12">
	  <div class="box">
			<div class="box-body">
			  <table id="example1" class="table table-bordered table-striped">
					<thead>
					  <tr>
							<th>Nome</th>
							<th>Escola</th>
							<th>Municipio</th>
							<th>Ano Letivo</th>
							<th style="width: 90px;">Opções</th>
					  </tr>
					</thead>
					<tbody>
				<?php
					$res = mysql_query("SELECT dbo_tab_escolas.*, dbo_tab_funcionarios.NOME_COMP, dbo_tab_funcionarios.DATA_UPDATE, dbo_tab_funcionarios.ENVIADO, dbo_tab_municipios.MUNICIPIO, dbo_tab_ano_letivo.ANO_LETIVO, dbo_tab_lista_escolas.NOME_ESCOLA FROM `dbo_tab_escolas`, `dbo_tab_funcionarios`, dbo_tab_municipios, dbo_tab_ano_letivo, dbo_tab_lista_escolas WHERE dbo_tab_escolas.ID_FUNCIONARIO = dbo_tab_funcionarios.ID_FUNCIONARIO AND dbo_tab_escolas.ID_MUNICIPIO = dbo_tab_municipios.ID_MUNICIPIO AND dbo_tab_escolas.ID_ANO_LETIVO = dbo_tab_ano_letivo.ID_ANO_LETIVO AND dbo_tab_escolas.ID_LISTA_ESCOLAS = dbo_tab_lista_escolas.ID_LISTA_ESCOLAS ORDER BY DATA_UPDATE DESC");

					while($row = mysql_fetch_object($res)){
						echo"<tr>
							<td>";
								if(empty($row->NOME_COMP)){
									echo"N/A";
								}else{
									echo utf8_encode($row->NOME_COMP);
								}
							echo"</td>
							<td>";
								if(empty($row->ID_LISTA_ESCOLAS)){
									echo"N/A";
								}else{
									if($row->ID_LISTA_ESCOLAS == 374){
										echo utf8_encode($row->ESCOLA);
									}else{
										echo utf8_encode($row->NOME_ESCOLA);
									}
								}
							echo"</td>
							<td>";
								if(empty($row->ID_MUNICIPIO)){
									echo"N/A";
								}else{
									echo utf8_encode($row->MUNICIPIO);
								}
							echo"</td>
							<td>";
								if(empty($row->ID_ANO_LETIVO)){
									echo"N/A";
								}else{
									echo utf8_encode($row->ANO_LETIVO);
								}
							?>
							<td style='text-align: center; vertical-align: middle;'>
								<a href='index.php?mod=dados&id=<?php echo $row->ID_FUNCIONARIO?>' class='btn btn-xs btn-primary'>
									<span class='glyphicon glyphicon-search'></span>
								</a>
								<a href='index.php?mod=edit_pessoal&search=1&a=2&id=<?php echo $row->ID_FUNCIONARIO?>' class='btn btn-xs btn-warning'>
									<span class='glyphicon glyphicon-pencil'></span>
								</a>
							<?php
								if($row->ENVIADO == 0){
							?>
									<a href='index.php?mod=finish&id=<?php echo $row->ID_FUNCIONARIO?>' class='btn btn-xs btn-info'>
										<span class='glyphicon glyphicon-envelope'></span>
									</a>
							<?php
								} else{
							?>
									<a href='index.php?mod=finish&id=<?php echo $row->ID_FUNCIONARIO?>' class='btn btn-xs btn-success'>
										<span class='glyphicon glyphicon-envelope'></span>
									</a>
							<?php
								}
							?>
								<a href='index.php?mod=send_pass&b=2&id=<?php echo $row->ID_FUNCIONARIO?>' class='btn btn-xs btn-danger'>
									<span class='glyphicon glyphicon-lock'></span>
								</a>
							</td>
						</tr>
				<?php
					}
				?>
					</tbody>
			  </table>
			</div><!-- /.box-body -->
	  </div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->

<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>

<script src="bootstrap/js/bootstrap.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>

<script src="plugins/fastclick/fastclick.min.js"></script>

<script src="dist/js/app.min.js"></script>

<script src="dist/js/demo.js"></script>

<script>
	$(function () {
		$('#example1').DataTable({
			"language": {
			"url": "json/portuguese.json"
			},
			"ordering": true
		});
	});
</script>
