<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class crm extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('mod_crm');
	}

	function index(){
		$this->usuarios->verificar_login();
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("crm/crm.css");
		$datos['js'] = array("crm/crm.js", "moneda.min.js");
		$datos['title'] = 'CRM';
		@$datos['mi_cartera'] = $this->mod_crm->mi_cartera();
		$datos['menu'] = $this->lib_menu->menu_usuarios();

		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/crm', $datos);
		$this->load->view('fijos/footer');
	}

	



	function ajax(){
		switch(@$_POST['case']){
			case 1:
				$r = $this->mod_crm->traer_regiones();
				echo json_encode($r);
			break;
			case 2:
				$r = @$this->mod_crm->detalle_region($_POST);
				echo json_encode($r);
			break;
			case 3:
				$r = @$this->mod_crm->cartera_por_gestiones();
				echo json_encode($r);
			break;
			case 4:
				$r = @$this->mod_crm->traer_cotizaciones();
				echo json_encode($r);
			break;
			case 5:
				$r = @$this->mod_crm->traer_personal();
				echo json_encode($r);
			break;
			case 6:
				$r = @$this->mod_crm->actualizar_colegio($_POST);
				echo json_encode($r);
			break;
			case 7://reporte ejecutivos	
				$r = @$this->mod_crm->reporte_ejecutivos($_POST);
				echo json_encode($r);
			break;
			case 8://buscar colegio
				$r = @$this->mod_crm->buscar_colegio($_POST);
				echo json_encode($r);
			break;
		}
	}
}

?>