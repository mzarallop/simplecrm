<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

	class Mod_telefonia extends CI_Model
	{
		function __construct(){
			
			parent::__construct();
			$this->central = $this->load->database('asterisk', TRUE);

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
			$this->central->select('*, SEC_TO_TIME(duration) tiempo, ');
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

	}

?>