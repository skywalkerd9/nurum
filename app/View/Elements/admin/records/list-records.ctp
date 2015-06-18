<div class="col-lg-12">
	<h2>Listado de Registros Creados</h2>
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>#</th>
				<th>Creado Por</th>
				<th>Record</th>
				<th>Fecha de Creación</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=1; foreach ($records as $key=>$value):?>
			<tr class="odd gradeX">
				<td style="text-align: center;"><?php echo $i;?></td>
				<td><?php echo $records[$key]['User']['first_name'];?></td>
				<td style="text-align: center;"><?php echo $records[$key]['Record']['record'];?></td>
				<td style="text-align: center;"><?php echo $records[$key]['Record']['created'];?></td>
				<td style="text-align: center;"><a href="<?php echo $this->Html->url(array('controller' => "Records", 'action' => "deleteRecord", $records[$key]['Record']['id'],'admin' => false));?>" class="delete-record">X</a></td>
			</tr>			
			<?php $i++; endforeach;?>
		</tbody>
	</table>
</div>