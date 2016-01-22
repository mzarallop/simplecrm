<div class="row-fluid">
	<div class="span12">
	<div id="demo"></div>
		<?php
			$semana4 = date("W")-1;
			$semana3 = $semana4-1;
			$semana2 = $semana3-1;
			$semana1 = $semana2-1;
		?>
		<table id="resumen_ejecutivos" class="table table-condensed table-striped table-bordered" style="font-size:11px;">
		<thead>
			<tr>
				<th>ID</th>
				<th>NOMBRE</th>
				<th>ANEXO</th>
				<th><a href="#" title="Cartera Asignada">CA</a></th>
				<th>SG</th>
				<th>AVG_S</th>
				<th>SG_PS</th>
				<th>SG_MU</th>
				<th>% SG</th>
				<th>TG_S1</th>
				<th>TG_S2</th>
				<th>TG_S3</th>
				<th>TG_S4</th>
				<th>AVG_G</th>
				<th>TC_S1</th>
				<th>TC_S2</th>
				<th>TC_S3</th>
				<th>TC_S4</th>
				<th>AVG_C</th>
				<th>CALL1</th>
				<th>CALL2</th>
				<th>CALL3</th>
				<th>CALL4</th>
				<th>AVG_C</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($reporte as $r): ?>
			<tr>
				<td><?= $r['resumen']['idv']; ?></td>
				<td><?= $r['resumen']['nombre_vendedor']; ?></td>
				<td style="background-color:rgba(0, 196, 255, 0.17);text-align:center;"><?= $r['resumen']['anexo']; ?></td>
				<td><?= $r['resumen']['cartera']; ?></td>
				<td><?= $r['resumen']['pendientes']; ?></td>
				<td><?= $r['resumen']['avg_sep']; ?></td>
				<td><?= $r['resumen']['sg_psub']; ?></td>
				<td><?= $r['resumen']['sg_muni']; ?></td>
				<?php
					if($r['resumen']['incumplimiento']<=15){
						$color = 'rgba(4, 255, 4, 0.42)';
					}elseif($r['resumen']['incumplimiento']>15&&$r['resumen']['incumplimiento']<=30){
						$color = 'rgba(255, 255, 0, 0.54)';
					}elseif($r['resumen']['incumplimiento']>30){
						$color = 'rgba(255, 0, 0, 0.37)';
					}
				?>
				<td style="background-color:<?= $color ?>"><?= $r['resumen']['incumplimiento']; ?></td>
				<td style="background-color:rgba(255, 255, 0, 0.28);text-align:center;"><?= $r['resumen']['semana1']; ?></td>
				<td style="background-color:rgba(255, 255, 0, 0.28);text-align:center;"><?= $r['resumen']['semana2']; ?></td>
				<td style="background-color:rgba(255, 255, 0, 0.28);text-align:center;"><?= $r['resumen']['semana3']; ?></td>
				<td style="background-color:rgba(255, 255, 0, 0.28);text-align:center;"><?= $r['resumen']['semana4']; ?></td>
				<?php $avg_ges=($r['resumen']['semana1']+$r['resumen']['semana2']+$r['resumen']['semana3']+$r['resumen']['semana4'])/4; ?>
				<td style="background-color:rgba(0, 128, 28, 0.31); text-align:center;"><?= $avg_ges; ?></td>
				<td style="background-color:rgba(0, 196, 255, 0.17);text-align:center;"><?= $r['resumen']['tcs1']; ?></td>
				<td style="background-color:rgba(0, 196, 255, 0.17);text-align:center;"><?= $r['resumen']['tcs2']; ?></td>
				<td style="background-color:rgba(0, 196, 255, 0.17);text-align:center;"><?= $r['resumen']['tcs3']; ?></td>
				<td style="background-color:rgba(0, 196, 255, 0.17);text-align:center;"><?= $r['resumen']['tcs4']; ?></td>
				<?php $avg_cot = ($r['resumen']['tcs1']+$r['resumen']['tcs2']+$r['resumen']['tcs3']+$r['resumen']['tcs4'])/4; ?>
				<td style="background-color:rgba(0, 128, 28, 0.31); text-align:center;"><?= $avg_cot; ?></td>
				<td style="background-color:rgba(0, 196, 255, 0.17);text-align:center;"><?= $r['resumen']['call1']; ?></td>
				<td style="background-color:rgba(0, 196, 255, 0.17);text-align:center;"><?= $r['resumen']['call2']; ?></td>
				<td style="background-color:rgba(0, 196, 255, 0.17);text-align:center;"><?= $r['resumen']['call3']; ?></td>
				<td style="background-color:rgba(0, 196, 255, 0.17);text-align:center;"><?= $r['resumen']['call4']; ?></td>
				<?php
					$avg_call = ($r['resumen']['call1']+$r['resumen']['call2']+$r['resumen']['call3']+$r['resumen']['call4'])/4;
				 ?>
				<td style="background-color:rgba(0, 128, 28, 0.31); text-align:center;"><?= $avg_call ?></td>
				<td>
					<button class="btn btn-mini btn-primary" onclick="detalle_reporte(<?= $r['resumen']['idv'] ?>, '<?= $r['resumen']['idsemana'] ?>')">
						<i class="icon-white icon-search"></i>
					</button>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
		<button class="btn btn-primary" onclick="generar_reporte()">
			Generar PDF Detallado
		</button>

	</div>
	</div>
	<div class="row-fluid">
	<div class="span12">
		Definición<br>
		<table class="table table-condensed table-bordered" style="font-size:11px;">
			<tr>
				<td>CA</td>
				<td>Cartera Asignada</td>
				<td>SG</td>
				<td>Sin Gestión</td>
				<td>AVG SEP</td>
				<td>Promedio de alumnos SEP que posee la cartera</td>
			</tr>
			<tr>
				<td>SG_PS</td>
				<td>Sin Gestión en colegios particulares subvencionados</td>

				<td>SG_MU</td>
				<td>Sin Gestión en colegios Municipales</td>

				<td>% SG</td>
				<td>Porcentaje sin gestión de la cartera asignada</td>
			</tr>
			<tr>
				<td>TG_S1</td>
				<td>Total gestión de la semana <?= $semana1 ?></td>

				<td>TG_S2</td>
				<td>Total gestión de la semana <?= $semana2 ?></td>

				<td>TG_S3</td>
				<td>Total gestión de la semana <?= $semana3 ?></td>
			</tr>
			<tr>
				<td>TG_S4</td>
				<td>Total gestión de la semana <?= $semana4 ?></td>

				<td>AVG_G</td>
				<td>Promedio de la gestión realizada en el mes</td>

				<td>TC_S1</td>
				<td>Total cotizaciones realizadas en la semana <?= $semana1 ?></td>
			</tr>
			<tr>
				<td>TC_S2</td>
				<td>Total cotizaciones realizadas en la semana <?= $semana2 ?></td>

				<td>TC_S3</td>
				<td>Total cotizaciones realizadas en la semana <?= $semana3 ?></td>

				<td>TC_S4</td>
				<td>Total cotizaciones realizadas en la semana <?= $semana4 ?></td>
			</tr>
			<tr>
				<td>AVG_C</td>
				<td>Promedio de cotizaciones del mes</td>
				<td>CALL</td>
				<td>Total de llamadas de la semana</td>
				<td>AVG_CALL</td>
				<td>Promedio de llamadas semanales</td>

			</tr>
		</table>
	</div>
	</div>
</div>

<div class="volver_llamar">

</div>