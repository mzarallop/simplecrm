$(function(){

    $(".age").age()
     $('#cartera').DataTable({
        "scrollY":        "450px",
        "scrollCollapse": false,
        "paging":         false
    } );

  //  detectBrowser()
})

function initialize(obj) {
  var mapOptions = {
    center: new google.maps.LatLng(obj.lat, obj.lng),
    zoom: 14,
     mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.DEFAULT,
      mapTypeIds: [
        google.maps.MapTypeId.ROADMAP,
        google.maps.MapTypeId.TERRAIN
      ]
    },
    zoomControl: true,
    zoomControlOptions: {
      style: google.maps.ZoomControlStyle.SMALL
    }
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  var marker = new google.maps.Marker({
    map: map,
    title:obj.NOMBRE,
    position: map.getCenter()
  });
  
  var infowindow = new google.maps.InfoWindow({
      content: obj.html
  });
  
  infowindow.open(map, marker);
  google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map, marker);
  });
}

/*
function detectBrowser() {
  var useragent = navigator.userAgent;
  var mapdiv = document.getElementById("map-canvas");

  if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1 ) {
    mapdiv.style.width = '100%';
    mapdiv.style.height = '100%';
  } else {
    mapdiv.style.width = '100%';
    mapdiv.style.height = '350px';
  }
}*/
function remover_contacto(id){
	var datos = {id:id, path:'clientes/ajax/', case:46}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)

	if(data){
		$("#contacto_"+id).remove()
	}else{
		bootbox.alert('No se logro eliminar el contacto!');
	}
}
function ficha(rbd){

	var datos = {rbd:rbd, path:'clientes/ajax/', case:37}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	$(".capas").hide()
	var ficha_detalle = tmp_ficha_detalle(data)
	var ficha_cotizacion = tmp_ficha_cotizacion(data)
	var ficha_contactos = tmp_ficha_contactos(data)
	var ficha_gestiones = tmp_ficha_gestiones(data)
	var ficha_productos = tmp_ficha_productos(data)
	//total productos
	var total_productos = parseInt(data[0].facturas.length)
	var total_gestiones = parseInt(data[0].gestiones.length)
	var total_cotizaciones = parseInt(data[0].cotizaciones.length)
	var total_contactos = parseInt(data[0].contactos.length)

	$("#propuestas_detalle").html(ficha_cotizacion)
	$("#ficha_detalle").html(ficha_detalle)
	$("#contactos_detalle").html(ficha_contactos)
	$("#gestiones_detalle").html(ficha_gestiones)
	$("#productos_detalle").html(ficha_productos)
	$("#ficha_cliente").fadeIn('fast')
	$("#productos_facturados").DataTable();
	
	$('#total_productos').text(total_productos).addClass('label label-info')
	$('#total_gestiones').text(total_gestiones).addClass('label label-info')
	$('#total_cotizaciones').text(total_cotizaciones).addClass('label label-info')
	$('#total_contactos').text(total_contactos).addClass('label label-info')
	

	
	var colegio = data[0].resumen
	var obj = {lat:colegio.LATITUD, lng:colegio.LONGITUD,html:'Teléfono:'+colegio.TELEFONO}
	google.maps.event.addDomListener(window, 'load', initialize(obj));

}
	function tmp_ficha_productos(obj){
		var prod = obj[0].facturas
		var html = '<table id="productos_facturados" class="display compact" style="font-size:11px">'
			html+='<thead><tr>'
			html+='<th>Fecha</th>'
			html+='<th>Factura</th>'
			html+='<th>Productos</th>'
			html+='<th>Unidades</th>'
			html+='<th>Valor Neto</th>'
			html+='<th>Total</th>'
			html+='</tr></thead><tbody>'
		$.each(prod, function(){
			html+='<tr>'
			html+='<td>'+this.mes+'-'+this.year+'</td>'
			html+='<td>'+this.idfactura+'</td>'
			html+='<td>'+this.descripcion+'</td>'
			html+='<td>'+this.unidades+'</td>'
			html+='<td>'+accounting.formatMoney(this.neto, "$ ", 0, ".", ",")+'</td>'
			html+='<td>'+accounting.formatMoney((parseInt(this.unidades)*parseInt(this.neto)), "$ ", 0, ".", ",")+'</td>'
			html+='</tr>'
		})
		html+='</tbody></table>'
		return html
	}

