
<table class="table table-striped table-codensed table-bordered" style="font-soze:12px">
	<thead>
	<tr>
		<th>#</th>
		<th>Fecha</th>
		<th>RBD</th>
		<th>Colegio</th>
		<th>Monto Cotizado</th>
		<th>Fecha de Cierre</th>
		<th>% de cierre</th>
		<th>Estado</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($cotizaciones as $c): ?>
		<tr>
		<td><?= $c['id'] ?></td>
		<td><?= $c['fecha'] ?></td>
		<td><?= $c['rbd'] ?></td>
		<td><?= $c['colegio'] ?></td>
		<td>$ <?= number_format($c['total'],0, ',', '.') ?></td>
		<td><?= $c['fecha_cierre'] ?></td>
		<td><?= $c['porcentaje_cierre'] ?>% </td>
		<td><div class="badge badge-info">P</div></td>
		<td>
			<a class="btn btn-succes" href="<?= base_url() ?>clientes/cotizacion_pdf/<?= $c['id'] ?>" target="_new"><i class="icon-search"></i></a> 
			<button class="btn btn-succes"><i class="icon-pencil"></i></button> 
			<button class="btn btn-succes"><i class="icon-trash"></i></button> 

		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>