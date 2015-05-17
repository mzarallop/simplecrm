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
				Monitor Araucano 10<br>
				Providencia - Santiago R. Metropolitana<br>
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
			$div.='<td width="35%" style="border-bottom:1px solid rgb(238,238,238);border-right:1px solid rgb(238,238,238);">'.date("d-m-Y h:m:s").'</td>';
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
			<div style="font-size:12px;"><b>'.$obj['col']['ejecutivo'].'</b><br>Ejecutivo comercial<br>Kdoce Soluciones Educativas.<br><a href="http://www.kdoce.cl">www.kdoce.cl</a></div></div></div>';
			return $div;
	}
} 
?>