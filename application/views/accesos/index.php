<div id="login">
	<img src="<?= base_url() ?>img/logos/<?= $empresa['logo'] ?>" alt="<?= $empresa['razon_social'] ?>">
	<table align="center">
		<tr>
			<td><input type="text" id="user" placeholder="Usuario" required/>	</td>
		</tr>
		<tr>
			<td><input type="password" id="pass" placeholder="Contraseña" required/></td>
		</tr>
		<tr>
			<td><button class="btn btn-large btn-primary" onclick="login()">Iniciar sesion</button></td>
		</tr>
	</table>
</div>