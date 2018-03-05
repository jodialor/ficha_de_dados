<?php
	if($_GET['delete']==1){
		$search = mysql_query("SELECT * from dbo_tab_primeiro_ciclo where ID_ANO_ESCOLAR = $_GET[id] limit 1");
		$num_rows = mysql_num_rows($search);

		if ($num_rows == 0) {
			$res = mysql_query("DELETE FROM `dbo_tab_anos_escolares` WHERE ID_ANO_ESCOLAR = $_GET[id]");
		}else if ($num_rows == 1 && !empty($_GET['id'])){
			echo '<div class="alert alert-warning">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <a data-dismiss="alert"><strong>Atenção!</strong> Não é possível apagar um ano escolar que já tenha registos efectuados!</a>
			</div>';
		}
	}
?>
<div class="row">
	<div class="col-xs-12">
	  <div class="box">
			<div class="box-body">
			  <table id="tbl_anos_esc" class="table table-bordered table-striped">
				<thead>
				  <tr>
						<th>Ref.</th>
						<th>Ano Escolar</th>
						<th>Opções</th>
				  </tr>
				</thead>
				<tbody>
				<?php
					$res = mysql_query("SELECT * FROM dbo_tab_anos_escolares");

					while($row = mysql_fetch_object($res)){ ?>
						<tr>
							<td> <?php echo $row->REFERENCIA; ?> </td>
							<td> <?php echo $row->ANO_ESCOLAR; ?> </td>
							<td style='text-align: center;'>
								<a href='index.php?mod=edit_ano_esc&id=<?php echo $row->ID_ANO_ESCOLAR; ?>' class='btn btn-xs btn-warning'>
									<span class='glyphicon glyphicon-pencil'></span>
									Editar
								</a>
								<a href='index.php?mod=ano_escolar&delete=1&id=<?php echo $row->ID_ANO_ESCOLAR; ?>' class='btn btn-xs btn-danger'>
									<span class='glyphicon glyphicon-trash'></span>
									Eliminar
								</a>
							</td>
						</tr>
					<?php }	?>
					</tbody>
		  	</table>
		  	<a href="index.php?mod=reg_ano_esc" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Novo Ano Escolar</a>
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
		$('#tbl_anos_esc').DataTable({
			"language": {
			"url": "json/portuguese.json"
			}
			,
			"columnDefs":[{
			  "targets": 'no-sort',
			  "orderable": false,
			}],
			"order": [[ 0, "asc" ]]
		});
	});
</script>
