<div id="cartera">
<table class="table table-bordered table-condensed table-striped table-hover">
<?php foreach($datos as $d): ?>
	<?php $col = $d['datos_colegio'][0]; ?>
<tr>
	<td><?= $col['NOMBRE'] ?></td>
	<td><?= $col['DEPENDENCIA'] ?></td>
	<td><?= $col['REGION'] ?></td>
	<td><?= $col['COMUNA'] ?></td>
	<td><?= $col['ALUMNOS_SEP'] ?></td>
	<?php $porcentaje =  number_format((($col['ALUMNOS_SEP'] / $col['MATRICULA'])*100),0); ?>
	<td><?=	$porcentaje;  ?>% </td>
	<?php $fondos_disponibles = (($col['ALUMNOS_SEP']*35000)/2);  ?>
	<td><?= number_format($fondos_disponibles, 0); ?></td>
	<?php $ges = end($d['datos_gestiones']); ?>

	<td><?= date("d/m/Y",$ges['FECHA_GESTION']);  ?></td>
	<td><?= $ges['gestion'];  ?></td>
	<td><?= $ges['NOM_EJECUTIVO'];  ?></td>
	<td>
		
	</td>
</tr>
<?php endforeach; ?>
</table>
<pre>
<?php print_r($gestiones); ?>
</pre>
</div>
