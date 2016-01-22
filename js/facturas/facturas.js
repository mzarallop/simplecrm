function buscar_datos(valor){
	var data = capsula({path:'facturas/ajax', case:1, codigo:valor})
	data = JSON.parse(data.fuente)
	data = data[0]

	$("#razon_social").val(data.SOSTENEDOR)
	$("#direccion").val(data.DIRECCION)
	$("#comuna").val(data.COMUNA)
}

function agregar_item(){

	var unidad = $("#unidad").val()
	var descripcion = $("#descripcion").val()
		descripcion = descripcion.split('|')
	var neto = parseInt(descripcion[2])
	var codigo = parseInt(descripcion[0])
	var items = $(".unidad").length; items = items+1
	var total_neto = parseInt(unidad)*parseInt(neto)
	var total_fila = parseInt(total_neto)

	//var datos = {unidad:unidad, descripcion:descripcion, neto:neto, path:'factura/ajax', case:2}
	var tr = '<tr id="fila_'+items+'">'
		tr+='<td style="text-align:center"><input type="hidden" id="codigo_'+items+'" value="'+codigo+'" class="codigo"/><input type="hidden" id="unidad_'+items+'"  class="unidad_tr" value="'+unidad+'"/>'+unidad+'</td>'
		tr+='<td><input type="hidden" id="descripcion_'+items+'"  class="descripcion_tr" value="'+descripcion[1]+'" />'+descripcion[1]+'</td>'
		tr+='<td><input type="hidden" id="neto_'+items+'"  class="neto_tr" value="'+neto+'" />$ '+moneda(neto)+'</td>'
		tr+='<td><input type="hidden" id="total_neto_'+items+'"  value="'+total_neto+'" class="total_neto_tr"/>$ '+moneda(total_neto)+'</td>'
		tr+='<td><input type="hidden" id="total_fila_'+items+'"  value="'+total_fila+'" class="total_fila_tr"/>$ '+moneda(total_fila)+'</td>'
		tr+='<td><button class="btn btn-mini btn-danger" onclick="eliminar_fila('+items+')"><i class="icon-white icon-trash"></i></button></td>'
		tr+='</tr>'
	$("#detalle_factura>tbody").append(tr)
	setTimeout(calcular_impuesto_factura(), '2000')
}

function eliminar_fila(item){
	$("#fila_"+item).remove()
	calcular_impuesto_factura()
}

function calcular_impuesto_factura(){
	var unidades = $(".unidad_tr")
	var neto = $(".neto_tr")


	var total = unidades.length
	var neto_final, iva, total_final = 0
	var total_f = new Array
	if(total>0){

		for(var i=0;i<total;i++){

			var u = unidades[i].value
			var n = neto[i].value

			var calculo = parseInt(u)*parseInt(n)
			console.log(calculo)
			total_f.push(calculo)
		}

		total_f = total_f.sum()
		iva = parseInt(total_f)*parseFloat(0.19)
		total_final = parseInt(total_f)+iva

		$("#neto_final").val(total_f)
		$("#iva_final").val(iva)
		$("#total_final").val(total_final)

		$(".neto_final").text('$ '+moneda(total_f))
		$(".iva_final").text('$ '+moneda(iva))
		$(".total_final").text('$ '+moneda(total_final))

		$("#unidad").val(1)
		$("#neto").val('')
		$("#descripcion").val('')


	}else{

	}
}

function cargar_precio(valor){
	var descripcion = valor.split('|')
	$("#neto").val(descripcion[2])
	agregar_item();
}

function guardar_factura(){

}

function validar_factura(){
	var datos = {
		empresa:$("#empresa").val(),
		codigo:$("#codigo").val(),
		correlativo:$("#correlativo").val(),
		fecha:$("#fecha").val(),
		coordinador:$("#coordinador").val(),
		vendedor:$("#vendedor").val(),
		case:2,
		path:'facturas/ajax/'
	}

	var procesar = capsula(datos)


}