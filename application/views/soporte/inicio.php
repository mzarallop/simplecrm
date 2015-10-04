<table class="table table-striped">
	<tr>
		<td>Colegios:</td>
		<td>
			<select name="colegios" id="colegios">
				<option value="">--</option>
				<?php foreach ($colegios as $col ): ?>
				<option value="<?php echo $col['basedatos']; ?>"><?php echo $col['Nombre']; ?></option>
				<?php endforeach; ?>
			</select>
		</td>
		
			<td>Accion</td>
			<td>
				<select name="accion" id="accion">
					<option value="0">--</option>
					<option value="1">Ver profesores</option>
					<option value="2">Ver alumnos</option>
					<option value="3">Ver Pruebas</option>

				</select>
			</td>
			<td><button class="btn btn-primary" onclick="mostrar_informacion(event)">Mostrar Información</button></td>
		
	</tr>
</table>
<div id="resultados"></div>