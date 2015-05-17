<?php 
class lib_soporte{
	
	function colegios(){

		$CI = get_instance();
		$sp = $CI->load->database('explotacion', TRUE);

		$sql = "SELECT CC.* FROM kdoceduc_colegios.core_colegios CC ORDER BY CC.nombre ";
		$query = $sp->query($sql);
		return $query->result_array();
	}

}

?>