<div class="row">
	<div class="col-xs-12">
	  <div class="box">
			<div class="box-body">
			  <table id="example1" class="table table-bordered table-striped">
					<thead>
					  <tr>
					    <th>ID</th>
							<th>Número</th>
							<th>Nome</th>
							<th>NIF</th>
							<th>E-mail</th>
							<th>Telemóvel</th>
							<th style="width: 90px;">Opções</th>
					  </tr>
					</thead>
					<tbody>
				<?php
					$res = mysql_query("SELECT ID_FUNCIONARIO, ENVIADO, NUM_FUNCIONARIO, NOME_COMP, NIF, EMAIL, TEL FROM dbo_tab_funcionarios  ORDER BY DATA_UPDATE DESC");

					while($row = mysql_fetch_object($res)){
							echo"<tr>
							<td>";
								echo $row->ID_FUNCIONARIO;
							echo"</td>
							<td>";
								if(empty($row->NUM_FUNCIONARIO)){
									echo"N/A";
								}else{
									echo $row->NUM_FUNCIONARIO;
								}
							echo"</td>
							<td>";
								if(empty($row->NOME_COMP)){
									echo"N/A";
								}else{
									echo utf8_encode($row->NOME_COMP);
								}
							echo"</td>
							<td>";
								if(empty($row->NIF)){
									echo"N/A";
								}else{
									echo $row->NIF;
								}
							echo"</td>
							<td>";
								if(empty($row->EMAIL)){
									echo"N/A";
								}else{
									echo $row->EMAIL;
								}
							echo"</td>
							<td>";
								if(empty($row->TEL)){
									echo"N/A";
								}else{
									echo $row->TEL;
								}
							echo"</td>";
						?>
							<td style='text-align: center; vertical-align: middle;'>
								<a href='index.php?mod=dados&id=<?php echo $row->ID_FUNCIONARIO?>' class='btn btn-xs btn-primary'>
									<span class='glyphicon glyphicon-search'></span>
								</a>
								<a href='index.php?mod=edit_pessoal&search=1&a=1&id=<?php echo $row->ID_FUNCIONARIO?>' class='btn btn-xs btn-warning'>
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
								<a href='index.php?mod=send_pass&b=1&id=<?php echo $row->ID_FUNCIONARIO?>' class='btn btn-xs btn-danger'>
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
			"ordering": true,
			"order": [ 0, 'desc' ]
		});
	});
</script>
