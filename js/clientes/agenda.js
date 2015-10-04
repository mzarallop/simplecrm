var date = new Date();
var d = date.getDate();
var m = date.getMonth();
var y = date.getFullYear();

$(function() {

    var datos = [{
        "start": "2013-11-06",
        "title": "ESCUELA PARTICULAR CERRO LA CRUZ"
    }, {
        "start": "2013-11-06",
        "title": "ESCUELA ESPECIAL DE LENGUAJE HORIZONTES"
    }, {
        "start": "2013-11-06",
        "title": "COLEGIO EDWARD"
    }, {
        "start": "2013-11-06",
        "title": "ESCUELA BASICA CHILLAN"
    }, {
        "start": "2013-11-06",
        "title": "COLEGIO POLIVALENTE SAN ANDRES DE COLINA"
    }, {
        "start": "2013-11-06",
        "title": "COLEGIO MARIA DE ANDACOLLO"
    }, {
        "start": "2013-11-06",
        "title": "COLEGIO SANTA MARTA"
    }, {
        "start": "2013-11-06",
        "title": "ESCUELA GRECIA"
    }, {
        "start": "2013-11-06",
        "title": "COLEGIO PUDAHUEL"
    }, {
        "start": "2013-11-06",
        "title": "CENTRO REHABILITACION INTEGRAL ALBORADA"
    }]

    console.log(datos)
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        events: datos,
        eventClick: function(event, element) {

            event.title = "CLICKED!";

            $('#calendar').fullCalendar('updateEvent', event);

        }
    });


})

function agenda(e) {
    console.log(e)
    var inicio = e.timestamp
    var fin = e.timestamp
    $.ajax({
        url: 'http://' + window.location.host + '/clientes/ajax/',
        type: 'post',
        data: "inicio=" + inicio + "&fin=" + fin + "&case=18",
        success: function(result) {
            var datos = result
            console.log(datos)
            /*var eventos = datos
				$('#calendar').html('')		
				$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					editable: true,
					events: eventos
				});
*/

        }
    })
}