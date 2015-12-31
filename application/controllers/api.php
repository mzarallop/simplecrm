<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('mod_api');
		header('Access-Control-Allow-Origin:*');
		header('Content-Type: application/json');
	}

	function index(){
		$r = $this->mod_api->contacto($_POST);
		echo json_encode($r);
	}

	function listarcupones(){
		$r = $this->mod_api->listarcupones();
		echo json_encode($r);
	}
}