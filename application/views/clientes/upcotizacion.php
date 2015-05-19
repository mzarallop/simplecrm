<script type="text/javascript">
	$(function(){ajustar_cotizacion()})
</script>
<input type="hidden" id="idcotizacion" value="<?= $idcotizacion ?>">
<input type="hidden" id="id_usuario" value="<?= @$usuario[0]['ID'] ?>">

<ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#datos_colegio"><span class="badge">1</span> Datos del colegio</a></li>
  <li><a href="#productos"><span class="badge">2</span> Asociar productos</a></li>
</ul>
<div id="myTabContent" class="tab-content">
<div class="tab-pane fade active in" id="datos_colegio">
	<h4 style="background-color:rgba(128, 128, 128, 0.17);padding:3px">Datos del colegio</h4>
	<table class="table table-striped table-bordered table-condensed">
		 <tr>
		 	<td width="10%">Institución:</td>
		 	<td width="40%"><input type="text" id="colegio" value="<?= @$colegio['NOMBRES']  ?>"/></td>
		 	<td width="10%">RBD:</td>
		 	<td width="40%"><input type="text" id="rbd" value="<?= @$colegio['RBD'] ?>" disabled/></td>
		 </tr>
		 <tr>
		 	<td>Dirección:</td>
		 	<td><input type="text" id="direccion" value="<?= @$cot['cotizacion']['direccion']  ?>, <?= @$colegio['COMUNA'] ?>"></td>
		 	<td>Teléfono:</td>
		 	<td><input type="text" id="telefono" value="(0<?= @$colegio['COD_AREA']  ?>) - <?= @$colegio['TELEFONO']  ?>"> </td>
		 </tr>
		 <tr>
		 	<td>Contacto:</td>
		 	<td><input type="text" value="<?= $cot['cotizacion']['contacto'] ?>" placeholder="Ingresa el nombre de contacto" id="contacto"></td>
		 	<td>Dependencia:</td>
		 	<td><input type="text" id="dependencia" value="<?= @$colegio['AUX1'] ?>" disabled></td>
		 </tr>
		 <tr>
		 	<td>Modo de pago:</td>
		 	<td>
		 		<select name="modo_pago" id="modo_pago">
		 			<?php foreach($pago as $p): ?>
		 				<option value="<?= $p['id']  ?>"><?= $p['nombre']; ?></option>
		 			<?php endforeach; ?>
		 		</select>
		 	</td>
		 	<td>Probabilidad de Cierre:</td>
		 	<td>
		 		<select name="probabilidad" id="probabilidad">
		 			<option value="0">Sin probabilidad</option>
		 			<option value="50" <?php if(50 === $cot['cotizacion']['porcentaje_cierre']){ echo 'selected';} ?>>50%</option>
		 			<option value="60" <?php if(60 === $cot['cotizacion']['porcentaje_cierre']){ echo 'selected';} ?>>60%</option>
		 			<option value="70" <?php if(70 === $cot['cotizacion']['porcentaje_cierre']){ echo 'selected';} ?>>70%</option>
		 			<option value="80" <?php if(80 === $cot['cotizacion']['porcentaje_cierre']){ echo 'selected';} ?>>80%</option>
		 			<option value="90" <?php if(90 === $cot['cotizacion']['porcentaje_cierre']){ echo 'selected';} ?>>90%</option>
		 			<option value="100" <?php if(100 === $cot['cotizacion']['porcentaje_cierre']){ echo 'selected';} ?>>100%</option>
		 		</select>
		 	</td>
		 </tr>
		 <tr>
		 	<td>Observaciones:</td>
		 	<td><textarea name="observaciones" id="observaciones" cols="30" rows="3" class="span6"><?= $cot['cotizacion']['observaciones'] ?></textarea></td>
		 	<td></td>
		 	<td></td>
		 </tr>
	</table>
</div>
<div class="tab-pane fade" id="productos">
<table width="100%" class="table table-condensed table-striped table-bordered">
	<tr>
		<td width="30%">
			<h4 style="background-color:rgba(128, 128, 128, 0.17);padding:3px">catalogo de Productos</h4>
		</td>
		<td width="70%">
			<h4 style="background-color:rgba(128, 128, 128, 0.17);padding:3px">Cotización
				<button class="btn btn-warning	" style="float:right" onclick="actualizar_cotizacion()">
					Actualizar Cotización
				</button>
			</h4>
		</td>
	</tr>
	<tr>
		<td>
			<input type="text" id="texto_buscar">
			<!--<button class="btn btn-success" style="float:right" onclick="agregar_producto()">
				<i class="icon-plus icon-white" onclick="agregar_producto()"></i>
			</button>   -->
			 <button class="btn btn-info" style="float:right" onclick="buscar_producto()">
				<i class="icon-search icon-white" onclick="buscar_producto()"></i>
			</button> 
			<!-- RESULTADOS DE BUSQUEDA -->
			<div id="listado_productos"></div>
		</td>
		<td>
			<!-- COTIZACION -->
			<h4 style="background-color:rgba(128, 128, 128, 0.17);padding:3px">Detalle de productos seleccionados</h4>
			<table class="table table-striped table-condensed table-bordered" id="detalle_productos">
				<thead>
				<tr>
					<th>ITEM</th>
					<th>DESCRIPCIÓN</th>
					<th>UNIDADES</th>
					<th>PRECIO NETO</th>
					<th>TOTAL NETO</th>
					<th>IVA</th>
					<th>PRECIO TOTAL</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="6" style="text-align:right">Neto</td>
						<td style="text-align:right" id="total_neto">0</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right">I.V.A</td>
						<td style="text-align:right" id="iva">0</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right">Total</td>
						<td style="text-align:right" id="total_iva">0</td>
					</tr>
				</tfoot>
				<tbody>

					<?php foreach($cot['detalle'] as $det): ?>

						<tr id="rbd_<?= $det['idproducto'] ?>">
							<td widht="5%"><button onclick="remover_producto_cotizacion(<?= $det['idproducto'] ?>)"><i class="icon-trash"></i></button></td>
							<td widht="40%">
								<h6><?= $det['nombre'] ?></h6>
								<textarea name="descripcion" class="descripcion span5" id="descripcion_<?= $det['idproducto'] ?>" rows="5" cols="15"><?= $det['descripcion'] ?></textarea>
								<input type="hidden" class="productos" value="<?= $det['idproducto'] ?>">
								<input type="hidden" id="afecto" class="afecto" value="<?= $det['afecto_iva'] ?>">
							</td>
							<td widht="10%">
								<input type="text" id="unidad_<?= $det['idproducto'] ?>" class="span1 unidades" value="<?= $det['unidades'] ?>" onblur="ajustar_cotizacion()"> 
							</td>
							<td widht="11%">
								<input type="text" id="precio_neto_<?= $det['idproducto'] ?>" class="span2 precio_neto" value="<?= $det['neto'] ?>" onblur="ajustar_cotizacion()">
							</td>
							<td widht="11%" class="total_iva" id="total_neto_fila_<?= $det['idproducto'] ?>"></td> 
							<td widht="11%" id="iva_fila_<?= $det['idproducto'] ?>">19000</td>
							<td widht="11%" id="total_fila_<?= $det['idproducto'] ?>">119000</td>
						</tr>
					<?php endforeach; ?>
				</tbody>

			</table>

		</td>
	</tr>
</table>
</div>
</div>