function volver_prospectos(){
	//window.location.href = server+'clientes/'
	$(".capas").hide()
	$("#lista_prospectos").fadeIn('fast')

}

function tmp_ficha_gestiones(obj){

	var colegio = obj[0].resumen
	var html='<h4>Gestiones:<div style="float:right"><button class="btn btn-mini btn-success" onclick="agregar_gestion('+colegio.RBD+')"><i class="icon-plus"></i></button></div></h4><div><table style="font-size:10px" class="table table-crondesed">'
	$.each(obj[0].gestiones, function(){
		html+='<tr id="gestion_'+this.ID+'">'
		html+='<td>'+this.fecha+'</td>'
		html+='<td>'+this.vendedor+'</td>'
		html+='<td>'+this.gestion+'</td>'
		html+='<td valign="top">'+this.observaciones+'</td>'
		html+='<td><button class="btn btn-mini btn-danger" onclik="remover_contacto('+this.ID+')"><i class="icon-white icon-trash"></i></button></td>'
		html+='</tr>'
	})
	html+='</table></div>'
	return html

}

function tmp_ficha_contactos(obj){
	var colegio = obj[0].resumen
	var html='<h4>Contactos:<div style="float:right"><button class="btn btn-mini btn-success" onclick="agregar_usuario('+colegio.RBD+')"><i class="icon-plus"></i></button></div></h4><table style="font-size:12px" class="table table-crondesed">'
	$.each(obj[0].contactos, function(){
		html+='<tr id="contacto_'+this.ID+'">'
		html+='<td>'+this.NOMBRE+'</td>'
		html+='<td>'+this.CARGO+'</td>'
		html+='<td>'+this.TELEFONO+'</td>'
		html+='<td>'+this.EMAIL+'</td>'
		html+='<td><button class="btn btn-mini btn-danger" onclick="remover_contacto('+this.ID+')"><i class="icon-white icon-trash"></i></button></td>'
		html+='</tr>'
	})
	html+='</table>'
	return html
}

function tmp_ficha_detalle(obj){
	var colegio = obj[0].resumen
	var html='<h4>Ficha del colegio: <span class="label label-info">Entrevista</span> <div style="float:right"><button class="btn btn-mini btn-success" onclick="actualizar_colegio('+colegio.RBD+')"><i class="icon-white icon-refresh"></i> Actualizar Datos</button></div></h4><table style="font-size:12px" class="table table-crondesed">'
	html+='<tr>'
	html+='<td>RBD<br>'+colegio.RBD+'</td>'
	html+='<td>Nombre Colegio:<br><input type="text" class="span10" id="nombre_colegio" class="input_form" value="'+colegio.NOMBRE+'"/></td>'
	html+='<td>Matrícula:<br><input type="text" id="matricula_colegio" class="input_form" value="'+colegio.MATRICULA+'"/></td>'
	html+='</tr>'
	html+='<tr>'
	html+='<td>Rut<br><input type="text" id="rut_colegio" class="span4" value="'+colegio.RUT+'"/></td>'
	html+='<td>Sostenedor:<br><input type="text" class="span10" id="sostenedor_colegio"  value="'+colegio.SOSTENEDOR+'"/></td>'
	html+='<td>SEP:<br><input type="text" class="" id="alumnos_colegio"  value="'+colegio.ALUMNOS_SEP+'"/></td>'
	html+='</tr>'
	html+='<tr>'
	html+='<td>Dependencia:<br>'+colegio.DEPENDENCIA+'</td>'
	html+='<td>Región:<br>'+colegio.REGION+'</td>'
	html+='<td>Comuna:<br>'+colegio.COMUNA+'</td>'
	html+='</tr>'
	html+='<tr>'
	html+='<td colspan="4">Dirección:<br><input id="direccion_colegio" type="text" class="span12" value="'+colegio.DIRECCION+'" /></td>'
	html+='</tr>'
	html+='<tr>'
	html+='<td>Código area:<br> <span class="telefono">('+colegio.COD_AREA+')</span></td>'
	html+='<td>Teléfono:<br> <input type="text" id="telefono_colegio"  value="'+colegio.TELEFONO+'"/></td>'
	html+='<td>Director:<br><input type="text"  id="director_colegio"  value="'+colegio.DIRECTOR+'"/></td>'
	html+='</tr>'
	html+='<tr>'
	html+='<td>Area:<br>'+colegio.AREA+'</td>'
	html+='<td>Clasificación:<br>'+colegio.CLASIFICACION+'</td>'
	var monto_sep = ((parseInt(colegio.ALUMNOS_SEP)*40000)*12)
	html+='<td>Capacidad de Inversión:<br> <b>$ '+monto_sep.toFixed(0).replace(/./g, function(c, i, a) {return i && c !== "." && !((a.length - i) % 3) ? ',' + c : c;})+'</b></td>'
	html+='</tr>'
	html+='</table>'
	return html
}

