$(function(){
	//llamadas()
	cotizaciones_aprobadas()
})

function aprobar_cotizacion(clave)
{	
	var datos = {cotizacion:clave, path:'clientes/ajax/', case:34}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var aprobadas = tmp_cotizaciones_aprobadas(data.aprobadas)
	if(data.estado === true){
		$("#cot_"+clave).fadeOut('600', function(){
			$(this).remove()
			$("#cotizacion_aprobada").html(aprobadas)
		})
	}else{
		$("#cotizacion_aprobada").html(aprobadas)
	}

}

function tmp_cotizaciones_aprobadas(obj){

	var html ='<div style="background-color:white;margin:5px;padding:5px;overflow:scroll;overflow-x:hidden;height:440px;border:1px dotted gray;width:95%">'
		html+= '<table class="table table-condesed table-striped">'
		html+='<thead><tr>'
		html+='<th>Código</th>'
		html+='<th>Fecha</th>'
		html+='<th>Colegio</th>'
		html+='<th>Monto Neto</th>'
		html+='<th>Vendedor</th>'
		html+='</tr></thead><tbody>'
	$.each(obj, function(){
		html+='<tr>'
		html+='<td>'+this.id+'</td>'
		html+='<td>'+this.fecha+'</td>'
		html+='<td>'+this.colegio+'</td>'
		html+='<td>'+this.neto+'</td>'
		html+='<td>'+this.ejecutivo+'</td>'
		html+='</tr>'
	})
	html+='</tbody></table></div>'
	return html
}

function cotizaciones_aprobadas(){
	var datos = {path:'clientes/ajax/', case:35}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var aprobadas = tmp_cotizaciones_aprobadas(data)
	$("#cotizacion_aprobada").html(aprobadas)
}