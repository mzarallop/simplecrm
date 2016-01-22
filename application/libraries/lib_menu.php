<?php
class lib_menu{

	function menu_usuarios($titulo = 'CRM')
		{
			$ci = get_instance();
			$usuario = $ci->session->userdata('acceso');

			/*if($usuario['IDPERFIL'] == 2){

			$sql = "SELECT cmp.idmodulo, m.*
					FROM core_menu_perfil as cmp join core_menu as m ON
					cmp.idmodulo = m.id WHERE idperfil = '".$usuario['IDPERFIL']."' order by m.orden";
				}
			if($usuario['IDPERFIL'] == 2){

			$sql = "SELECT cmp.idmodulo, m.*
					FROM core_menu_perfil as cmp join core_menu as m ON
					cmp.idmodulo = m.id WHERE idperfil = '".$usuario['IDPERFIL']."' order by m.orden";
				}
			elseif($usuario['IDPERFIL']== 3)
			{
				$sql = "SELECT cmp.idmodulo, m.*
					FROM core_menu_perfil as cmp join core_menu as m ON
					cmp.idmodulo = m.id WHERE idperfil in (2,3) order by m.orden";
			}
			else{*/

			$sql = "SELECT cmp.idmodulo, m.*
					FROM core_menu_perfil as cmp join core_menu as m ON
					cmp.idmodulo = m.id WHERE idperfil = 2 order by m.orden";
			//}
			$query = $ci->db->query($sql);
			$row = $query->result_array();

				$div = '<div class="navbar navbar-inverse navbar-fixed-top">
						<div class="navbar-inner" style="padding-left: 10px;padding-right: 10px;">
						<a href="'.base_url().'" class="brand">'.$titulo.'</a>
						  <ul class="nav">';

	        foreach($row as $r)
			{
				if($r['nombre']=='Cartera'){
					$div.='<li id="cartera" class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">'.$r['nombre'].' <b class="caret"></b></a>
					 <ul class="dropdown-menu">
						<li>
							<a href="'.base_url().'clientes/index/1">Cartera Gestionada</a>
							<a href="'.base_url().'clientes/index/0">Cartera Sin Gestión</a>
							<a href="'.base_url().'clientes/cobertura/13/2">Cobertura Terreno</a>
							<a href="javascript:mis_pendientes()">Tareas</a>
							<a href="javascript:mis_cotizaciones()">Cotizaciones</a>
							<a href="javascript:traer_cartera_gestion()">Resumen</a>
						</li>
  					</ul>
					</li>';
					//'.base_url().$r['path'].'

				}elseif($r['nombre']=='Reportes'){
					$div.='<li id="reportes" class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown">'.$r['nombre'].' <b class="caret"></b></a>
					 <ul class="dropdown-menu">
						<li>
							<a href="'.base_url().$r['path'].'">Reporte General</a>
							<a href="'.base_url().'gestion/resumen_gestion">Reporte mensual gestión</a>
							<a href="'.base_url().'gestion/usuarios/">Gestion Usuarios</a>
						</li>
  					</ul>
					</li>';
				}
				else{

				}
			}
				$div.='<li id="reportes" class="dropdown">
				<a href="" class="dropdown-toggle" data-toggle="dropdown">Facturas <b class="caret"></b></a>
					 <ul class="dropdown-menu">
						<li>
							<a href="'.base_url().'facturas/">Factura de Venta</a>
							<a href="'.base_url().'clientes/factura_compra">Factura de compras</a>
							<a href="'.base_url().'clientes/reporte">Reportes</a>
						</li>
  					</ul>
					</li>';
				$div.='<li id="Salir"><a href="http://localhost/crmkdoce/accesos/logout/#salir">Salir del sistema</a></li>';
				$div.='</ul>';

				$div.='<div class="navbar-form pull-right">
						  <input type="text" id="finder" name="finder" class="span2" placeholder="RBD o Nombre">
						  <button  class="btn" onclick="buscar_colegio();"><i class="icon-search"></i>Buscar</button>
						</div>';
				$div.='</div></div>';
			return $div;

			$ci->db->close();
		}

}
 ?>