function tmp_ficha_cotizacion(obj){
	var colegio = obj[0].resumen
	var html = '<h4>Cotizaciones:<div style="float:right"><a href="'+server+'clientes/cotizacion/'+colegio.RBD+'" target="_new" class="btn btn-mini btn-success"><i class="icon-plus"></i></a></div></h4><table class="table table-condesed table-striped">'
		html+='<thead><tr>'
		html+='<th>Código</th>'
		html+='<th>Proyecto</th>'
		html+='<th>Contacto</th>'
		html+='<th>Precio</th>'
		html+='<th></th>'
		html+='</tr></thead><tbody>'
	$.each(obj[0].cotizaciones, function(){
		html+='<tr>'
		html+='<td>'+this.id+'</td>'
		html+='<td>'+this.nombre_producto+'</td>'
		html+='<td>'+this.contacto+'</td>'
		html+='<td>$ '+moneda(this.precio)+'</td>'
		html+='<td><button class="btn btn-mini" onclick="visor_cotizacion('+this.id+')"><i class="icon-search"></i></button></td>'
		html+='</tr>'
	})
	html+='</tbody></table>'
	return html
}

function tmp_propuestas(obj){

}

function productos(){
	var datos = {case:38, path:'clientes/ajax/'}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	return data
}

function tipo_gestion(){
	var datos = {case:39, path:'clientes/ajax/'}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	return data
}

function traer_personal(){
		var datos = {case:5, path:'crm/ajax/'}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	return data
}

function agregar_gestion(rbd){
	var reloj = new Date();
	var html = '<h2>Nueva Gestión </h2>'
		html+='<table class="table table-condesed table-striped">'
		html+='<tr>'
		html+='<td>Tipo de gestión:</td>'
		html+='<td>'
		//tipo de gestion
			html+='<select name="tipo_gestion_sel" id="tipo_gestion_sel">'
				html+='<option value="0">--</option>'
			var gestion = tipo_gestion()
			$.each(gestion, function(){
				if(parseInt(this.id) === 34){
					html+='<option value="'+this.id+'" selected>'+this.descripcion+'</option>'
				}else{
					html+='<option value="'+this.id+'">'+this.descripcion+'</option>'
					
				}
			})
			html+='</select>'
		html+='</td>'
		html+='<td>Fecha:</td>'
		html+='<td><input type="date" id="fecha" /></td>'
		html+='</tr>'
		html+='<tr>'
		html+='<td>Hora:</td>'
		var minuto = reloj.getMinutes()
		var hora = reloj.getHours()
		if(parseInt(hora)<10){hora = '0'+hora}else{hora = hora}
		if(parseInt(minuto)<10){minuto = '0'+minuto}else{minuto = minuto}
		html+='<td><input type="time" name="hora" id="hora" value="'+hora+':'+minuto+'" /></td>'
		html+='<td>Asignar a:</td>'
		var personal = traer_personal()
			html+='<td>'
				html+='<select name="personal" id="personal">'
				html+='<option value="0">--</option>'
				$.each(personal, function(){
					html+='<option value="'+this.ID+'">'+this.NOM_EJECUTIVO+'</option>'
				})
				html+='</select>'
			html+='</td>'
		html+='</tr>'
		html+='<tr>'
		html+='<td colspan="2">Observaciones:<br>'
		html+='<textarea name="observaciones"  id="observaciones" class="span5" rows="5"></textarea></td>'
		html+='<td colspan="2">'
		//select multiple
		html+='Proyectos de interes: <br>'
		html+='<select name="proyectos[]" id="proyectos" class="span5" style="height:150px" multiple>'

		var vector_productos = productos()
		html+='<option value="0" selected>Sin proyectos definidos</option>'
		$.each(vector_productos, function(){
			html+=' <optgroup label="'+this.categoria.nombre+'">'
				$.each(this.productos, function(){
					html+='<option value="'+this.id+'">'+this.nombre+'</option>'
				})
			html+='</optgroup>'
		})
		html+='</select>'
		html+='</td>'
		html+='</tr>'
		html+='</table>'
	bootbox.confirm(html, function(resp){
		if(resp){

			var proyectos = $("#proyectos option:checked")
			var vector_interes = new Array
			$.each(proyectos, function(){
				vector_interes.push(this.value)
			})

			var datos_gestion = {
				rbd:rbd,
				interes:vector_interes,
				gestion:$("#tipo_gestion_sel").val(),
				observaciones:$("#observaciones").val(),
				fecha_agenda:$("#fecha").val(),
				responsable:$("#personal").val(),
				hora_agenda:$("#hora").val(),
				case:40,
				path:'clientes/ajax/'
			}

			console.log(datos_gestion)
			var crear = capsula(datos_gestion)
			var resultado = JSON.parse(crear.fuente)
			
			if(parseInt(resultado)>0){
				ficha(rbd)
			}else{
				bootbox.alert("No se creo la gestion")
			}


		}
	})

}

