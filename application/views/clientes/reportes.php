
<table width="100%">
	<tr>
		<td width="20%" valign="top">
			<div style="background-color:rgba(128, 128, 128, 0.43);padding:10px;color:white;border-radius:5px">
				Desde:<br>
				<input id="desde" type="date" /><br>
				Hasta:<br>
				<input id="hasta" type="date"><br>
				Vendedores:<br>
				<select id="vendedor">
					<option value="0">Todos</option>
					<?php foreach($vendedores as $v): ?>
						<option value="<?= $v['ID'] ?>"><?= $v['NOM_EJECUTIVO']; ?></option>
					<?php endforeach; ?>
				</select><br>
				Estados:<br>
				<select id="estado">
					<?php foreach($estados as $e): ?>
						<option value="<?= $e['id'] ?>"><?= $e['nombre']; ?></option>
					<?php endforeach; ?>
				</select>
				<br>
				<button class="btn btn-primary" onclick="generar_reporte()">Mostrar</button>
				<button class="btn btn-success">Generar PDF</button>
			</div>
		</td>
		<td width="80%" valign="top">
			<div id="reporte_general"></div>
		</td>
	</tr>
</table>