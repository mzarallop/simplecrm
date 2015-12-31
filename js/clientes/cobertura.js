var dependencia  =  (window.location.pathname.split('/').reverse()[0].split('-'))
var region  =  (window.location.pathname.split('/').reverse()[1].split('-'))
var data = capsula({path:'clientes/ajax', region:region, dependencia:dependencia, case:49})
data = JSON.parse(data.fuente)
var beaches = data

$(function(){
   var chk_reg = $("input[name='reg']")
   var chk_dep = $("input[name='dep']")
   $("#total_colegios").html(beaches.length+' colegios')
   $.each(dependencia, function(){
      var clave = this
      $.each(chk_dep, function(){
          if(parseInt(this.value)===parseInt(clave)){
            $(this).attr('checked', true)
          }
      })
   })

   $.each(region, function(){
      var clave = this
      $.each(chk_reg, function(){
          if(parseInt(this.value)===parseInt(clave)){
            $(this).attr('checked', true)
          }
      })
   })
})

function initMap() {

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: {lat: parseFloat(data[0].LATITUD), lng: parseFloat(data[0].LONGITUD)}
  });
  setMarkers(map)
}

function cargar_mapa(){

  var region = $("#region").val()
  var datajson = capsula({path:'clientes/ajax', case:49, region:region})
      datajson = JSON.parse(data.fuente)

  console.log(datajson)
  var mapjson = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: {lat: parseFloat(datajson[0].LATITUD), lng: parseFloat(datajson[0].LONGITUD)}
  });
  mapjson.setMap(null);

  setMarkersjson(mapjson, datajson)
}
// Data for the markers consisting of a name, a LatLng and a zIndex for the
// order in which these markers should display on top of each other.

function setMarkers(map) {
  // Adds markers to the map.

  // Marker sizes are expressed as a Size of X,Y where the origin of the image
  // (0,0) is located in the top left of the image.

  // Origins, anchor positions and coordinates of the marker increase in the X
  // direction to the right and in the Y direction down.

  // Shapes define the clickable region of the icon. The type defines an HTML
  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
  // The final coordinate closes the poly by connecting to the first coordinate.

  var usuario = conectado()

  var shape = {
    coords: [1, 1, 1, 20, 18, 20, 18, 1],
    type: 'poly'
  };

  for (var i = 0; i < beaches.length; i++) {


    var beach = beaches[i];
    if(parseInt(beach.VENDEDOR) === parseInt(usuario.ID)){

      switch(parseInt(beach.SEGMENTO)){
        case 1: var img = 'img/pinche_cartera_amarillo.png'; break;
        case 2: var img = 'img/pinche_cartera_azul.png'; break;
        case 3: var img = 'img/pinche_cartera_verde.png'; break;
        case 4: var img = 'img/pinche_cartera_rojo.png'; break;
      }

    }else{

      switch(parseInt(beach.SEGMENTO)){
        case 1: var img = 'img/pinche.png'; break;
        case 2: var img = 'img/pinche_blue.png'; break;
        case 3: var img = 'img/pinche_green.png'; break;
        case 4: var img = 'img/pinche_red.png'; break;
      }

    }

    var image = {
    url: server+img,
    // This marker is 20 pixels wide by 32 pixels high.
    size: new google.maps.Size(30, 30),
    // The origin for this image is (0, 0).
    origin: new google.maps.Point(0, 0),
    // The anchor for this image is the base of the flagpole at (0, 32).
    anchor: new google.maps.Point(0, 32)
    };

    var marker = new google.maps.Marker({
      position: {lat: parseFloat(beach.LATITUD), lng: parseFloat(beach.LONGITUD)},
      map: map,
      icon: image,
      shape: shape,
      title: beach.RBD,
      zIndex: i
    });

    marker.addListener('click', function() {
      ficha_mapa(parseInt(this.title))
      $.notify(this.title, 'success')
    });

  }
    //marker.addListener('click', toggleBounce);
}



function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

function filtrar_mapa(){
    var regiones = $("input[name='reg']:checked")
    var dependencias = $("input[name='dep']:checked")

    var total_reg = parseInt(regiones.length)
    var total_dep = parseInt(dependencias.length)

    if(total_dep>0){
      if(total_reg>0){
          var url_region = new Array
          $.each(regiones, function(){
            url_region.push(this.value)
          })

          var url_dep = new Array
          $.each(dependencias, function(){
            url_dep.push(this.value)
          })
          window.location.href = server+'clientes/cobertura/'+url_region.join('-')+'/'+url_dep.join('-')
      }else{
        $.notify('Debes seleccionar al menos 1 región', 'info');

      }
    }else{
      $.notify('Debes seleccionar al menos 1 dependencia', 'info');
    }
}

