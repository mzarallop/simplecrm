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
			$datos['js'] = array("jquery.js","bootstrap.js", "bootstrap.min.js", "bootstrap-tab.js",
							"gestion/gestion.js", "moneda.min.js", "gestion/llamadas.js", "highcharts.js", "exporting.js", "funnel.js");
			$datos['title'] = 'Gestión';
			$datos['menu'] = $this->lib_menu->menu_usuarios();

			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('gestion/index', $datos);
			$this->load->view('fijos/footer', $datos);
	}

	function resumen_gestion(){
		$this->load->library('table');
		$this->usuarios->verificar_login();
		$datos['css'] = array("bootstrap.css", "bootstrap.min.css");
		$datos['js'] = array("jquery.js","bootstrap.js", "bootstrap.min.js", "bootstrap-tab.js",
						"gestion/gestion.js", "moneda.min.js", "highcharts.js", "exporting.js", "funnel.js");
		$datos['title'] = 'Reporte Gestión';
		$datos['menu'] = $this->lib_menu->menu_usuarios();
		$datos['reporte'] = $this->mod_gestion->reporte_gestiones(2);
		$this->load->view('fijos/head', $datos);
		$this->load->view('fijos/menu', $datos);
		$this->load->view('gestion/reporte_gestion', $datos);
		$this->load->view('fijos/footer', $datos);

	}

	public function carteras()
	{
			$this->usuarios->verificar_login();
			$datos['css'] = array("bootstrap.css", "bootstrap.min.css");
			$datos['js'] = array("jquery.js","bootstrap.js", "bootstrap.min.js", "bootstrap-tab.js",
							"gestion/gestion.js", "moneda.min.js", "gestion/llamadas.js", "highcharts.js", "exporting.js", "funnel.js");
			$datos['title'] = 'Carteras Ventas';
			$datos['menu'] = $this->lib_menu->menu_usuarios();
			$this->load->database();
			$this->load->view('fijos/head', $datos);
			$this->load->view('fijos/menu', $datos);
			$this->load->view('gestion/carteras', $datos);
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
			$this->usuarios->verificar_login();
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
					           array_push($vector, array("rbd"=>$data[0], "usuario"=>$data[1]));
					        }
					    } while ($data = fgetcsv($handle,1000,",","'"));


						$r = $this->mod_gestion->crear_asignacion($vector, $_POST['forma_carga']);
						echo $r;
						echo '<pre>';
						print_r($vector);
						echo '</pre>';
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

	function reporte(){

		$this->load->library('pdf');
		$this->load->library('plantillas');
		//$tabla = urldecode($_POST['tabla']);

		$smthing = ($_POST['tabla']);

		$smthing = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($smthing));
		$smthing = html_entity_decode($smthing,null,'UTF-8');
		$html_final = '<h1>Resumen de gestión</h1><table width="100%" style="font-size:10px;border:1px solid gray;">'.$smthing.'</table>';
		$html_final = str_replace('background-color:rgba(255, 255, 0, 0.54)', 'background-color:yellow;border-bottom:0.1px solid gray;', $html_final);
		#background-color:rgba(255, 0, 0, 0.37)
		$html_final = str_replace('background-color:rgba(255, 0, 0, 0.37)', 'background-color:red;border-bottom:0.1px solid gray;', $html_final);
		#background-color:rgba(4, 255, 4, 0.42)
		#background-color:rgba(255, 255, 0, 0.28);
		#background-color: rgb(126, 199, 142); - background-color:rgba(0, 128, 28, 0.31);
		#background-color:rgba(0, 196, 255, 0.17);
		$html_final = str_replace('background-color:rgba(0, 196, 255, 0.17);', 'border-bottom:0.1px solid gray;', $html_final);
		$html_final = str_replace('background-color:rgba(0, 128, 28, 0.31);', 'background-color: rgb(126, 199, 142);border-bottom:0.1px solid gray;', $html_final);
		$html_final = str_replace('background-color:rgba(4, 255, 4, 0.42)', 'background-color:green;border-bottom:0.1px solid gray;', $html_final);
		$html_final = str_replace('background-color:rgba(255, 255, 0, 0.28);', 'border-bottom:0.1px solid gray;', $html_final);
		$html_final = str_replace('<td>', '<td style="border-bottom:0.1px solid gray;border-right:1px solid gray;text-align:center;">', $html_final);
		$html_final = str_replace('<th>', '<th style="background-color: rgb(142, 141, 208);border-bottom:0.1px solid gray;border-right:1px solid gray;text-align:center;">', $html_final);
		//echo $html_final;



        ////////////////////////////////////
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Kdoce');
            $pdf->SetTitle('Cotizacion');
            $pdf->SetSubject('Sistema de cotizaciones');

            $pdf->SetKeywords('Cotizaciones kdoce');
            $titulo = 'Reporte';
            $titulo_string = 'Reporte';
        // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
                //$pdf->SetHeaderData('logo_masterclass_impresion.png', PDF_HEADER_LOGO_WIDTH, $titulo, $titulo_string, array(0, 64, 255), array(0, 64, 128));
        $pdf->SetHeaderData(base_url().'img/logo_kdoce.png', 25, '', '', array(0, 64, 255), array(0, 64, 128));
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
            $pdf->setPageOrientation('L');
            $pdf->AddPage('L');
            $pdf->WriteHTML($html_final, true, 0, true, 0);
            $pdf->lastPage();
            $vendedores = @$this->mod_gestion->reporte_gestiones(2);
            //echo '<pre>';print_r($vendedores);echo '</pre>';
            foreach($vendedores as $vend){
            	//$pdf->setPageOrientation('P');
            	$pdf->AddPage('P');
            	$r = $this->plantillas->tmp_reporte_vendedor($vend);

	            $pdf->WriteHTML('<h1>'.$vend['resumen']['nombre_vendedor'].'</h1>'.$r, true, 0, true, 0);
	            $pdf->lastPage();
            }
        // ---------------------------------------------------------
        // Cerrar el documento PDF y preparamos la salida
        // Este método tiene varias opciones, consulte la documentación para más información.
           $nombre_archivo = utf8_decode("Reporte_ventas_kdoce_soluciones_educativas.pdf");
           $pdf->Output($nombre_archivo, 'I');
	}

	function ajax(){
		$post = @$_POST;
		switch($post['case']){
			case 1:
				$r = @$this->mod_gestion->reporte_gestion($_POST);
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
			case 5:
				$r = $this->mod_gestion->volcar_colegios($_POST);
				echo json_encode($r);
				//print_r($_POST);
			break;
			case 6:
				$r = $this->mod_gestion->volcar_colegios($_POST);
				echo json_encode($r);
				//print_r($_POST);
			break;
			case 7:
				$r = $this->mod_gestion->volcar_colegios($_POST);
				echo json_encode($r);
				//print_r($_POST);
			break;
			case 8:
				$r = @$this->mod_gestion->reporte_gestionesb();
				echo json_encode($r);
			break;
		}
	}
}

/* End of file gestion.php */
/* Location: ./application/controllers/gestion.php */