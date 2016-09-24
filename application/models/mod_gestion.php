<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

class mod_gestion extends CI_Model{

	function reporte_gestion($obj){

		$this->db->where('id >', 1);
		$perfiles = $this->db->get('core_perfiles');

		$datos = array();
		foreach($perfiles->result_array() as $perfil){

			array_push($datos, array("perfil"=>$perfil, "asesores"=>$this->traer_asesores($perfil, $obj)));
		}
		return $datos;
	}

	function traer_asesores($obja, $objb){

		$this->db->where('idperfil', $obja['id']);
		$this->db->where('visible', 1);
		$query = $this->db->get('vista_carteras_vendedores');
		$row = $query->result_array();
		$datos = array();
		foreach($row as $vendedor){
			array_push($datos, array(
				"vendedor"=>$vendedor,
				"cotizaciones"=>$this->traer_cotizaciones($vendedor, $objb),
				"acciones"=>$this->traer_acciones($vendedor, $objb)
				)
			);
		}

		return $datos;
	}

	function traer_cotizaciones($obja, $objb){

		$this->db->select('count(idcotizacion) total_cotizacion, sum(neto) total_neto, sum(iva) total_iva, sum(total) total_final');
		if($objb['mes']>0){
			$this->db->where('fecha_cotizacion', $objb['mes']);
		}else{
			$this->db->where('fecha_cotizacion', date("m-Y"));
		}
		$this->db->from('vista_cotizaciones_vendedores');
		$this->db->where('idvendedor', $obja['idvendedor']);
		$this->db->group_by('idvendedor');
		$query = $this->db->get();
		$row = $query->result_array();
		if($query->num_rows()>0){
			return $row[0];
		}else{
			return array();
		}
	}


	function traer_acciones($obja, $objb){

		$this->db->where('idperfil', $obja['idperfil']);
		$this->db->order_by('orden');
		$q_tipo_accion = $this->db->get('core_gesitones_tipo');
		$row_tipo = $q_tipo_accion->result_array();
		$inicio = explode("-",$objb['inicio']);
		$mes = $inicio[1].'-'.$objb[0];
		$data = array();

		foreach($row_tipo as $rt){
			//detalle de las acciones

			$this->db->from('core_cliente_gestion ccg');
			$this->db->where("ccg.fecha between '".$objb['inicio']." 00:00:01' AND '".$objb['termino']." 23:59:59'");
			$this->db->where('ccg.idvendedor', $obja['idvendedor']);
			$this->db->where('ccg.idgestion', $rt['id']);
			$this->db->group_by('ccg.rbd, ccg.idgestion');
			$query = $this->db->get();
			$row = $query->result_array();

			array_push($data, array("tipo"=>$rt, "detalle"=>$row));
		}
		return $data;
	}

	function traer_usuarios($obj){

		$this->db->select('cu.*, count(cca.id) total_asignacion');
		$this->db->from('core_usuarios cu');
		$this->db->join('core_clientes_asignaciones cca', 'cu.ID=cca.idusuario', 'left');
		$this->db->group_by('cu.ID');
		$this->db->order_by('visible desc, NOM_EJECUTIVO');

		if($obj['id']>0){
			$this->db->where('cu.ID', $obj['id']);
		}

		$q = $this->db->get();

		return $q->result_array();
	}

	function update_usuarios($obj){
		$datos = array("NOM_EJECUTIVO"=>$obj['nombre'], "EMAIL"=>$obj['email'],
						"LOGIN"=>$obj['loggin'],"PASSWORD"=>$obj['password'],
						"visible"=>$obj['visible'], "ANEXO"=>$obj['anexo']);
		$this->db->where('ID', $obj['id']);
		return $this->db->update('core_usuarios', $datos);
	}

	function cargar_asignacion($obj){
		$usuario = $this->usuarios->usuario_completo();
		$datos = array("idusuario"=>$usuario['ID'], "archivo"=>$obj['archivo']);
		return $this->db->insert('asignacion_realizada', $datos);
	}

	function filtrar_vendedores_carga(){
		$this->db->select('cu.ID, cu.LOGIN');
		$this->db->from('asignacion a');
		$this->db->join('core_usuarios cu', 'a.vendedor = cu.LOGIN', 'left');
		$this->db->group_by('cu.id');
		$query = $this->db->get();
		return $query->result_array();
	}

