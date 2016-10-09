<div class="row-fluid">
	<div class="span3">
		<label>Segmentos:<br>
		<select name="segmento" id="segmento" onblur="selRegiones(this.value);" multiple>
			<?php foreach($segmento as $seg): ?>
				<option value="<?= $seg['SEGMENTO'] ?>"><?= $seg['SEGMENTO'] ?> 
				(<?= number_format($seg['total_colegios'],0, '.', ''); ?>)</option>
			<?php endforeach; ?>
		</select>
		</label>
		<label>Regiónes:<br>
		<select name="region" id="region" onchange="selComunas(this.value);">
			<option value="0">Todas</option>
		</select></label>
		<label>Comunas:<br>
		<select name="comuna" id="comuna" onchange="filtrarColegios()">
			<option value="0">Todas</option>
		</select></label>
	</div>
	<div class="span9">
		<div class="tabla_colegios">
			
		</div>
	</div>
</div>