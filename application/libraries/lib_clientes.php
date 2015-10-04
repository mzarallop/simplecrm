<?php 
class lib_clientes {

	function ultima_gestion($rbd)
	{
		$CI = get_instance();
		$query = $CI->db->query("select * from core_cliente_gestiones WHERE RBD = '".$rbd."'");
		$row = $query->result_array();

		return $row[0];

	}

	function mis_gestiones()
	{
		$ci = get_instance();
		$ci->load->library('table');
		$ci->load->model('mod_clientes');
		$tmpl = array ( 'table_open'  => '<table class="table table-striped table-condensed table-bordered">' );
		$ci->table->set_heading('Comunas', 'Colegios', 'Alumnos SEP', 'Gestiones');
		$ci->table->set_template($tmpl);
		$datos = $ci->mod_clientes->mostrar_cartera_usuario();
		return $ci->table->generate($datos);
	}

	function devuelve_dia($fecha)
	{
		$datos = array("inicio"=>strtotime($fecha.' 00:00'), "termino"=>strtotime($fecha.' 23:59'));
		return $datos;
	}

	function datos_colegios($rbd)
	{
		$colegio = new SimpleXMLElemnt("http://data.mineduc.cl/data.svc/Establecimiento_Matricula(agno='".date('Y')."',rbd='".$rbd."')");
		return $colegio;
	}


}
?>