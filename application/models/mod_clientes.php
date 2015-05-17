<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

	class Mod_clientes extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function mostrar_clientes($param)
		{
			if($param['tipo']=='region')
			{
				$query = $this->db->query("select * from core_clientes_sep where
											ID_REGION = '".$param['id']."'
											ORDER BY COMUNA, DEPENDENCIA, ALUMNOS_SEP DESC");
			}
			elseif($param['tipo']=='comuna')
			{
				$query = $this->db->query("select * from core_clientes_sep where
											COMUNA = '".$param['id']."'
											ORDER BY COMUNA, DEPENDENCIA, ALUMNOS_SEP DESC");
			}
			elseif($param['tipo']=='dependencia')
			{
				$query = $this->db->query("select * from core_clientes_sep where COMUNA = '".$param['comuna']."'
											AND ID_DEPENDENCIA = '".$param['id']."'
											ORDER BY COMUNA, DEPENDENCIA, ALUMNOS_SEP DESC");
			}
			elseif($param['tipo']=='clasificacion')
			{
				$query = $this->db->query("select * from core_clientes_sep where
											COMUNA = '".$param['comuna']."'
											AND ID_DEPENDENCIA = '".$param['dependencia']."'
											AND IDCLASIFICACION = '".$param['id']."'
											ORDER BY COMUNA, DEPENDENCIA, ALUMNOS_SEP DESC");
			}
			elseif($param['tipo']='vendedor')
			{
				$query = $this->db->query("SELECT CCS.* FROM core_clientes_sep CCS
											WHERE CCS.RBD in
											(SELECT CCA.idrbd FROM core_clientes_asignaciones CCA WHERE CCA.idusuario = '".$param['id']."')
											ORDER BY COMUNA, DEPENDENCIA, ALUMNOS_SEP DESC");

			}


			if(isset($query))
			{

			return $query->result_array();
			}
		}

		function mi_cartera()
		{
			$usuario = $this->usuarios->datos_usuarios();
			// se cambio los VAV.* , CCG.* por los sgt select.
			$query = $this->db->query("SELECT * FROM `core_cartera_asignada` WHERE `idusuario` ='".$usuario[0]['ID']."'");
			return $query->result_array();

		}

		function corporaciones()
		{
			$query = $this->db->query("SELECT * FROM vista_corporaciones
										WHERE ID_DEPENDENCIA in (1,3) ORDER BY ID_REGION, ID_DEPENDENCIA DESC, ALUMNOS_SEP DESC");
			return $query->result_array();
		}

		function gestiones_cliente($rbd, $usuario)
		{
			$us = $this->session->userdata('acceso');
			$query = $this->db->query("SELECT
										CCG.*,
										CU.NOM_EJECUTIVO
										FROM core_cliente_gestiones CCG LEFT JOIN core_usuarios CU
										ON CCG.EJECURIVO = CU.ID
										WHERE CCG.RBD = '$rbd' ORDER BY CCG.ID_GESTION DESC limit 5");
			return $query->result_array();
		}

		function gestiones_cliente_completa($rbd, $usuario)
		{
			$us = $this->session->userdata('acceso');
			$sql = "SELECT CCG.*, CU.NOM_EJECUTIVO
				FROM core_cliente_gestiones CCG LEFT JOIN core_usuarios CU
				ON CCG.EJECURIVO = CU.ID
				WHERE CCG.RBD = '$rbd'
				ORDER BY CCG.FECHA_GESTION
				DESC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}

		function datos_cliente($rbd)
		{
			$query = $this->db->query("SELECT * FROM core_clientes_sep WHERE RBD = '".$rbd."'");
			$row = $query->result_array();
			return $row[0];
		}

		function datos_antiguos($rbd)
		{
			$query = $this->db->query("SELECT * FROM core_clientes WHERE RBD = '".$rbd."'");
			$row = $query->result_array();
			return $row[0];
		}

		function contactos_cliente($rbd)
		{
					$query = $this->db->query("select *  from core_cliente_contacto WHERE RBD ='".$rbd."'");
					$row = $query->result_array();
					return $row;

		}

		function add_contacto($param){
			$datos = array("NOMBRE"=>$param['nombre'], "CARGO"=>$param['cargo'],
						"TELEFONO"=>$param['telefono'], "EMAIL"=>$param['email'],
						"RBD"=>$param['rbd']);
			if($this->db->insert('core_cliente_contacto', $datos))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function crear_asignacion($param)
		{
			$rbd = explode(",", $param['rbds']);
			$total = count($rbd);
			$usuario = $this->session->userdata('acceso');
			$contador = 1;
			for($i = 0; $i<$total; $i++)
			{
				$datos = array("idusuario"=>$param['vendedor'],
						"idrbd"=>$rbd[$i],
						"idasignador"=>$usuario['ID']);
				if($this->db->insert('core_clientes_asignaciones', $datos))
				{
				$contador++;
				}
			}

			if($contador > 0)
			{
				return true;
			}
			else
			{
				return false;
			}

		}

		function add_gestion($param)
		{	$usuario = $this->session->userdata('acceso');
			$datos = array(
					"RBD"=>$param['rbd'],
					"COD_GESTION"=>$param['gestion'],
					"FECHA_GESTION"=>time(),
					"COD_EJECUTIVO"=>$usuario['ID'],
					"OBSERVACIONES"=>$param['msn'],
					"FECHA_AGENDAMIENTO"=>$param['fecha_agenda'],
					"HORA_AGENDAMIENTO"=>$param['hora_agenda']
					);
			if($this->db->insert('core_cliente_gestion', $datos))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function vendedor_asociado($rbd)
		{
			$query = $this->db->query("SELECT CCA.idusuario, CU.NOM_EJECUTIVO from core_clientes_asignaciones CCA JOIN core_usuarios CU
										ON CCA.idusuario = CU.ID
										WHERE CCA.idrbd ='".$rbd."'");
			$row = $query->result_array();
			if(count($row)>0)
			{

			return $row[0]['NOM_EJECUTIVO'];
			}
			else{
				return $row = '';
			}

		}

		function mostrar_cartera($clave)
		{
			$this->db->select('CC.COMUNA, CCA.idrbd rbd, CC.ALUMNOS_SEP alumnos_sep');
			$this->db->from('core_clientes_sep CC');
			$this->db->join('core_clientes_asignaciones CCA', 'CC.RBD = CCA.idrbd');
			$this->db->join('core_cliente_gestion CCG', 'CCG.RBD = CCA.idrbd', 'left');
			$this->db->where('CCA.idusuario', $clave['ID']);
			//$this->db->group_by('CC.COMUNA');
			$query = $this->db->get();
			return $query->result_array();
		}

		function mostrar_cartera_usuario()
		{
			$us = $this->session->userdata('acceso');
			$query = $this->db->query("SELECT CC.COMUNA,count(CCA.idrbd) as colegios,sum(CC.ALUMNOS_SEP) as alumnos_sep, count(CCG.rbd) as gestiones_colegios 										FROM core_clientes_sep CC JOIN core_clientes_asignaciones CCA
										ON CC.RBD = CCA.idrbd LEFT JOIN core_cliente_gestion CCG ON CCG.RBD = CCA.idrbd
										WHERE CCA.idusuario = '".$us['ID']."'
										GROUP BY CC.COMUNA");
			return $query->result_array();
		}

		function borrar_gestion($id)
		{
			if($this->db->delete('core_cliente_gestion', array("ID_GESTION"=>$id))){
				return true;
			}else{return false;}

		}

		function borrar_contactos_clientes($id)
		{
			if ($this->db->delete('core_cliente_contacto', array("ID" => $id)))
				return true;
			else
				return false;
		}

		function editar_contactos_clientes($post)
		{
			$query = "UPDATE core_cliente_contacto set
				NOMBRE = '" . $post['nombre'] ."',
				TELEFONO = '" . $post['telefono'] ."',
				EMAIL = '" . $post['email'] . "',
				CARGO = '" . $post['cargo']. "'
				WHERE ID = ". $post['id'];

			if ($this->db->query($query))
				return true;
			else
				return false;
		}

		function up_fechas($inicio, $fin)
		{
			$query = $this->db->query("select * FROM gestiones_copy WHERE ID_GESTION > $inicio AND ID_GESTION < $fin");
			$row = $query->result_array();

			$contador = 1;
			foreach($row as $r){

				$fecha_final = $this->revertir_fecha($r['FECHA_GESTION']);

				$datos = array("FECHA_GESTION"=>$fecha_final);
				$this->db->where(array("ID_GESTION"=>$r['ID_GESTION']));
				$this->db->update('gestiones_copy', $datos);
				$contador++;
			}

			return $contador;

		}

		function revertir_fecha($dato)
		{
			$date = $dato;
			$uno = explode(" ", $date);
			//print_r($uno);
			$dos = explode("-", $uno[0]);
			//print_r($dos);
			$tres = array_reverse($dos);
			//print_r($tres);
			$cuatro = implode("-", $tres);
			//print_r($cuatro);
			$cinco = $cuatro.' '.$uno[1];

				return $cinco;
		}

		function buscar_colegio($param)
		{
			/*$cadena1 = $param['finder'];
			$patron = "/^[[:digit:]]+$/";
			if (preg_match($patron, $cadena1)) {
			    $eval = 1;
			} else {
			    $eval = 0;
			}
			if($eval > 0)
			{
				$sql="SELECT * FROM core_clientes_sep WHERE RBD = '".$param['finder']."' ORDER BY COMUNA, NOMBRE";
			}
			else{
				$sql="SELECT * FROM core_clientes_sep WHERE NOMBRE like '%".$param['finder']."%' order by COMUNA, NOMBRE";
			}

			$query = $this->db->query($sql);
			return $query->result_array();*/
			$rbd = $param['finder'];
			if(is_int($rbd)){
				$this->db->where('RBD', $rbd);
			}else{
				$this->db->like('NOMBRES', $rbd);
			}
			$this->db->select('NOMBRES, NOMBRES NOMBRE,  RBD, CALLE, COMUNA, AUX1, AUX1 DEPENDENCIA, ALUM_SEP ALUMNOS_SEP');
			$query_a = $this->db->get('core_clientes');
			$row_clientes = $query_a->result_array();
			if($query_a->num_rows()>0)
				{
					return $row_clientes;}
			else{
				$this->db->select('NOMBRE NOMBRES, NOMBRE,  RBD, REGION CALLE, COMUNA, DEPENDENCIA AUX1, DEPENDENCIA, ALUMNOS_SEP, MATRICULA ');
				$this->db->where('RBD', $rbd);
				$query_b = $this->db->get('core_clientes_sep');
				$row_sep = $query_b->result_array();
				if($query_b->num_rows()>0){
					return $row_sep;
				}else{
					$this->db->select('ccs.NOMBRE NOMBRES, ccs.NOMBRE, ccs.RBD, ccs.REGION CALLE, ccs.COMUNA, ccs.DEPENDENCIA AUX1, ccs.DEPENDENCIA, ccs.ALUMNOS_SEP, ccs.MATRICULA ');
					$this->db->like('RUT', $rbd);
					$query_c = $this->db->get('core_clientes_sep ccs');
					$row_rut = $query_c->result_array();
					if($query_c->num_rows()>0)
					{
						return $row_rut;
					}else{
						return array("estado"=>false);
					}
				}
			}
		}

		function mostrar_agenda(){

			$agenda = array();
			$this->db->select('CCG.FECHA_GESTION start, CC.NOMBRES title');
			$this->db->from('core_cliente_gestion CCG');
			$this->db->join('core_clientes CC', 'CCG.RBD = CC.RBD');
			$this->db->limit('10');
			$this->db->order_by('CCG.ID_GESTION DESC');
			$query = $this->db->get();

			return $query->result_array();
		}

		function mostrar_facturas(){
			$this->db->order_by('idfactura DESC');
			$query = $this->db->get('factura_general');
			return $query->result_array();
		}

		function agregar_colegio($obj){
			$datos_colegio = array("RBD"=>$obj['rbd'], "NOMBRES"=>$obj['nombre_colegio'], "RAZON_SOCIAL"=>$obj['nombre_colegio'],
									"GIRO_COMERCIAL"=>'EDUCACION', "CALLE"=>$obj['direccion_colegio'], "TELEFONO"=>$obj['telefono_colegio'],
									"EMAIL"=>$obj['email_colegio'], "AUX2"=>$obj['nombre_contacto']);
			$colegio = $this->db->insert('core_clientes', $datos_colegio);
			if($colegio)
			{
				$idcolegio = $this->db->insert_id();
				$datos_contacto = array("id_CLIENTE"=>$idcolegio, "RBD"=>$obj['rbd'], "NOMBRE"=>$obj['nombre_contacto'],
									"CARGO"=>$obj["cargo_contacto"], "TELEFONO"=>$obj['telefono_contacto']);
				$this->db->insert('core_cliente_contacto', $datos_contacto);
			}

			return array("idcolegio"=>$idcolegio, "rbd"=>$obj['rbd'], "estado"=>$colegio);
		}

	}
?>