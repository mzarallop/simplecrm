<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mod_master extends CI_Model
{
	function __construct(){
		$this->master = $this->load->database('master', TRUE);
	}

	function colegios(){
		$query = $this->master->get('core_colegios');
		return $query->result_array();
	}

	function mostrar_usuarios($base){
		$this->master->select('id, nombre, idcurso, idnivel, idperfil');
		$query = $this->master->get($base.'.core_usuarios');
		return $query->result_array();
	}

	function mostrar_pruebas($base){
		
		$query = $this->master->get($base.'.simce_evaluaciones');
		return $query->result_array();
	}

	function mostrar_planificaciones($base){
		
		$query = $this->master->get($base.'.plan_planificacion');
		return $query->result_array();
	}

}
?>