function agregar_usuario(rbd){
	var html = '<h2>Agregar usuario</h2>'
		html+='<table class="table table-condesed table-striped">'
		html+='<tr>'
		html+='<td>Nombre:</td>'
		html+='<td><input type="text" id="nombre" /></td>'
		html+='<td>Email:</td>'
		html+='<td><input type="email" id="email" /></td>'
		html+='</tr>'
		html+='<tr>'
		html+='<td>Cargo:</td>'
		html+='<td><input type="text" id="cargo" /></td>'
		html+='<td>Teléfono:</td>'
		html+='<td><input type="text" id="telefono" /></td>'
		html+='</tr>'
		html+='</table>'
	
	bootbox.confirm(html, function(resp){
		if(resp){
			var datos = {
				rbd:rbd,
				nombre:$("#nombre").val(),
				email:$("#email").val(),
				cargo:$("#cargo").val(),
				telefono:$("#telefono").val(),
				case:44,
				path:'clientes/ajax/'
			}
			console.log(datos)
			var procesar = capsula(datos)
			var data = JSON.parse(procesar.fuente)
			ficha(rbd)
		}
	})
}
function visor_cotizacion(idcotizacion) {
    var html = '<h4>Cotización ' + idcotizacion + '</h4><iframe src="' + server + 'clientes/cotizacion_pdf/' + idcotizacion + '" frameborder="0" width="99%" height="350"></iframe>'
    bootbox.alert(html)
}

function mis_pendientes(){
	var datos = {case:42, path:'clientes/ajax'}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var html_pendientes = tmp_pendientes(data)
	$(".capas").hide()
	$("#mispendientes").html(html_pendientes)
	$("#mispendientes").fadeIn('fast')
}

function tmp_pendientes(obj)
{
	var html = '<h4>Resumen de los próximos 5 días</h4><div class="row-fluid" style="font-size:10px">'
	$.each(obj, function(){
		html+='<div class="panel_dia">'
		html+='<span class="titulo_dia">'+this.nombre_dia+'<br>'+this.fecha_dia+'</span>'
		//eventos
			html+='<ul class="dia_eventos">'
			$.each(this.eventos, function(){
				html+='<li class="evento" onclick="ficha('+this.rbd+')">'
					html+='<span class="'+this.label+'">'+this.hora+' '+this.gestion+'</span><br>'
					html+=''+this.nombre+''
				html+='</li>'
			})
			html+='</ul>'
		html+='</div>'
	})
	html+='</div>'
	return html
}

function reporte_gestion(){
	var datos = {case:43, path:'clientes/ajax'}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var html_gestiones = tmp_reporte_gestion(data)
	$(".capas").hide()
	$("#reportegestion").html(html_gestiones)
	$("#reportegestion").fadeIn('fast')
}

function tmp_reporte_gestion(obj)
{
	var html = '<h4>Reporte del mes</h4><div class="row-fluid" style="font-size:10px">'
	$.each(obj, function(){
		html+='<div class="span3 panel_dia">'
		var label = this.gestion.label
		html+='<span class="titulo_dia">'+this.gestion.descripcion+'<h1>'+this.resumen.length+'</h1></span>'
		//eventos
			html+='<ul class="dia_eventos">'
			$.each(this.resumen, function(){
				html+='<li class="evento" onclick="ficha('+this.rbd+')">'
					html+='<span class="">'+this.colegio+'</span>'
				html+='</li>'
			})
			html+='</ul>'
		html+='</div>'
	})
	html+='</div>'
	return html
}

