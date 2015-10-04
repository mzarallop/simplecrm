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

				$sql="insert into core_clientes_asignaciones (idusuario, idcliente, idrbd, idasignador)
					  select '".$u['ID']."', rbd, rbd, '168' from asignacion where vendedor = '".$u['LOGIN']."'";

				$this->db->query($sql);

			}elseif($carga == 0){

				$this->db->where('idusuario', $u['ID']);
				$this->db->delete('core_clientes_asignaciones');

				$sql2="insert into core_clientes_asignaciones (idusuario, idcliente, idrbd, idasignador)
				  select '".$u['ID']."', rbd, rbd, '168' from asignacion  where vendedor = '".$u['LOGIN']."'";
			 	$this->db->query($sql2);
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

} ?>