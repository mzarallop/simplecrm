<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mod_api extends CI_Model
{
	function contacto($obj){

		if(isset($obj['nombre']) && $obj['nombre']!=""){


		$datos = array(
			"nombre"=>$obj['nombre'],
			"colegio"=>$obj['colegio'],
			"email"=>$obj['email'],
			"telefono"=>$obj['telefono'],
			"producto"=>$obj['producto']
			);

		$r = $this->db->insert('core_cupones', $datos);
		if($r){
			return json_encode(array("estado"=>$r, "contacto"=>$obj['nombre']));

		}else{
			return json_encode(array("estado"=>'Error', "contacto"=>'no hay datos de contacto validos'));
		}
	}else{

		return json_encode(array("estado"=>'Error', "contacto"=>'no hay datos de contacto validos'));
	}

	}

	function listarcupones(){
		$this->db->order_by('fecha', 'desc');
		$r = $this->db->get('core_cupones');

		return $r->result_array();
	}
}