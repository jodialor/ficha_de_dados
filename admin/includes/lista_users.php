<?php
if($_GET['delete']==1){
	$res = mysql_query("DELETE FROM `dbo_tab_utilizadores` WHERE ID_UTILIZADOR = $_GET[id]");
}
if($_GET['s']==1){
	if($_GET['a']==1){
		$res = mysql_query("UPDATE `dbo_tab_utilizadores` SET `EMAIL_SIMPLES`='0' WHERE ID_UTILIZADOR = $_GET[id]");
	}else{
		$res = mysql_query("UPDATE `dbo_tab_utilizadores` SET `EMAIL_SIMPLES`='1' WHERE ID_UTILIZADOR = $_GET[id]");
	}
}
if($_GET['s']==2){
	if($_GET['a']==1){
		$res = mysql_query("UPDATE `dbo_tab_utilizadores` SET `EMAIL_COMPLETO`='0' WHERE ID_UTILIZADOR = $_GET[id]");
	}else{
		$res = mysql_query("UPDATE `dbo_tab_utilizadores` SET `EMAIL_COMPLETO`='1' WHERE ID_UTILIZADOR = $_GET[id]");
	}
}
?>

<div class="row">
	<div class="col-xs-12">
	  <div class="box">
		<div class="box-body">
		  <table id="example1" class="table table-bordered table-striped">
			<thead>
			  <tr>
				<th>Utilizador</th>
				<th>Email</th>
				<th>Info. Simples</th>
				<th>Info. Completa</th>
				<th>Opções</th>
			  </tr>
			</thead>
			<tbody>
			<?php
				$res = mysql_query("SELECT * FROM dbo_tab_utilizadores");
				
				while($row = mysql_fetch_object($res)){
					echo"<tr>
						<td>"; 
							echo $row->UTILIZADOR;
						echo"</td>
						<td>";
							echo $row->EMAIL;
						echo"</td>
						<td>";
							if($row->EMAIL_SIMPLES == 1){
								echo"
								<a href='index.php?mod=lista_users&s=1&a=1&id=". $row->ID_UTILIZADOR ."' class='btn btn-xs btn-success'> 
									<span class='glyphicon glyphicon-envelope'></span>
									Sim
								</a>";
							}else{
								echo"
								<a href='index.php?mod=lista_users&s=1&a=2&id=". $row->ID_UTILIZADOR ."' class='btn btn-xs btn-danger'> 
									<span class='glyphicon glyphicon-envelope'></span>
									Não
								</a>";
							}
						echo"</td>
						<td>";
							if($row->EMAIL_COMPLETO == 1){
								echo"
								<a href='index.php?mod=lista_users&s=2&a=1&id=". $row->ID_UTILIZADOR ."' class='btn btn-xs btn-success'> 
									<span class='glyphicon glyphicon-envelope'></span>
									Sim
								</a>";
							}else{
								echo"
								<a href='index.php?mod=lista_users&s=2&a=2&id=". $row->ID_UTILIZADOR ."' class='btn btn-xs btn-danger'> 
									<span class='glyphicon glyphicon-envelope'></span>
									Não
								</a>";
							}
						echo"</td>
						<td style='text-align: center;'>
							<a href='index.php?mod=edit_user&id=". $row->ID_UTILIZADOR ."' class='btn btn-xs btn-warning'> 
								<span class='glyphicon glyphicon-pencil'></span>
								Editar
							</a>
							<a href='index.php?mod=lista_users&delete=1&id=". $row->ID_UTILIZADOR ."' class='btn btn-xs btn-danger'> 
								<span class='glyphicon glyphicon-trash'></span>
								Eliminar
							</a>";
						echo"
						</td>
					</tr>";
				}
			?>
			</tbody>
		  </table>
		  <a href="index.php?mod=reg_user" type="button" class="btn btn-success"><i class="fa fa-user-plus"></i> Registar novo Utilizador</a>
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
			}
			,
			"columnDefs":[{
			  "targets": 'no-sort',
			  "orderable": true,
			}],
			"order": [[ 0, "asc" ]]
		});	
	});
</script>
