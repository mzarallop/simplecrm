function mostrar_informacion(e)
{
	var colegio = $("#colegios").val()	
	var casos = $("#accion").val()
	$.ajax({
		url: 'http://'+window.location.host+'/soporte/ajax/',
		type: 'post',
		data: "base="+colegio+"&caso="+casos,
		success:function(resp){
			$("#resultados").html(resp)
		}
	})
	

}