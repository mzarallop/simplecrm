<div class="row-fluid">

	<div class="span12">
		<div class="documento_factura">
				<div class="row-fluid">
					<div class="span8">
					<h1>Three software</h1>
						<table class="table table-condensed table-bordered">
							<tr>
								<td>Emisor:</td>
								<td>
									<select name="emisor" id="emisor">
										<option value="76567317-K">Three Software SPA</option>
									</select>
								</td>
								<td>Fecha:</td>
								<td><input type="date" id="fecha_factura" value="<?= date("Y-m-d")  ?>"></td>
							</tr>
							<tr>
								<td>Razon Social:</td>
								<td><input type="text" id="razon_social" disabled="true" class="span12"></td>
								<td>RUT:</td>
								<td><input type="text" id="rut_rbd" placeholder="Rut o RBD Receptor" class="span12" onblur="buscar_datos(this.value)"></td>
							</tr>
							<tr>
								<td>Dirección:</td>
								<td><input type="text" id="direccion" disabled="true" class="span12"></td>
								<td>Comuna:</td>
								<td><input type="text" id="comuna" class="span12" disabled="true"></td>
							</tr>
							<tr>
								<td>Coordinador:</td>
								<td>
									<select name="coordinador" id="coordinador" placeholder="coordinador">
										<option value="0">--</option>
										<?php foreach($coordinador as $co): ?>
											<option value="<?= $co['ID'] ?>"><?=$co['NOM_EJECUTIVO'] ?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td>Vendedor:</td>
								<td>
									<select name="vendedor" id="vendedor" placeholder="vendedor">
										<option value="0">--</option>
										<?php foreach($vendedor as $co): ?>
											<option value="<?= $co['ID'] ?>"><?=$co['NOM_EJECUTIVO'] ?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
						</table>
					</div>
					<div class="span4">
						<div class="numero_factura">
							<div class="rut">RUT: 76.788.459-0</div>
							<div class="tipo_doc">FACTURA</div>
							<div class="numero_doc">N° 00000000234</div>
						</div>
					</div>
				</div>
				<!--DETALLE DE LA COMPRA-->
				<div class="row-fluid">
					<table class="table table-codensed" id="detalle_factura">
						<thead><tr>
							<th width="10%">Unidad</th>
							<th width="55%">Descripción</th>
							<th width="10%">Neto Unidad</th>
							<th width="10%">Total Neto</th>
							<th width="10%">Total</th>
							<th width="5%"></th>
						</tr>
						</thead>
						<tbody>
						<tr style="background-color: rgba(128, 128, 128, 0.25);">
							<td><input type="text" id="unidad" class="span12" value="1" style="text-align:center"></td>
							<td colspan="5" >
							<select name="" id="descripcion" class="span12" onchange="cargar_precio(this.value);">
								<option value="0">--</option>
								<?php  foreach($productos as $p): ?>
									<optgroup label="<?= $p['categoria']['nombre'] ?>">
										<?php foreach($p['submenu'] as $sm): ?>
											<option value="<?= $sm['id']; ?>|<?= $sm['nombre']; ?>|<?= $sm['precio']; ?>"><?= $sm['nombre'] ?> Neto ($ <?= number_format($sm['precio'],0) ?>)</option>
										<?php endforeach; ?>
									</optgroup>
								<?php endforeach; ?>
							</select>
							<input type="hidden" id="neto" class="span12">
							<input type="hidden" id="total_neto" class="span12" disabled="true">
							<input type="hidden" id="total" class="span12" disabled="true">
							</td>

						</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4" width="75%" style="text-align:right;font-weight:bold">Neto</td>
								<td colspan="2" align="right"><input type="hidden" id="neto_final"><span class="neto_final"></span></td>
							</tr>
							<tr>
								<td colspan="4" width="75%" style="text-align:right;font-weight:bold">I.V.A 19%</td>
								<td colspan="2" align="right"><input type="hidden" id="iva_final"><span class="iva_final"></span></td>
							</tr>
							<tr>
								<td colspan="4" width="75%" style="text-align:right;font-weight:bold">Total</td>
								<td colspan="2" align="right"><input type="hidden" id="total_final"><span class="total_final"></span></td>
							</tr>
						</tfoot>
					</table>
				</div>
			<button class="btn btn-success" style="float:right">Guardar Factura</button>
		</div>

	</div>
</div>

