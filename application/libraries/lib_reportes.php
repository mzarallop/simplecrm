<?php	
if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');
class lib_reportes {

	function reporte_gestiones($param)
	{
		$CI = get_instance();
		$sql = "SELECT * FROM core_usuarios ORDER BY NOM_EJECUTIVO";
		
		$query = $CI->db->query($sql);
		$row = $query->result_array();
		$total = $query->num_rows();

		if($total>0)
		{
			$div = '<table class="table table-condensed table-bordered">';
			$div.='<theader>';
			$div.='<th>Ejecutivos</th>';
			$div.='<th>Emails</th>';
			$div.='<th>Interesados</th>';
			$div.='<th>Agendas</th>';
			$div.='<th>Cotizaciones</th>';
			$div.='<th>Visitas</th>';
			$div.='<th>Entrevistas</th>';
			$div.='<th>Presentaciónes</th>';
			$div.='<th>Ventas :)</th>';
			$div.='<th style="background-color:yellowgreen">Totales</th>';
			$div.='<th style=""><i class="icon-search"></i></th>';
			$div.='</theader>';
			$div.='<tbody>';

				$sum0 = 0;
				$sum1 = 0;
				$sum2 = 0;
				$sum3 = 0;
				$sum4 = 0;
				$sum5 = 0;
				$sum6 = 0;
				$sum7 = 0;
				$sum8 = 0;

			foreach($row as $r){
				$div.='<tr>'."\r\n";
				$div.='<td>'.$r['NOM_EJECUTIVO'].'</td>'."\r\n";
				$calculos = $this->gestiones_usuario(array("ejecutivo"=>$r['ID'], "inicio"=>$param['inicio'], "fin"=>$param['termino']));
				$div.= $calculos['html'];
				$div.='<td><a href="javascript:;"  data-usuario="'.$r['ID'].'" onclick="ver_gestiones_ejecutivos(event)"><i class="icon-search" data-usuario="'.$r['ID'].'"></i></a></td>';
				$sum0+= $calculos['vector'][0];
				$sum1+= $calculos['vector'][1];
				$sum2+= $calculos['vector'][2];
				$sum3+= $calculos['vector'][3];
				$sum4+= $calculos['vector'][4];
				$sum5+= $calculos['vector'][5];
				$sum6+= $calculos['vector'][6];
				$sum7+= $calculos['vector'][7];
				$sum8+= $calculos['vector'][8];

				$div.='</tr>'."\r\n";

			}
				$div.='<tr style="background-color:yellow;color:black;text-align:center">';
				$div.='<td style="text-align:center"><b>Totales</b></td>';
				$div.='<td style="text-align:center"><b>'.$sum0.'</b></td>';
				$div.='<td style="text-align:center"><b>'.$sum1.'</b></td>';
				$div.='<td style="text-align:center"><b>'.$sum2.'</b></td>';
				$div.='<td style="text-align:center"><b>'.$sum3.'</b></td>';
				$div.='<td style="text-align:center"><b>'.$sum4.'</b></td>';
				$div.='<td style="text-align:center"><b>'.$sum5.'</b></td>';
				$div.='<td style="text-align:center"><b>'.$sum6.'</b></td>';
				$div.='<td style="text-align:center"><b>'.$sum7.'</b></td>';
				$div.='<td style="text-align:center"><b>'.$sum8.'</b></td>';
				$div.='<td style="text-align:center"><b></b></td>';				
				$div.='</tr>';
			$div.='</tbody>';
			$div.='</table>';

			return $div;
		}		

	}

	//recopila el tototal de gestiones del usuario agrupandolo por el codigo de gestión
	function gestiones_usuario($param)
	{
		$CI = get_instance();

		$f1 = strtotime($this->invertir_fecha($param['inicio']).' 00:00');
		$f2 = strtotime($this->invertir_fecha($param['fin']).' 23:59');

		$sql="SELECT CG.*, count(CCG.COD_GESTION) as TOTAL_GESTION FROM core_gestiones CG
				LEFT JOIN core_cliente_gestion CCG ON (CG.id = CCG.COD_GESTION)
				WHERE CCG.COD_EJECUTIVO = '".$param['ejecutivo']."' AND CCG.FECHA_GESTION  
				BETWEEN '".$f1."' AND '".$f2."' 
				GROUP BY CG.id ORDER BY CG.id DESC";

		$query = $CI->db->query($sql);
		$row = $query->result_array();
		$total = $query->num_rows();
			
				$div='';
				$suma = 0;
				$contador = 1;
				for($i=0;$i<8;$i++)
				{
					if(@$row[$i]['TOTAL_GESTION']>0)
					{
					$valor = $row[$i]['TOTAL_GESTION'];
						$divs ='<td style="text-align:center"><a href="javascript:;" title="G: '.$row[$i]['id'].$row[$i]['gestion'].'">'.$row[$i]['TOTAL_GESTION'].'</a></td>'."\r\n";
					}
					else
					{
						$valor = 0;
					$divs ='<td style="text-align:center"><a href="javascript:;" title="G: '.$contador.'">'.$valor.'</a></td>'."\r\n";

					}

					$div.= $divs;


					
					$suma += $valor;
					$datos[$i] = $valor;
					$contador++;
				}
					$datos[8]= $suma;
					$div.='<td style="background-color:yellowgreen;color:white;text-align:center"><b>'.$suma.'</b></td>'."\r\n";
					//$div.='<td>'.$sql.'</td>';
					

			return array("html"=>$div, "vector"=>$datos);
	}

	function invertir_fecha($date)
	{

		$fecha_ini = explode("/",$date);
		$fecha_ini = array_reverse($fecha_ini);
		$fecha_ini = implode("-", $fecha_ini);

		return $fecha_ini;
	}

	



}
?>