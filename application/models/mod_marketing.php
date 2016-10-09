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

	function lista_regiones_colegios($segmento){
		$q = $this->db->select('COD_REG_RBD, COUNT(RBD) TOTAL_COLEGIOS')
		->from('SEP_ACTUAL sa')
		->where_in('SEGMENTO', $segmento)
		->group_by('COD_REG_RBD')
		->get();
		return $q->result_array();
	}

	function lista_comunas_colegios($segmento, $region){
		$q = $this->db->select('COD_COM_RBD, NOM_COM_RBD, COUNT(RBD) TOTAL_COLEGIOS')
		->from('SEP_ACTUAL sa')
		->where_in('SEGMENTO', $segmento)
		->where('COD_REG_RBD', $region)
		->group_by('COD_COM_RBD')
		->get();
		return $q->result_array();
	}

	function filtrarColegios($data){
		$this->db->select('RBD, NOM_RBD, COD_DEPE, N_PRIO, N_BEN');
		$this->db->from('SEP_ACTUAL');
		if(count($data['segmento'])>0){
			$this->db->where_in('SEGMENTO', $data['segmento']);
		}
		if(isset($data['region']) && $data['region']>0){
			$this->db->where('COD_REG_RBD', $data['region']);
		}
		if(isset($data['comuna']) && $data['comuna']>0){
			$this->db->where('COD_COM_RBD', $data['comuna']);
		}
		$this->db->order_by('N_PRIO ASC');
		$q = $this->db->get();

		return $q->result_array();
		
	}
}