<?php foreach($categorias as $cat): ?>
<ul id="bco_prod_<?= $cat['categoria']['id'] ?>" class="bco_prod">
	<div class="titulo_categorias"><?= $cat['categoria']['nombre']  ?> <button class="btn btn-mini" style="float:right" onclick="nuevo_producto(<?= $cat['categoria']['id'] ?>)">Nuevo Producto</button></div>
	<?php foreach($cat['productos'] as $prod): ?>
		<li id="prod_<?= $prod['id'] ?>">
			<div class="titlo_prod"><?= $prod['nombre'] ?></div>
			<div class="descripcion_prod"><?= $prod['descripcion']  ?></div>
			<div class="precio_prod">
				$ <?= number_format($prod['precio'],0, ',', '.')  ?>
				<button class="btn btn-mini btn-success" style="float:right" onclick="editar_producto(<?= $prod['id'] ?>)">
					Editar
				</button>
			</div>
		</li>
	<?php endforeach; ?>
</ul>
<?php endforeach; ?>