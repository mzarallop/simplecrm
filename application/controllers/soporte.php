<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Soporte extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function index()
	{
		$this->usuarios->verificar_login();
		$this->load->model('Mod_soporte');
		$this->load->library('lib_soporte');
		$datos['usuario'] = $this->usuarios->datos_usuarios();
			$datos['css'] = array("bootstrap.min.css", 
									"clientes/clientes.css", "prettify.css",
									"theme.bootstrap.css", "jquery.tablesorter.pager.css"
									,"datepicker.css","bootstrap-glyphicons.css", "general.css");
			$datos['js'] = array("jquery.js", "bootstrap.js",
								"bootstrap.min.js", "bootstrap-tab.js", 
								"bootstrap-collapse.js", 
								"bootstrap-modal.js","bootbox.min.js",
								"docs.js", "prettify.js", "clientes/table_sorter.js",
								"jquery.tablesorter.js", "jquery.tablesorter.widgets.js",
								"jquery.tablesorter.pager.js",
								"soporte/soporte.js", 
								"bootstrap-datepicker.js", "usabilidad.js");

			$datos['title'] = 'Módulo de soprote';
			$datos['menu'] = $this->lib_menu->menu_usuarios();
			$datos['colegios'] = $this->lib_soporte->colegios();
			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('soporte/inicio', $datos);
			$this->load->view('fijos/footer', $datos);
	}

	function datos()
	{
			$file = "http://data.mineduc.cl/data.svc/Establecimiento_Rendimiento(agno='2006',rbd=1234)";
			$xmp = simplexml_load_file($file);
			echo '<pre>';
			$demo = new SimpleXMLElement($xmp->content);
			print_r($demo);
			echo '</pre>';
	}

	function ajax()
	{
		$this->load->model('mod_soporte');

			$inicio_tabla ='<table class="table table-condensed table-bordered>"';
			$fin_tabla ='</table>';
			$div = '';
		switch ($_POST['caso']) {
			case '1':
				$resultado = $this->mod_soporte->ver_alumnos($_POST);
				foreach($resultado as $result){
				
					$div.='<tr>';
					$div.='<td>'.$result['id'].'</td>';
					$div.='<td>'.$result['nombre'].'</td>';
					$div.='<td>'.$result['usuario'].'</td>';
					$div.='<td>'.$result['email'].'</td>';
					$div.='</tr>';
				
				}
				
				echo $inicio_tabla.$div.$fin_tabla;	
				break;
			case '3':
				$resultado = $this->mod_soporte->ver_pruebas($_POST);
				foreach($resultado as $result){
				
					$div.='<tr>';
					$div.='<td>'.date("y/m/d", $result['fecha_creacion']).'</td>';
					$div.='<td>'.$result['nombre'].'</td>';
					$div.='<td>'.$result['duracion'].'</td>';
					$div.='</tr>';
				
				}
				
				echo $inicio_tabla.$div.$fin_tabla;	
				break;	
			default:
				# code...
				break;
		}
		


	}
}
?>