$(function(){
	reporte_oportunidades()
})

function reporte_oportunidades(){
	var datos = {desde:$("#desde").val(),hasta:$("#hasta").val(),case:36, path:'clientes/ajax/'}
	var procesar = capsula(datos)
	var html = tmp_reporte_oportunidades_categorias(JSON.parse(procesar.fuente))
	$("#reporte_oportunidades").html(html)
}

function tmp_reporte_oportunidades_categorias(obj)
{
	var html = '<h2>Oportunidades del mes</h2><div class="tabbable tabs-left">'
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
		html+='<td colspan="5" style="background-color: bisque;">Información colegio</td>'
		html+='<td style="background-color: chartreuse;">Kdoce</td>'
		html+='</tr>'
		html+='<tr>'
		html+='<td>Fecha</td>'
		html+='<td>Código</td>'
		html+='<td>Producto</td>'
		html+='<td>Colegio</td>'
		html+='<td>Contacto</td>'
		html+='<td>Vendedor</td>'
		html+='</tr>'
	$.each(obj, function(){
		html+='<tr>'
		html+='<td>'+this.fecha_cotizacion+'</td>'
		html+='<td>'+this.id+'</td>'
		html+='<td>'+this.producto+'</td>'
		html+='<td>'+this.colegio+'</td>'
		html+='<td>'+this.contacto+'</td>'
		html+='<td>'+this.vendedor+'</td>'
		html+='</tr>'
	})
		html+='</table>'
		html+='</div>'

		return html

}