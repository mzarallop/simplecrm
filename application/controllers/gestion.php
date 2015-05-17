<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gestion extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('mod_gestion');
	}

	public function index()
	{
			$this->usuarios->verificar_login();
			$datos['css'] = array("bootstrap.css", "bootstrap.min.css");
			$datos['js'] = array("jquery.js","bootstrap.js", "bootstrap.min.js", "bootstrap-tab.js", "gestion/gestion.js", "moneda.min.js");
			$datos['title'] = 'Gestión';
			$datos['menu'] = $this->lib_menu->menu_usuarios();
			$this->load->database();
			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('gestion/index', $datos);
			$this->load->view('fijos/footer', $datos);
	}
	
	function usuarios(){
			
			$this->usuarios->verificar_login();
			$datos['css'] = array("bootstrap.css", "bootstrap.min.css");
			$datos['js'] = array("jquery.js","bootstrap.js", "bootstrap.min.js", "bootstrap-tab.js", 
							"gestion/gestion.js", "moneda.min.js", "gestion/llamadas.js");
			$datos['title'] = 'Gestión';
			$datos['menu'] = $this->lib_menu->menu_usuarios();
			$datos['usuarios'] = $this->mod_gestion->traer_usuarios(array("id"=>0));
			$this->load->database();
			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('gestion/usuarios', $datos);
			$this->load->view('fijos/footer', $datos);

	}

	function carga_csv_asignacion(){
			
			$datos['css'] = array("bootstrap.css", "bootstrap.min.css");
			$datos['js'] = array("jquery.js","bootstrap.js", "bootstrap.min.js", "bootstrap-tab.js", "gestion/gestion.js", "moneda.min.js");
			$this->load->view('fijos/head', $datos);


			if(isset($_FILES['archivo'])){
				if(@$_FILES['archivo']['size']>0){
					$nombre = time().'.csv';
					$estado = copy($_FILES['archivo']['tmp_name'], './asignaciones/'.$nombre);
					
					if($estado){
						@$this->mod_gestion->cargar_asignacion(array("archivo"=>$nombre));
						$file = './asignaciones/'.$nombre;
						 
						 $handle = fopen($file,"r");
						 $vector = array();

						 do { 
					        if (@$data[0]) { 
					           array_push($vector, $data[0]);
					        } 
					    } while ($data = fgetcsv($handle,1000,",","'"));
						$datos = array("rbd"=>$vector, "usuario"=>$_POST['ejecutivo']);
						@$this->mod_gestion->crear_asignacion($datos);
					}else{

					}

				}else{
					echo '<div class="alert">';
	  				echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	  				echo '<strong>Advertencia!</strong> No se recibio ningun archivo CSV';
					echo '</div>';	
				}
			}
	}

	function ajax(){
		$post = @$_POST;
		switch($post['case']){
			case 1:
				$r = @$this->mod_gestion->reporte_gestion();
				echo json_encode($r);
			break;
			case 2:
				$r = @$this->mod_gestion->traer_usuarios($_POST);
				echo json_encode($r);
			break;
			case 3:
				$r = @$this->mod_gestion->update_usuarios($_POST);
				echo json_encode($r);
			break;
			case 4:
				$r = @$this->mod_gestion->agregar_usuarios($_POST);
				echo json_encode($r);
			break;
		}
	}
}

/* End of file gestion.php */
/* Location: ./application/controllers/gestion.php */