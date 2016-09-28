<?php
class mod_marketing extends CI_Model{

	function lista_segmentos(){
		$q = $this->db->select('vs.SEGMENTO, count(sa.RBD) total_colegios')
		->from('vista_segmentos vs')
		->join('SEP_ACTUAL sa', 'vs.SEGMENTO = sa.SEGMENTO', 'LEFT')
		->group_by('vs.SEGMENTO')
		->get();
		return $q->result_array();
	}

}