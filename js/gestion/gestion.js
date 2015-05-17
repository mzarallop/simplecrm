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
	var datos = {path:'gestion/ajax', case:1}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var html_reporte = tmp_reporte_gestion(data)
	$("#reporte_gestion").html(html_reporte)
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

function tmp_reporte_gestion(obj){

	var html = '<h3>Reporte de gestión</h3>'
	$.each(obj, function(){
		//filtrar_por perfiles
		var cargo = this.perfil.nombre
		html+='<p><h5>'+this.perfil.nombre+' ('+this.perfil.grupo+')</h5>'
		html+='<table class="table table-condensed table-striped table-bordered" style="font-size:11px">'
			html+='<thead><tr>'
			html+='<th>Corr</th>'
			html+='<th>Nombre</th>'
			html+='<th>Cargo</th>'
			html+='<th>Asignación</th>'
			html+='<th>Meta</th>'
			html+='<th>Presentaciones</th>'
			html+='<th>Oportunidades</th>'
			html+='<th>Total Neto</th>'
			html+='<th>% op / asig</th>'
			html+='</tr></thead><tbody>'
			var cont = 1;
			$.each(this.asesores, function(){
			html+='<tr><td>'+cont+'</td>'
			html+='<td>'+this.vendedor.vendedor+'</td>'
			html+='<td>'+cargo+'</td>'
			html+='<td>'+this.vendedor.asignacion+'</td>'
			html+='<td>60</td>'
			//presentaciones
				var presentaciones = 0
				$.each(this.acciones, function(){
					if(parseInt(this.id)===5||parseInt(this.id)===35||parseInt(this.id)===31){
						presentaciones = presentaciones+parseInt(this.total_gestion)
					}
				})
			html+='<td>'+presentaciones+'</td>'
			var oportunidades= 0;
			if(parseInt(this.cotizaciones.total_cotizacion)>0){
				oportunidades = this.cotizaciones.total_cotizacion
				html+='<td>'+this.cotizaciones.total_cotizacion+'</td>'
				html+='<td>'+accounting.formatMoney(this.cotizaciones.total_final, "$ ", 0, ".", ",")+'</td>'
			}else{
				html+='<td>0</td>'
				html+='<td>$ 0</td>'
			}
			
			html+='<td>'+(parseInt(oportunidades)/parseInt(this.vendedor.asignacion)*100).toFixed(0)+' % </td></tr>'
			cont++
			})
			html+='</tbody></table></p>'
	})
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