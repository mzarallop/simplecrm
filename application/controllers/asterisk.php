<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asterisk extends CI_Controller {

	function ajax(){

		$this->load->model('mod_telefonia');
		
		switch(@$_POST['case']){
			
			case 1:
				$r = $this->mod_telefonia->llamadas(array("inicio"=>date("Y-m-d"), "termino"=>date("Y-m-d")));
				echo json_encode($r);
			break;

		}
	}
}

?>