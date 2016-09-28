<?php 

class marketing extends CI_controller{

	function __construct(){
		parent::__construct();
		$this->load->model('mod_marketing');
	}

	function index(){
		$this->usuarios->verificar_login();
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("crm/crm.css");
		$datos['js'] = array("crm/crm.js", "moneda.min.js");
		$datos['title'] = 'Marketing';
		$datos['segmentos'] = $this->mod_marketing->lista_segmentos();
		$datos['menu'] = $this->lib_menu->menu_usuarios();

		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('marketing/index', $datos);
		$this->load->view('fijos/footer');

	}

	function carteras(){

	}

	function reporte(){

	}

	function camp(){

	}

	function rest(){
		switch($_POST){
			case 1:
			break;
		}
	}

}