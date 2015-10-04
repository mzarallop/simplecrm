<?php
class calendar Extends CI_Controller{

	function __construct(){
		parent::__construct();
		$prefs = array (
               'start_day'    => 'monday',
               'month_type'   => 'long',
               'day_type'     => 'large'
             );
		$this->load->library('calendar', $prefs);
		$this->load->helper('directory');
	}

	function index(){
		$data = array(
               3  => 'http://example.com/news/article/2006/03/',
               7  => 'muchooaaaa',
               13 => 'http://example.com/news/article/2006/13/',
               26 => 'http://example.com/news/article/2006/26/'
             );

		echo $this->calendar->generate(date("Y"), date("m"), $data);
		$map = directory_map('./');
		echo '<pre>';
		echo json_encode($map);
		echo '</pre>';
	}
}