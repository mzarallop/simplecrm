function fecha_entero(fecha) {
    var elem = fecha.split('/');
    dia = elem[0];
    mes = elem[1];
    ano = elem[2];

    var new_form_fecha = ano + "/" + mes + "/" + dia;
    var Epoch_mili = Date.parse(new_form_fecha);
    var entero_fecha = parseInt((Epoch_mili / 1000))
    return (entero_fecha);
    //eliminar los milisegundos
}

$(function() {

    $('#myTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    })

    $(".fecha").on('click', function() {
        $(this).datepicker('show')
    })

    // filter button demo code
    $('button.filter').click(function() {
        var col = $(this).data('column'),
            txt = $(this).data('filter');
        $('table').find('.tablesorter-filter').val('').eq(col).val(txt);
        $('table').trigger('search', false);
        return false;
    });

    // toggle zebra widget
    $('button.zebra').click(function() {
        var t = $(this).hasClass('btn-success');
        //			if (t) {
        // removing classes applied by the zebra widget
        // you shouldn't ever need to use this code, it is only for this demo
        //				$('table').find('tr').removeClass('odd even');
        //			}
        $('table')
            .toggleClass('table-striped')[0]
            .config.widgets = (t) ? ["uitheme", "filter"] : ["uitheme", "filter", "zebra"];
        $(this)
            .toggleClass('btn-danger btn-success')
            .find('i')
            .toggleClass('icon-ok icon-remove').end()
            .find('span')
            .text(t ? 'disabled' : 'enabled');
        $('table').trigger('refreshWidgets', [false]);
        return false;
    });
});


function select_all(source) {
    checkboxes = document.getElementsByName('foo');
    for (var i = 0, n = checkboxes.length; i < n; i++) {
        checkboxes[i].checked = source.checked;
    }
}



$(function() {
    $('#select-all').click(function(event) {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;
            });
        }
    });

    $("#region_bcli").change(function(e) {

        var id = e.currentTarget.value
        var caso = 1;
        $.ajax({
            beforeSuccess: function() {
                $("#comuna_bcli").html('<option value="">Actualizando!</option>');
            },
            url: server + 'clientes/ajax/',
            type: 'post',
            data: "id=" + id + "&case=" + caso,
            success: function(result) {
                $("#comuna_bcli").html(result);
                var datos = ({
                    clave: id
                })
                mostrar_clientes(datos, 'region')
            }
        })
    })

    $("#comuna_bcli").change(function(e) {
        var id = e.currentTarget.value
        var caso = 3
        console.log(e)
        $.ajax({
            beforeSuccess: function() {
                $("#dependencia").html('<option value="">Actualizando!</option>')
            },
            url: server + 'clientes/ajax/',
            type: 'post',
            data: "id=" + id + "&case=" + caso,
            success: function(result) {
                console.log(result)
                $("#dependencia").html(result);
                var datos = ({
                    clave: id
                })
                mostrar_clientes(datos, 'comuna')
            }
        })

    })

    /*	$("#vendedor_cartera").change(function(e){
		var id = e.currentTarget.value

		$.ajax({
		beforeSuccess:function(){$("#clientes_bcli").html('Actualizando!');},
		url:server+'clientes/ajax/',
		type:'post',
		data:"id="+id+"&tipo="+tipo+"&case=2",
		success:function(result){
			$("#clientes_bcli").html(result);

			}
		})
	})
*/

    $("#dependencia").change(function(e) {
        var id = e.currentTarget.value
        var comuna = $("#comuna_bcli").val()
        $.ajax({
            beforeSuccess: function() {
                $("#clasificacion").html('<option value="">Actualizando!</option>')
            },
            url: server + 'clientes/ajax/',
            type: 'post',
            data: "id=" + id + "&comuna=" + comuna + "&case=4",
            success: function(result) {
                console.log(result)
                $("#clasificacion").html(result);
                var datos = ({
                    clave: id,
                    com: comuna
                })
                mostrar_clientes(datos, 'dependencia')
            }
        })

    })

    $("#clasificacion").change(function(e) {
        var id = e.currentTarget.value
        var comuna = $("#comuna_bcli").val()
        var dep = $("#dependencia").val()
        $.ajax({
            beforeSuccess: function() {
                $("#clasificacion").html('<option value="">Actualizando!</option>')
            },
            url: server + 'clientes/ajax/',
            type: 'post',
            data: "id=" + id + "&comuna=" + comuna + "&dependencia=" + dep + "&case=9",
            success: function(result) {
                console.log(result)
                $("#area").html(result);
                var datos = ({
                    clave: id,
                    com: comuna,
                    dependencia: dep
                })
                mostrar_clientes(datos, 'clasificacion')
            }
        })

    })




})

function gestion_lista(e) {

    if (parseInt(e) === 4) {
        $(".agenda").show()
    } else {
        $(".agenda").hide()
    }

}

function crear_gestion(datos) {

    $.ajax({
        url: server + 'clientes/ajax/',
        type: 'post',
        data: "rbd=" + datos.rbd +
            "&gestion=" + datos.gestion +
            "&msn=" + datos.msn +
            "&fecha_agenda=" + fecha_entero(datos.fecha_agenda) +
            "&hora_agenda=" + datos.hora_agenda +
            "&case=11",
        success: function(result) {

            console.log(result)
        }
    })
}

function mostrar_clientes(id, tipo) {
    if (tipo === 'dependencia') {

        $.ajax({
            beforeSuccess: function() {
                $("#clientes_bcli").html('Actualizando!');
            },
            url: server + 'clientes/ajax/',
            type: 'post',
            data: "id=" + id.clave + "&comuna=" + id.com + "&tipo=" + tipo + "&case=2",
            success: function(result) {
                $("#clientes_bcli").html(result);

            }
        })
    } else if (tipo === 'clasificacion') {
        $.ajax({
            beforeSuccess: function() {
                $("#clientes_bcli").html('Actualizando!');
            },
            url: server + 'clientes/ajax/',
            type: 'post',
            data: "id=" + id.clave + "&comuna=" + id.com + "&dependencia=" + id.dependencia + "&tipo=" + tipo + "&case=2",
            success: function(result) {
                $("#clientes_bcli").html(result);

            }
        })
    } else if (tipo === 'vendedor') {
        $.ajax({
            beforeSuccess: function() {
                $("#clientes_bcli").html('Actualizando!');
            },
            url: server + 'clientes/ajax/',
            type: 'post',
            data: "id=" + id.id + "&tipo=" + tipo + "&case=2",
            success: function(result) {
                $("#clientes_bcli").html(result);

            }
        })
    } else {

        $.ajax({
            beforeSuccess: function() {
                $("#clientes_bcli").html('Actualizando!');
            },
            url: server + 'clientes/ajax/',
            type: 'post',
            data: "id=" + id.clave + "&tipo=" + tipo + "&case=2",
            success: function(result) {
                $("#clientes_bcli").html(result);

            }
        })
    }
}


function colorear_bkg(id, color) {
    var datos = {
        backgroundColor: color
    }
    $(id).css(datos)
}

/*
ver ficha del cliente
ver contactos
ver gestiones
*/
function ver_ficha_cliente(id) {
    var datos = id.target.dataset;
    $("#filtros_clientes").hide();
    $("#ficha_cliente").slideDown();
    colorear_bkg('#cliente_' + datos.id, 'yellowgreen');

    mostrar_ficha(datos.id);
    ver_contactos1(datos.id);

}

function mostrar_ficha(id) {
    $.ajax({
        url: server + 'clientes/ajax/',
        type: 'post',
        data: "rbd=" + id + "&case=5",
        success: function(result) {
            $("#datos_cliente").html(result)
            $("#datos_cliente").slideDown()

        }
    });
}

// Muestra la tabla de abajo.
function ver_contactos(dat) {
    var rbd = $("#ficha_rbd").val()
    $.ajax({
        // pedir los datos
        url: server + 'clientes/ajax/',

        type: 'post',
        data: "rbd=" + rbd + "&case=6",
        success: function(result) {
            $(".contenedores").hide()
            $("#contenedor_contactos").slideToggle('fast')
            $("#lista_contactos").html(result)
        }
    })

}

function ver_contactos1(dat) {
    var rbd = dat;
    $.ajax({
        url: server + 'clientes/ajax/',
        type: 'post',
        data: "rbd=" + rbd + "&case=6",
        success: function(result) {
            $(".contenedores").hide()
            $("#contenedor_contactos").slideToggle('fast')
            $("#lista_contactos").html(result)
        }
    })

}

function datos_cliente(id) {
    $.ajax({
        url: server + 'clientes/ajax/',
        type: 'post',
        data: "rbd=" + id + "&case=6",
        success: function(result) {

        }
    })
}


function editar_cliente(contacto) {
    var msn = '<h4><i class="icon-user"></i> Editar Contacto</h4><table class="table table-condensed table-bordered">';
    msn += '<tr>';
    msn += '<td><input type="text" id="nombre_cli" placeholder="Nombre" value="' + contacto.NOMBRE + '"></td>';
    msn += '<td><input type="text" id="telefono_cli" placeholder="Telefono" value="' + contacto.TELEFONO + '"></td>';
    msn += '</tr>';
    msn += '<tr>';
    msn += '<td><input type="text" id="email_cli" placeholder="Email" value="' + contacto.EMAIL + '"></td>';
    msn += '<td><input type="text" id="cargo_cli" placeholder="Cargo" value="' + contacto.CARGO + '"></td>';
    msn += '<input type="hidden" id="id_cli" value="' + contacto.ID + '">';
    msn += '<input type="hidden" id="rbd" value="' + contacto.rbd + '"></tr>';
    msn += '</table>';

    bootbox.confirm(msn, function(resp) {
        if (resp === true) {
            var id = $("#id_cli").val();
            var nombre = $("#nombre_cli").val();
            var telefono = $("#telefono_cli").val();
            var email = $("#email_cli").val();
            var cargo = $("#cargo_cli").val();
            var rbd = $("#rbd").val();

            $.ajax({
                url: server + 'clientes/ajax/',
                type: 'post',
                data: "id=" + id +
                    "&nombre=" + nombre +
                    "&telefono=" + telefono +
                    "&email=" + email +
                    "&cargo=" + cargo +
                    "&rbd=" + rbd +
                    "&case=19",
                success: function(resp) {
                    var estado = JSON.parse(resp);
                    if (estado != 1)
                        bootbox.alert("Se edito con éxito el contacto");
                    ver_contactos1(estado);
                }
            })
        }
    })
}

function eliminar_cliente(data) {
    var datos = data.target.dataset;
    bootbox.confirm("¿Estas seguro que desaeas eliminar este registro?", function(e) {
        if (e === true) {
            $.ajax({
                url: server + 'clientes/ajax/',
                type: 'post',
                data: "id=" + datos.id + "&case=15",
                success: function(resp) {
                    var estado = JSON.parse(resp)
                    if (estado === true) {
                        bootbox.alert("Se elimino correctamente el registro");
                        ver_contactos1(datos.rbd);
                    }
                }
            });
        }
    });
}

function volver_filtros_clientes() {
    $(".contenedores").hide()
    $("#ficha_cliente").hide();
    $("#filtros_clientes").slideDown();
}

function ver_gestiones(e) {
    var rbd = $("#ficha_rbd").val()
    var usuario = $("#id_usuario").val();
    $.ajax({
        url: server + 'clientes/ajax/',
        type: 'post',
        data: "rbd=" + rbd + "&usuario=" + usuario + "&case=7",
        success: function(result) {
            $(".contenedores").hide()
            $("#contenedor_gestiones_completa").hide();
            $("#contenedor_gestiones").slideToggle('fast')
            $("#lista_gestiones").html(result)
        }
    })
}

function ver_gestiones_completa(e) {
    var rbd = $("#ficha_rbd").val();
    var usuario = $("#id_usuario").val();
    // var usuario = usuario.target.dataset;
    console.log(usuario);
    $.ajax({
        url: server + 'clientes/ajax/',
        type: 'post',
        data: "rbd=" + rbd + "&usuario=" + usuario + "&case=20",
        success: function(result) {
            $(".contenedores").hide();
            $("#contenedor_gestiones").hide();
            $("#contenedor_gestiones_completa").slideToggle('fast');
            $("#lista_gestiones_completa").html(result);
        }
    })
}

function nuevo_contacto() {
    var msn = '<h4><i class="icon-user"></i> Nuevo Contacto</h4><table class="table table-condensed table-bordered">'
    msn += '<tr>'
    msn += '<td><input type="text" id="nombre_cli" placeholder="Nombre"></td>'
    msn += '<td><input type="text" id="telefono_cli" placeholder="Telefono"></td>'
    msn += '</tr>'
    msn += '<tr>'
    msn += '<td><input type="text" id="email_cli" placeholder="Email"></td>'
    msn += '<td><input type="text" id="cargo_cli" placeholder="Cargo"></td>'
    msn += '</tr>'
    msn += '</table>'

    bootbox.confirm(msn, function(resp) {
        if (resp === true) {
            var nombre = $("#nombre_cli").val()
            var telefono = $("#telefono_cli").val()
            var email = $("#email_cli").val()
            var cargo = $("#cargo_cli").val()
            var rbd = $("#ficha_rbd").val()

            $.ajax({
                url: server + 'clientes/ajax/',
                type: 'post',
                data: "nombre=" + nombre +
                    "&telefono=" + telefono +
                    "&email=" + email +
                    "&cargo=" + cargo + "&case=8&rbd=" + rbd,
                success: function(resp) {

                    ver_contactos(rbd)
                }
            })
        } else {

        }
    })
}

function nueva_gestion() {
    var msn = '<h4><i class="icon-time"></i> Nueva gestión</h4><table class="table table-condensed table-bordered">'
    msn += '<tr>'
    msn += '<td>Gestión:</td>'
    msn += '<td><select id="gestion_lista" onchange="gestion_lista(this.value)"><option value="1">Se envia email</option><option value="2">Se interesa en comprar</option><option value="3">Cotización</option><option value="4">Agendamiento</option><option value="5">Visita</option><option value="6">Entrevista</option><option value="7">Presentación</option><option value="8">Venta :)</option></select></td>'
    msn += '</tr>'
    msn += '<tr>'
    msn += '<td>Observaciones:</td>'
    msn += '<td colspan="2"><textarea id="msn" name="msn" placeholder="Observaciones"></textarea></td></tr>'
    msn += '</tr>'
    msn += '<tr class="agenda" style="display:none">'
    msn += '<td >Fecha:</td>'
    msn += '<td><input type="date" id="fecha_agenda" placeholder="Fecha dd/mm/yyy"></td>'
    msn += '</tr>'
    msn += '<tr class="agenda" style="display:none">'
    msn += '<td >Hora:</td>'
    msn += '<td><input type="time" id="hora_agenda" placeholder="Fecha dd/mm/yyy"></td>'
    msn += '</tr>'
    msn += '</table>'

    bootbox.confirm(msn, function(resp) {
        if (resp === true) {

            var datos = ({
                rbd: $("#ficha_rbd").val(),
                gestion: $("#gestion_lista").val(),
                msn: $("textarea#msn").val(),
                fecha_agenda: $("#fecha_agenda").val(),
                hora_agenda: $("#hora_agenda").val()
            })
            var proceso = crear_gestion(datos)
            ver_gestiones(datos.rbd)
        }
    })
}

function asignacion_cartera() {
    var rbds = $(".lista_clientes")
    var total_rbds = rbds.length
    var rbd = new Array
    for (var i = 0; i < total_rbds; i++) {
        if (rbds[i].checked === true) {
            rbd[i] = rbds[i].value
        }
    }

    var vendedor = parseInt($("#vendedor").val())

    if (vendedor > 0 && rbd.length > 0) {
        var msn = '<h4>Asignación de cartera</h4>'
        msn += 'Total de colegios: <b>' + rbd.length + '</b>'
        bootbox.confirm(msn, function(resp) {
            if (resp === true) {
                $.ajax({
                    url: server + 'clientes/ajax/',
                    type: 'post',
                    data: "rbds=" + rbd +
                        "&vendedor=" + vendedor +
                        "&case=10",
                    success: function(resp) {
                        console.log(resp)
                    }
                })
            }
        })

    } else {
        bootbox.alert("Debe seleccionar un vendedor y al menos 1 colegio")
    }
}

function mostrar_cartera(id) {
    $.ajax({
        url: server + 'clientes/ajax/',
        type: 'post',
        data: "id=" + id + "&case=12",
        success: function(resp) {
            $("#lista_cartera_ejecutivo").html(resp)
        }
    })

}

function eliminar_gestion(idgestion) {
    bootbox.confirm("Estas seguro que desaeas eliminar la gestión código:" + idgestion, function(e) {

        if (e === true) {
            $.ajax({
                url: server + 'clientes/ajax/',
                type: 'post',
                data: "id=" + idgestion + "&case=13",
                success: function(resp) {
                    var estado = JSON.parse(resp)
                    if (estado === true) {
                        bootbox.alert("Se elimino correctamente la gestión " + idgestion);
                        ver_gestiones(event)
                    }

                }
            })
        } else {

        }

    })

}


function mostrar_mis_gestiones() {
    $.ajax({
        beforeSend: function() {
            $("#misgestiones").html("<center><img src='http://" + window.location.host + "/img/loading.gif'></center>")
        },
        url: server + 'clientes/ajax/',
        type: 'post',
        data: "case=14",
        success: function(resp) {
            $("#misgestiones").html(resp)
        }
    })
}

function ver_ges() {
    var inicio = $("#inicio_gestiones").val()
    var fin = $("#fin_gestiones").val()

    if (fin < inicio) {
        bootbox.alert("<h3>Verificar fechas</h3><p>La fecha de finalización es menor a la fecha de inicio!</p>")
    } else {
        console.log('iguales')
        $.ajax({
            beforeSend: function() {
                $("#mis_gestiones").html("<center><img src='http://" + window.location.host + "/img/loading.gif'></center>")
            },
            url: server + 'clientes/ajax/',
            type: 'post',
            data: "inicio=" + $("#inicio_gestiones").val() + "&termino=" + $("#fin_gestiones").val() + "&case=16",
            success: function(resp) {

                $("#mis_gestiones").html(resp)

            }
        })
    }

}

function ver_ag() {
    var inicio = $("#inicio_agenda").val()
    var fin = $("#fin_agenda").val()

    if (fin < inicio) {
        bootbox.alert("<h3>Verificar fechas</h3><p>La fecha de finalización es menor a la fecha de inicio!</p>")
    } else {
        $.ajax({
            beforeSend: function() {
                $("#mi_agenda").html("<center><img src='http://" + window.location.host + "/img/loading.gif'></center>")
            },
            url: server + 'clientes/ajax/',
            type: 'post',
            data: "inicio=" + inicio + "&termino=" + fin + "&case=17",
            success: function(resp) {
                $("#mi_agenda").html(resp)
            }
        })
    }

}

function generar_cotizacion(e) {
    var rbd = e.target.dataset.id
    window.location.href = server + 'clientes/cotizacion/' + rbd
}

function agregar_producto(idproducto) {

    var prod = $.ajax({
        url: server + 'clientes/ajax/',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            idproducto: idproducto,
            case :21
        }
    })

    var producto = JSON.parse(prod.responseText)
    var compilado = temp_item_cotizacion({
        idproducto: idproducto,
        descripcion: producto.descripcion,
        precio: producto.precio,
        titulo: producto.nombre,
        afecto: producto.afecto_iva
    })
    $("#detalle_productos>tbody").append(compilado)
    $("#descripcion_" + idproducto).val(producto.descripcion)
    ajustar_cotizacion()
}

function remover_producto_cotizacion(id) {
    $("#rbd_" + id).remove()
    ajustar_cotizacion()
}

function ajustar_cotizacion() {

    var productos = $(".productos")
    var vector_productos = new Array
    $.each(productos, function() {
        vector_productos.push(parseInt(this.value))
    })

    var unidades = $(".unidades")
    var vector_unidades = new Array
    $.each(unidades, function() {
        vector_unidades.push(parseInt(this.value))
    })

    var precio_neto = $(".precio_neto")
    var vector_neto = new Array
    $.each(precio_neto, function() {
        vector_neto.push(parseInt(this.value))
    })

    var descripcion = $(".descripcion")
    var vector_descripcion = new Array
    $.each(descripcion, function() {
        vector_descripcion.push(parseInt(this.value))
    })

    var afecto_iva = $(".afecto")
    var vector_afecto = new Array
    $.each(afecto_iva, function() {
        vector_afecto.push(parseInt(this.value))
    })
    var total_neto_afecto = 0;
    var total_neto_sin_iva = 0;
    for (var i = 0; i < vector_productos.length; i++) {
        
        var producto = parseInt(vector_productos[i])
        var unidad = parseInt(vector_unidades[i])
        var neto = parseInt(vector_neto[i])
        var desc = vector_descripcion[i]
        var aplica_iva = parseInt(vector_afecto[i])


        $("#unidad_" + producto).val(unidad)
        $("#precio_neto_" + producto).val(neto)
        $("#descripcion_" + producto).text(desc)
        if (parseInt(aplica_iva) === 1) {

            var calculo_iva = parseInt(((unidad * neto)*0.19))
            var total_mas_iva = parseInt(((unidad * neto)+calculo_iva))
            total_neto_afecto += parseInt(total_mas_iva)
            
            $("#total_fila_" + producto).text(total_neto_afecto)
            $("#iva_fila_" + producto).text(calculo_iva)
            $("#total_neto_fila_" + producto).text((unidad * neto))
        } else {

            var calculo_iva = parseInt(0)
            var total_mas_iva = parseInt((unidad * neto))
            total_neto_sin_iva += parseInt(total_mas_iva)
            
            $("#iva_fila" + producto).text(calculo_iva)
            $("#total_fila_" + producto).text(total_mas_iva)
            $("#total_neto_fila_" + producto).text((unidad * neto))
        }
    }
    
    var total_neto = (parseInt(total_neto_afecto) + parseInt(total_neto_sin_iva))
    var neto_sin_iva = ((total_neto_afecto/1.19)+total_neto_sin_iva)
    var iva = (total_neto_afecto-(parseInt(total_neto_afecto)/1.19))
    var total_final = (parseInt(neto_sin_iva)+iva)
    console.log(neto_sin_iva, iva, total_final)
    
    $("#total_neto").text(neto_sin_iva)
    $("#iva").text(iva)
    $("#total_iva").text(total_final)

}


function buscar_producto() {
    var texto = $("#texto_buscar").val()
    var prod = $.ajax({
        url: server + 'clientes/ajax/',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            texto: texto,
            case :22
        }
    })
    var result = JSON.parse(prod.responseText)
    var html = tmp_item_producto(result)
    $.each(result, function() {

        html += tmp_item_producto(this)

    })

    $("#listado_productos").html(html)
}

function crear_cotizacion() {
    //valores de la cotizacion


    var productos = $(".productos")
    var vector_productos = new Array
    $.each(productos, function() {
        vector_productos.push(parseInt(this.value))
    })

    var unidades = $(".unidades")
    var vector_unidades = new Array
    $.each(unidades, function() {
        vector_unidades.push(parseInt(this.value))
    })

    var precio_neto = $(".precio_neto")
    var vector_neto = new Array
    $.each(precio_neto, function() {
        vector_neto.push(parseInt(this.value))
    })

    var descripcion = $(".descripcion")
    var vector_descripcion = new Array
    $.each(descripcion, function() {
        vector_descripcion.push($(this).val())
    })

    var afecto_iva = $(".afecto")
    var vector_afecto = new Array
    $.each(afecto_iva, function() {
        vector_afecto.push(parseInt(this.value))
    })

    //datos del colegio
    var colegio = $("#colegio").val()
    var direccion = $("#direccion").val()
    var rbd = $("#rbd").val()
    var telefono = $("#telefono").val()
    var dependencia = $("#dependencia").val()
    var contacto = $("#contacto").val()
    var total = $("#total_neto").text()
    var iva = $("#iva").text()
    var total_iva = $("#total_iva").text()
    var modo_pago = $("#modo_pago").val()
    var obs = $("#observaciones").val()

    if (contacto != "") {

        if (parseInt(total_iva) > 0) {
            var procesar = $.ajax({
                url: server + 'clientes/ajax',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    productos: vector_productos,
                    unidades: vector_unidades,
                    netos: vector_neto,
                    descripciones: vector_descripcion,
                    afecto: vector_afecto,
                    colegio: colegio,
                    direccion: direccion,
                    rbd: rbd,
                    telefono: telefono,
                    dependencia: dependencia,
                    contacto: contacto,
                    neto: total,
                    iva: iva,
                    total_iva: total_iva,
                    modo_pago: modo_pago,
                    observaciones: obs,
                    case :23
                }
            })

            var result = JSON.parse(procesar.responseText)
            if (parseInt(result) > 0) {
                bootbox.confirm('<h1>Felicitaciones</h1> Se ha generado la cotización solicitada asociada al codigo:<br><h4>' + parseInt(result) + '</h4>Desea geneara una nueva cotización? en caso contrario será direccionado al banco de cotizaciones', function(resp) {
                    if (resp) {
                        window.location.reload()
                    } else {
                        window.location.href = server + 'clientes/cotizacion_pdf/' + result
                    }
                })
            }

        } else {
            bootbox.alert('Debes agregar al menos 1 producto con un precio mayor a 0 para esta cotización.')
        }
    } else {
        bootbox.alert('Debes ingresar un nombre de contacto para enviar la cotización', function() {
            $("#contacto").focus()
        })
    }
}

function buscar_colegio() {
    var valor = $("#texto").val()
    if (parseInt(valor) === 'NaN') {
        //no es rbd
        var caso = 1

    } else {
        //rbd
        var caso = 2
    }

    var proc = $.ajax({
        beforeSend: function() {
            bootbox.alert('Espere un momento, estamos buscando el colegio solicitado')
        },
        url: server + 'clientes/ajax',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            finder: valor,
            accion: caso,
            case :25
        }
    })

    $(".modal-footer > a.btn").trigger('click')

    var result = JSON.parse(proc.responseText)
    var total_result = parseInt(result.length) 
    if(total_result > 0)
    {
        var html = ''
        $.each(result, function() {
            html += temp_tabla_colegio(this)
        })

        $("#resultado_colegios>tbody").html(html)
    }else{
        bootbox.confirm("No se encontro ningun colegio relacionado!<br>¿Deseas agregar un colegio nuevo?", function(resp){
            if(resp){
                var html = '<h4>Datos del colegio</h4><table>'
                html+='<tr>'
                html+='<td>Rol base de datos (RBD):<br><input type="text" id="rbd" /></td>'
                html+='<td>Nombre del colegio:<br><input type="text" id="nombre_colegio" /></td>'
                html+='</tr>'
                html+='<tr>'
                html+='<td>Dirección:<br><input type="text" id="direccion" /></td>'
                html+='<td>Teléfono:<br><input type="text" id="telefono" /></td>'
                html+='</tr>'
                html+='<tr>'
                html+='<td>Email:<br><input type="text" id="email" /></td>'
                html+='<td></td>'
                html+='</tr>'
                html+='</table>'
                html+='<h4>Datos del contacto valido</h4><table>'
                html+='<tr>'
                html+='<td>Nombre:<br><input type="text" id="nombre_contacto"/></td>'
                html+='<td>Teléfono:<br><input type="text" id="telefono_contacto"/></td>'
                html+='</tr>'
                html+='<tr>'
                html+='<td>Email:<br><input type="text" id="email_contacto" /></td>'
                html+='<td>Cargo:<br><input type="text" id="cargo_contacto" /></td>'
                html+='</tr>'
                html+='</table>'
                bootbox.confirm(html, function(resp){
                    if(resp)
                    {
                        var datos = {
                            rbd:$("#rbd").val(),
                            nombre_colegio:$("#nombre_colegio").val(),
                            direccion_colegio:$("#direccion").val(),
                            telefono_colegio:$("#telefono").val(),
                            email_colegio:$("#email").val(),
                            nombre_contacto:$("#nombre_contacto").val(),
                            telefono_contacto:$("#telefono_contacto").val(),
                            email_contacto:$("#email_contacto").val(),
                            cargo_contacto:$("#cargo_contacto").val(),
                            path:'clientes/ajax/',
                            case:31
                        }

                        var procesar = capsula(datos)
                        var data = JSON.parse(procesar.fuente)
                        
                        
                        if(data.estado){
                            window.location.href = server + 'clientes/cotizacion/'+data.rbd
                        }else{

                        }
                        
                    }
                })
            }
        })
    }

}

function nuevo_colegio(){
     var html = '<h4>Datos del colegio</h4><table>'
                html+='<tr>'
                html+='<td>Rol base de datos (RBD):<br><input type="text" id="rbd" /></td>'
                html+='<td>Nombre del colegio:<br><input type="text" id="nombre_colegio" /></td>'
                html+='</tr>'
                html+='<tr>'
                html+='<td>Dirección:<br><input type="text" id="direccion" /></td>'
                html+='<td>Teléfono:<br><input type="text" id="telefono" /></td>'
                html+='</tr>'
                html+='<tr>'
                html+='<td>Email:<br><input type="text" id="email" /></td>'
                html+='<td></td>'
                html+='</tr>'
                html+='</table>'
                html+='<h4>Datos del contacto valido</h4><table>'
                html+='<tr>'
                html+='<td>Nombre:<br><input type="text" id="nombre_contacto"/></td>'
                html+='<td>Teléfono:<br><input type="text" id="telefono_contacto"/></td>'
                html+='</tr>'
                html+='<tr>'
                html+='<td>Email:<br><input type="text" id="email_contacto" /></td>'
                html+='<td>Cargo:<br><input type="text" id="cargo_contacto" /></td>'
                html+='</tr>'
                html+='</table>'
                bootbox.confirm(html, function(resp){
                    if(resp)
                    {
                        var datos = {
                            rbd:$("#rbd").val(),
                            nombre_colegio:$("#nombre_colegio").val(),
                            direccion_colegio:$("#direccion").val(),
                            telefono_colegio:$("#telefono").val(),
                            email_colegio:$("#email").val(),
                            nombre_contacto:$("#nombre_contacto").val(),
                            telefono_contacto:$("#telefono_contacto").val(),
                            email_contacto:$("#email_contacto").val(),
                            cargo_contacto:$("#cargo_contacto").val(),
                            path:'clientes/ajax/',
                            case:31
                        }

                        var procesar = capsula(datos)
                        var data = JSON.parse(procesar.fuente)
                        
                        
                        if(data.estado){
                            window.location.href = server + 'clientes/cotizacion/'+data.rbd
                        }else{

                        }
                        
                    }
                })
}

function nuevo_producto(categoria) {

    var html = '<h2>Nuevo producto</h2>'
    html += '<table>'
    html += '<tr>'
    html += '<td>Nombre:<br><input type="text" id="nombre_prod" /></td>'
    html += '<td>Precio:<br><input type="text" id="precio_prod" placeholder="$" /></td>'
    html += '</tr>'
    html += '<tr>'
    html += '<td colspan="2">Descripcion:<br><textarea class="span6" name="descripcion_prod" id="descripcion_prod" cols="30" rows="10"></textarea></td>'
    html += '</tr>'
    html += '</table>'

    bootbox.confirm(html, function(r) {
        if (r) {
            var nombre = $("#nombre_prod").val()
            var precio = $("#precio_prod").val()
            var desc = $("#descripcion_prod").val()

            var procesar = $.ajax({
                url: server + 'clientes/ajax',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    nombre: nombre,
                    precio: precio,
                    descripcion: desc,
                    parent: categoria,
                    case :26
                }
            })

            console.log(procesar.responseText)

        }
    })
}

function generar_reporte() {

    var inicio = $("#desde").val()
    var termino = $("#hasta").val()
    var vendedor = $("#vendedor").val()
    var estado = $("#estado").val()

    var proceso = $.ajax({
        url: server + 'clientes/ajax',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            desde: inicio,
            hasta: termino,
            vendedor: vendedor,
            estado: estado,
            case :27
        }
    })

    var result = JSON.parse(proceso.responseText)
    var html = tmp_reporte_cotizaciones(result)
    $("#reporte_general").html(html)

}

function mostrar_detalle(id) {
    $(".detalle").slideUp('fast')
    $("#detalle_" + id).slideDown('fast');
}

function modificar_posibilidades(cotizacion) {

    var html = '<h3>Informar posibilidades de cierre</h3>'
    html += '<p>Fecha probable de cierre:<br><input type="date" id="fecha_cierre"/></p>'
    html += '<p>Probabilidad de cierre:<br><select id="porcentaje_cierre">'
    html += '<option value="50">50% Posibilidades</option>'
    html += '<option value="60">60% Posibilidades</option>'
    html += '<option value="70">70% Posibilidades</option>'
    html += '<option value="80">80% Posibilidades</option>'
    html += '<option value="90">90% Posibilidades</option>'
    html += '<option value="100">100% Posibilidades</option>'
    html += '</select></p>'
    html += '<p>Comentario interno:<br><textarea id="observaciones" rows="5" cols="30" class="span6"></textarea></p>'
    bootbox.confirm(html, function(resp) {
        if (resp) {

        }
    })
}

