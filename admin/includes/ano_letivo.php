<?php

	if($_GET['delete']==1){
		$search = mysql_query("SELECT * from dbo_tab_escolas where ID_ANO_LETIVO = $_GET[id] limit 1");
		$num_rows = mysql_num_rows($search);

		if ($num_rows == 0) {
			$res = mysql_query("DELETE FROM `dbo_tab_ano_letivo` WHERE ID_ANO_LETIVO = $_GET[id]");
		}else if ($num_rows == 1 && !empty($_GET['id'])){
			echo '<div class="alert alert-warning">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  <a data-dismiss="alert"><strong>Atenção!</strong> Não é possível apagar um ano letivo que já tenha escolas registadas!</a>
			</div>';
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
				<th>Ano Letivo</th>
				<th>Atual</th>
				<th>Opções</th>
			  </tr>
			</thead>
			<tbody>
			<?php
				$res = mysql_query("SELECT * FROM dbo_tab_ano_letivo");

				while($row = mysql_fetch_object($res)){ ?>
					<tr>
						<td> <?php echo $row->ANO_LETIVO; ?> </td>
						<td>
							<?php
							$isChecked = ($row->ANO_ATUAL) ? "checked" : "";
							echo '<input type="checkbox" name="ano_atual" value="" disabled '.$isChecked.'>';
							?>
						</td>
						<td style='text-align: center;'>
							<a href='index.php?mod=edit_ano&id=<?php echo $row->ID_ANO_LETIVO; ?>' class='btn btn-xs btn-warning'>
								<span class='glyphicon glyphicon-pencil'></span>
								Editar
							</a>
							<a href='index.php?mod=ano_letivo&delete=1&id=<?php echo $row->ID_ANO_LETIVO; ?>' class='btn btn-xs btn-danger'>
								<span class='glyphicon glyphicon-trash'></span>
								Eliminar
							</a>
						</td>
					</tr>
				<?php }	?>
			</tbody>
		  </table>
		  <a href="index.php?mod=reg_ano" type="button" class="btn btn-success"><i class="fa fa-calendar-plus-o"></i> Novo Ano Letivo</a>
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
			  "orderable": false,
			}],
			"order": [[ 0, "desc" ]]
		});
	});
</script>
