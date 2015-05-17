<?php
	class Usuarios {

		function login($param)
		{
			$ci = get_instance();

			$usuario = $this->verificar_datos($param);

			if($usuario[0]['ID']>0)
			{
				if($ci->session->set_userdata('acceso', $usuario[0]))
				{
					return true;
					//$this->firmar($usuario['ID'], 'Entrar', date("d/m/Y"), time());
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}

		}

		function verificar_datos($param)
		{
			$ci = get_instance();

			$sql = "select ID, IDEMPRESA, IDPERFIL from core_usuarios where LOGIN = '".$param['user']."' 
					and PASSWORD = '".$param['pass']."'";

				$query = $ci->db->query($sql);
				$row = $query->result_array();

				return $row;
				$ci->db->close();
		}

		function cerrar_session()
		{
			session_start();
			$ci = get_instance();
			$usuario = $ci->session->userdata('acceso');
			
			//$this->firmar($usuario['ID'], 'salir', date("d/m/Y"), time());

			$ci->session->unset_userdata('acceso');
			session_destroy();
		}

		function datos_usuarios()
		{
			$ci = get_instance();
			$us = $ci->session->userdata('acceso');

			$query = $ci->db->query("Select * from core_usuarios where ID = '".$us['ID']."'");
			$row = $query->result_array();
			$ci->db->close();
			if($query->num_rows>0){
				return $row;
			}
			else{
				return array("NOM_USUARIO"=> 'Desconocido');
			}

		}

		function usuario_completo()
		{
			$ci = get_instance();
			$us = $ci->session->userdata('acceso');

			$query = $ci->db->query("Select * from core_usuarios where ID = '".$us['ID']."'");
			$row = $query->result_array();
			$ci->db->close();
			if($query->num_rows>0){
				return $row[0];
			}
			else{
				return array("NOM_USUARIO"=> 'Desconocido');
			}

		}

		function firmar($usuario, $accion, $fecha, $unix)
		{
			$ci = get_instance();
			$datos = array(
				"usuario"=>$usuario,
				"accion"=>$accion, 
				"fecha"=>$fecha,
				"unix"=>$unix
				);

			$ci->db->insert('core_logs', $datos);
		}

		function verificar_login()
		{
			$ci = get_instance();

			if($ci->session->userdata('acceso'))
			{  }else{ redirect(base_url().'accesos');}
		}

		function segmentos($obj){
			$color='';
			switch($obj){
				case 1:	$color='#A9F5F2'; break;
				case 2:	$color='#2E2EFE'; break;
				case 3:	$color='#FE9A2E'; break;
				case 4:	$color='#FF0000'; break;
			}
			return $color;
		}
	}
 ?>