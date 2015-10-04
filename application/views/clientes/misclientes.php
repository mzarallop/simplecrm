<div class="row-fluid">
	<div class="span2">
		<ul>
			<li><a href="<?= base_url() ?>clientes/">Mi Cartera</a></li>
			<li><a href="javascript:;" onclick="mis_pendientes()">Mis Tareas</a></li>
			<li><a href="javascript:;" onclick="mis_cotizaciones()">Mis Cotizaciones</a></li>
			<li><a href="javascript:;" onclick="traer_cartera_gestion()">Resumen de gestiónes</a></li>
		</ul>

	</div>
	<div class="span10">
	<input type="hidden" id="id_usuario" value="<?= $usuario[0]['ID'] ?>">
				<div id="mispendientes" class="capas"></div>
				<div id="buscador" class="capas"></div>
				<div id="cotizaciones" class="capas"></div>
				<div id="reportegestion" class="capas"></div>
		   	    <div id="lista_prospectos" class="capas">
	      	    <table class="display compact" id="cartera" style="font-size:10px">
	      	    <thead>
	      	    <tr>
	      	    	<th></th>
	      	    	<th>Rbd</th>
	      	    	<th>Colegio</th>
	      	    	<th>Region</th>
	      	    	<th>Comuna</th>
	      	    	<th>SEP</th>
	      	    	<th>Dependencia</th>
	      	    	<th>Fecha gestión</th>
	      	    	<th>Última gestión</th>
	      	    	<th data-orderable="false">Acciones</th>

	   	      	    </tr>
	      	    </thead>
	      	    <tbody>
	      	    	<?php $cont =1; foreach($mi_cartera as $mc): ?>
	      	    	<tr id="<?= $mc['colegio']['RBD'] ?>" class="prospecto" data-rbd="<?= $mc['colegio']['RBD'] ?>">
	      	    		<?php $color = $this->usuarios->segmentos($mc['colegio']['SEGMENTO']); ?>
	      	    		<td style="border-left: 6px solid <?= $color; ?>;"><span class="segmento"><?= $mc['colegio']['SEGMENTO'] ?></span></td>
	      	    		<td><?= $mc['colegio']['RBD'] ?></td>
	      	    		<td><?= $mc['colegio']['NOMBRE'] ?></td>
	      	    		<td><?= $mc['colegio']['REGION'] ?></td>
	      	    		<td><?= $mc['colegio']['COMUNA'] ?></td>
	      	    		<td><?= $mc['colegio']['ALUMNOS_SEP'] ?></td>
	      	    		<?php //$monto_sep = ($mc['colegio']['ALUMNOS_SEP']*35000*12); ?>
	      	    		<td><?= $mc['colegio']['DEPENDENCIA']?></td>
	      	    		<td><time datetime="<?= $mc['colegio']['fecha_gestion'] ?>" class="age"><?= $mc['colegio']['fecha_gestion'] ?></time></td>
	      	    		<td>
	      	    			<span class="<?= $mc['colegio']['label'] ?>"><?= $mc['colegio']['gestion'] ?></span>
	      	    		</td>
	      	    		<td>
	      	    			<button class="btn btn-mini btn-info" onclick="ficha(<?= $mc['colegio']['RBD'] ?>)" title="Ver Ficha">
	      	    				<i class="icon-search icon-white"></i>
	      	    			</button>
	      	    			<button class="btn btn-mini btn-success" onclick="agregar_gestion(<?= $mc['colegio']['RBD'] ?>)" title="Agregar gestión">
	      	    				<i class="icon-plus icon-white"></i>
	      	    			</button>
	      	    			<button class="btn btn-mini" onclick="agregar_usuario(<?= $mc['colegio']['RBD'] ?>)" title="Agregar contacto">
	      	    				<i class="icon-user"></i>
	      	    			</button>

	      	    		</td>

	      	    	</tr>
 	      	    	<?php $cont++; endforeach; ?>
	      	    </tbody>
	      	    </table>
	      	    </div>

	      	    <div id="ficha_cliente" style="display:none" class="capas">
	      	    	<ul id="myTab" class="nav nav-tabs">
		              <li class="active"><a href="#ficha" data-toggle="tab"><i class="icon-th-list"></i> Ficha</a></li>
		              <!--<li class=""><a href="#gestiones" data-toggle="tab"><i class="icon-comment"></i> Gestiones <span id="total_gestiones"></span></a></li>-->
		              <!--<li class=""><a href="#contactos" data-toggle="tab"><i class="icon-user"></i> Contactos <span id="total_contactos"></span></a></li>-->
		              <li class=""><a href="#generarcotizaciones" data-toggle="tab"><i class="icon-shopping-cart"></i> Cotizaciones <span id="total_cotizaciones"></span></a></li>
		              <!--<li class=""><a href="#proyectos" data-toggle="tab"><i class="icon-folder-open"></i> Proyectos</a></li>-->
		              <li class=""><a href="#productos" data-toggle="tab"><i class="icon-folder-open"></i> Productos <span id="total_productos"></span></a></li>
		              <!--<li class=""><a href="#soporte" data-toggle="tab" style="background-color: azure;"><i class="icon-fire"></i> Ticket de soporte</a></li>-->
		              <button class="btn btn-primary" onclick="volver_prospectos()" style="float:right">Volver a prospectos</button>
		            </ul>

	      	    	<div id="myTabContent" class="tab-content">
		      	    	<div class="tab-pane fade active in" id="ficha">
		      	    		<div class="" id="ficha_detalle">Ficha:</div>
		      	    		<div id="detalle-contactos"></div>
		      	    		<div id="gestiones_detalle-front"></div>
		      	    	</div>
		      	    	<!--<div class="tab-pane fade in" id="gestiones">
		      	    		<div class="" id="gestiones_detalle"><h4>Gestiones:</h4></div>
		      	    	</div>-->
		      	    	<!--<div class="tab-pane fade in" id="contactos">
		      	    		<div class="" id="contactos_detalle"><h4>Contactos:</h4></div>
		      	    	</div>-->
		      	    	<div class="tab-pane fade in" id="generarcotizaciones">
		      	    		<div class="" id="propuestas_detalle"><h4>Cotizaciones:</h4></div>
		      	    	</div>
		      	    	<!--<div class="tab-pane fade in" id="proyectos">
		      	    		<div class="" id="proyectos_detalle"><h4>Proyectos:</h4><button class="btn btn-small" style="float:right">Nuevo Proyecto</button></div>
		      	    	</div>-->
		      	    	<div class="tab-pane fade in" id="productos">
		      	    		<div class="" id="productos_detalle"><h4>Productos:</h4></div>
		      	    	</div>
						<div class="tab-pane fade in" id="soporte">
		      	    		<div class="" id="soporte_detalle"><h4>Soporte:</h4></div>
		      	    	</div>
	      	    	</div>
	      	  </div>
	      	  <div id="tipo_gestion" style="display:none"  class="capas" >

	      	  </div>
	    </div>
	</div>
</div>