	function crear_asignacion($obj, $carga){

		$this->db->truncate('asignacion');

		foreach($obj as $col){
			$datos = array("rbd"=>$col['rbd'], "vendedor"=>$col['usuario']);
			$this->db->insert('asignacion', $datos);
		}

		$usuario = $this->filtrar_vendedores_carga();
		$contador = 1;
		foreach($usuario as $u){



			if($carga == 1){



					$rbds = $this->db->where('vendedor', $u['LOGIN'])->select('rbd')->from('asignacion')->get();
					$row_rbds = $rbds->result_array();
					$rbd = array();
					foreach($row_rbds as $rb){
						array_push($rbd, $rb['rbd']);
					}

					$this->db->where_in('idrbd', $rbd);
					$del = $this->db->delete('core_clientes_asignaciones');


				if($del){

					$sql="insert into core_clientes_asignaciones (idusuario, idcliente, idrbd, idasignador)
						select '".$u['ID']."', rbd, rbd, '168' from asignacion
						where vendedor = '".$u['LOGIN']."'";

					$this->db->query($sql);

				}

			}elseif($carga == 0){


					$rbds = $this->db->where('vendedor', $u['LOGIN'])->select('rbd')->from('asignacion')->get();
					$row_rbds = $rbds->result_array();
					$rbd = array();
					foreach($row_rbds as $rb){
						array_push($rbd, $rb['rbd']);
					}

					$this->db->where_in('idrbd', $rbd);
					$del = $this->db->delete('core_clientes_asignaciones');


				if($del){
					$this->db->where('idusuario', $u['ID']);
					$this->db->delete('core_clientes_asignaciones');

					$sql2="insert into core_clientes_asignaciones (idusuario, idcliente, idrbd, idasignador)
					  select '".$u['ID']."', rbd, rbd, '168' from asignacion
					  where vendedor = '".$u['LOGIN']."'";
				 	$this->db->query($sql2);
				 }
			}

			$contador++;
		}

		return $contador;

	}

	function agregar_usuarios($obj){
		$datos = array(
			"NOM_EJECUTIVO"=>$obj['nombre'],
			"EMAIL"=>$obj['email'],
			"LOGIN"=>$obj['login'],
			"PASSWORD"=>$obj['pass'],
			"IDPERFIL"=>$obj['perfil'],
			"visible"=>1
			);

		return $this->db->insert('core_usuarios', $datos);
	}

	function volcar_colegios($obj){
		$datos = array();
		//entrevistas
		if(isset($obj['entrevista']) && count($obj['entrevista'])>0){

		$entrevista = $obj['entrevista'];
		$this->db->select('RBD, NOMBRE, ALUMNOS_SEP, TELEFONO, DEPENDENCIA, COMUNA, CLASIFICACION, MATRICULA');
		$this->db->where_in('RBD', $entrevista);
		$this->db->group_by('RBD');
		$entr = $this->db->get('core_clientes_sep');
			$datos["entrevista"] = $entr->result_array();

		}else{
			$datos["entrevista"] = array();
		}

		//presentacion
		if(isset($obj['presentacion']) && count($obj['presentacion'])>0){
		$presentacion = $obj['presentacion'];
		$this->db->select('RBD, NOMBRE, ALUMNOS_SEP, TELEFONO, DEPENDENCIA, COMUNA, CLASIFICACION, MATRICULA');
		$this->db->where_in('RBD', $presentacion);
		$this->db->group_by('RBD');
		$pres = $this->db->get('core_clientes_sep');
			$datos['presentacion'] = $pres->result_array();
		}else{
			$datos['presentacion'] = array();
		}
		//cierre
		if(isset($obj['cierre']) && count($obj['cierre'])>0){
		$cierre = $obj['cierre'];
		$this->db->select('RBD, NOMBRE, ALUMNOS_SEP, TELEFONO, DEPENDENCIA, COMUNA, CLASIFICACION, MATRICULA');
		$this->db->where_in('RBD', $cierre);
		$this->db->group_by('RBD');
		$cier = $this->db->get('core_clientes_sep');
			$datos["cierre"] = $cier->result_array();
		}else{
			$datos["cierre"] = array();
		}
		//interesados
		if(isset($obj['interesado']) && count($obj['interesado'])>0){
		$interesados = $obj['interesado'];
		$this->db->select('RBD, NOMBRE, ALUMNOS_SEP, TELEFONO, DEPENDENCIA, COMUNA, CLASIFICACION, MATRICULA');
		$this->db->where_in('RBD', $interesados);
		$this->db->group_by('RBD');
		$inte = $this->db->get('core_clientes_sep');
			$datos["interesado"] = $inte->result_array();
		}else{
			$datos["interesado"] = array();
		}
		return $datos;
	}

