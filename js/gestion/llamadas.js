

function reporte_llamadas(){
    var datos = {path:'clientes/ajax/', case:32, inicio:$("#inicio").val(), termino:$("#termino").val()}
    var procesar = capsula(datos)
    var data = JSON.parse(procesar.fuente)
    var html = tmp_reporte_llamadas(data)
    $("#uso").html(html)
    $('#otro a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    })
}

function tmp_reporte_llamadas(obj){

    var html = '<div class="tabbable tabs-left"><ul id="myTab" class="nav nav-tabs">'
        html+='<li class="active"><a href="#resumen" data-toggle="tab" style="background-color: cadetblue;color: white;""><b>Resumen</b></a></li>'
        $.each(obj, function(){
        html+='<li><a href="#vendedor_'+this.usuario.ID+'" data-toggle="tab">'+this.usuario.NOM_EJECUTIVO+'</a></li>'
        })
    html+='</ul>'
    html+='<div id="myTabContent" class="tab-content">'
        html+='<div class="tab-pane fade in active" id="resumen">'
            html+=tmp_reporte_llamadas_resumen(obj)
        html+='</div>'
        $.each(obj, function(){
        html+='<div class="tab-pane fade" id="vendedor_'+this.usuario.ID+'">'
                html+='<h1>'+this.usuario.NOM_EJECUTIVO+'</h1>'
                html+='<ul id="otro" class="nav nav-tabs">'
                html+='<li class="active"><a href="#detalle_cotizacion_'+this.usuario.ID+'" data-toggle="tab">Detalle de cotizaciones</a></li>'
                html+='<li class=""><a href="#detalle_llamadas_'+this.usuario.ID+'" data-toggle="tab">Detalle de llamadas</a></li>'
                html+='</ul>'
                html+='<div id="otroContent" class="tab-content">'
                html+='<div class="tab-pane fade in active caja_detalle_vendedor" id="detalle_cotizacion_'+this.usuario.ID+'">'
                var arreglo = {vendedor:this.usuario.ID,inicio:$("#inicio").val(), termino:$("#termino").val()}
                html+=reporte_cotizaciones(arreglo)
                html+='</div>'
                html+='<div class="tab-pane fade in caja_detalle_vendedor" id="detalle_llamadas_'+this.usuario.ID+'">'
                html+=tmp_llamadas(this.llamadas)
                html+='</div>'
            html+='</div>'
        html+='</div>'    
        })
    html+='</div></div>'

    return html
}

function tmp_reporte_llamadas_resumen(obj){
    var html = '<table class="table table-condensed table-striped">'
        html+='<thead><tr>'
        html+='<th>Nombre del ejecutivo</th>'
        html+='<th>Anexo</th>'
        html+='<th>Primera llamada</th>'
        html+='<th>Números discados</th>'
        html+='<th>1 a 3 mín.</th>'
        html+='<th>3 a 5 mín.</th>'
        html+='<th>más de 5 mín.</th>'
        html+='<th>N cotizaciones</th>'
        html+='<th>Neto MM</th>'
        html+='</tr></thead><tbody>'
    $.each(obj, function(){
        html+='<tr>'
        html+='<td>'+this.usuario.NOM_EJECUTIVO+'</td>'
        html+='<td>'+this.usuario.ANEXO+'</td>'
        var total_llamadas = parseInt(this.llamadas.length)
        if(total_llamadas > 0){
            var primera = this.llamadas.pop()
               html+='<td>'+primera.calldate+'</td>'
        }else{
                html+='<td>No registra</td>'
        }

        
        html+='<td>'+total_llamadas+'</td>'
        var contestadas = new Array
        var tres = new Array
        var cinco = new Array
        var ideal = new Array
        var data_rc = {vendedor:this.usuario.ID, inicio:$("#inicio").val(), termino:$("#termino").val() }
        var rc = reporte_cotizaciones_resumen(data_rc)
        $.each(this.llamadas, function(){
            
                var seg = parseInt(this.duration)
                if(seg>60 && seg<=180){
                    tres.push(this)
                }
                else if(seg>180 && seg<=300){
                    cinco.push(this)
                }
                else if(seg>300){
                    ideal.push(this)
                }
            
        })
        html+='<td>'+tres.length+'</td>'
        html+='<td>'+cinco.length+'</td>'
        html+='<td>'+ideal.length+'</td>'
        html+='<td>'+rc.length+'</td>'
        var total_mm = 0
        $.each(rc, function(){
            total_mm+=parseInt(this.neto)
        })
            total_mm = (total_mm/1000000)
        html+='<td>'+total_mm.toFixed(1)+' MM</td>'
        html+='</tr>'
    })
    html+='</tbody></table>'

    return html
}

function ver_detalle_llamadas(usuario,anexo){
    
    var datos = {usuario:usuario, anexo:anexo, case:1, path:'asterisk/ajax/'}
    var procesar = capsula(datos)
    var data = JSON.parse(procesar.fuente)
    var html = tmp_llamadas(data)
    //bootbox.alert(html)
    return html
}

function reporte_cotizaciones(obj)
{
    var datos = {vendedor:obj.vendedor, case:33, path:'clientes/ajax/', inicio:obj.inicio, termino:obj.termino}
    var procesa = capsula(datos)
    var data = JSON.parse(procesa.fuente)
    var html = tmp_reporte_cotizaciones_nuevo(data)
    return html
}

function reporte_cotizaciones_resumen(obj)
{
    var datos = {vendedor:obj.vendedor, case:33, path:'clientes/ajax/', inicio:obj.inicio, termino:obj.termino}
    var procesa = capsula(datos)
    var data = JSON.parse(procesa.fuente)
    return data
}

function tmp_reporte_cotizaciones_nuevo(obj)
{
    var html = '<table class="table table-condensed table-striped">'
            html+='<tr>'
            html+='<td>RBD</td>'
            html+='<td>Contacto</td>'
            html+='<td>Nombre colegio</td>'
            html+='<td>Monto Neto</td>'
            html+'</tr>'
        $.each(obj, function(){
            html+='<tr>'
            html+='<td>'+this.rbd+'</td>'
            html+='<td>'+this.contacto+'</td>'
            html+='<td>'+this.colegio+'</td>'
            html+='<td>'+this.neto+'</td>'
            html+'</tr>'
        })
    html+='</table>'
    return html
}

function ver_detalle_vendedor(id, vendedor){
    var ref = $(id).attr('href')
    $(".caja_detalle_vendedor").removeClass('active')
    $(".tab-content > "+ref+"_"+vendedor).addClass('active')
}