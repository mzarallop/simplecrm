<div class="row-fluid">
<div class="span2">
	<ul>
		<li><a href="javascript:;" onclick="gestionar_ejecutivos()">Gestionar ejecutivos</a></li>
		<li><a href="javascript:;" onclick="asignar_carteras()">Asignar Carteras</a></li>
	</ul>
</div>
<div class="span10">

	<div id="listado_usuario" class="capa" >
	<div id="usuarios_sistema"></div>
	<script>
		$(function(){traer_usuarios()})
	</script>
	</div>
	<div id="cargar_carteras" class="capa" style="display:none">
		<h2>Asignación de colegios</h2>
		<p>Estimado usuario a continuación podrá realizar la carga de registros a los ejecutivos de ventas, subiendo un archivo
		csv con formato excel codificado en UTF-8. Para realizar una carga adecuada debe tener una sola columa con los rbd que desea asignar
		al ejecutivo y a continuación selecionar el ejecutivo al que desea realizar la asignación.</p>

		<form action="<?= base_url() ?>gestion/carga_csv_asignacion/" method="post" enctype="multipart/form-data" target="iframe_csv">
			<table class="table">
				<tr>
					<td>Cargar CSV:<br>
						<input type="file" name="archivo" id="archivo">
					</td>
				</tr>
				<tr>
					<td>Como cargo los RBD:<br>
						<label><input type="radio" id="forma_carga" name="forma_carga" value="1"> Mantener la asignación actual y agregar nuevos registros.</label>
						<label><input type="radio" id="forma_carga" name="forma_carga" value="0"> Eliminar los registros y cargar la nueva base.</label>
					</td>
				</tr>
				<tr>
					<td><button class="btn btn-primary" type="submit">Cargar los RBD</button></td>
				</tr>
			</table>
		</form>
		<iframe width="100%" height="250" src="<?= base_url() ?>gestion/carga_csv_asignacion/" frameborder="0" id="iframe_csv" name="iframe_csv"></iframe>
	</div>
</div>
</div>