function traer_cartera_gestion(){
	var datos = {case:3, path:'crm/ajax'}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var html_tipo_gestion = tmp_tipo_gestiones(data)
	$(".capas").hide()
	$("#tipo_gestion").html(html_tipo_gestion)
	$("#tipo_gestion").prepend('<div id="gestion" style=""></div></div>')
	pintar_grafico()
	$("#tipo_gestion").fadeIn()
}


function tmp_tipo_gestiones(obj){

	var html = '<ul class="estados_cartera">'
		$.each(obj, function(){
			html+='<li>'
			
			var color_id = parseInt(this.gestion.id)
			switch(color_id){
						case 1: var color = 'grey';	break;
						case 2: var color = 'rgb(58, 135, 173)'; break;
						case 5: var color = 'rgb(248, 148, 6)'; break;
						case 4: var color = 'rgb(70, 136, 71)'; break;
					}
			html+='<span id="gestion_'+this.gestion.id+'" style="background-color:'+color+';display: block;padding: 5px;text-align: center;color: white;">'+this.gestion.descripcion+' ('+this.detalle.length+')</span>'
			var suma = 0
				$.each(this.detalle, function(){

					html+='<div class="caso" draggable="true" style="border-left:3px solid '+color+'">'
					html+=this.NOMBRE+'<br>'
					html+='Techmobile<br>'
					html+='$ 12.490.000'
					html+='</div>'
					suma+=parseInt(12490000)
				})
			html+='<span id="gestion_'+color_id+'" style="background-color:'+color+';display: block;padding: 5px;text-align: center;color: white;">'+accounting.formatMoney(suma)+'</span>'
			html+='</li>'

		})
	html+='</ul>'
	return html
}

function mis_cotizaciones(){
	var datos = {case:4, path:'crm/ajax'}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var html_cotizacion = tmp_cotizacion(data)
	$('.capas').hide()
	$('#cotizaciones').html(html_cotizacion)
	$('.age').age()
	
	$('#cotizaciones').fadeIn()
	$('#miscotizaciones').DataTable()
}

function ver_cotizacion(idcotizacion) {
    var html = '<h4>Cotización ' + idcotizacion + '</h4><iframe src="' + server + 'clientes/cotizacion_pdf/' + idcotizacion + '" frameborder="0" width="99%" height="350"></iframe>'
    bootbox.alert(html)
}

function tmp_cotizacion(obj){
	var html = '<table id="miscotizaciones" class="display compact">'
		html+='<thead><tr>'
		html+='<th>Código</th>'
		html+='<th>Fecha</th>'
		html+='<th>Colegio</th>'
		html+='<th>Monto neto</th>'
		html+='<th>Estado</th>'
		html+='<th>Acciones</th>'
		html+='</tr></thead><tbody>'
		$.each(obj, function(){
			html+='<tr>'
			html+='<td>'+this.id+'</td>'
			html+='<td><span datetime="'+this.fecha+'" class="age">'+this.fecha+'</span></td>'
			html+='<td>'+this.colegio+'</td>'
			html+='<td>'+accounting.formatMoney(this.neto, "$ ", 0, ".", ",")+'</td>'
			html+='<td>'+this.estado+'</td>'
			html+='<td>'
			html+='<button class="btn btn-mini" onclick="ver_cotizacion('+this.id+')"><i class="icon-search"></i></button> '
			html+='<button class="btn btn-mini" onclick="editar_cotizacion('+this.id+')"><i class="icon-pencil"></i></button> '
			html+='<button class="btn btn-mini" onclick="eliminar_cotizacion('+this.id+')"><i class="icon-trash"></i></button>'
			html+='</td>'
			html+='</tr>'
		})
		html+='</tbody></table>'
	return html
}

function actualizar_colegio(rbd){

	var nombre_colegio = $("#nombre_colegio").val()
	var matricula = $("#matricula_colegio").val()
	var rut = $("#rut_colegio").val()
	var sostenedor = $("#sostenedor_colegio").val()
	var sep = $("#alumnos_colegio").val()
	var telefono = $("#telefono_colegio").val()
	var director = $("#director_colegio").val()
	var direccion = $("#direccion_colegio").val()

	var datos = {
		nombre:nombre_colegio,
		matricula:matricula,
		rut:rut,
		sostenedor:sostenedor,
		sep:sep,
		telefono:telefono,
		director:director,
		direccion:direccion,
		rbd:rbd,
		case:6,
		path:'crm/ajax/'
	}

	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	if(data){
		bootbox.alert('Se actualizo el colegio', function(){
			window.location.href=server+'clientes/'
		})
	}
}

