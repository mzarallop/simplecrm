<div class="row-fluid">
	<div class="span3">
		<label>Segmentos:<br>
		<select name="segmento" id="segmento">
			<?php foreach($segmento as $seg): ?>
				<option value="<?= $seg['COD_DEPE'] ?>"><?= $seg['COD_DEPE'] ?></option>
			<?php endforeach; ?>
		</select>
		</label>
		<label>Regiónes:<br>
		<select name="region" id="region"></select></label>
		<label>Comunas:<br>
		<select name="comuna" id="comuna"></select></label>
	</div>
	<div class="span9">
		
	</div>
</div>