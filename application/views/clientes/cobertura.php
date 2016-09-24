<div class="row-fluid">

	<div class="span6">
		<div class="panel_colegio">

	</div>
			<b>Iconografía</b><br>
			<li class="log_map"><img src="<?= base_url() ?>img/pinche.png" alt=""><br>100</li>
			<li class="log_map"><img src="<?= base_url() ?>img/pinche_blue.png" alt=""><br>100-250</li>
			<li class="log_map"><img src="<?= base_url() ?>img/pinche_green.png" alt=""><br>250-600</li>
			<li class="log_map"><img src="<?= base_url() ?>img/pinche_red.png" alt=""><br>600++</li>
		<br>
		<b>Dependencia:</b><br>
		<li class="dos_columnas"><label><input type="checkbox" name="dep" id="dep" value="1">Municipal</label></li>
		<li class="dos_columnas"><label><input type="checkbox" name="dep" id="dep" value="2">Particular Subvencionado</label></li>
		<b>Regiones:</b><br>
		<?php for($i=1;$i<16;$i++): ?>
			<li class="dos_columnas"><label><input type="checkbox" name="reg" id="reg" value="<?= $i ?>"><?= $i ?>° Región</label></li>
		<?php endfor; ?>
		<p>
		<button class="btn btn-primary" onclick="filtrar_mapa()">Filtrar</button></p>
	</div>
	<div class="span6">
		<div class="map" id="map" style="width:100%;height:460px;"></div>
		<div id="total_colegios" class="total_colegios">600</div>
	</div>
</div>