function reporte_seguimiento_ventas(){
	var datos = {case:7, path:'crm/ajax/', clave:2}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var gestiones = tmp_gestiones(data)
	
	$("#reporte_general").html(gestiones)

}

function tmp_gestiones(obj){
	var caso = obj[0].detalle
	var html='<table class="table table-striped table-condesed">'
		html+='<thead>'
			html+='<tr>'
			html+='<td>EJECUTIVO</td>'
			html+='<td>ASIGNACIÓN</td>'
			$.each(caso, function(){
				html+='<td style="text-align:center">'+this.gestion.descripcion+'</td>'
			})
			html+='<td>Acciones</td>'
			html+='<td>% Gestionado</td>'
			html+='</tr>'
		html+='</thead><tbody>'
		$.each(obj, function(){
			html+='<tr>'

				html+='<td>'+this.vendedor.NOM_EJECUTIVO+'</td>'
				html+='<td></td>'
				$.each(this.detalle, function(){
					html+='<td style="text-align:center">'+this.detalle.length+'</td>'
				})

			html+='<td>'

			html+='</td>'
			html+='<td></td>'
			html+='</tr>'
		})
		
		html+='<tbody></table>'
	return html
}


function buscar_colegio(){
	var dato = $("#finder").val()
	var datos = {colegio:dato, path:'clientes/ajax/', case:25}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var html_buscador = tmp_buscador_colegios(data)
	$("#buscador").html(html_buscador)
	$('.capas').hide()
	$("#buscador").fadeIn('fast')
	$('#buscador_colegios').DataTable();

}

function tmp_buscador_colegios(obj){

	var html='<table class="display compact" id="buscador_colegios" style="font-size:10px">'
			html+='<thead><tr>'
			html+='<th>RBD</th>'
			html+='<th>COLEGIO</th>'
			html+='<th>REGION</th>'
			html+='<th>COMUNA</th>'
			html+='<th>SEP</th>'
			html+='<th>MONTO</th>'
			html+='<th>SEP_ANUAL</th>'
			html+='<th>FECHA_GESTION</th>'
			html+='<th>ULTIMA GESTION</th>'
			html+='<th></th>'
			html+='</tr></thead><tbody>'
		$.each(obj, function(){
			html+='<tr>'
			html+='<td>'+this.colegio.RBD+'</td>'
			html+='<td>'+this.colegio.NOMBRE+'</td>'
			html+='<td>'+this.colegio.REGION+'</td>'
			html+='<td>'+this.colegio.COMUNA+'</td>'
			html+='<td>'+this.colegio.ALUMNOS_SEP+'</td>'
			html+='<td>$ 0</td>'
			html+='<td>$ 0</td>'
			html+='<td>n/a </td>'
			html+='<td>n/a </td>'
			html+='<td>'
				html+='<button class="btn btn-mini btn-success" onclick="ficha('+this.colegio.RBD+')" title="Ver Ficha"><i class="icon-search"></i></button> '
				html+='<button class="btn btn-mini btn-info" onclick="agregar_gestion('+this.colegio.RBD+')" title="Agregar Gestión"><i class="icon-plus"></i></button> '
				html+='<button class="btn btn-mini" onclick="agregar_usuario('+this.colegio.RBD+')" title="Agregar Usuario"><i class="icon-user"></i></button> '
			html+='</td>'
			html+='</tr>'

		})
		html+='</tbody></table>'
	return html
}

function resumen_gestiones(mes){
	var datos = {path:'clientes/ajax', case:47, mes:mes}
	var procesar = capsula(datos)
	var data = JSON.parse(procesar.fuente)
	var vector = []
	$.each(data, function(){
		vector.push([this.descripcion, parseInt(this.total)])
	})
	return vector
}

function pintar_grafico(mes){
	$('#gestion').highcharts({
            chart: {
            	type: 'column',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Resumen'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Resumen de las gestiones',
                data: resumen_gestiones(mes)
            }]
        })
	//$('#gestion').append('<select name="" id="mes" onchange="pintar_grafico(this.value)"><option value="03">Marzo</option><option value="04">Abril</option><option value="05">Mayo</option></select>')

}
