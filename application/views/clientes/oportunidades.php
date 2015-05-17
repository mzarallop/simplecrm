<table class="">
	<tr>
		<td>Desde:<input type="date" id="desde" value="<?= date("Y-m-d");  ?>"> </td>
		<td>Hasta:<input type="date" id="hasta" value="<?= date("Y-m-d");  ?>"></td>
		<td><button class="btn" onclick="reporte_oportunidades()">Mostrar</button></td>
	</tr>
</table>
<div id="reporte_oportunidades"></div>


