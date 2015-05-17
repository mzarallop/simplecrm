<?php
class modfacturas extends CI_Model{

	function recuperar_clientes(){

		$this->db->select('rut, razon_social, count(rbd) colegios, sum(neto) neto_factura');
		$this->db->group_by('rut');
		$this->db->order_by('neto_factura DESC');
		$query = $this->db->get('factura_general');
		return $query->result_array();
	}

	function buscar_facturas($param){
		$this->db->where('rut', $param['rut']);
		$this->db->order_by('idfactura');
		$query = $this->db->get('factura_general');
		return $query->result_array();
	}

}
