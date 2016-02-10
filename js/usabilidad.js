var server = 'http://' + window.location.host + '/crmkdoce/'
var central = 'http://192.168.60.100'
var cargador = '<center><img src="'+server+'img/loading.gif"></center>'

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

function capsula_asincrona(obj, onSuccess, load, id){
    if(load){
        $.ajax({
           beforeSend:function(){$(id).html(cargador)},
            url: server + obj.path,
            type: 'post',
            dataType: 'json',
            async: true,
            data: obj,
            success: function(result,status,xhr){
                $(id).html("")
                onSuccess(result);
            }
        });
    }else{
        $.ajax({
            url: server + obj.path,
            type: 'post',
            dataType: 'json',
            async: true,
            data: obj,
            success: function(result,status,xhr){
                onSuccess(result);
            }
        });
    }
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


Array.prototype.sum = function(selector) {
    if (typeof selector !== 'function') {
        selector = function(item) {
            return item;
        }
    }
    var sum = 0;
    for (var i = 0; i < this.length; i++) {
        sum += parseFloat(selector(this[i]));
    }
    return sum;
};
