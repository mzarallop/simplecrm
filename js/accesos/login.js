$(document).keypress(function(e) {
    if(e.which == 13) {
        login()
    }
});

function login() {
    var usuario = $("#user").val()
    var pass = $("#pass").val();
    $.ajax({
        url: server + 'accesos/login/',
        type: 'post',
        data: "user=" + usuario + "&pass=" + pass + "&accion=logear",
        success: function(result) {
            console.log(result)
            var resp = JSON.parse(result)
            if (resp === true) {

                var procesar = capsula({case:1, path:'accesos/ajax/'})
                var resultado = JSON.parse(procesar.fuente)
                var p = parseInt(resultado.IDPERFIL)
                if(p === 2)
                {
                    window.location.href = server + 'clientes/index/1'
                }else if(p > 2){
                    window.location.href = server + 'clientes/index/1'
                }else if(p === 1){
                    window.location.href = server + 'gestion/resumen_gestion/'
                }

            } else {
                window.location.href = server + 'accesos/?estado=0'
            }

        }
    })
}

function initMap(){}
function salirCRM() {
    $.ajax({
        url: server + 'accesos/logout/',
        type: 'post',
        data: "user=" + usuario + "&pass=" + pass + "&accion=logear",
        success: function(result) {
            console.log(result)
            var resp = JSON.parse(result)
            if (resp === true) {
                window.location.href = server + 'accesos/'
            } else {
                window.location.href = server + 'clientes/?estado=0'
            }

        }
    })
}