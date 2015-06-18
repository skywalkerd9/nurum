<?php $list = $records[0]['Record'];?>
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
			<?php $i=1; foreach ($list as $key=>$value):?>
			<tr class="odd gradeX">
				<td style="text-align: center;"><?php echo $i;?></td>
				<td><?php echo $records[0]['User']['first_name'];?></td>
				<td style="text-align: center;"><?php echo $list[$key]['record'];?></td>
				<td style="text-align: center;"><?php echo $list[$key]['created'];?></td>
				<td style="text-align: center;"><a href="<?php echo $this->Html->url(array('controller' => "Records", 'action' => "deleteRecord", $list[$key]['id'],'admin' => false));?>">X</a></td>
			</tr>			
			<?php $i++; endforeach;?>
		</tbody>
	</table>
</div>