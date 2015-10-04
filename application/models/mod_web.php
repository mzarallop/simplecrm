<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

	class Mod_web extends CI_Model
	{
		function mensajes_web()
		{
			$query = $this->db->query("SELECT * FROM core_contactos_web order by fecha desc");
			return $query->result_array();
		}
	}

?>