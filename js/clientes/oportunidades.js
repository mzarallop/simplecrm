$(function(){
	reporte_oportunidades()
})

function reporte_oportunidades(){
	var datos = {desde:$("#desde").val(),hasta:$("#hasta").val(),case:36, path:'clientes/ajax/', estado:$("#estados").val()}
	var procesar = capsula(datos)
	var html = tmp_reporte_oportunidades_categorias(JSON.parse(procesar.fuente))
	$("#reporte_oportunidades").html(html)
}

function tmp_reporte_oportunidades_categorias(obj)
{
	var html = '<div class="tabbable tabs-left">'
		html+='<ul class="nav nav-tabs">'
	var contenido = '<div class="tab-content">'
	var contador = 1
			$.each(obj, function(){
				if(contador === 1){var activo = 'active'}else{var activo = ''}
				html+='<li class="'+activo+'"><a href="#categoria_'+this.categoria.id+'" data-toggle="tab"><span class="label label-info" style="">'+this.detalle.length+'</span> '+this.categoria.nombre+' </a></li>'
				contenido+=tmp_oportunidades_detalle(this.detalle, this.categoria.id, activo)
				contador++
			})
			contenido+='</div>'
		html+='</ul>'
		html+=contenido
	html+='</div>'

	return html
}

function tmp_oportunidades_detalle(obj, categoria, activo){
	 	
	var html='<div class="tab-pane fade in '+activo+'" id="categoria_'+categoria+'">'
	 	html+= '<table class="table table-condensed" style="font-size:11px">'
		html+='<tr>'
		html+='<td colspan="4" style="background-color: bisque;">Información colegio</td>'
		html+='<td colspan="2" style="background-color: chartreuse;">Kdoce</td>'
		html+='</tr>'
		html+='<tr>'
		html+='<td>Fecha</td>'
		html+='<td>Código</td>'
		html+='<td>Producto</td>'
		html+='<td>Colegio</td>'
		
		html+='<td>Vendedor</td>'
		html+='<td></td>'
		html+='</tr>'
	$.each(obj, function(){
		html+='<tr>'
		html+='<td>'+this.fecha_cotizacion+'</td>'
		html+='<td>'+this.id+'</td>'
		html+='<td>'+this.producto+'</td>'
		html+='<td>'+this.colegio+'</td>'
		
		html+='<td>'+this.vendedor+'</td>'
		html+='<td><button class="btn btn-mini" onclick="ver_cotizacion_iframe('+this.id+')"><i class="icon-search"></i></button></td>'
		html+='</tr>'
	})
		html+='</table>'
		html+='</div>'

		return html

}

function ver_cotizacion_iframe(idcotizacion) {
    var html = '<h4>Cotización ' + idcotizacion + '</h4><iframe src="' + server + 'clientes/cotizacion_pdf/' + idcotizacion + '" frameborder="0" width="99%" height="350"></iframe>'
    bootbox.alert(html)
}