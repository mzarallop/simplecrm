<?php
class mod_facturas extends CI_Model{

	function ejecutivos($perfil){
		$q = $this->db->where('IDPERFIL', $perfil)->where('visible', 1)->get('core_usuarios');
		$r = $q->result_array();
		$q->next_result();
		return $r;
	}

	function productos_opt(){

		$this->db->where('parent', 0);
		$this->db->order_by('nombre ASC');
		$p = $this->db->get('core_categorias_productos');
		$r = $p->result_array();
		$p->next_result();
		$menu = array();

		foreach($r as $parent){
			array_push($menu, array("categoria"=>$parent, "submenu"=>$this->submenu($parent), "error"=>$p));
		}

		return $menu;

	}

	function submenu($obj){
		$this->db->where('parent', $obj['id']);
		$this->db->order_by('nombre ASC');
		$p = $this->db->get('core_categorias_productos');
		$r = $p->result_array();
		$p->next_result();
		return $r;
	}

	function buscar_datos($obj){
		$this->db->where('RBD', $obj['codigo']);
		$q = $this->db->get('core_clientes_sep');

		if($q->num_rows()>0){
			return $q->result_array();
		}else{

			$this->db->where('RUT', $obj['codigo']);
			$q2 = $this->db->get('core_clientes_sep');
			if($q2->num_rows()>0){
				return $q2->result_array();
			}else{
				return array();
			}
		}

	}
} ?>