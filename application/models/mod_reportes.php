<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

class Mod_reportes extends CI_Model{
	function __construct(){
			
			parent::__construct();
			//$this->central = $this->load->database('asterisk', TRUE);

		}

	function traer_llamadas_anexo($obj){
			
			$this->central->select('*');
			$this->central->where('dcontext', 'from-internal');
			$this->central->where('src', $obj);
			$this->central->where('disposition', 'ANSWERED');
			$query = $this->central->get('cdr');
			return $query->result_array();

		}
		
	function llamadas($obj){

		$usuario = $this->usuarios->usuario_completo();
		$this->central->select('*, SEC_TO_TIME(duration) tiempo');
		$this->central->where('dcontext', 'from-internal');
		
		if(isset($obj['anexo']) && !empty($obj['anexo'])){
			$this->central->where('src', $obj['anexo']);
		}else{
			$this->central->where('src', $usuario['ANEXO']);
		}
		
		if(isset($obj['inicio']) && !empty($obj['inicio']) && isset($obj['termino']) && !empty($obj['termino']))
		{
			$this->central->where('calldate BETWEEN "'.$obj['inicio'].' 00:00:01" AND "'.$obj['termino'].' 23:59:59"');
		}else{
			$this->central->where('calldate BETWEEN "'.date("Y-m-d").' 00:00:01" AND "'.date("Y-m-d").' 23:59:59"');
		}
		
		$this->central->order_by('calldate DESC');
		$query = $this->central->get('cdr');
		
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return array();
		}

		$this->central->close();

	}

	function invertir_fecha($date)
	{

		$fecha_ini = explode("/",$date);
		$fecha_ini = array_reverse($fecha_ini);
		$fecha_ini = implode("-", $fecha_ini);

		return $fecha_ini;
	}

	function reportecall($obj){
		$this->load->model('mod_clientes');
		$this->load->model('mod_telefonia');
		$this->db->where('IDPERFIL', 2);
		$query = $this->db->get('core_usuarios');
		$row = $query->result_array();
		$datos = array();
		
		
		foreach($row  as $us)
		{
			array_push($datos, array(
				"usuario"=>$us, 
				"llamadas"=>$this->llamadas(array("inicio"=>@$obj['inicio'],"termino"=>@$obj['termino'],"anexo"=>$us['ANEXO']))
				));
			
		}

		return $datos;
	}

	function reporte_cotizacion($obj){
		$this->db->where('idvendedor', $obj['vendedor']);
		
		if(isset($obj['inicio']) && !empty($obj['inicio']) && isset($obj['termino']) && !empty($obj['termino']))
		{
			$this->db->where('fecha BETWEEN "'.$obj['inicio'].' 00:00:01" AND "'.$obj['termino'].' 23:59:59"');
		}else{
			$this->db->where("fecha BETWEEN '".date("Y-m-d")." 00:00:01' AND '".date("Y-m-d")." 24:59:59'");	
		}

		$query = $this->db->get('cotizacion_general');
		
		return $query->result_array();
	}

	function categorias_productos_oportunidades($obj){
		$this->db->select('nombre, id');
		$this->db->where('parent', 0);
		$query = $this->db->get('core_categorias_productos');
		$row = $query->result_array();
		$data = array();
		foreach($row as $r){
			$datos = array("idcategoria"=>$r['id'], "desde"=>$obj['desde'], "hasta"=>$obj['hasta']);
			array_push($data, array("categoria"=>$r, "detalle"=>$this->detalle_oportunidades($datos)));
		}

		return $data;

	}

	function detalle_oportunidades($obj){

		$this->db->where('categoria', $obj['idcategoria']);
		$this->db->where('id !=', 10000058);
		if(isset($obj['desde']) && !empty($obj['desde']) && isset($obj['hasta']) && !empty($obj['hasta']))
		{
			$this->db->where('fecha_cotizacion BETWEEN "'.$obj['desde'].' 00:00:01" AND "'.$obj['hasta'].' 23:59:59"');
		}else{
			$this->db->where("fecha_cotizacion BETWEEN '".date("Y")."-".date("m")."-01 00:00:01' AND '".date("Y")."-".date("m")."-31 24:59:59'");	
		}
		$this->db->order_by('fecha_cotizacion DESC, producto, vendedor ');
		$query = $this->db->get('vista_oportunidades_productos');

		return $query->result_array();
	}

	
} ?>
