
function capsula_llamada(obj) {

    var procesar = $.ajax({
        url: obj.path,        type: 'post',
        dataType: 'json',
        async: false,
        data: obj,
    })

    var resultado = {
        fuente: procesar.responseText,
        origen:procesar
    }

    return resultado

}

function traer_usuarios_anexos(){
    var datos = {path:'gestion/ajax/', case:2}
    var procesar = capsula(datos)
    var data = JSON.parse(procesar.fuente)
    var vector_u = new Array
    //limita a los usuarios activos
    $.each(data, function(){
        if(parseInt(this.visible) ===1){
            if(parseInt(this.IDPERFIL)===2){
                vector_u.push(this)
            }
        }
    })
    return vector_u
}

function reporte_llamadas(){

    var usuarios = traer_usuarios_anexos()

            var inicio = $("#inicio").val()
            var termino = $("#termino").val()
            var resultado  = new Array

            $.each(usuarios, function(){
                var buscar_llamadas = {path:central+'/api/', inicio:inicio, termino:termino, anexo:this.ANEXO}
                var procesar = capsula_llamada(buscar_llamadas)
                var data = JSON.parse(procesar.fuente)

                resultado.push({usuario:this, llamadas:data})
            })
    var nucleo = {inicio:inicio, termino:termino}
    //console.log(resultado, 'callback realizado')
    var html_reporte_llamadas = tmp_reporte_llamadas(resultado, nucleo)
    $("#reporte_llamadas").html(html_reporte_llamadas)
    $(".capa").hide()
    $("#reporte_llamadas").fadeIn()
}

function tmp_reporte_llamadas(obj, nucleo){
        var html = '<h2>Resumen de llamadas</h2>Registro de las llamadas realizadas entre el '+nucleo.inicio+' y el '+nucleo.termino
            html+= '<table class="table table-condensed table-striped">'
            html+='<thead><tr>'
            html+='<th>EJECUTIVOS</th>'
            html+='<th>ANEXO</th>'
            html+='<th>TOTAL LLAMADAS</th>'
            html+='<th>1° LLAMADA</th>'
            html+='<th>[0-1] min</th>'
            html+='<th>[1-3] min</th>'
            html+='<th>[3-5] min</th>'
            html+='<th>[+5] min</th>'
            html+='<th>Acciones</th>'
            html+='</tr></thead><tbody>'
            var suma_total_llamadas = 0
            var suma_seg1 = 0
            var suma_seg2 = 0
            var suma_seg3 = 0
            var suma_seg4 = 0
        $.each(obj, function(){
            html+='<tr>'
            html+='<td>'+this.usuario.NOM_EJECUTIVO+'</td>'
            html+='<td>'+this.usuario.ANEXO+'</td>'
            html+='<td>'+this.llamadas.length+'</td>'
            suma_total_llamadas=suma_total_llamadas+parseInt(this.llamadas.length)
            if(parseInt(this.llamadas.length)>0)
            {
                html+='<td>'+this.llamadas[0].calldate+'</td>'
                //segmentos de llamdas
                var seg1 = new Array
                var seg2 = new Array
                var seg3 = new Array
                var seg4 = new Array

                $.each(this.llamadas, function(){
                    var segundos = parseInt(this.duration)
                    if(segundos>0 && segundos<=60){
                        seg1.push(this)
                    }else if(segundos >=60.01 && segundos <= 180){
                        seg2.push(this)
                    }else if(segundos>=180.1 && segundos<=300){
                        seg3.push(this)
                    }else if(segundos>=300.1){
                        seg4.push(this)
                    }

                })
                html+='<td style="text-align:center">'+seg1.length+'</td>'
                html+='<td style="text-align:center">'+seg2.length+'</td>'
                html+='<td style="text-align:center">'+seg3.length+'</td>'
                html+='<td style="text-align:center">'+seg4.length+'</td>'
                suma_seg1+= suma_seg1+parseInt(seg1)
                suma_seg2+= suma_seg2+parseInt(seg2)
                suma_seg3+= suma_seg3+parseInt(seg3)
                suma_seg4+= suma_seg4+parseInt(seg4)
            }else{
                html+='<td></td>'
                html+='<td style="text-align:center">0</td>'
                html+='<td style="text-align:center">0</td>'
                html+='<td style="text-align:center">0</td>'
                html+='<td style="text-align:center">0</td>'
                suma_seg1+= suma_seg1+parseInt(0)
                suma_seg2+= suma_seg2+parseInt(0)
                suma_seg3+= suma_seg3+parseInt(0)
                suma_seg4+= suma_seg4+parseInt(0)
            }

            html+='<td style="text-align:center">'
                html+='<button class="btn btn-mini" title="Ver detalle llamadas" onclick="ver_detalle_llamadas('+this.usuario.ANEXO+')"><i class="icon-search"></i></button>'
            html+='</td>'
            html+='</tr>'
        })
            html+='<tr>'
            html+='<td colspan="2">Totales</td>'

            html+='<td>'+suma_total_llamadas+'</td>'
            html+='<td></td>'
            html+='<td>'+suma_seg1+'</td>'
            html+='<td>'+suma_seg2+'</td>'
            html+='<td>'+suma_seg3+'</td>'
            html+='<td>'+suma_seg3+'</td>'
            html+='</tr>'

        html+='</tbody></table>'
    return html
}

function ver_detalle_llamadas(anexo){
            var inicio = $("#inicio").val()
            var termino = $("#termino").val()
            var resultado  = new Array
            var buscar_llamadas = {path:'http://186.67.137.90:8080/api/', inicio:inicio, termino:termino, anexo:anexo}
            var datos = capsula_llamada(buscar_llamadas)
            var data = JSON.parse(datos.fuente);

            var seg1 = new Array
            var seg2 = new Array
            var seg3 = new Array
            var seg4 = new Array

            $.each(data, function(){
                var segundos = parseInt(this.duration)
                if(segundos>0 && segundos<=60){
                    seg1.push(this)
                }else if(segundos >=60.01 && segundos <= 180){
                    seg2.push(this)
                }else if(segundos>=180.1 && segundos<=300){
                    seg3.push(this)
                }else if(segundos>=300.1){
                    seg4.push(this)
                }
            })
        var html = '<h4>Detalle de llamadas por segmentos</h4>'
        html+=tmp_plantilla_segmento(seg1, 'Segmento [0-1] min.')
        html+=tmp_plantilla_segmento(seg2, 'Segmento [1-3] min.')
        html+=tmp_plantilla_segmento(seg3, 'Segmento [3-5] min.')
        html+=tmp_plantilla_segmento(seg4, 'Segmento [+5] min.')

        $("#detalle_llamadas").html(html)
        $(".capa").hide()
        $("#detalle_llamadas").fadeIn()
}

function tmp_plantilla_segmento(obj, title){
    var html = '<p><div class="panel_llamadas">'
        html+='<h5>'+title+'</h5>'
        html+='<table class="table table-striped table-condensed">'
        $.each(obj, function(){
            html+='<tr>'
            html+='<td>'+this.calldate+'</td>'
            html+='<td>'+this.dst+'</td>'
            html+='<td>'+this.tiempo+'</td>'
            html+='<td style="text-align:right">'
                html+='<audio controls="play-pause">'
                html+='<source src="'+central+'/audio/'+this.carpeta+'/'+this.recordingfile+'" type="audio/wav">'
                html+='</audio>'
            html+='</td>'
            html+='</tr>'
        })

        html+='</table>'
        html+='</div></p>'
        return html
}
