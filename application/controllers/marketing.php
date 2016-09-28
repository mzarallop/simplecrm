<?php 

class marketing extends CI_controller{

	function __construct(){
		parent::__construct();
		$this->load->model('mod_marketing');
	}

	function index(){

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