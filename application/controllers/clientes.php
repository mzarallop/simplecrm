<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends CI_Controller {

	public function index()
	{
		$this->usuarios->verificar_login();
		$idcartera = $this->uri->segment(3);
		$this->load->model('mod_crm');
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("clientes/clientes.css", "jquery.dataTables.css");
		$datos['js'] = array("clientes/crm.js", "moneda.min.js", "jquery.age.js",
							"jquery.dataTables.js", "highcharts.js", "exporting.js", "funnel.js");

		if($idcartera>0){
			$datos['title'] = 'Cartera Gestionada';
		}else{
			$datos['title'] = 'Cartera sin Gestión';
		}

		@$datos['mi_cartera'] = $this->mod_crm->mi_cartera(array(
			"tipo_colegio"=>'Particular Subvencionado',
			"gestion"=>$idcartera)
		);
		@$datos['mi_cartera_mu'] = $this->mod_crm->mi_cartera(array(
			"tipo_colegio"=>'Municipal',
			"gestion"=>$idcartera)
		);
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);

		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/misclientes', $datos);
		$this->load->view('fijos/footer');
	}

	function cobertura(){

		$this->usuarios->verificar_login();
		$this->load->model('mod_clientes');
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("clientes/clientes.css", "jquery.dataTables.css");
		$datos['js'] = array("clientes/crm.js","clientes/cobertura.js", "moneda.min.js", "jquery.age.js",
							"jquery.dataTables.js", "highcharts.js", "exporting.js", "funnel.js");
		$datos['title'] = 'Cobertura';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);

		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/cobertura', $datos);
		$this->load->view('fijos/footer');

	}

	function marketing(){
		$this->usuarios->verificar_login();
		$this->load->model('mod_crm');
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("clientes/clientes.css", "jquery.dataTables.css");
		$datos['js'] = array("clientes/crm.js", "moneda.min.js", "jquery.age.js",
							"jquery.dataTables.js", "highcharts.js", "exporting.js", "funnel.js");
		$datos['title'] = 'Mis Asignaciones';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);

		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/marketing', $datos);
		$this->load->view('fijos/footer');
	}

	public function reporteventas()
	{
		$this->usuarios->verificar_login();
		$this->load->model('mod_crm');
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("clientes/clientes.css", "jquery.dataTables.css");
		$datos['js'] = array("clientes/crm.js", "moneda.min.js", "jquery.age.js",
							"jquery.dataTables.js", "highcharts.js", "exporting.js", "funnel.js");
		$datos['title'] = 'Reporte de ventas';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);

		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/reporteventas', $datos);
		$this->load->view('fijos/footer');
	}

	public function facturas(){
		$this->usuarios->verificar_login();
		$this->load->model('Mod_clientes');
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("clientes/clientes.css");
			$datos['js'] = array("clientes/clientes.js");
			$datos['title'] = 'Módulo de Gestiones';

			$datos['facturas']  = $this->Mod_clientes->mostrar_facturas();
			$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
			$datos['regiones'] = $this->selectores->clientes_region();



			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('clientes/facturas', $datos);
			$this->load->view('fijos/footer');
	}

	function gestion_master(){
			$this->usuarios->verificar_login();
			$this->load->model('Mod_clientes');
			$this->load->model('mod_master');
			$datos['colegios'] = $this->mod_master->colegios();
			$datos['usuario'] = $this->usuarios->datos_usuarios();
			$datos['css'] = array("clientes/clientes.css");
			$datos['js'] = array("clientes/master.js");
			$datos['title'] = 'Gestión de masterclass';
			$datos['mi_cartera'] = $this->Mod_clientes->mi_cartera();
			$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
			$datos['regiones'] = $this->selectores->clientes_region();


			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('clientes/master', $datos);
			$this->load->view('fijos/footer');
	}


	public function asignaciones()
	{
		$this->usuarios->verificar_login();
		$datos['usuario'] = $this->usuarios->datos_usuarios();
			$datos['css'] = array("clientes/clientes.css");
			$datos['js'] = array("clientes/clientes.js");
			$datos['title'] = 'Módulo de Gestiones';
			$datos['vendedores'] = $this->selectores->sel_vendedores();
			$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
			$datos['regiones'] = $this->selectores->clientes_region();

			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('clientes/index', $datos);
			$this->load->view('fijos/footer');
	}

	public function asignacion()
	{
		$this->usuarios->verificar_login();
		$datos['usuario'] = $this->usuarios->datos_usuarios();
			$datos['css'] = array("clientes/clientes.css");
			$datos['js'] = array("clientes/clientes.js");
			$datos['title'] = 'Gestión de clientes';
			$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
			$datos['regiones'] = $this->selectores->clientes_region();

			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('clientes/index', $datos);
			$this->load->view('fijos/footer');
	}

	public function ficha()
	{
		$this->usuarios->verificar_login();
			$datos['usuario'] = $this->usuarios->datos_usuarios();
			$datos['css'] = array();
			$datos['js'] = array();
			$datos['title'] = 'Ficha del Cliente';
			$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);

			$this->load->view('fijos/head', $datos);
			$this->load->view('clientes/ficha', $datos);
			$this->load->view('fijos/footer');
	}

	function cotizacion(){

		$datos['rbd'] = $this->uri->segment(3);
		$datos['idcotizacion'] = $this->uri->segment(4);
		//$this->usuarios->verificar_login();
		$this->load->model('Mod_clientes');
		$this->load->model('mod_cotizaciones');

		$datos['productos'] = $this->mod_cotizaciones->categorias(0);
		$datos['colegio'] = $this->mod_cotizaciones->datos_colegio($datos['rbd']);
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['pago'] = $this->mod_cotizaciones->modo_pago();
		$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/clientes.js", "clientes/tmp_productos.js");
		$datos['title'] = 'Módulo de cotizaciones';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/cotizacion', $datos);
		$this->load->view('fijos/footer');
	}

	function upcotizacion(){

		$datos['idcotizacion'] = $this->uri->segment(3);
		//$this->usuarios->verificar_login();
		$this->load->model('Mod_clientes');
		$this->load->model('mod_cotizaciones');

		if(isset($datos['idcotizacion'])&&$datos['idcotizacion']>0){
			$datos['cot'] = $this->mod_cotizaciones->traer_cotizacion(array("cotizacion"=>$datos['idcotizacion']));
		}

		$datos['productos'] = $this->mod_cotizaciones->categorias(0);
		$datos['colegio'] = $this->mod_cotizaciones->datos_colegio($datos['cot']['cotizacion']['rbd']);
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['pago'] = $this->mod_cotizaciones->modo_pago();
		$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/clientes.js", "clientes/tmp_productos.js");
		$datos['title'] = 'Módulo de cotizaciones';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/upcotizacion', $datos);
		$this->load->view('fijos/footer');
	}


	function buscar_colegios(){
		$this->usuarios->verificar_login();
		$this->load->model('Mod_clientes');
		$this->load->model('mod_cotizaciones');
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['cotizaciones'] = @$this->mod_cotizaciones->banco_cotizaciones(2, $datos['usuario'][0]['ID']);
		$perfil = $this->usuarios->usuario_completo();
				$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/clientes.js", "clientes/tmp_productos.js", "clientes/ejecutivos.js");
		$datos['title'] = 'Banco de colegios';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/buscarcolegios', $datos);
		$this->load->view('fijos/footer');
	}

	function oportunidades(){

		$this->usuarios->verificar_login();
		$this->load->model('Mod_clientes');
		$this->load->model('mod_cotizaciones');
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['cotizaciones'] = @$this->mod_cotizaciones->banco_cotizaciones(2, $datos['usuario'][0]['ID']);
		$perfil = $this->usuarios->usuario_completo();
				$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/oportunidades.js", "clientes/tmp_productos.js");
		$datos['title'] = 'Oportunidades';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/oportunidades', $datos);
		$this->load->view('fijos/footer');

	}

	function reporte_gestion(){
		$this->usuarios->verificar_login();
		$this->load->model('Mod_clientes');
		$this->load->model('mod_cotizaciones');
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['cotizaciones'] = @$this->mod_cotizaciones->banco_cotizaciones(2, $datos['usuario'][0]['ID']);
		$perfil = $this->usuarios->usuario_completo();
				$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/clientes.js", "usabilidad.js", "clientes/tmp_productos.js", "clientes/reporte_gestion.js");
		$datos['title'] = 'Reporte de gestión';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/gestion', $datos);
		$this->load->view('fijos/footer');
	}


	function productos(){
		$this->usuarios->verificar_login();
		$this->load->model('Mod_clientes');
		$this->load->model('mod_cotizaciones');
		$datos['categorias'] = @$this->mod_cotizaciones->categorias(0);
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/clientes.js", "clientes/tmp_productos.js");
		$datos['title'] = 'Selecciona el colegio';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/productos', $datos);
		$this->load->view('fijos/footer');
	}

	function banco_cotizaciones(){

		$this->usuarios->verificar_login();
		$this->load->model('Mod_clientes');
		$this->load->model('mod_cotizaciones');
		$perfil = $this->usuarios->usuario_completo();
		$datos['cotizaciones'] = @$this->mod_cotizaciones->banco_cotizaciones($perfil['IDPERFIL'], $perfil['ID']);
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/clientes.js", "clientes/tmp_productos.js");
		$datos['title'] = 'Banco de cotizaciones';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/bacocotizacion', $datos);
		$this->load->view('fijos/footer');
	}

	function reporte_cotizaciones(){

		$this->usuarios->verificar_login();
		$this->load->model('Mod_clientes');
		$this->load->model('mod_cotizaciones');
		$perfil = $this->usuarios->usuario_completo();
		$datos['cotizaciones'] = @$this->mod_cotizaciones->banco_cotizaciones($perfil['IDPERFIL'], $perfil['ID']);
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['vendedores'] = $this->mod_cotizaciones->mostrar_vendedores();
		$datos['estados']= $this->mod_cotizaciones->estado_cotizacion();
		$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/clientes.js", "clientes/tmp_productos.js");
		$datos['title'] = 'Reporte de cotizaciones';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/reportes', $datos);
		$this->load->view('fijos/footer');
	}

	function bancoclientes(){
		$this->usuarios->verificar_login();
		$this->load->model('Mod_clientes');
		$this->load->model('mod_cotizaciones');
		$this->load->model('modfacturas');
		$perfil = $this->usuarios->usuario_completo();
		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['clientes'] = $this->modfacturas->recuperar_clientes();
		$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/clientes.js", "clientes/tmp_productos.js");
		$datos['title'] = 'Clientes';
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/clientes', $datos);
		$this->load->view('fijos/footer');
	}

	function cotizacion_pdf(){
		$idcotizacion = $this->uri->segment(3);
		$this->load->library('pdf');
		$this->load->library('plantillas');
        $this->load->model('mod_cotizaciones');
        $cot = $this->mod_cotizaciones->mostrar_cotizacion($idcotizacion);
        $codigo = $cot['col']['id'];
        //print_r($cot);
        $html_cotizacion = $this->plantillas->tmp_cotizacion($cot);
        $html_cotizacion_final = $this->plantillas->tmp_final_cotizacion($cot);

        ////////////////////////////////////
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Kdoce');
            $pdf->SetTitle('Cotizacion');
            $pdf->SetSubject('Sistema de cotizaciones');
            $pdf->setPageOrientation('P');
            $pdf->SetKeywords('Cotizaciones kdoce');
            $titulo = 'Cotizacion N';
            $titulo_string = 'Cotizacion';
        // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
                //$pdf->SetHeaderData('logo_masterclass_impresion.png', PDF_HEADER_LOGO_WIDTH, $titulo, $titulo_string, array(0, 64, 255), array(0, 64, 128));
                $pdf->SetHeaderData('logo_kdoce.png', 25, '', '', array(0, 64, 255), array(0, 64, 128));
                $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
        // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
                $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT, 5);
                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // se pueden modificar en el archivo tcpdf_config.php de libraries/config
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //relación utilizada para ajustar la conversión de los píxeles
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                $pdf->setPrintHeader(false); //no imprime la cabecera ni la linea
				$pdf->setPrintFooter(true); //no imprime el pie ni la linea

        // ---------------------------------------------------------
        // establecer el modo de fuente por defecto
                $pdf->setFontSubsetting(true);

       		//COTIZACION PDF
            $pdf->AddPage();
            $pdf->WriteHTML($html_cotizacion, true, 0, true, 0);
            $pdf->AddPage();
            $pdf->WriteHTML($html_cotizacion_final, true, 0, true, 0);
            $pdf->lastPage();
        // ---------------------------------------------------------
        // Cerrar el documento PDF y preparamos la salida
        // Este método tiene varias opciones, consulte la documentación para más información.
           $nombre_archivo = utf8_decode("cotizacion_".$codigo."_kdoce_soluciones_educativas.pdf");
           $pdf->Output($nombre_archivo, 'I');

	}

	public function ajax()
	{
		$this->usuarios->verificar_login();
		$this->load->model('mod_clientes');
		$this->load->library('lib_clientes');
		//$this->load->model('mod_reportes');
		$this->load->library('table');
		$this->load->model('mod_cotizaciones');
		$this->load->model('mod_crm');
		//$this->load->model('mod_master');
		//$this->load->model('modfacturas');

		switch(@$_POST['case'])
		{
			case 1://comunas clientes
				$com = $this->selectores->clientes_comuna($_POST['id']);
					$div = '<option>--</option>';
				foreach($com as $co){
					$div.= '<option value="'.$co['COMUNA'].'">'.$co['COMUNA'].' ('.$co['total'].')</option>';
				}
				echo $div;
			break;
			case 2:// lista de clientes para asignacion
				$clientes = $this->mod_clientes->mostrar_clientes($_POST);

					$tabla = '<table class="table table-bordered table-condensed table-striped">';
					foreach($clientes as $cliente)
					{
						$tabla.='<tr id="cliente_'.$cliente['RBD'].'">';
						$tabla.='<td><input type="checkbox" name="foo" class="lista_clientes" value="'.$cliente['RBD'].'" id="chk_cliente" name="chk_cliente" /></td>';
						$tabla.='<td>'.$cliente['RBD'].'</td>';
						$tabla.='<td>'.$cliente['NOMBRE'].'</td>';
						$tabla.='<td>'.$cliente['COMUNA'].'</td>';
						$tabla.='<td>'.$cliente['DEPENDENCIA'].'</td>';
						$tabla.='<td>'.$cliente['ALUMNOS_SEP'].'</td>';
						$tabla.='<td>'.$cliente['CLASIFICACION'].'</td>';
						$tabla.='<td>'.$this->mod_clientes->vendedor_asociado($cliente['RBD']).'</td>';
						//$tabla.='<td>'.$cliente['EMAIL'].'</td>';
						$tabla.='<td></td>';
						$tabla.='</tr>';
					}
						$tabla.='</table>';
					echo $tabla;
			break;

			case 3: //dependencia clientes

				$com = $this->selectores->clientes_dependencia($_POST['id']);
					$div = '<option>--</option>';
				foreach($com as $co){
					$div.= '<option value="'.$co['ID_DEPENDENCIA'].'">'.$co['DEPENDENCIA'].' ('.$co['total'].')</option>';
				}
				echo $div;
			break;
			case 4://option clasificacion
				$com = $this->selectores->clientes_clasificacion($_POST);
					$div = '<option>--</option>';
				foreach($com as $co){
					$div.= '<option value="'.$co['IDCLASIFICACION'].'">'.$co['CLASIFICACION'].' ('.$co['total'].')</option>';
				}
				echo $div;
			break;
			case 5://ficha del cliente -> encabezado
				// TABLA DE ARRIBA
				$cliente = $this->mod_clientes->datos_cliente($_POST['rbd']);
				$bd = $this->mod_clientes->datos_antiguos($_POST['rbd']);
				$div ='<table class="table table-mini table-condensed table-bordered table-striped">';
	     		$div.='<tr>';
	     		$div.='<td>Nombre:</td>';
	     		$div.='<td><b>'.$cliente['NOMBRE'].'</b></td>';
	     		$div.='<td>Dirección:</td>';
	     		$div.='<td>'.$bd['CALLE'].'</td>';
	     		$div.='</tr>';
	     		$div.='<tr>';
	     		$div.='<td>Comuna:</td>';
	     		$div.='<td>'.$cliente['COMUNA'].'</td>';
	     		$div.='<td>Teléfono:</td>';
	     		$div.='<td>'.$bd['TELEFONO'].'</td>';
	     		$div.='</tr>';
	     		$div.='<tr>';
	     		$div.='<td>Email:</td>';
	     		$div.='<td>'.$bd['EMAIL'].'</td>';
	     		$div.='<td>Dependencia:</td>';
	     		$div.='<td>'.$cliente['DEPENDENCIA'].'</td>';
	     		$div.='</tr>';
	     		$div.='<tr>';
	     		$div.='<td>Alumnos SEP:</td>';
	     		$div.='<td>'.$cliente['ALUMNOS_SEP'].'</td>';
	     		$div.='<td>Monto:</td>';
	     		$div.='<td>$'.NUMBER_FORMAT(($cliente['ALUMNOS_SEP']*33000),0).'</td>';
	     		$div.='</tr>';
	     		$div.='<tr>';
	     		$div.='<td>Rut sostenedor:</td>';
	     		$div.='<td>'.$cliente['RUT'].'</td>';
	     		$div.='<td>Sostenedor:</td>';
	     		$div.='<td>'.$cliente['SOSTENEDOR'].'</td>';
	     		$div.='</tr>';
	     		$div.='<tr>';
	     		$div.='<td>Director:</td>';
	     		$div.='<td>'.$bd['AUX2'].'</td>';
	     		$div.='<td></td>';
	     		$div.='<td></td>';
	     		$div.='</tr>';
	     		$div.='</table>';
	     		$div.='<input type="hidden" id="ficha_rbd" value="'.$cliente['RBD'].'"/>';
	     		echo $div;
			break;
			case 8:// agregar un nuevo contacto al cliente
				$estado = $this->mod_clientes->add_contacto($_POST);
				echo json_encode($estado);
			break;
			case 9:// selector de rural o urbano
				$com = $this->selectores->clientes_area($_POST);
					$div = '<option>--</option>';
				foreach($com as $co){
					$div.= '<option value="'.$co['AREA'].'">'.$co['AREA'].' ('.$co['total'].')</option>';
				}
				echo $div;
			break;
			case 10: //realizar la asignacion
				$estado = $this->mod_clientes->crear_asignacion($_POST);
				echo json_encode($estado);
			break;
			case 11://crear gestion en el cliente
				$estado = $this->mod_clientes->add_gestion($_POST);
				echo json_encode($estado);
			break;
			case 13:
				$estado = $this->mod_clientes->borrar_gestion($_POST['id']);
				echo json_encode($estado);
			break;
			case 14: // muestra las gestiones del ejecutivo
				echo $this->lib_clientes->mis_gestiones();
			break;
			case 15:
				$estado = $this->mod_clientes->borrar_contactos_clientes($_POST['id']);
				echo json_encode($estado);
			break;
			case 16:


					$us = $this->session->userdata('acceso');
					$this->load->library('lib_reportes');
					$div = $this->lib_reportes->reporte_gestiones($_POST);
					/*
					//filtrado por vendedor
					$datos = array("inicio"=>$_POST['inicio'], "termino"=>$_POST['termino']);

					$registros = $this->mod_reportes->reporte_gestiones($datos);
					$total = count($registros);

					$uno = $registros;
					$dos = $registros;
					if($total > 0)
					{
						$div = '<table class="table table-striped table-bordered table-condensed">';
						$div.='<tr><thead>';
						$div.='<th>Código</th>';
						$div.='<th>Nombre ejecutivo</th>';
						$div.='<th>Total de gestiones</th>';
						$div.='<th>% del día</th>';
						$div.='</tr></thead>';
						$div.='<tbody>';
							foreach($uno as $r)
							{
								$total = $total + $r['TOTAL_GESTION'];
							}
							$t_porcentaje = 0;
							foreach($uno as $reg)
							{
								$div.='<tr>';
								$div.='<td>'.$reg['ID'].'</td>';
								$div.='<td>'.$reg['NOM_EJECUTIVO'].'</td>';
								$div.='<td>'.$reg['TOTAL_GESTION'].'</td>';
								if($reg['TOTAL_GESTION']>0){
									$porcentaje = number_format(($reg['TOTAL_GESTION']/$total*100),0);
									$t_porcentaje += $porcentaje;
								$div.='<th>'.$porcentaje.'%</th>';
								}
								else{
									$div.='<th>0 %</th>';
								}

								$div.='</tr>';
							}
							$div.='<tr>';
							$div.='<td colspan="2">Totales</td>';
							$div.='<td>'.number_format($total, 0).'</td>';
							$div.='<td></td>';
							$div.='</tr>';
						$div.='</tbody>';
						$div.='</table>';
					*/
						echo $div;



			break;
			case 17:

					$datos = array("inicio"=>$_POST['inicio'], "termino"=>$_POST['termino']);

					$registros = $this->mod_reportes->mi_agenda($datos);
					$total = count($registros['registros']);
					if($total > 0)
					{
						$tmpl = array ( 'table_open'  => '<table class="table table-striped table-bordered table-condensed">' );
						$this->table->set_heading('Creación', 'Observaciones', 'Fecha agenda', 'Hora');
						$this->table->set_template($tmpl);
						echo $this->table->generate($registros['registros']);
					}
					else
					{

					}
			break;
			case 18:

				$registros = $this->mod_reportes->mi_agenda_calendar($_POST);
					$total = count($registros['registros']);
					if($total > 0)
					{
						for($i = 0; $i<$total;$i++){

							$datos[$i] = array("title"=>$registros[$i]['nombre'], "start"=>$registros[$i]['FECHA_GESTION']);
						}
					}
					else
					{

					}

					echo json_encode($datos);
			break;
			case 19:
				$estado = $this->mod_clientes->editar_contactos_clientes($_POST);
				if ($estado)
					echo $_POST['rbd'];
				else
					echo 2;
				// echo json_encode($estado);
				// echo 1;
				break;
			case 20:
				// Mostrar gestiones completa
				$contacto = $this->mod_clientes->gestiones_cliente_completa($_POST['rbd'], $_POST['usuario']);
				$us = $this->session->userdata('acceso');
				$div ='<table class="table table-condensed table-bordered table-striped">';
	     		$div.='<thead>';
	     		$div.='<tr>';
	     		$div.='<th>Fecha</td>';
	     		$div.='<th>Gestión</td>';
	     		$div.='<th>Vendedor</td>';
	     		$div.='<th>Observaciones</td>';
	     		$div.='<th></th>';
	     		$div.='</tr>';
	     		$div.='</thead>';
	     		$div.='<tbody>';
	     		foreach($contacto as $con){
	     		$div.='<tr>';
	     		$div.='<td>'.date("d/m/Y",$con['FECHA_GESTION']).'</td>';
	     		$div.='<td>'.$con['gestion'].'</td>';
	     		$div.='<td>'.$con['NOM_EJECUTIVO'].'</td>';
	     		$div.='<td>'.$con['OBSERVACIONES'].'</td>';
				$div.='<td>
					<a href="javascript:;" title="Eliminar gestión" onclick="eliminar_gestion('.$con['ID_GESTION'].')">
						<i class="icon-trash"></i>
					</a></td>';
	     		$div.='</tr>';
	     		}
	     		$div.='</tbody>';
	     		$div.='</table>';

	     		echo $div;
				break;
			case 21:

				$r = @$this->mod_cotizaciones->producto($_POST['idproducto']);
				echo json_encode($r);
				//print_r($_POST);
			break;
			case 22://buscar_productos(

				$r = @$this->mod_cotizaciones->buscar_productos($_POST['texto']);
				echo json_encode($r);
			break;
			case 23:
				$r = @$this->mod_cotizaciones->crear_cotizacion($_POST);
				echo json_encode($r);
			break;
			case 24://borrar_cotizacion
				$r = @$this->mod_cotizaciones->borrar_cotizacion($_POST['id']);
				echo json_encode($r);
			break;
			case 25://buscar
				$r = @$this->mod_crm->buscar_colegio($_POST);
				echo json_encode($r);
			break;
			case 26://buscar
				$r = @$this->mod_cotizaciones->agregar_producto($_POST);
				echo json_encode($r);
			break;
			case 27://reporte
				$r = @$this->mod_cotizaciones->reporte_cotizacion($_POST);
				echo json_encode($r);
			break;
			case 28://eliminar cotizacion
				$r = @$this->mod_cotizaciones->eliminar_cotizacion($_POST);
				echo json_encode($r);
			break;
			case 29://master usuarios
				$r = @$this->mod_master->mostrar_usuarios($_POST['base']);
				echo json_encode($r);
			break;
			case 30://buscar facturas por rut
				$r = @$this->modfacturas->buscar_facturas($_POST);
				echo json_encode($r);
			break;
			case 31:
				$r = @$this->mod_clientes->agregar_colegio($_POST);
				echo json_encode($r);
			break;
			case 32:
			$r = @$this->mod_reportes->reportecall($_POST);
			echo json_encode($r);
			break;
			case 33:
			$r = @$this->mod_reportes->reporte_cotizacion($_POST);
			echo json_encode($r);
			break;
			case 34:
				$r = @$this->mod_cotizaciones->aprobar_cotizacion($_POST);
				echo json_encode($r);
			break;
			case 35:
				$r = @$this->mod_cotizaciones->banco_cotizaciones_aprobadas($_POST);
				echo json_encode($r);
			break;
			case 36:
				$r = @$this->mod_reportes->categorias_productos_oportunidades($_POST);
				echo json_encode($r);
			break;
			case 37:
				$r = @$this->mod_crm->ficha($_POST);
				echo json_encode($r);
			break;
			case 38:
				$r = @$this->mod_crm->proyectos_categorias();
				echo json_encode($r);
			break;
			case 39:
				$r = @$this->mod_crm->gestiones_tipo();
				echo json_encode($r);
			break;
			case 40://agregar gestion
				$r = @$this->mod_crm->crear_gestion($_POST);
				echo json_encode($r);
			break;
			case 41:
				$r = @$this->mod_crm->traer_gestiones($_POST);
				echo json_encode($r);
			break;
			case 42://pendientes
				$r = @$this->mod_crm->mis_pendientes($_POST);
				echo json_encode($r);
			break;
			case 43://reporte mi gestion
				$r = @$this->mod_crm->misgestiones();
				echo json_encode($r);
			break;
			case 44:
				$r = @$this->mod_crm->agregar_usuario_colegio($_POST);
				echo json_encode($r);
			break;
			case 45:
				$this->load->model('mod_asistencia');
				$r = @$this->mod_asistencia->inasistencias();
				echo json_encode($r);
			break;
			case 46://remover contacto
				$r  = @$this->mod_crm->remover_contacto($_POST);
				echo json_encode($r);
			break;
			case 47://remover contacto
				$r  = @$this->mod_crm->resumen_gestiones($_POST);
				echo json_encode($r);
			break;
			case 48:
				$r = @$this->mod_cotizaciones->actualizar_cotizacion($_POST);
				//$r = $_POST;
				echo json_encode($r);
			break;
			case 49:
				$r = @$this->mod_clientes->render_mapas($_POST);
				echo json_encode($r);
			break;
			case 50:
				$r = $this->mod_clientes->usuario_conectado();
				echo json_encode($r);
			break;
			case 50:
				$r = $this->mod_clientes->usuario_conectado();
				echo json_encode($r);
			break;
			default:
				$r = @$this->mod_clientes->render_mapas();
				echo json_encode($r);
			break;
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */