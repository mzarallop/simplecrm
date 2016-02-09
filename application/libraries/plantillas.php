<?php

class plantillas{

	function __construct(){
		$this->ci = get_instance();

	}

	function tipo_pago($id){
		$this->ci->db->where('id', $id);
		$query = $this->ci->db->get('cotizacion_pago');
		$row = $query->result_array();
		return $row[0]['nombre'];
	}
	function tmp_cotizacion($obj){
		//TITULOS
		$div ='<table><tr><td width="50%"><img src="'.base_url().'/img/logo_kdoce.png" width="130"/></td><td width="50%">
				<div style="text-align:right;font-size:11px">
					<b>KDOCE soluciones educativas</b><br>
				Avenida Baucheff 1171<br>
				Santiago R. Metropolitana<br>
				Teléfono: (02)599 49 93<br>
				</div></td></tr></table>';
		$div.='<br><br><div style="font-size:11px">Estimado (a): <b>'.$obj['col']['contacto'].'</b><br>';
		$div.='A continuación enviamos a Uds. cotización de productos solicitados.</div>';
		$div.= '<div style="background-color:rgb(238,238,238);"> Datos del cliente</div>';
		//INDENTIFICACION DEL COLEGIO
		$div.= '<br><table style="border-top:1px solid rgb(238,238,238);border-left:1px solid rgb(238,238,238);font-size:12px" width="100%">';
			$div.='<tr>';
			$div.='<td width="15%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">Código:</td>';
			$div.='<td width="35%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);"><b>'.$obj['col']['id'].'</b></td>';
			$div.='<td width="15%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">Emisión:</td>';
			$div.='<td width="35%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">'.$obj['col']['fecha'].'</td>';
			$div.='</tr>';
			if(!empty($obj['sostenedor'])){
			$div.='<tr>';
			$div.='<td width="15%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">RUT:</td>';
			$div.='<td width="35%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">'.number_format($obj['sostenedor']['RUT'], 0, ',', '.').'</td>';
			$div.='<td width="15%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">Sostenedor:</td>';
			$div.='<td width="35%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">'.$obj['sostenedor']['SOSTENEDOR'].'</td>';
			$div.='</tr>';
			}else{}
			$div.='<tr>';
			$div.='<td width="15%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">Colegio:</td>';
			$div.='<td width="35%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">'.$obj['col']['colegio'].'</td>';
			$div.='<td width="15%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">Dirección:</td>';
			$div.='<td width="35%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">'.$obj['col']['direccion'].'</td>';
			$div.='</tr>';
			$div.='<tr>';
			$div.='<td style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">Contacto:</td>';
			$div.='<td style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">'.$obj['col']['contacto'].'</td>';
			$div.='<td style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);"></td>';
			$div.='<td style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);"></td>';
			$div.='</tr>';
			$div.='</table><br>';
		$div.= '<div style="background-color:rgb(238,238,238);"> Detalle de los productos</div>';
		//DETALLE DE LOS PRODUCTOS

		$div.= '<br><table style="border-top:1px solid rgb(238,238,238);font-size:11px" width="100%">';
			//titulos de la tabla detalle
			$div.='<tr style="background-color:rgba(235, 255, 0, 0.51);color:white">';
			$div.='<td width="6%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:center">ITEM</td>';
			$div.='<td width="38%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:center">DESCRIPCIÓN</td>';
			$div.='<td width="5%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:center">UNI.</td>';
			$div.='<td width="13%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:center">PRECIO NETO</td>';
			$div.='<td width="13%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:center">TOTAL NETO</td>';
			$div.='<td width="13%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:center">IVA</td>';
			$div.='<td width="12%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:center">PRECIO TOTAL</td>';
			$div.='</tr>';
			$n = 1;
			//productos asociados
			foreach($obj['detalle'] as $d){
				$div.='<tr>';
				$div.='<td width="6%" style="border-left:1px solid rgb(238,238,238);border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:center">'.$n.'</td>';
				$div.='<td width="38%" style="border-left:1px solid rgb(238,238,238);border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:justify"><b>'.$d['nombre'].'</b><br>'.$d['descripcion'].'</td>';
				$div.='<td width="5%" style="border-left:1px solid rgb(238,238,238);border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:center">'.$d['unidades'].'</td>';
				$div.='<td width="13%" style="border-left:1px solid rgb(238,238,238);border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:right">$ '.number_format($d['neto'],0, ',', '.').'</td>';
				$total_neto = ($d['unidades'] * $d['neto']);
				$div.='<td width="13%" style="border-left:1px solid rgb(238,238,238);border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:right">$ '.number_format($total_neto,0,',','.').'</td>';
				if($d['afecto_iva']==1){$valor_iva = ($total_neto*0.19);}else{$valor_iva = 0;}
				$div.='<td width="13%" style="border-left:1px solid rgb(238,238,238);border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:right">$ '.number_format($valor_iva,0,',','.').'</td>';
				if($d['afecto_iva']==1){$precio_total = ($total_neto*1.19);}else{$precio_total = $total_neto;}
				$div.='<td width="12%" style="border-left:1px solid rgb(238,238,238);border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:right">$ '.number_format($precio_total,0,',','.').'</td>';
				$div.='</tr>';
			$n++;
			}
			//detalle de la factura neto
			$div.='<tr>';
			$div.='<td width="70%" colspan="3"></td>';
			$div.='<td width="15%" style="text-align:right">SUBTOTAL</td>';
			$div.='<td width="15%" style="border-left:1px solid rgb(238,238,238);border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:right">$ '.number_format($obj['col']['neto'],0, ',', '.').'</td>';
			$div.='</tr>';
			//detalle de la factura IVA
			$div.='<tr>';
			$div.='<td width="70%" colspan="3"></td>';
			$div.='<td width="15%" style="text-align:right">IVA</td>';
			$div.='<td width="15%" style="border-left:1px solid rgb(238,238,238);border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:right">$ '.number_format($obj['col']['iva'],0, ',', '.').'</td>';
			$div.='</tr>';
			//detalle de la factura total
			$div.='<tr>';
			$div.='<td width="70%" colspan="3"></td>';
			$div.='<td width="15%" style="text-align:right">TOTAL</td>';
			$div.='<td width="15%" style="border-left:1px solid rgb(238,238,238);border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);text-align:right">$ '.number_format($obj['col']['total'],0, ',', '.').'</td>';
			$div.='</tr>';

			$div.='</table><br>';
			//CONDICIONES

		return $div;
	}

	function tmp_final_cotizacion($obj){
			$div ='<div style="font-size:12px;">CONDICIONES:<br>';
			$div.='<div style="border:1px solid rgb(238,238,238)">'.$this->tipo_pago($obj['col']['modalidad_pago']).'<br></div>';
			$div.='<br>OBSERVACIONES:<br>';
			$div.='<div style="border:1px solid rgb(238,238,238)">'.$obj['col']['observaciones'].'<br></div>';
			//mensaje final
			$div.='<div>Esperando que la presente cotización sea de su agrado, sin otro particular le saluda atentamente.<br><br>
			<div style="font-size:12px;"><b>'.$obj['col']['ejecutivo'].'</b><br>Asesor(a) de proyectos<br>Kdoce Soluciones Educativas.<br><a href="http://www.kdoce.cl">www.kdoce.cl</a></div></div></div>';
			return $div;
	}

	function tmp_reporte_vendedor($obj){
		$div='<h3>Cotizaciones</h3>';
		foreach($obj['detalle']['cotizaciones'] as $cot){
			if(count($cot['result'])>0){
				$div.= '<h4>Semana '.$cot['semana'].'</h4>';
				$div.='<table width="100%" style="font-size:11px; border:1px solid gray;">';
				$div.='<thead><tr>';
					$div.='<th width="5%">Id</th>';
					$div.='<th width="50%">Colegio</th>';
					$div.='<th width="25%">Dependencia</th>';
					$div.='<th width="20%">Monto</th>';
				$div.='</tr></thead><tbody>';
				foreach($cot['result'] as $r){
					$div.='<tr>';
					$div.='<td width="5%" style="border-bottom:1px solid gray;border-right:1px solid gray">'.$r['id'].'</td>';
					$div.='<td width="50%" style="border-bottom:1px solid gray;border-right:1px solid gray">'.$r['colegio'].'</td>';
					$div.='<td width="25%" style="border-bottom:1px solid gray;border-right:1px solid gray">'.$r['dependencia'].'</td>';
					$div.='<td width="20%" style="text-align:right" style="border-bottom:1px solid gray;border-right:1px solid gray">$ '.number_format($r['total'], 0, ',','.').'</td>';
				$div.='</tr>';
				}
				$div.='</tbody></table>';
			}
		}
		$div.='<h3>Gestiones</h3>';
		foreach($obj['detalle']['gestiones'] as $ges){
			if(count($ges['result'])>0){
				$div.='<h4>Semana '.$ges['semana'].'</h4>';

				$div.='<table width="100%" style="font-size:11px;border:1px solid gray;">';
				$div.='<thead><tr>';
					$div.='<th width="20%" style="border-bottom:1px solid gray;border-right:1px solid gray">Fecha</th>';
					$div.='<th width="20%" style="border-bottom:1px solid gray;border-right:1px solid gray">Descripcion</th>';
					$div.='<th width="50%" style="border-bottom:1px solid gray;border-right:1px solid gray">Colegio</th>';
					$div.='<th width="10%" style="border-bottom:1px solid gray;border-right:1px solid gray">SEP</th>';
					//$div.='<th>Observaciones</th>';
				$div.='</tr></thead><tbody>';
				foreach($ges['result'] as $g){
					$div.='<tr>';
					$div.='<td width="20%" style="border-bottom:1px solid gray;border-right:1px solid gray">'.$g['fecha'].'</td>';
					$div.='<td width="20%" style="border-bottom:1px solid gray;border-right:1px solid gray">'.$g['descripcion'].'</td>';
					$div.='<td width="50%" style="border-bottom:1px solid gray;border-right:1px solid gray">'.$g['nombre'].'</td>';
					$div.='<td width="10%" style="border-bottom:1px solid gray;border-right:1px solid gray">'.$g['alumnos_sep'].'</td>';
					//$div.='<td>'.$g['observaciones'].'</td>';
				$div.='</tr>';
				}
				$div.='</tbody></table>';
			}
		}

		return $div;
	}

	function contrato_renovacion(){
		$div='<h1 style="text-align:center">Contrato de Mantención de Servicio<br>“MasterClass”</h1>';
		$div.='<p style="text-align:justify">En Santiago, a '.date("d").' de Octubre del año '.date("Y").', entre <b>KDOCE SPA</b>, RUT <b>76.319.406-K</b>, domiciliada en calle Beaucheff #1171, comuna de Santiago, Región Metropolitana,  en adelante  “El Proveedor”, representada por el Sr. Rodrigo Andrés Villarroel Ramírez, RUT 15.329.741-K, propietario de todos los derechos de autor de la plataforma individualizada “MasterClass”, con idéntico domicilio, y la institución de educación <b>COLEGIO DALMACIA</b>, Rut: <b>96.955.930-5</b>, Razón Social: <b>SOCIEDAD EDUCACIONAL DALMACIA S.A</b>. Domiciliado en<b> Prolongación Calle Benavente s/n. Ciudad de Ovalle</b> representada por el Sr.(a) <b>SEBASTIAN ROBERTO DABED MARTINIC, C.I. 16.020.922-4</b> en  adelante la “Institución educacional”, acuerdan lo siguiente:</p>';
		$div.='<p>Formalizan de contrato de servicio. “MasterClass” plataforma de gestión de recursos educativos formaliza el contrato de mantención y actualización de servicio con la institución adoptante de acuerdo a los siguientes puntos:</p>';

		$div.='<h3>Modulo de Evaluaciones</h3>';
		$div.='<p style="text-align:justify">“MasterClass” proveerá a las institución adoptante el modulo de evaluaciones digital de acuerdo a los contenidos propuestos por el MINEDUC, podrán acceder al banco de evaluaciones estandarizas, así como también podrán crear cualquier otro instrumento de evaluación.</p>';

		$div.='<h3>Modulo de Aprendizajes Claves:</h3>';
		$div.='<p style="text-align:justify">“MasterClass” proveerá a la institución adoptante el modulo de evaluación de aprendizajes claves digital exigido por la Ley SEP, el modulo permite que institución visualice y aplique la evaluación de Diagnostico, Intermedia y Final, así como el acceso a los reportes exigidos por el Plan de Mejoramiento Educativo (PME).</p>';

		$div.='<h3>Evaluaciones Asistidas:</h3>';
		$div.='<p style="text-align:justify">La institución adoptante puede acceder al servicio de evaluaciones asistidas durante el año para los aprendizajes claves. Dicho servicio considera un costo adicional la institución.</p>';


		$div.='<h3>Modulo de cronograma de planificaciones</h3>';
		$div.='<p style="text-align:justify">“MasterClass” proveerá a las instituciones adoptantes el modulo de cronogramas de planificaciones pedagógicas digitales.  El modulo le permitirá la visualización de los cronogramas, así como también creación y modificación del las planificaciones del banco existente.</p>';

		$div.='<h3>Modulo de Recursos</h3>';
		$div.='<p style="text-align:justify">“MasterClass” proveerá un modulo de recursos digitales donde la institución adoptante podrá cargar nuevos recursos y visualizar el banco existente.</p>';

		$div.='<h3>Soporte en línea</h3>';
		$div.='<p style="text-align:justify">La institución adoptante tendrá derecho a recibir soporte técnico oportuno en los tiempos y formas adecuadas, la institución podrá acceder directamente a nuestro número de soporte (02-2599 49 93) donde será atendido por ejecutivos de servicio en los siguientes horarios de atención Lunes a Viernes de 8:30 a 17:30 hrs. No obstante, el proveedor podrá realizar soporte en terreno si el problema persiste.</p>';

		$div.='<h3>Actualización del software</h3>';
		$div.='<p style="text-align:justify">La institución adoptante tendrá derecho a recibir la totalidad de las actualizaciones que se realicen durante el periodo del contrato.</p>';


		$div.='<h3>Respaldo de la Información:</h3>';
		$div.='<p style="text-align:justify">La institución adoptante siempre podrá solicitar información de respaldo del último mes de uso.</p>';

		$div.='<h3>Accesos de Usuarios</h3>';
		$div.='<p style="text-align:justify">“MasterClass” proveerá las claves de acceso para toda la comunidad educativa sin límite de usuarios. Se consideran alumnos, profesores y directivos según la matricula vigente del establecimiento.</p>';

		$div.='<h3>Capacitación a usuarios</h3>';
		$div.='<p style="text-align:justify">“MasterClass” realiza proceso de capacitación necesario en el establecimiento para la plana docente y directivos que estimen participar y puesta en marcha de la plataforma. Considera además, proceso de capacitación diferenciado para la plana directiva y lideres de proyecto.</p>';
		return $div;
	}

	function termino_contrato(){

		$div='<h2>Termino del Contrato</h2>';
		$div.='<p style="text-align:justify">La institución adoptante podrá poner términos al presente contrato, comunicando mediante carta certificada el deseo de no continuar con el servicio. Deberá informarse con un plazo mínimo de 60 días anteriores al vencimiento del contrato. En ese momento “MasterClass” dejara de actualizar los contenidos, recursos y funciones.</p>';

		$div='<h2>Renovación del contrato</h2>';
		$div.='<p style="text-align:justify">Sin perjuicio del artículo anterior, el contrato se renovara en forma automática por plazos iguales sucesivos de un año.</p>';

		$div='<h2>Precio del servicio</h2>';
		$div.='<p style="text-align:justify">El precio del servicio de mantención de “MasterClass” es de 90 UF más IVA anuales.</p>';


		$div='<h2>Facturación del Servicio</h2>';
		$div.='<p style="text-align:justify">La institución adoptante Faculta a “MasterClass” a enviar la respectiva factura de servicios con 30 días de anticipación al vencimiento del contrato.</p>';


		$div.='<p style="text-align:justify">En comprobante y previa lectura, firman las partes el presente contrato en 2 ejemplares.</p>';


		$div.='<p></p><p style="text-align:justify">
			<table width="100%">
			<tr>
				<td width="25%" style="border-bottom:1px solid gray"></td>
				<td width="25%"></td>
				<td width="25%"></td>
				<td width="25%" style="border-bottom:1px solid gray"></td>
			</tr>
			<tr>
				<td width="25%">
					Empresa
				</td>
				<td width="25%"></td>
				<td width="25%"></td>
				<td width="25%">
					Cliente
				</td>
			</tr>
			</table>
		</p>';
		return $div;
	}
}
?>