var server = 'http://' + window.location.host + '/crmkdoce/'
var central = 'http://192.168.60.100'

$(function() {
    if (window.location.hash != "") {
        $("li" + window.location.hash).addClass('active')
    }
})


function capsula(obj) {

    var procesar =
    $.ajax({

        url: server + obj.path,
        type: 'post',
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


function moneda(cash){
    var clp = parseFloat(cash).toFixed(0).replace(/./g, function(c, i, a) {return i && c !== "." && !((a.length - i) % 3) ? ',' + c : c;})
    return clp
}


function conversor_segundos(seg_ini) {
var horas = Math.floor(seg_ini/3600);
var minutos = Math.floor((seg_ini-(horas*3600))/60);
var segundos = Math.round(seg_ini-(horas*3600)-(minutos*60));

if (horas > 0){
return horas+ ':'+ minutos+ ' Hrs. ';
} else {
return minutos+ ':'+ segundos+ ' Mín.';
}
}

