<?php 
class lib_menu{
	
	function menu_usuarios()
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

				$div = '<div class="navbar">
						<div class="navbar-inner">
						 
						  <ul class="nav">';
	             
	        foreach($row as $r)
			{
				$div.='<li id="'.$r['idtag'].'"><a href="'.base_url().$r['path'].'">'.$r['nombre'].'</a></li>';
			}
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
