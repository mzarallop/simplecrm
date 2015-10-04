<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bodega extends CI_Controller {


	public function index()
	{
		$this->usuarios->verificar_login();
		$this->load->model('mod_bodega');

			$datos['css'] = array("bootstrap.css", "bootstrap.min.css","bodega/bodega.css");
			$datos['js'] = array("jquery.js","bootstrap.js", "bootstrap.min.js", "bootstrap-tab.js", "bodega/control.js");
			$datos['title'] = 'Logistica y ditribución';
			$datos['ingresos'] = $this->mod_bodega->ultimos_ingresos();
			$datos['productos'] = $this->mod_bodega->productos();

			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('bodega/inicio', $datos);
			$this->load->view('fijos/footer');
	}

	public function ajax()
	{
		$this->usuarios->verificar_login();
		$this->load->model('mod_bodega');

		$caso = $_POST['caso'];
		switch($caso)
		{
			case 1://ingreso de producto a la bodega
			$this->mod_bodega->inserto_producto($_POST['codigo']);
			$ingresos = $this->mod_bodega->ultimos_ingresos();
			$div = '<table class="table table-condensed table-bordered">';
			$div.='<tr>';
			$div.='	<td>Código</td>';
			$div.='	<td>Descripción</td>';
			$div.='	<td>Proveedor</td>';
			$div.='	<td>Fabricante</td>';
			$div.='	<td>Unidades</td>';
			$div.='</tr>';
	      	foreach($ingresos as $i){
			$div.='<tr>';
				$div.='<td>'.$i['codigo'].'</td>';
				$div.='<td>'.$i['decripcion'].'</td>';
				$div.='<td>'.$i['proveedor'].'</td>';
				$div.='<td>'.$i['fabricante'].'</td>';
				$div.='<td>'.$i['cantidad'].'</td>';
			$div.='</tr>';
	      	}
	      $div.='</table>';

			break;
		}
		echo $div;
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */