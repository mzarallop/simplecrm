<div >

	<div class="tabbable">
	  <ul class="nav nav-tabs">
	    <li class="active"><a href="#tab1" data-toggle="tab">Crear Campaña</a></li>
	    <li><a href="#tab2" data-toggle="tab">Asignar Campaña</a></li>
	    <li><a href="#tab3" data-toggle="tab">Reportes de campañas</a></li>
	  </ul>
	  <div class="tab-content">
	  	 <div class="tab-pane active" id="tab1">
	  	 	 <table class="table table-striped">
	      	<tr>
	      	<td>Nombre:</td>
	      	<td><input type="text"></td>
	      	<td>Fecha Inicio:</td>
	      	<td><input type="text"></td>
	      	</tr>
	      	<tr>
	      	<td>Fecha Termino:</td>
	      	<td><input type="text"></td>
	      	<td></td>
	      	<td></td>
	      	</tr>
	      </table>
	  	 </div>
	    <div class="tab-pane" id="tab2">
	      <table class="table table-striped">
	      	<tr>
	      	<td>Campaña:</td>
	      	<td><select name="" id=""></select></td>
	      	<td>Comercial:</td>
	      	<td><select name="" id=""></select></td>
	      	</tr>
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
	      	</tr>
	      </table>
	      	<div id="clientes_bcli"></div>
	    </div>
	    <div class="tab-pane" id="tab3">
	      <p>Howdy, I'm in Section 2.</p>
	    </div>
	    <div class="tab-pane" id="tab4">
	      <p>Howdy, I'm in Section 2.</p>
	    </div>
	  </div>
	</div>

</div>

<!--END ROW-->
</div>
<!--END CONTAINER-->
</div>
