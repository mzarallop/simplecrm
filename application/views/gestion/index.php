<div class="row-fluid">
<div class="span3">
	<div class="filtro_fecha">
		<p>
			Inicio:<br>
			<input type="date" id="inicio" value="<?= date("Y-m-d"); ?>">
		</p>
		<p>
			termino:<br>
			<input type="date" id="termino" value="<?= date("Y-m-d"); ?>">
		</p>
	</div>
	<ul id="menu_gestion">
		<li><a href="javascript:reporte_gestion()">Resumen de Gestión</a></li>
		<li><a href="javascript:resumen_gestion()">Detalle de Gestión</a></li>
		<li><a href="javascript:reporte_llamadas()">Reporte llamadas</a></li>
		</ul>
</div>
<div class="span8">
	<div id="reporte_gestion" class="capa"></div>
	<div id="reporte_facturacion" class="capa"></div>
	<div id="reporte_llamadas" class="capa"></div>
	<div id="detalle_llamadas" class="capa"></div>
	<div id="flujo_pagos" class="capa"></div>
</div>
</div>