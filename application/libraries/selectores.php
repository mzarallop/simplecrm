<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');
	
	class Selectores
	{
		function clientes_region()
		{
			$CI = get_instance();

			$query = $CI->db->query("call sp_selectores('', 'regiones_clientes')");
			return $query->result_array();
		}

		function clientes_comuna($id)
		{
			$CI = get_instance();

			$query = $CI->db->query("call sp_selectores('$id', 'comunas_clientes')");
			return $query->result_array();
		}

		function clientes_dependencia($id)
		{
			$CI = get_instance();
			$query = $CI->db->query("call sp_selectores('$id', 'dependencia_clientes')");
			return $query->result_array();
		}

		function clientes_clasificacion($id)
		{
			$CI = get_instance();
			$query = $CI->db->query("SELECT IDCLASIFICACION, CLASIFICACION, COUNT(RBD) as total FROM core_clientes_sep
									WHERE COMUNA = '".$id['comuna']."' and ID_DEPENDENCIA = '".$id['id']."'
									GROUP BY IDCLASIFICACION ORDER BY IDCLASIFICACION");
			return $query->result_array();


		}

		function clientes_area($param)
		{
			$CI = get_instance();
			$query = $CI->db->query("SELECT AREA, COUNT(RBD) as total 
									FROM core_clientes_sep
									WHERE COMUNA = '".$param['comuna']."' 
									AND ID_DEPENDENCIA = '".$param['dependencia']."'
									AND IDCLASIFICACION = '".$param['id']."'
									GROUP BY AREA ORDER BY AREA");
			return $query->result_array();
		}

		function sel_vendedores()
		{
			$CI = get_instance();
			$query = $CI->db->query("SELECT CU.*, (SELECT count(idrbd) FROM core_clientes_asignaciones WHERE idusuario =
									CU.id) as total
									FROM core_usuarios CU  WHERE PRIVILEGIO = 'USR_VENDEDOR'");
			return $query->result_array();
		}
	}

?>