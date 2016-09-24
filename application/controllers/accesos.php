<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accesos extends CI_Controller {

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
			$datos['usuario'] = $this->usuarios->datos_usuarios();
			$datos['empresa'] = $this->usuarios->empresa();
			$datos['css'] = array("bootstrap.css", "bootstrap.min.css","general.css");
			$datos['js'] = array("jquery.js","bootstrap.js", "bootstrap.min.js", "bootstrap-tab.js", "usabilidad.js", "accesos/login.js");
			$datos['title'] = 'CRM | '.$datos['empresa']['razon_social'];

			$this->load->database();
			$this->load->view('fijos/head', $datos);
			$this->load->view('accesos/index', $datos);
			$this->load->view('fijos/footer_loggin',$datos);
	}

	public function login()
	{
		$datos = $_POST;
		if(@$_POST['accion']== 'logear')
		{
			$this->usuarios->login($datos);

			if($this->session->userdata('acceso'))
			{
				//redirect(base_url().'clientes');
				echo  json_encode(true);
			}
			else
			{
				//redirect(base_url().'accesos/?estado=0');
				echo json_encode(false);
			}
		}
		else
		{

		}
	}

	public function logout()
	{

		$this->usuarios->cerrar_session();
		redirect(base_url());
	}

	function ajax(){
		$case = @$_POST['case'];
		switch($case){
			case 1:
				$r = $this->usuarios->usuario_completo();
				echo json_encode($r);
			break;
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */