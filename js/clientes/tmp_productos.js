function temp_item_cotizacion(obj) {

    var html = '<tr id="rbd_' + obj.idproducto + '">'
    html += '<td widht="5%"><button onclick="remover_producto_cotizacion(' + obj.idproducto + ')"><i class="icon-trash"></i></button></td>'
    html += '<td widht="40%"><h6>' + obj.titulo + '</h6>'
    html += '<textarea name="descripcion" class="descripcion span5" id="descripcion_' + obj.idproducto + '" rows="5" cols="15"></textarea>'
    html += '<input type = "hidden"   class = "productos"  value = "' + obj.idproducto + '" /><input type="hidden" id="afecto" class="afecto" value="' + obj.afecto + '" /></td>'
    html += '<td widht="10%"><input type="text" id="unidad_' + obj.idproducto + '"  class="span1 unidades" value="1" onblur="ajustar_cotizacion()"/> </td>'
    html += '<td widht="11%"><input type="text" id="precio_neto_' + obj.idproducto + '" class="span2 precio_neto" value="' + obj.precio + '" onblur="ajustar_cotizacion()"/> </td>'
    var total = (parseInt(obj.precio) * 1)

   
    if (parseInt(obj.afecto) === 1) {
         html += '<td widht="11%" class="total_iva" id="total_neto_fila_' + obj.idproducto + '">' + total + '</td> '
        var iva = parseInt((total * 0.19))
        html += '<td widht="11%" id="iva_fila_'+obj.idproducto+'">' + iva.toFixed(0) + '</td>'
        var total_producto = parseInt((total * 1.19))
        html += '<td widht="11%" id="total_fila_'+obj.idproducto+'">' + total_producto.toFixed(0) + '</td>'
    } else {
        var iva = parseInt(0)
         html += '<td widht="11%" class="total_neto_fila" id="total_neto_fila_' + obj.idproducto + '">' + total + '</td> '
        html += '<td widht="11%" id="iva_fila_'+obj.idproducto+'">' + iva + '</td>'
        var total_producto = obj.precio
        html += '<td widht="11%" id="total_fila_'+obj.idproducto+'">' + total_producto + '</td>'
    }
    html += '</tr>'
    return html
}

function temp_tabla_colegio(obj) {

    var html = '<tr id="rbd_' + obj.RBD + '">'

    html += ' <td> ' + obj.RBD + ' </td>'
    html += ' <td> ' + obj.NOMBRE + ' </td>'
    html += '<td>' + obj.COMUNA + '</td>'
    html += '<td><a class="btn btn-mini" href="' + server + 'clientes/cotizacion/' + obj.RBD + '" target="_new " title="Generar cotización"><i class="icon-shopping-cart"></i></a> <button class="btn btn-mini" onclick="ver_ficha_colegio()" title="Ver ficha del colegio"><i class="icon-search"></i></button></td>'
    html += '</tr>'
    return html
}

function tmp_item_producto(obj) {
    var html = '<div id="prod_ ' + obj.id + ' " style="padding: 5px;margin: 5px;display: block;" class="buscador_producto ">'
    if (parseInt(obj.hash_tag) > 0) {

        html += obj.nombre + ' (' + obj.hash_tag + ')'
    } else {
        html += obj.nombre
    }
    html += '<buttom class="btn btn - success btn - mini " style="float: right " onclick="agregar_producto(' + obj.id + ')"><i class="icon-shopping-cart"></i></buttom>'
    html += '</div>'

    return html
}

function tmp_banco_productos(obj) {
    var html = '<li id="prod_ ' + obj.id + '" onclick="acciones_producto(' + obj.id + ')">'
    html += '<div class="nombre_prod ">' + obj.nombre + '</div>'
    html += '<div class="descripcion_prod ">' + obj.descripcion + '</div>'
    html += '<div class="precio_prod ">' + obj.precio + '</div>'
    html += '</li>'
}

function tmp_reporte_cotizaciones(obj) {

    if (obj.detalle.length > 0) {
        var color = 'background-color:yellowgreen;'
    } else {
        var color = 'background-color:rgba(20, 0, 255, 0.14);color:rgb(148, 136, 136);'
    }


    var tabla = ''
    var html = ''
    //if (obj.detalle.length > 0) {
    tabla += '<div id="detalle_' + obj.vendedor.ID + '" class="detalle" style="display:none"><table class="table table-striped table-condensed">'
    tabla += '<tr>'
    tabla += '<td>Fecha</td>'
    tabla += '<td>Colegio</td>'
    tabla += '<td>Fecha Cierre</td>'
    tabla += '<td>Probabilidad</td>'
    tabla += '<td>Neto</td>'
    tabla += '<td>iva</td>'
    tabla += '<td>Total</td>'
    tabla += '</tr>'

    //precio
    var t_neto = 0
    var t_iva = 0
    var t_total = 0
    
    $.each(obj.detalle, function() {
        t_neto += parseInt(this.neto)
        t_iva += parseInt(this.iva)
        t_total += parseInt(this.total)
    })

    $.each(obj.detalle, function() {
        tabla += '<tr>'
        tabla += '<td>' + this.fecha + '</td>'
        tabla += '<td>' + this.colegio + '</td>'
        if (this.fecha_cierre === null) {
            var fecha = ''
        } else {
            fecha = this.fecha_cierre
        }
        tabla += '<td>' + fecha + '</td>'
        tabla += '<td>' + this.porcentaje_cierre + '%</td>'
        tabla += '<td>$ ' + formato_numero(this.neto, 0, ',', '.') + '</td>'
        tabla += '<td>$ ' + formato_numero(this.iva, 0, ',', '.') + '</td>'
        tabla += '<td>$ ' + formato_numero(this.total, 0, ',', '.') + '</td>'
        tabla += '<td><a class="btn btn-succes" href="' + server + 'clientes/cotizacion_pdf/' + this.id + '" target="_new"><i class="icon-search"></i></a></td>'
        tabla += '</tr>'
    })
    //pie
    tabla += '<tr>'
    tabla += '<td colspan="4">TOTALES</td>'
    tabla += '<td>$ ' + formato_numero(t_neto, 0, ',', '.') + '</td>'
    tabla += '<td>$ ' + formato_numero(t_iva, 0, ',', '.') + '</td>'
    tabla += '<td>$ ' + formato_numero(t_total, 0, ',', '.') + '</td>'
    tabla += '</tr>'

    tabla += '</table></div></p>'
    var fin = '<p><div style="' + color + 'color:rgb(148, 136, 136);padding:5px;margin:5px;cursor:pointer;" onclick="mostrar_detalle(' + obj.vendedor.ID + ')">' + obj.vendedor.NOM_EJECUTIVO + '<div class="detalle_general"><span style="padding: 3px;border-top:1px solid gray">COTIZACIONES: ' + obj.detalle.length + ' | MONTO NETO $ ' + formato_numero(t_neto, 0, ',', '.') + ' | MONTO TOTAL COTIZADO: $ ' + formato_numero(t_total, 0, ',', '.') + '</span></div></div>' + tabla
    html += fin
    //}

    return html
}

function formato_numero(numero, decimales, separador_decimal, separador_miles) { // v2007-08-06
    numero = parseFloat(numero);
    if (isNaN(numero)) {
        return "";
    }

    if (decimales !== undefined) {
        // Redondeamos
        numero = numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero = numero.toString().replace(".", separador_decimal !== undefined ? separador_decimal : ",");

    if (separador_miles) {
        // Añadimos los separadores de miles
        var miles = new RegExp("(-?[0-9]+)([0-9]{3})");
        while (miles.test(numero)) {
            numero = numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}

function tmp_mensaje(obj) {
    var html = '<div class="' + obj.css + '">'
    html += '<button type="button" class="close" data-dismiss="alert">×</button>'
    html += '<strong>' + obj.titulo + '</strong> ' + obj.mensaje + '</div>'
    $(obj.id).html(html)
}

function tmp_facturas_cliente(obj) {
    var html = '<td></td>'
}