<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facturas extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('mod_facturas');
		$this->load->model('Mod_clientes');
	}

	function index(){
		$this->usuarios->verificar_login();

		$datos['usuario'] = $this->usuarios->datos_usuarios();
		$datos['css'] = array("clientes/clientes.css");
		$datos['js'] = array("clientes/clientes.js", "facturas/facturas.js");
		$datos['title'] = 'Módulo de Gestiones';
		$datos['productos']  = $this->mod_facturas->productos_opt();
		$datos['menu'] = $this->lib_menu->menu_usuarios($datos['title']);
		$datos['coordinador'] = $this->mod_facturas->ejecutivos(2);
		$datos['vendedor'] = $this->mod_facturas->ejecutivos(3);

		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('clientes/facturas', $datos);
		$this->load->view('fijos/footer');
	}

	function contratos(){
		$idcotizacion = $this->uri->segment(3);
		$this->load->library('pdf');
		$this->load->library('plantillas');

        //print_r($cot);

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
            $pdf->WriteHTML($this->plantillas->contrato_renovacion(), true, 0, true, 0);
            $pdf->AddPage();
            $pdf->WriteHTML($this->plantillas->termino_contrato(), true, 0, true, 0);
            $pdf->lastPage();
        // ---------------------------------------------------------
        // Cerrar el documento PDF y preparamos la salida
        // Este método tiene varias opciones, consulte la documentación para más información.
           $nombre_archivo = utf8_decode("contrato.pdf");
           $pdf->Output($nombre_archivo, 'I');
	}
	function ajax(){
		switch($_POST['case']){
			case 1:
				$r = $this->mod_facturas->buscar_datos($_POST);
				echo json_encode($r);
			break;
			case 2:
				$r = $this->mod_facturas->buscar_datos($_POST);
				echo json_encode($r);
			break;
			default:
			break;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */