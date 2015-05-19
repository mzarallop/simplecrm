$(function(){
	reporte_gestion()
})
function gestionar_ejecutivos(){
	$(".capa").hide()
	$("#listado_usuario").fadeIn()

}
function asignar_carteras(){
	$(".capa").hide()	
	$("#cargar_carteras").fadeIn()
}
function reporte_gestion(){
	var inicio=$("#inicio").val()
	var termino=$("#termino").val()
	var datos = {
				path:'gestion/ajax', 
				case:1, 
				inicio:inicio, 
				termino:termino
			}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var html_reporte = tmp_reporte_gestion(data, datos)
	$("#reporte_gestion").html(html_reporte)
	$(".capa").hide()
	$("#reporte_gestion").fadeIn()
}

function traer_usuarios(){
	var datos={path:'gestion/ajax', case:2}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var html = tmp_usuarios(data)
	$("#usuarios_sistema").html(html)
}

function perfiles(obj){
	var per = ''
	switch(parseInt(obj)){
		case 1:
			per='SUPERVISOR'
		break;
		case 2:
			per='TELEFONO'
		break;
		case 3:
			per='ASESOR PROYECTOS'
		break;
		case 4:
			per='CAUTIVOS'
		break;
		case 5:
			per='MASTERCLASS'
		break;
	}
	return per
}


function tmp_usuarios(obj){
	var html='<div class="acciones_usuarios"><button class="btn btn-mini btn-success" style="float:right" onclick="agregar_usuario()"><i class="icon-plus icon-white"></i> Agregar nuevo usuario</button></div><br><br>'
	    html+= '<table class="table table-condensed table-striped table-bordered">'
		html+='<thead><tr>'
		html+='<th>Código</th>'
		html+='<th>Ejecutivo</th>'
		html+='<th>Correo</th>'
		html+='<th>Loggin</th>'
		html+='<th>Anexo</th>'
		html+='<th>Perfil</th>'
		html+='<th>Visible</th>'
		html+='<th>Cartera</th>'
		html+='<th></th>'
		html+='</tr></thead><tbody>'


	$.each(obj, function(){
		html+='<tr>'
		html+='<td>'+this.ID+'</td>'
		html+='<td>'+this.NOM_EJECUTIVO+'</td>'
		html+='<td>'+this.EMAIL+'</td>'
		html+='<td>'+this.LOGIN+'</td>'
		html+='<td>'+this.ANEXO+'</td>'
		html+='<td>'+perfiles(this.IDPERFIL)+'</td>'
		var estado = parseInt(this.visible)
		if(estado){
			html+='<td style="text-align:center"><a href="javascript:;" class="label label-success">Ok</a></td>'
		}else{
			html+='<td style="text-align:center"><a href="javascript:;" class="label label-warning">No</a></td>'
		}
		html+='<td style="text-align:right">'+this.total_asignacion+'</td>'
		html+='<td style="text-align:center">'
			html+='<button class="btn btn-mini btn-primary" onclick="modificar_usuario('+this.ID+')"><i class="icon-pencil icon-white"></i></button>'
		html+='</td>'
		html+='</tr>'
	})
		html+='</tbody></table>'
	return html
}

function tmp_reporte_gestion(obj, datos){

	var html = '<h3>Reporte de gestión</h3>'
	$.each(obj, function(){
		//filtrar_por perfiles
		var cargo = this.perfil.nombre
		html+='<p><h5>'+this.perfil.nombre+' ('+this.perfil.grupo+')</h5>'
		switch(parseInt(this.perfil.id)){
			case 2:
				html+= tmp_grupo_call(this.asesores, this.perfil.grupo, datos)
			break;
			case 3:
				html+= tmp_grupo_terreno(this.asesores, this.perfil.grupo)
			break;
			case 4:
				html+= tmp_grupo_cautivo(this.asesores, this.perfil.grupo, datos)
			break;
			case 5:
				html+= tmp_grupo_masterclass(this.asesores, this.perfil.grupo, datos)
			break;
		}
		
		html+='</p>'
	})
	return html
}

function tmp_grupo_call(obj, cargo, datos){

	var html = '<table class="table table-condensed table-bordered table-striped" style="font-size:11px">'
		html+='<thead><tr>'
		html+='<th>Ejecutivo</th>'
		html+='<th>Asignacion</th>'
		html+='<th>Anexo</th>'
		html+='<th>Llamadas</th>'
		html+='<th style="text-align:center">Volver a llamar</th>'
		html+='<th style="text-align:center">Entrevista</th>'
		html+='<th style="text-align:center">Presentación</th>'
		html+='<th style="text-align:center">Interesado</th>'
		html+='<th style="text-align:center">Cierre</th>'
		html+='</tr></thead><tbody>'	
		$.each(obj,function() {
			var buscar_llamadas = {path:server+'central.php', inicio:datos.inicio, termino:datos.termino, anexo:this.vendedor.anexo}
            var procesar = capsula_llamada(buscar_llamadas)
            var data = JSON.parse(procesar.fuente)
			html+='<tr>'
				html+='<td>'+this.vendedor.vendedor+'</td>'
				html+='<td>'+this.vendedor.asignacion+'</td>'
				html+='<td>'+this.vendedor.anexo+'</td>'
				html+='<td>'+data.length+'</td>'
				$.each(this.acciones, function(){
					html+='<td style="text-align:center" title="'+this.tipo.descripcion+'">'+this.detalle.length+'</td>'
				})
			html+='</tr>'	
		});
	html+='</tbody></table>'
	return html
}

function tmp_grupo_terreno(obj, cargo){

	var html = '<table class="table table-condensed table-bordered table-striped" style="font-size:11px">'
		html+='<thead><tr>'
		html+='<th>Ejecutivo</th>'
		html+='<th>Cargo</th>'
		html+='<th>Asignacion</th>'
		html+='<th style="text-align:center">Entrevista</th>'
		html+='<th style="text-align:center">Oportunidad</th>'
		html+='<th style="text-align:center">Presentación</th>'
		html+='<th style="text-align:center">Cierre</th>'
		html+='<th style="text-align:center">Cierre</th>'
		html+='</tr></thead><tbody>'	
		$.each(obj,function() {
			html+='<tr>'
				html+='<td>'+this.vendedor.vendedor+'</td>'
				html+='<td>'+cargo+'</td>'
				html+='<td>'+this.vendedor.asignacion+'</td>'
				$.each(this.acciones, function(){
					html+='<td style="text-align:center" title="'+this.tipo.descripcion+'">'+this.detalle.length+'</td>'
				})
			html+='</tr>'	
		});
	html+='</tbody></table>'
	return html
}

function tmp_grupo_cautivo(obj, cargo, datos){

	var html = '<table class="table table-condensed table-bordered table-striped" style="font-size:11px">'
		html+='<thead><tr>'
		html+='<th>Ejecutivo</th>'
		html+='<th>Asignacion</th>'
		html+='<th>Anexo</th>'
		html+='<th>Llamadas</th>'
		html+='<th style="text-align:center">Oportunidad</th>'
		html+='<th style="text-align:center">Actualizacion</th>'
		html+='<th style="text-align:center">Presentación</th>'	
		html+='<th style="text-align:center">Cierre</th>'
		html+='</tr></thead><tbody>'	
		$.each(obj,function() {
			var buscar_llamadas = {path:server+'central.php', inicio:datos.inicio, termino:datos.termino, anexo:this.vendedor.anexo}
            var procesar = capsula_llamada(buscar_llamadas)
            var data = JSON.parse(procesar.fuente)
			html+='<tr>'
				html+='<td>'+this.vendedor.vendedor+'</td>'
				html+='<td>'+this.vendedor.asignacion+'</td>'
				html+='<td>'+this.vendedor.anexo+'</td>'
				html+='<td>'+data.length+'</td>'
				$.each(this.acciones, function(){
					html+='<td style="text-align:center" title="'+this.tipo.descripcion+'">'+this.detalle.length+'</td>'
				})
			html+='</tr>'	
		});
	html+='</tbody></table>'
	return html
}

function tmp_grupo_masterclass(obj, cargo, datos){

	var html = '<table class="table table-condensed table-bordered table-striped" style="font-size:11px">'
		html+='<thead><tr>'
		html+='<th>Ejecutivo</th>'
		html+='<th>Asignacion</th>'
		html+='<th>Anexo</th>'
		html+='<th>Llamadas</th>'
		html+='<th style="text-align:center">Activación</th>'
		html+='<th style="text-align:center">PM</th>'
		html+='<th style="text-align:center">VT</th>'
		html+='<th style="text-align:center">CG</th>'
		html+='<th style="text-align:center">CP</th>'
		html+='<th style="text-align:center">TA</th>'
		html+='<th style="text-align:center">Renovación</th>'
		html+='</tr></thead><tbody>'	
		$.each(obj,function() {
			var buscar_llamadas = {path:server+'central.php', inicio:datos.inicio, termino:datos.termino, anexo:this.vendedor.anexo}
            var procesar = capsula_llamada(buscar_llamadas)
            var data = JSON.parse(procesar.fuente)
			html+='<tr>'
				html+='<td>'+this.vendedor.vendedor+'</td>'
				html+='<td>'+this.vendedor.asignacion+'</td>'
				html+='<td>'+this.vendedor.anexo+'</td>'
				html+='<td>'+data.length+'</td>'
				$.each(this.acciones, function(){
					html+='<td style="text-align:center" title="'+this.tipo.descripcion+'">'+this.detalle.length+'</td>'
				})
			html+='</tr>'	
		});
	html+='</tbody></table>'
	return html
}

function modificar_usuario(id){
		var datos={path:'gestion/ajax', case:2, id:id}
		var procesar = capsula(datos)
		var data = JSON.parse(procesar.fuente)
		
		var msn = '<h1>Modificar Usuario</h1><table class="table table-condensed table-striped">'
			msn+='<tr>'
			msn+='<td>Nombre:<br><input type="text" id="nombre_usuario" value="'+data[0].NOM_EJECUTIVO+'"/></td>'
			msn+='<td>Correo:<br><input type="text" id="email_usuario" value="'+data[0].EMAIL+'"/></td>'
			msn+='</tr>'
			msn+='<tr>'
			msn+='<td>Loggin:<br><input type="text" id="loggin_usuario" value="'+data[0].LOGIN+'"/></td>'
			msn+='<td>Contraseña:<br><input type="password" id="pass_usuario" value="'+data[0].PASSWORD+'"/></td>'
			msn+='</tr>'
			msn+='<tr>'
			if(parseInt(data[0].visible)===1){
				msn+='<td>Estado:<br><input type="radio" name="visible" value="1" checked="checked"/> Activado <br> <input type="radio" name="visible" value="0"/> Desactivado</td>'
			}else{
				msn+='<td>Estado:<br><input type="radio" name="visible" value="1"/> Activado <br> <input type="radio" name="visible" value="0" checked="true"/> Desactivado</td>'
			}
			
			msn+='<td>Anexo:<br><input type="text" id="anexo_usuario" value="'+data[0].ANEXO+'" /></td>'
			msn+='</tr>'
			msn+='</table>'

		bootbox.confirm(msn, function(r){
			if(r){
				var datos={
						   id:id,
						   path:'gestion/ajax', case:3, nombre:$("#nombre_usuario").val(),
						   email:$("#email_usuario").val(), loggin:$("#loggin_usuario").val(),
						   password:$("#pass_usuario").val(), visible:$('input:radio[name=visible]:checked').val(),
						   anexo:$("#anexo_usuario").val()
						}

				var procesar = capsula(datos)
				var data = JSON.parse(procesar.fuente)
				if(data){
					traer_usuarios()
				}
			}
		})


}

function agregar_usuario(){
			var msn = '<h1>Crear Usuario</h1><table class="table table-condensed table-striped">'
			msn+='<tr>'
			msn+='<td>Nombre:<br><input type="text" id="nombre_usuario"/></td>'
			msn+='<td>Correo:<br><input type="text" id="email_usuario"/></td>'
			msn+='</tr>'
			msn+='<tr>'
			msn+='<td>Loggin:<br><input type="text" id="loggin_usuario" /></td>'
			msn+='<td>Contraseña:<br><input type="password" id="pass_usuario"/></td>'
			msn+='</tr>'
			msn+='<tr>'
			msn+='<td>Perfil del usuario<br>'
			msn+='<select name="perfil_usuario" id="perfil_usuario">'
				msn+='<option value="0">--</option>'
				msn+='<option value="2" selected>Asesor Telefónico</option>'
				msn+='<option value="3">Asesor Terreno</option>'
				msn+='<option value="4">Clientes cautivos</option>'
				msn+='<option value="5">Asesor Masterclass</option>'				
				msn+='<option value="1">Supervisor</option>'				
			msn+='</select>'
			msn+='</td>'
			msn+='<td></td>'
			msn+='</tr>'
			msn+='<tr>'
		bootbox.confirm(msn, function(r){
			if(r){
				var datos = {nombre:$("#nombre_usuario").val(), email:$("#email_usuario").val(),
							login:$("#loggin_usuario").val(), pass:$("#pass_usuario").val(),
							perfil:$("#perfil_usuario").val(), path:'gestion/ajax/', case:4}
				var procesar = capsula(datos)
				var data = JSON.parse(procesar.fuente)
				if(data){
					traer_usuarios()
				}
			}
		})
}