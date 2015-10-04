<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web extends CI_Controller {

	public function index()
	{
		$this->usuarios->verificar_login();

		$this->load->model('Mod_web');

			$datos['css'] = array("bootstrap.min.css", 
									"clientes/clientes.css", "prettify.css",
									"theme.bootstrap.css", "jquery.tablesorter.pager.css"
									,"datepicker.css");
			$datos['js'] = array("jquery.js", "bootstrap.js",
								"bootstrap.min.js", "bootstrap-tab.js", 
								"bootstrap-collapse.js", 
								"bootstrap-modal.js","bootbox.min.js",
								"docs.js", "prettify.js", "clientes/table_sorter.js",
								"jquery.tablesorter.js", "jquery.tablesorter.widgets.js",
								"jquery.tablesorter.pager.js",
								"bootstrap-datepicker.js","usabilidad.js");

			$datos['title'] = 'Módulo de cupones web';
			$datos['mi_cartera'] = $this->Mod_web->mensajes_web();
			$datos['menu'] = $this->lib_menu->menu_usuarios();
			$datos['regiones'] = $this->selectores->clientes_region();
			
			$this->load->database();
			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('web/contacto', $datos);
			$this->load->view('fijos/footer');
	}

}
?>