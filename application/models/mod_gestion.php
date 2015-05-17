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

		$this->db->select('cgt.id, cgt.descripcion gestion, count(ccg.id) total_gestion');
		$this->db->from('core_cliente_gestion ccg');
		$this->db->join('core_gesitones_tipo cgt', 'ccg.idgestion = cgt.id');
		if($objb['mes']>0){
			$this->db->where('DATE_FORMAT(ccg.fecha, "%m-%Y")=', $objb['mes']);
		}else{
			$this->db->where('DATE_FORMAT(ccg.fecha, "%m-%Y")=', date("m-Y"));
		}
		$this->db->where('ccg.idvendedor', $obja['idvendedor']);
		$this->db->group_by('ccg.idvendedor, cgt.id');
		$query = $this->db->get();
		return $query->result_array();

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

	function crear_asignacion($obj){
		$this->db->truncate('asignacion');

		foreach($obj['rbd'] as $rbd){

			$datos = array("rbd"=>$rbd, "vendedor"=>$obj['usuario']);
			$this->db->insert('asignacion', $datos);

		}

		$this->db->where('idusuario', $obj['usuario']);
		$this->db->delete('core_clientes_asignaciones');

		$sql="insert into core_clientes_asignaciones (idusuario, idcliente, idrbd, idasignador)
			  select vendedor, rbd, rbd, '168' from asignacion";

		return $this->db->query($sql);

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