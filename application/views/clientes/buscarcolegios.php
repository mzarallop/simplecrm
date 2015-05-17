<input type="hidden" id="inicio" value="<?= date("Y-m-d") ?>">
<input type="hidden" id="termino" value="<?= date("Y-m-d") ?>">
	<table width="100%">
		<tr>
		<td width="40%" valign="top" style="padding: 10px;">
			<div style="padding:10px;margin-bottom:5px;border:1px solid rgba(0, 141, 36, 1);background-color:rgba(128, 128, 128, 0.06);border-radius:2px">
				<b>Buscar colegio para generar cotización</b>
				<table class="table">
					<tr>
						<td>
							<input type="text" id="texto" class="span4" placeholder="RBD o Nombre colegio">
						</td>
						<td>
							<button class="btn btn-mini btn-primary" onclick="buscar_colegio()" title="Buscar colegio">
								<i class="icon-search icon-white"></i>
							</button> 
							<button class="btn btn-mini btn-success" onclick="nuevo_colegio()" title="Agregar un nuevo colegio">
								<i class="icon-plus icon-white"></i>
							</button>
						</td>
					</tr>
				</table>
			<div style="background-color:white;margin:5px;padding:5px;overflow:scroll;overflow-x:hidden;height:370px;border:1px dotted gray;width:95%">
				<table class="table table-condensed table-striped" style="font-size:9px" id="resultado_colegios">
					<thead>
						<th>RBD</th>
						<th>COLEGIO</th>
						<th>REGION</th>
						<th></th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			</div>
			</td>
		<td width="60%" valign="top" style="padding: 10px;">
			<!--MIS COTIZACIONES -->
			<ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#pendientes" data-toggle="tab">Cotizaciones Pendientes</a></li>
              <li><a href="#aprobadas" data-toggle="tab">Cotizaciones Aprobadas</a></li>
              <li><a href="#llamadas" data-toggle="tab">Llamadas de hoy</a></li>
            </ul>
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade in active" id="pendientes">
					<div style="background-color:white;margin:5px;padding:5px;overflow:scroll;overflow-x:hidden;height:440px;border:1px dotted gray;width:95%">
						<table class="table table-condesed table-striped">
							<thead>
							<tr>
								<th>Código</th>
								<th>Colegio</th>
								<th>Monto</th>
								<th>Acciones</th>
							</tr>
							</thead>
							<tbody>
							<?php foreach($cotizaciones as $cot): ?>
								<tr id="cot_<?= $cot['id']  ?>">
									<th><?= $cot['id'] ?></th>
									<td><?= $cot['colegio']  ?></td>
									<td>$ <?= number_format($cot['total'],0, ',','.') ?></td>
									<td>
										<button class="btn btn-primary btn-mini" onclick="ver_cotizacion_iframe(<?= $cot['id'] ?>)" title="Ver cotización"><i class="icon-white icon-search"></i></button>
										<button class="btn btn-mini" onclick="eliminar_cotizacion(<?= $cot['id'] ?>)" title="Eliminar cotización"><i class="icon-trash"></i></button>
										<button class="btn btn-mini btn-success" onclick="aprobar_cotizacion(<?= $cot['id'] ?>)" title="Aprobar Cotización"><i class="icon-white icon-ok"></i></button>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				
				</div>
				<div class="tab-pane fade" id="llamadas">

				</div>
				<div class="tab-pane fade" id="aprobadas">
					<div id="cotizacion_aprobada"></div>
				</div>

			</div>
		</td>
		</tr>
	</table>
	