<div >

	<div class="tabbable tabs-left"> 
	  <ul class="nav nav-tabs">
	    <li class="active"><a href="#tab1" data-toggle="tab">Lista de corporaciones</a></li>
	    <li><a href="#tab2" data-toggle="tab">Gestiones</a></li>
	    <li><a href="#tab3" data-toggle="tab">Agenda</a></li>
	    <li><a href="#tab4" data-toggle="tab">Informe de gestiones</a></li>
	  </ul>
	  <div class="tab-content">
	    <div class="tab-pane active" id="tab1">
	      <!-- cliente filtros -->
	      <div id="filtros_clientes" >
	      	    <div id="clientes_bcli">
	      	    <table class="tablesorter">
	      	    <thead>
	      	    <tr>
	      	    	<th>Rut</th>
	      	    	<th>Sostenedor</th>
	      	    	<th>Dependencia</th>
	      	    	<th>Colegios</th>
	      	    	<th>SEP</th>
	      	    	<th>Monto</th>
	      	    	<th></th>
	      	    </tr>
	      	    </thead>
	      	    <tfoot>
			<th colspan="7" class="pager form-horizontal">
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
		</tr>
	</tfoot>
	      	    <tbody>
	      	    	<?php $cont =1; foreach($mi_cartera as $mc): ?>
	      	    	<tr id="<?php echo $mc['RUT'] ?>">
	      	    	<td><?php echo number_format($mc['RUT'],0); ?></td>
	      	    	<td><?php echo $mc['SOSTENEDOR']; ?></td>
	      	    	<td><?php echo $mc['DEPENDENCIA']; ?></td>
	      	    	<td><?php echo $mc['COLEGIOS']; ?></td>
	      	    	<td><?php echo number_format($mc['ALUMNOS_SEP'], 0); ?></td>
	      	    	<td>$ <?php echo number_format($mc['TSEP'],0); ?></td>
	      	    	<td>
	      	    	<a href="javascript:;" data-rbd="<?php echo $mc['RUT'] ?>" onclick="ver_ficha_cliente(event)"><i  data-id="<?php echo $mc['RUT'] ?>"></i> Ver Ficha</a> 
	      	    	<a href="javascript:;" data-rbd="<?php echo $mc['RUT'] ?>" onclick="generar_cotizacion(event)"><i data-id="<?php echo $mc['RUT'] ?>"></i> Cotizar</a>
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
	      		<a href="javascript:;" class="btn btn-mini" onclick="nueva_gestion()"><i class="icon-plus-sign"></i> Nueva gestion :)</a>	
			     		<div id="lista_gestiones"></div>
			     </div>
			     <!-- FIN DE CONTENEDOR CLIENTES -->
			
	     <!--fin ficha cliente-->
	    </div>
	    </div>
	    <div class="tab-pane" id="tab2">
	      <p>Howdy, I'm in Section 2.</p>
	    </div>
	    <div class="tab-pane" id="tab3">
	      <p>Howdy, I'm in Section 3.</p>
	    </div>
	    <div class="tab-pane" id="tab4">
	      <p>Howdy, I'm in Section 4.</p>
	    </div>
	  </div>
	</div>

</div>

<!--END ROW-->
</div>
<!--END CONTAINER-->
</div>
