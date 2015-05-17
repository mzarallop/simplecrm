<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

	class Mod_soporte extends CI_Model{

		 function __construct(){
       	 	parent::__construct();
        	$this->master = $this->load->database('explotacion', TRUE);
    	}

		function ver_alumnos($param)
		{
			$sql="SELECT CA.* FROM ".$param['base'].".core_usuarios CA WHERE CA.idperfil = 4";
			$query = $this->master->query($sql);
			return $query->result_array();
		}

		function ver_pruebas($param)
		{
			$sql="SELECT CA.* FROM ".$param['base'].".simce_evaluaciones CA ORDER BY CA.idnivel, CA.idasignatura";
			$query = $this->master->query($sql);
			return $query->result_array();
		}
		


	} 

?>