	function reporte_gestiones($obj, $usuario){
		$data = array();
			$query = $this->db->query('call sp_reporte_gestion(2,'.$usuario.')');
			$row = $query->result_array();
			$query->next_result();
		foreach($row as $r){
			array_push($data, array("resumen"=>$r, "detalle"=>$this->detalle_resultados_($r)));
		}
		return $data;
	}


	function reporte_gestionesb(){
			$query = $this->db->query('call sp_reporte_llamar(2, "Particular Subvencionado")');
			return $query->result_array();
	}

	function detalle_resultados_($obj){

		$semana = explode(",",$obj['idsemana']);
		$data_gestion = array();
		$data_cotizacion = array();

		foreach($semana as $sem){

			$this->db->where('DATE_FORMAT(fecha, "%u")=', $sem);
			$this->db->where('idvendedor', $obj['idv']);
			$this->db->order_by('fecha DESC');
			$query2 = $this->db->get('cotizacion_general');
			array_push($data_cotizacion, array("semana"=>$sem, "result"=>$query2->result_array()));
			$query2->next_result();
			$this->db->where('idsemana', $sem);
			$this->db->where('idvendedor', $obj['idv']);
			$this->db->where('descripcion !="volver a llamar"');
			$this->db->order_by('fecha DESC');
			$query = $this->db->get('vista_resumen_gestiones');
			array_push($data_gestion, array("semana"=>$sem, "result"=>$query->result_array()));
			$query->next_result();

		}

		return array("gestiones"=>$data_gestion, "cotizaciones"=>$data_cotizacion);

	}

	function sostenedores(){
		/*
		 [general] => Array
                (
                    [0] => AGNO
                    [1] => P_JURIDICA
                    [2] => MRUN
                    [3] => RUT_SOST
                    [4] => NOMBRE_SOST
                    [5] => NUM_RBD_CORP_MUN
                    [6] => NUM_RBD_MUN_DAEM
                    [7] => NUM_RBD_PART_SUBV
                    [8] => NUM_RBD_PART_PAG
                    [9] => NUM_RBD_ADM_DEL
                    [10] => NUM_RBD
                    [11] => NUM_RBD_EN_FUNCION_CON_MAT
                    [12] => NUM_RBD_EN_FUNCION_SIN_MAT
                    [13] => NUM_RBD_EN_RECESO
                    [14] => NUM_RBD_CERRADO
                    [15] => NUM_RBD_AUT_SIN_MATRICULA
                    [16] => MAT_CORP_MUN
                    [17] => MAT_MUN_DAEM
                    [18] => MAT_PART_SUBV
                    [19] => MAT_PART_PAG
                    [20] => MAT_ADM_DEL
                    [21] => MAT_TOTAL
                    [22] => NUM_C_DOC
                    [23] => NUM_C_ASIS
            */

		$file = './asignaciones/sostenedores.csv';
		$handle = fopen($file,"r");
		$vector = array();

			 do {
		        if (@$data[0]) {


		           $colegios = array();

		           for($i=24;$i<160;$i++){
		           		if($data[$i]>0){
		           			array_push($colegios, $data[$i]);
		           		}else{

		           		}
		           }
		           $total_colegios = count($colegios);
		           $sostenedor = array(
		           	"rut"=>$data[3],
		           	"nombre"=>$data[4],
		           	"total_colegios"=>$total_colegios,
		           	"num_rbd"=>$data[10],
		           	"total_profesores"=>$data[22],
		           	"matricula_total"=>$data[21],
		           	"asistentes_aula"=>$data[23],
		           	"cmu"=>$data[5],
		           	"daem"=>$data[6],
		           	"psub"=>$data[7],
		           	"ppa"=>$data[8],
		           	"cad"=>$data[9]);

		           array_push($vector, array("sostenedor"=>$sostenedor,	"colegios"=>$colegios));
		        }
		    } while ($data = fgetcsv($handle,13000,";","'"));

		$total_vector = count($vector);

		$this->db->truncate('core_sostenedores');
		$this->db->truncate('core_sostenedor_colegios');
		for($i=1;$i<$total_vector;$i++){


			$this->db->insert('core_sostenedores', $vector[$i]['sostenedor']);
			$id = $this->db->insert_id();

			foreach($vector[$i]['colegios'] as $col){

				$datos = array("idsostenedor"=>$id, "idrbd"=>$col);
				$this->db->insert('core_sostenedor_colegios', $datos);
			}

		}

		return $vector;
	}


