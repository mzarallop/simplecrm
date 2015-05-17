$(function(){
	pintar_regiones()
})
function traer_regiones(){

	var datos = {case:1, path:'crm/ajax'}
	var result = capsula(datos)
	var data = JSON.parse(result.fuente)
	return data

}

function detalle_comunas(region){
	var datos = {case:2, path:'crm/ajax', ID_REGION:region}
	var result = capsula(datos)
	var data = JSON.parse(result.fuente)
	var html_comunas = tmp_comunas(data, region)
	$(".cajas_segmentacion").hide()
	$("#comunas").html(html_comunas)
	$("#comunas").fadeIn()

}

function tmp_comunas(obj, region){
	var html = '<table class="table table-condensed table-striped">'
		html+='<tr>'
		html+='<th>COMUNAS</th>'
		html+='<th>COLEGIOS</th>'
		html+='<th>ALUMNOS SEP</th>'
		html+='<th>FONDOS</th>'
		/*html+='<th>MUNICIPAL</th>'
		html+='<th>SUBVENCIONADO</th>'*/
		html+='<th>DETALLE</th>'
		html+='</tr>'
	$.each(obj, function(){
		var c = this.comuna
		html+='<tr>'
		html+='<td>'+c.COMUNA+'</td>'
		html+='<td>'+accounting.formatNumber(c.TOTAL_COLEGIO, 0, ".", ",")+'</td>'
		html+='<td>'+accounting.formatNumber(c.ALUMNOS_SEP, 0, ".", ",")+'</td>'
		var inv = parseInt(c.ALUMNOS_SEP*35000)
		html+='<td>'+accounting.formatMoney(inv, "$ ", 0, ".", ",")+'</td>'
		/*html+='<td>'+this.detalle_dependencia[0].ID_DEPENDENCIA+' '+this.detalle_dependencia[0].ALUMNOS_SEP+'</td>'
		html+='<td>'+this.detalle_dependencia[1].ID_DEPENDENCIA+' '+this.detalle_dependencia[1].ALUMNOS_SEP+'</td>'
		html+='<td>'+this.detalle_dependencia[2].ID_DEPENDENCIA+' '+this.detalle_dependencia[2].ALUMNOS_SEP+'</td>'*/
		html+='<td>'
			html+='<table width="100%">'
			$.each(this.detalle_dependencia, function(){
				//html+='<button class="btn btn-small" onclick="detalle_colegios('+region+', '+this.ID_DEPENDENCIA+')">'+this.DEPENDENCIA+' ('+this.COLEGIOS+')</button> '
				html+='<tr>'
				html+='<td width="25%">'+this.DEPENDENCIA+'</td>'
				html+='<td width="25%">'+this.COLEGIOS+' (Colegios)</td>'
				html+='<td width="25%">'+accounting.formatNumber(this.ALUMNOS_SEP, 0, ".", ",")+' (Alumnos)</td>'
				html+='</tr>'
			})
			html+='</table>'
		html+='</td>'
		html+='</tr>'
	})

	html+='</table>'
	return html
}

function tmp_regiones(obj){

	var html = '<table class="table table-condensed table-striped">'
		html+='<tr>'
		html+='<th>REGION</th>'
		html+='<th>COLEGIOS</th>'
		html+='<th>ALUMNOS SEP</th>'
		html+='<th>COMUNAS</th>'
		html+='<th>FONDOS</th>'
		html+='<th></th>'
		html+='</tr>'
	$.each(obj, function(){
		var r = this.region
		html+='<tr id="region_'+r.ID_REGION+'" class="lista_regiones">'
		html+='<td class="interior interior_region"><b>'+r.REGION+'</b> </td>'
		html+='<td class="interior_colegio" title="Total de colegios">'+r.TOTAL_COLEGIOS+'</td>'
		var as = accounting.formatNumber(r.ALUMNOS_SEP, 0, ".", ",");
		
		var inversion = accounting.formatMoney(parseInt(r.ALUMNOS_SEP)*35000, "$ ", 0, ".", ",");
		html+='<td class="interior_alumnos" title="Cantidad de alumnos SEP">'+as+'</td>'
		html+='<td class="interior_comunas" title="Total de comunas">'+this.detalle.length+'</td>'
		html+='<td class="interior_inversion" title="Inversión">'+inversion+'</td>'
		html+='<td><button class="btn btn-small" onclick="detalle_comunas('+r.ID_REGION+')">VER</button></td>'
		html+='</tr>'
	})
		html+='</table>'
	return html
}

function pintar_regiones()
{
	var regiones = traer_regiones()
	var html_regiones = tmp_regiones(regiones)
	$(".cajas_segmentacion").hide()
	$('#regiones').html(html_regiones)
	$('#regiones').fadeIn()
}