function eliminar_cotizacion(cotizacion) {
    bootbox.confirm('<h4>¡Eliminando cotización número (' + cotizacion + ')!</h4>', function(resp) {
        if (resp) {
            var procesar = $.ajax({
                url: server + 'clientes/ajax',
                type: 'POST',
                dataType: 'json',
                async: false,
                data: {
                    case :28,
                    cotizacion:
                        cotizacion
                },
            })
            console.log(procesar.responseText)
            var result = JSON.parse(procesar.responseText)
            if (result) {

                $("#cot_" + cotizacion).slideUp('fast', function() {
                    bootbox.alert('<h4>Su cotización fue eliminada!</h4>', function() {
                        $("#cot_" + cotizacion).remove()
                    })
                })

            }
        }
    })
}

function cambiar_estado(event, cotizacion) {

    bootbox.confirm('<h4>Cambiar estado:</h4>', function() {
        $(event.target).removeClass('badge-info').addClass('badge-success')
        $(event.target).text('Aprobada')
        var cotizacion_tabla = $("#cot_" + cotizacion)
        $("#cot_aprobadas>tbody").append(cotizacion_tabla)
        tmp_mensaje({
            titulo: 'Felicitaciones!',
            mensaje: 'Su cotizacion fue aprobada con exito.',
            id: '#msn',
            css: 'alert alert-success'
        })
    })
}

function ver_ficha_colegio(rut) {

    var procesar = $.ajax({
        url: server + 'clientes/ajax',
        type: 'POST',
        dataType: 'json',
        async: false,
        data: {
            case :30,
            rut:
                rut
        }
    })

    console.log(procesar.responseText)
    var data = JSON.parse(procesar.responseText)
    $("#clientes").hide('fast')
    $("#detalle_factura").slideDown('fast')
}

function ver_cotizacion_iframe(idcotizacion) {
    var html = '<h4>Cotización ' + idcotizacion + '</h4><iframe src="' + server + 'clientes/cotizacion_pdf/' + idcotizacion + '" frameborder="0" width="99%" height="350"></iframe>'
    bootbox.alert(html)
}

function llamadas(){
   /* var datos = {case:1, path:'asterisk/ajax/'}
    var procesar = capsula(datos)
    var data = JSON.parse(procesar.fuente)
    var html = tmp_llamadas(data)
    $("#llamadas").html(html)*/
}

function tmp_llamadas(obj){
    
        var html = ''
        var total_llamadas = 0
        var contador_llamadas = 1
        $.each(obj, function(){
            var seg = parseInt(this.duration)
                if(this.disposition ==='ANSWERED')
                {
                    if(this.duration >= 60){
                        total_llamadas+=seg     
                        contador_llamadas++
                    }
                }else{

                }
                
        })
        var total_hablado = conversor_segundos(total_llamadas)
        html+='<div class="resumen_ejecutivo"><p>Se consideraron solo las llamadas superiores a 59 segundos.</p><h1>Gestión efectiva: '+total_hablado+' | Total de llamadas: '+contador_llamadas+'</h1></div>'
        html+= '<div class="caja_llamadas"><table class="table table-striped table-condensed">'
        html+='<thead><tr>'
        html+='<th>Fecha</th>'
        html+='<th>Destino</th>'
        html+='<th>Minutos</th>'
        html+='<th></th>'
        html+='<th>Grabación</th>'
        html+='</tr></thead><tbody>'

    $.each(obj, function(){
        var fecha = this.calldate.split(" ")
            fecha = fecha[0]
            fecha = fecha.replace('-', '/')
            fecha = fecha.replace('-', '/')
            fecha = fecha.replace('-', '/')
            path_fecha = 'https://186.67.31.228/grabaciones/'+fecha+'/'
        var grabacion = path_fecha+this.recordingfile

        html+='<tr>'
        html+='<td>'+this.calldate+'</td>'
        html+='<td>'+this.dst+'</td>'
        
        html+='<td>'+this.tiempo+'</td>'
        if(this.disposition ==='ANSWERED'){
            html+='<td><span class="badge badge-success"><i class="icon-white icon-ok"></i></span></td>'
        }else{
            html+='<td><span class="badge badge-warning"><i class="icon-white icon-remove"></i></span></td>'
        }
        
        html+='<td><audio controls preload="none"><source src="'+grabacion+'" type="audio/wav"></source></audio></td>'

        html+='</tr>'
    })

    html+='</tbody></table></div>'

    return html
}

function grabacion(registro, archivo){
     var fecha = registro.split(" ")
            fecha = fecha[0]
            fecha = fecha.replace('-', '/')
            fecha = fecha.replace('-', '/')
            fecha = fecha.replace('-', '/')
            path_fecha = 'https://186.67.31.228/grabaciones/'+fecha+'/'
        var grabacion = path_fecha+archivo
    var html = '<audio controls><source src="'+grabacion+'" type="audio/wav"></source></audio>'
    bootbox.alert(html)
}
