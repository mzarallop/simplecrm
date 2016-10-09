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
		$datos['js'] = array("marketing/marketing.js", "moneda.min.js");
		$datos['title'] = 'Marketing';
		$datos['segmento'] = $this->mod_marketing->lista_segmentos();
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

	function ajax(){
		switch($_POST['case']){
			case 1:
				
				$q = $this->mod_marketing->lista_regiones_colegios($_POST['data']);
				echo json_encode($q);
			break;
			case 2:
				
				$q = $this->mod_marketing->lista_comunas_colegios($_POST['data']['segmento'], $_POST['data']['region']);
				echo json_encode($q);
			break;
			case 3:
				
				$q = $this->mod_marketing->filtrarColegios($_POST['data']);
				echo json_encode($q);
			break;
		}
	}

}