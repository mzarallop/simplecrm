function segmentos(){
	var vector = new Array; 
	$.each($('#segmento :selected'),function(i, valor){ vector.push(valor.value); });
	return vector
}

function selRegiones(valor){
	

	var procesar = capsula({path:'marketing/ajax', case:1, data:segmentos()})
	var data  = JSON.parse(procesar.fuente)
	optionRegiones(data)
	filtrarColegios()
}

function optionRegiones(data){

	var option = '<option value="0">Todas</option>'
	$.each(data, function(){
		option+='<option value="'+this.COD_REG_RBD+'">'+this.COD_REG_RBD+' Región  ('+this.TOTAL_COLEGIOS+' Colegios)</option>'
	})

	$("#region").html(option)

}

function selComunas(valor){

	var data = {
		segmento:segmentos(),
		region:valor
	}

	var procesar = capsula({path:'marketing/ajax', case:2, data:data})
	var data  = JSON.parse(procesar.fuente)
	optionComunas(data)
	filtrarColegios()
}

function optionComunas(data){
	var option = '<option value="0">Todas</option>'
	$.each(data, function(){
		option+='<option value="'+this.COD_COM_RBD+'">'+this.NOM_COM_RBD+' ('+this.TOTAL_COLEGIOS+' Colegios)</option>'
	})

	$("#comuna").html(option)
}

function filtrarColegios(){
	var data = {
		segmento:segmentos(),
		region:$("#region").val(),
		comuna:$("#comuna").val()
	}

	var procesar = capsula({path:'marketing/ajax', case:3, data:data})
	var data  = JSON.parse(procesar.fuente)
	$(".tabla_colegios").html(pintarColegios(data))
	 $('#tabla_colegios').DataTable({
	     buttons: [
        'copy', 'excel', 'pdf'
    ]
	 });
}

function pintarColegios(data){

	var tabla = '<table  id="tabla_colegios" class="table table-condensed table-striped">'
	tabla+='<thead>'
	tabla+='<tr>'
	tabla+='<th></th>'
	tabla+='<th>RBD</th>'
	tabla+='<th>COLEGIO</th>'
	tabla+='<th>DEPENDENCIA</th>'
	tabla+='<th>PRIORITARIOS</th>'
	tabla+='<th>BEN</th>'
	tabla+='</tr>'
	tabla+='</thead><tbody>'
	$.each(data, function(){
		tabla+='<tr>'
		tabla+='<td><input type="checkbox" value="'+this.RBD+'" checked="true"/></td>'
		tabla+='<td>'+this.RBD+'</td>'
		tabla+='<td>'+this.NOM_RBD+'</td>'
		tabla+='<td>'+this.COD_DEPE+'</td>'
		tabla+='<td>'+this.N_PRIO+'</td>'
		tabla+='<td>'+this.N_BEN+'</td>'
		tabla+='</tr>'
	})
	tabla+='</tbody></table>'
	return tabla
}




