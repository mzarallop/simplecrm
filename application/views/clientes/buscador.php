<div>

	<div class="tabbable tabs-left"> 
	  <ul class="nav nav-tabs">
	    <li class="active"><a href="#tab1" data-toggle="tab">Resultados</a></li>
	   </ul>
	  <div class="tab-content">
	    <div class="tab-pane active" id="tab1">
	      <!-- cliente filtros -->
	      <div id="filtros_clientes" >
	      	    <div id="clientes_bcli">
	      	    <table class="tablesorter">
	      	    <thead>
	      	    <tr>
	      	    	<th>RBD</th>
	      	    	<th>Nombre</th>
	      	    	<th>Dependencia</th>
	      	    	<th>Comuna</th>
	      	    	<th>SEP</th>
	      	    	<th>Monto $</th>
	      	    	<th>Clasificación</th>
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
	      	    	<tr id="<?php echo $mc['RBD'] ?>">
	      	    	<td><?php echo $mc['RBD'] ?></td>
	      	    	<td><?php echo $mc['NOMBRE'] ?></td>
	      	    	<td><?php echo $mc['DEPENDENCIA'] ?></td>
	      	    	<td><?php echo $mc['COMUNA'] ?></td>
	      	    	<td><?php echo $mc['ALUMNOS_SEP'] ?></td>
	      	    	<td><?php echo number_format(($mc['ALUMNOS_SEP']*33000)); ?></td>
	      	    	<td><?php echo $mc['CLASIFICACION'] ?></td>
	      	    	<td>
	      	    	<a href="javascript:;" data-rbd="<?php echo $mc['RBD'] ?>" onclick="ver_ficha_cliente(event)"><i class="icon-search" data-id="<?php echo $mc['RBD'] ?>"></i></a> 
	      	    	<a href="javascript:;" data-rbd="<?php echo $mc['RBD'] ?>" onclick="generar_cotizacion(event)"><i class="icon-shopping-cart" data-id="<?php echo $mc['RBD'] ?>"></i></a>
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
	   
	
</div>

<!--END ROW-->
</div>
<!--END CONTAINER-->
</div>
