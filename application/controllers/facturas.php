<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facturas extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('mod_facturas');
		$this->load->model('Mod_clientes');
	}

	function index(){
		$this->usuarios->verificar_login();

		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/clientes.js", "facturas/facturas.js");
		$datos['title'] = 'Módulo de Gestiones';
		$datos['productos']  = $this->mod_facturas->productos_opt();
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$datos['coordinador'] = $this->mod_facturas->ejecutivos(2);
		$datos['vendedor'] = $this->mod_facturas->ejecutivos(3);

		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/facturas', $datos);
		$this->load->view('fijos/footer');
	}
	function ajax(){
		switch($_POST['case']){
			case 1:
				$r = $this->mod_facturas->buscar_datos($_POST);
				echo json_encode($r);
			break;
			case 2:
				$r = $this->mod_facturas->buscar_datos($_POST);
				echo json_encode($r);
			break;
			default:
			break;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */