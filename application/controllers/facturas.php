<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facturas extends CI_Controller {

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
			$datos['css'] = array("bootstrap.css", "bootstrap.min.css");
			$datos['js'] = array("jquery.js","bootstrap.js", "bootstrap.min.js", "bootstrap-tab.js");
			$datos['title'] = 'Gestión de Proyectos';

			$this->load->database();
			$this->load->view('fijos/head', $datos);
			$this->load->view('proyecto/index', $datos);
			$this->load->view('fijos/footer');
	}
	
	public function mensaje()
	{
		$this->usuarios->verificar_login();
		$this->load->view('mensaje');	
	}

	public function tareas()
	{
		$this->usuarios->verificar_login();
	}

	public function asignaciones()
	{
		$this->usuarios->verificar_login();
	}

	public function reportes()
	{
		$this->usuarios->verificar_login();
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */