<div >

	<div class="tabbable tabs-left">
	  <ul class="nav nav-tabs">
	    <li class="active"><a href="#tab1" data-toggle="tab">Asignaciones</a></li>
	    <li><a href="#tab3" data-toggle="tab">Carteras</a></li>
	</ul>
	  <div class="tab-content">
	    <div class="tab-pane active" id="tab1">
	      <!-- cliente filtros -->
	      <div id="filtros_clientes" >
	      <table class="table table-striped table-bordered table-condensed">
	      	<tr>
	      		<td>Región:</td>
	      		<td>
	      			<select id="region_bcli">
	      				<option value="">--</option>
	      				<?php foreach($regiones as $reg): ?>
	      				<option value="<?php echo $reg['id'] ?>"><?php echo $reg['nombre'] ?> (<?php echo $reg['total'] ?>)</option>
	      			<?php endforeach; ?>
	      			</select>
	      		</td>
	      		<td>Comuna:</td>
	      		<td>
	      			<select id="comuna_bcli">
	      				<option>--</option>
	      			</select>
	      		</td>
	      		<td>Dependencia:</td>
		      		<td>
		      		<select id="dependencia">
		      			<option>--</option>
		      		</select>
		      		</td>
		      	</tr>
		      	<tr>
		      		<td>Clasificación:</td>
		      		<td><select id="clasificacion"><option>--</option></select></td>
		      		<td>Area:</td>
		      		<td>
			      		<select id="area">
			      			<option>--</option>
			      		</select>
		      		</td>
		      		<td>
		      			Vendedores:
		      		</td>
		      		<td>
		      		<select id="vendedor">
		      			<option value="">--</option>
		      		<?php foreach($vendedores as $vend): ?>
		      			<option value="<?php echo $vend['ID']; ?>">
		      				<?php echo $vend['NOM_EJECUTIVO']; ?> (<?php echo $vend['total']; ?>)
		      			</option>
		      		<?php endforeach;  ?>
		      		</select>
		      		</td>
		      	</tr>
		      	<tr>
		      		<td colspan="6">
		      			 <button class="btn btn-primary" style="float:right" onclick="asignacion_cartera()"><i class="icon-white icon-time"></i> Asignar</button>
		      		</td>
		      	</tr>

	      </table>

	      	<label style="width:auto;"><input type="checkbox" class="icon-thumbs-up" onclick="select_all(this)"> Seleccionar Todo</label>
	      	<div id="clientes_bcli">

	      	</div>
	      </div>
	     <!--fin de filtros clientes -->
	     <!--inicio ficha cliente -->
	     	<div id="ficha_cliente" style="display:none">
	     		<div id="datos_cliente" style="diaply:none"></div>
	     		<div class="accordion" id="accordion2">
	     	<div class="accordion-group">
	    		<div class="accordion-heading" style="vertical-align:top">
	      		<a id="contactos_clientes" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" onclick="ver_contactos(event)">
	      		<i class="icon-user"></i> Contactos del cliente
	      		</a>

	      		</div>
	      		<div id="collapseTwo" class="accordion-body collapse">
      				<div class="accordion-inner">
      					<a href="javascript:;" class="btn btn-mini" onclick="nuevo_contacto()"><i class="icon-plus-sign"></i> Nuevo</a>
	     				<div id="ccf"></div>

	     			</div>
	     		</div>
	     	</div>
	     	<div class="accordion-group">
	    		<div class="accordion-heading">
	      		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTree" onclick="ver_gestiones(event)">
	      		<i class="icon-comment"></i> Gestiones del cliente
	      		</a>
	      		</div>
	      		<div id="collapseTree" class="accordion-body collapse">
      				<div class="accordion-inner">
			     	<a href="javascript:;" class="btn btn-mini" onclick="nueva_gestion()"><i class="icon-plus-sign"></i> Nueva gestion :)</a>
			     		<p><table class="table table-condensed table-bordered">
			     		<tr>
			     		<td>
			     		<div id="ficha_clientes_list"></div>
			     		</td>
			     		</tr>
			     		<tr>
			     		<td>
			     		</td>
			     		</tr>
			     		</table></p>
			     	</div>
			     </div>
			   </div>
	     	</div>
	     	<button class="btn btn-warning" onclick="volver_filtros_clientes()">
			     			<i class="icon-white icon-arrow-left"></i> Volver
			     		</button>

	     	</div>
	     <!--fin ficha cliente-->
	    </div>
	    <div class="tab-pane" id="tab2">
	      <p>Howdy, I'm in Section 2.</p>
	    </div>
	    <div class="tab-pane" id="tab3">
	     Vendedor: <select id="vendedor_cartera" onchange="mostrar_cartera(this.value)">
		      			<option value="">--</option>
		      		<?php foreach($vendedores as $vend): ?>
		      			<option value="<?php echo $vend['ID']; ?>">
		      				<?php echo $vend['NOM_EJECUTIVO']; ?> (<?php echo $vend['total']; ?>)
		      			</option>
		      		<?php endforeach;  ?>
		      		</select>
		    <p>
		    	<div id="lista_cartera_ejecutivo"></div>
		    </p>
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