	function colegios(){


		$file = './asignaciones/colegios_general.csv';
		$handle = fopen($file,"r");
		$vector = array();

			 do {
		        if (@$data[0]) {

		           $ensenanza = array();

		           for($i=19;$i<31;$i++){
		           		if($data[$i]>0){
		           			array_push($ensenanza, $data[$i]);
		           		}else{

		           		}
		           }

		           $total_ensenanza = count($ensenanza);

		           $colegio = array(
		           	"agno"=>$data[0],
		           	"rbd"=>$data[1],
		           	"dgv_rbd"=>$data[2],
		           	"nom_rbd"=>$data[3],
		           	"cod_reg_rbd"=>$data[4],
		           	"cod_pro_rbd"=>$data[5],
		           	"cod_com_rbd"=>$data[6],
		           	"nom_com_rbd"=>$data[7],
		           	"cod_deprov_rbd"=>$data[8],
		           	"nom_deprov_rbd"=>$data[9],
		           	"cod_depe"=>$data[10],
		           	"cod_depe2"=>$data[11],
		           	"rural_rbd"=>$data[12],
		           	"fono_rbd"=>$data[13],
		           	"celular_rbd"=>$data[14],
		           	"dir_rbd"=>$data[15],
		           	"latitud"=>$data[16],
		           	"longitud"=>$data[17],
		           	"convenio_pie"=>$data[18],
		           	"matricula"=>$data[31],
		           	"estado_rbd"=>$data[32],
		           	"ori_religiosa"=>@$data[33],
		           	"ori_otro_religiosa"=>@$data[34],
		           	"pago_matricula"=>@$data[35],
		           	"pago_mensual"=>@$data[36]
		           	);

		           array_push($vector, array("colegio"=>$colegio,	"ensenanza"=>$ensenanza));

		        }

		    } while ($data = fgetcsv($handle,15000,";","'"));

		    $total_vector = count($vector);

		    $this->db->truncate('core_colegios');
		    $this->db->truncate('core_colegios_ensenanza');

		    for($i=1;$i<$total_vector;$i++){

		    	$this->db->insert('core_colegios', $vector[$i]['colegio']);
		    	$id = $this->db->insert_id();

		    	foreach($vector[$i]['ensenanza'] as $ens){

		    		$datos = array("idcolegio"=>$id, "rbd"=>$vector[$i]['colegio']['rbd'], "idensenanza"=>$ens);
		    		$this->db->insert('core_colegios_ensenanza', $datos);
		    	}
		    }
		    return $vector;
	}

	function sep(){


		$file = './asignaciones/colegios_sep.csv';
		$handle = fopen($file,"r");
		$vector = array();

			 do {
		        if (@$data[0]) {


		           $colegio = array(
		           	"agno"=>$data[0],
		           	"rbd"=>$data[1],
		           	"dgv_rbd"=>$data[2],
		           	"nom_rbd"=>$data[3],
		           	"cod_reg_rbd"=>$data[4],
		           	"cod_pro_rbd"=>$data[5],
		           	"cod_com_rbd"=>$data[6],
		           	"nom_com_rbd"=>$data[7],
		           	"cod_deprov_rbd"=>$data[8],
		           	"nom_deprov_rbd"=>$data[9],
		           	"cod_depe"=>$data[10],
		           	"cod_depe2"=>$data[11],
		           	"rural_rbd"=>$data[12],
		           	"convenio_sep"=>$data[13],
		           	"agno_igreso_sep"=>$data[14],
		           	"clasificacion_sep"=>$data[15],
		           	"clasificacion_sep"=>$data[15],
		           	"n_prop	"=>$data[16],
		           	"n_ben"=>$data[17]
		           	);

		           array_push($vector, array("colegio"=>$colegio));

		        }

		    } while ($data = fgetcsv($handle,15000,";","'"));

		    $total_vector = count($vector);

		    $this->db->truncate('core_colegios_sep');


		    for($i=1;$i<$total_vector;$i++){

		    	$this->db->insert('core_colegios_sep', $vector[$i]['colegio']);
		    }

		    return $vector;
	}

} ?>