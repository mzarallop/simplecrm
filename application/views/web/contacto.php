<div>

	<div class="tabbable"> 
	  <ul class="nav nav-tabs">
	    <li class="active"><a href="#tab1" data-toggle="tab">Mi Cartera</a></li>
	    <li><a href="#tab2" data-toggle="tab" onclick="mostrar_mis_gestiones()">Gestiones por Comunas</a></li>
	    <li><a href="#tab3" data-toggle="tab" onclick="ver_ges()">Comparativo de gestiones</a></li>
	    <li><a href="#tab4" data-toggle="tab" onclick="ver_ag()">Mi agenda</a></li>
	    
	    <li><a href="#tab5" data-toggle="tab">Informe de gestiones</a></li>
	  </ul>
	  <div class="tab-content">
	    <div class="tab-pane active" id="tab1">
	      <!-- cliente filtros -->
	      <div id="filtros_clientes" >
	      	    <div id="clientes_bcli">
	      	    <table class="tablesorter">
	      	    <thead>
	      	    <tr>
	      	    	<th>Fecha</th>
	      	    	<th>Nombre</th>
	      	    	<th>Colegio</th>
	      	    	<th>Mensaje</th>
	      	    	<th>Telefono</th>
	      	    	<th>Email</th>
	      	    	<th>Estado</th>
	      	    	<th></th>
	      	    </tr>
	      	    </thead>
	      	    <tfoot>
					<th colspan="10" class="pager form-horizontal">
						<button type="button" class="btn first"><i class="icon-step-backward"></i></button>
						<button type="button" class="btn prev"><i class="icon-arrow-left"></i></button>
						<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
						<button type="button" class="btn next"><i class="icon-arrow-right"></i></button>
						<button type="button" class="btn last"><i class="icon-step-forward"></i></button>
						<select class="pagesize input-mini" title="Select page size">
							<option selected="selected" value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
						</select>
						<select class="pagenum input-mini" title="Select page number"></select>
					</th>					
				</tfoot>
	      	    <tbody>
	      	    	<?php $cont =1; foreach($mi_cartera as $mc): ?>
	      	    	<tr id="<?php echo $mc['id'] ?>">
	      	    	<td><?php echo $mc['fecha'] ?></td>
	      	    	<td><?php echo $mc['nombre'] ?></td>
	      	    	<td><?php echo $mc['institucion'] ?></td>
	      	    	<td><?php echo $mc['mensaje'] ?></td>
	      	    	<td><?php echo $mc['telefono'] ?></td>
	      	    	<td><?php echo $mc['email']; ?></td>
	      	    	<td><?php echo $mc['estado'] ?></td>
	      	    	<td>
	      	    	<a href="javascript:;" data-rbd="<?php echo $mc['id']; ?>" onclick="ver_ficha_cliente(event)"><i class="glyphicon glyphicon-search" data-id="<?php echo $mc['id'] ?>"></i></a>
	      	    	<a href="javascript:;" data-rbd="<?php echo $mc['id']; ?>" onclick="generar_cotizacion(event)"><i class="icon-usd" data-id="<?php echo $mc['id'] ?>"></i></a>
	      	    	</td>	      	    	
	      	    	</tr>
	      	    	<?php $cont++; endforeach; ?>
	      	    </tbody>
	      	    </table>
	      	    </div>
	      </div>
	     <!--fin de filtros clientes -->
	     <!--inicio ficha cliente -->
	     	<div id="ficha_cliente" style="display:none">
	     	
	     	<div id="datos_cliente" style="diaply:none">
	     		
	     	</div>
	     		 <button class="btn btn-info" onclick="volver_filtros_clientes()">
			 		<i class="icon-white icon-arrow-left"></i> Volver
			 	</button>
	      		<a id="contactos_clientes" href="javascript:;" onclick="ver_contactos(event)">
	      		<i class="icon-white icon-user"></i> Contactos del cliente
	      		</a>
	      		<a id="gestiones_clientes" class="accordion-toggle" href="javascript:;" onclick="ver_gestiones(event)">
	      		<i class="icon-white icon-comment"></i> Gestiones del cliente
	      		</a>
	      		<!-- CONTENEDOR DE USUARIOS -->
	      		<div id="contenedor_contactos" class="contenedores" style="display:none">
		      		<a href="javascript:;" class="btn btn-mini" onclick="nuevo_contacto()" style="float:right">
		      		<i class="icon-plus-sign"></i> Nuevo
		      		</a>
		      		<P>
	      			<div id="lista_contactos"></div></P>
	      		</div>
	      		<!-- FIN DE CONTENEDOR USUARIOS -->
	     		<!-- CONTENEDOR CLIENTES -->
	
	      		<div id="contenedor_gestiones" class="contenedores" style="display:none">
	      		<a href="javascript:;" style="float:right" class="btn btn-mini" onclick="nueva_gestion()"><i class="icon-plus-sign"></i> Nueva gestion :)</a>	
			     		<div id="lista_gestiones"></div>
			     </div>
			     <!-- FIN DE CONTENEDOR CLIENTES -->
			
	     <!--fin ficha cliente-->
	    </div>
	    </div>
	    <div class="tab-pane" id="tab2">
	      <div id="misgestiones">
	      	
	      </div>

	    </div>
	    <div class="tab-pane" id="tab3">
	      <table class="table table-condensed table-striped">
	      	<tr>
	      		<td>Inicio</td>
	      		<td><input type="text" class="fecha" id="inicio_gestiones" value="<?php echo date("d/m/Y"); ?>"/></td>
	      		<td>Termino</td>
	      		<td><input type="text" class="fecha" id="fin_gestiones" value="<?php echo date("d/m/Y"); ?>"/></td>
	      		<td>
	      			<button class="btn btn-primary" onclick="ver_ges()"><i class="glyphicon glyphicon-search icon-white"></i> Ver Gestiones</button>
	      		</td>
	      	</tr>
	      </table>
	      <div id="mis_gestiones"></div>
	    </div>
	    <div class="tab-pane" id="tab4">
	      <table class="table table-condensed table-striped ">
	      	<tr>
	      		<td>Inicio</td>
	      		<td><input type="text" class="fecha" id="inicio_agenda" value="<?php echo date("d/m/Y"); ?>"/></td>
	      		<td>Termino</td>
	      		<td><input type="text" class="fecha" id="fin_agenda" value="<?php echo date("d/m/Y"); ?>"/></td>
	      		<td>
	      			<button class="btn btn-primary" onclick="ver_ag()"><i class="glyphicon glyphicon-search icon-white"></i> Ver Gestiones</button>
	      		</td>
	      	</tr>
	      </table>
	      <div id="mi_agenda"></div>
	    </div>
	    <div class="tab-pane" id="tab5">
	      <p>Howdy, I'm in Section 4.</p>
	    </div>
	  </div>
	</div>
</div>

<!--END ROW-->
</div>
<!--END CONTAINER-->
</div>
