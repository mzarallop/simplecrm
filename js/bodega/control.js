$(document)

$(function(){

		var ingreso_bodega = function(){
			var producto = $("#codigo").val()

		}


			$('#codigo').keydown(function(tecla){

            if(tecla.keyCode === 13){

            	var codigo = parseInt($('#codigo').val())

				if(codigo > 0)
				{
					$.ajax({
						beforeSend:function(){$("#lista_productos_ingresados").html('cargando...')},
						url:'http://'+window.location.host+'/app_beta/bodega/ajax/',
						type:'post',
						data:"codigo="+codigo+"&caso=1",
						success:function(result){
							$("#lista_productos_ingresados").html(result)
								$('#codigo').val('').focus()

						}
					})
				}
				else
				{

				}
			}


        	});



})