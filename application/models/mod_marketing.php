<?php
class mod_marketing extends CI_Model{

	function lista_segmentos(){
		$q = $this->db->select('vs.COD_DEPE, count(sa.RBD) total_colegios')
		->from('vista_segmentos vs')
		->join('SEP_ACTUAL sa', 'vs.COD_DEPE = sa.COD_DEPE', 'LEFT')
		->group_by('vs.COD_DEPE')
		->get();
		return $q->result_array();
	}

}