function conectado(){
  var procesar = capsula({path:'clientes/ajax', case:50})
      procesar = JSON.parse(procesar.fuente)
      return procesar

}

function ficha_mapa(rbd){

    var proceso = capsula({path:'clientes/ajax', case:37, rbd:rbd})
        proceso = JSON.parse(proceso.fuente)

    var html = ficha_detalle(proceso)
        html+= ficha_gestiones(proceso)
        html+= ficha_facturas(proceso)

    $(".panel_colegio").html(html)
}

function ficha_detalle(obj){
    var data = obj[0].resumen

    var vendedores = '<ul class="vendedores_ficha">'
      $.each(obj[0].asignacion, function(){
          vendedores+='<li>'+this.vendedor+'</li>'
      })
      vendedores+='</ul>'
    var html = '<h4>Datos Colegio '+vendedores+'</h4><table class="table table-condensed table-striped">'
        html+='<tr>'
          html+='<td>Colegio:<br>'+data.NOMBRE+'</td>'
          html+='<td align="center">Comuna:<br>'+data.COMUNA+'</td>'
          html+='<td align="center">Sep:<br>'+data.ALUMNOS_SEP+'</td>'
          html+='<td align="center">Matricula:<br>'+data.MATRICULA+'</td>'
        html+='</tr>'
        html+='<tr>'
          html+='<td>Teléfono:<br>'+data.TELEFONO+'</td>'
          html+='<td align="center"><a href="mailto:'+data.EMAIL+'">Enviar mail</a></td>'
          html+='<td colspan="2" align="center">Dirección:<br>'+data.DIRECCION+'</td>'
        html+='</tr>'
        html+='<tr>'
        var total_mes = ((parseInt(data.ALUMNOS_SEP)*35000)*0.45)
        var total_anual = (((parseInt(data.ALUMNOS_SEP)*35000)*0.45)*12)
          html+='<td>Presupuesto Mensual (Factor 45%):<br>'+accounting.formatMoney(total_mes, "$ ", 0, ".", ",")+'<br>Presupuesto Anual (Factor 45%): <br>'+accounting.formatMoney(total_anual, "$ ", 0, ".", ",")+'</td>'
          html+='<td colspan="3">'
          //contactos
            html+='<b>Contactos</b>:<br><table width="100%" style="font-size:11px">'
            $.each(obj[0].contactos, function(i, item){
                if(i<3){

                html+='<tr>'
                  html+='<td>'+this.NOMBRE+'</td>'
                  html+='<td>'+this.TELEFONO+'</td>'
                  html+='<td>'+this.CARGO+'</td>'
                  html+='<td><a href="mailto:'+data.EMAIL+'">Email</a></td>'
                html+='</tr>'
                }
            })
            html+='</table>'
          html+='</td>'

        html+='</tr>'
        html+='</table>'
    return html
}

function ficha_gestiones(obj){
    var data = obj[0].gestiones
    var html = '<h4>Ultimas 2 Gestiones:</h4><table class="table table-condensed table-striped">'
       $.each(data, function(i, item){
          if(i<2){
          html+='<tr>'
            html+='<td>'+this.fecha+'</td>'
            html+='<td>'+this.gestion+'</td>'
            html+='<td>'+this.observaciones+'</td>'
          html+='</tr>'
          }
       })

        html+='</table>'
    return html
}


function ficha_facturas(obj){
   var data = obj[0].facturas
    var html = '<h4>Facturas:</h4><table class="table table-condensed table-striped">'
       $.each(data, function(i, item){
          if(i<2){
          html+='<tr>'
            html+='<td>'+this.idfactura+'</td>'
            html+='<td>'+this.rut+'</td>'
            html+='<td>'+this.razon_social+'</td>'
            html+='<td>'+this.mes+'/'+this.year+'</td>'
            var total = (parseInt(this.neto)*0.19)+parseInt(this.neto)
            html+='<td>'+accounting.formatMoney(total, "$ ", 0, ".", ",")+'</td>'
          html+='</tr>'
          }
       })

        html+='</table>'
    return html
}