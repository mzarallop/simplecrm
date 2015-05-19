<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

	class mod_cotizaciones extends CI_Model
	{

		function datos_colegio($rbd){
			$this->db->where('RBD', $rbd);
			$query_a = $this->db->get('core_clientes');
			$row_clientes = $query_a->result_array();
			if($query_a->num_rows()>0)
				{
					return $row_clientes[0];}
			else{
				$this->db->select('NOMBRE NOMBRES, RBD, REGION CALLE, COMUNA, DEPENDENCIA AUX1');
				$this->db->where('RBD', $rbd);
				$query_b = $this->db->get('core_clientes_sep');
				$row_sep = $query_b->result_array();
				if($query_b->num_rows()>0){
					return $row_sep[0];
				}else{
					$this->db->select('NOMBRE NOMBRES, RBD, REGION CALLE, COMUNA, DEPENDENCIA AUX1');
					$this->db->like('RUT', $rbd);
					$query_c = $this->db->get('core_clientes_sep');
					$row_rut = $query_c->result_array();
					if($query_c->num_rows()>0)
					{
						return $row_rut[0];
					}else{
						return array("estado"=>false);
					}
				}
			}
		}

		function categorias($parent){

			$categorias = array();
			$this->db->select('id, nombre, hash_tag');
			$this->db->where('parent', $parent);
			$query = $this->db->get('core_categorias_productos');
			$row = $query->result_array();
			foreach($row as $pr){

				array_push($categorias, array("categoria"=>$pr, "productos"=>$this->traer_productos($pr['id'])));
			}
			return $categorias;
		}

		function traer_productos($categoria){
			$this->db->select('id, nombre, hash_tag, color, descripcion, precio');
			$this->db->where('parent', $categoria);
			$query = $this->db->get('core_categorias_productos');
			$row = $query->result_array();
			if($query->num_rows() >0)
			{
				return $row;
			}else{
				return array();
			}
		}

		function producto($id){
			$this->db->where('id', $id);
			$query = $this->db->get('core_categorias_productos');
			$row = $query->result_array();
			return $row[0];
		}

		function buscar_productos($id){
			$this->db->select('id, nombre, hash_tag');
			$this->db->like('nombre', $id);
			$this->db->where('parent !=', 0);
			$query = $this->db->get('core_categorias_productos');
			$row = $query->result_array();
			return $row;
		}

		function crear_cotizacion($param){

			$usuario = $this->usuarios->datos_usuarios();
			$datos = array("rbd"=>$param['rbd'],
							"idvendedor"=>$usuario[0]['ID'],
							"contacto"=>$param['contacto'],
							"colegio"=>$param['colegio'],
							"direccion"=>$param['direccion'],
							"telefono"=>$param['telefono'],
							"dependencia"=>"'".$param['dependencia']."'",
							"neto"=>$param['neto'],
							"iva"=>$param['iva'],
							"total"=>$param['total_iva'],
							"modalidad_pago"=>$param['modo_pago'],
							"observaciones"=>$param['observaciones'],
							"porcentaje_cierre"=>$param['probabilidad']
							);

			$estado = @$this->db->insert('cotizacion_general', $datos);
			$cotizacion = $this->db->insert_id();

			if($estado){
				$this->crear_cotizacion_detalle($param,$cotizacion);
				return $cotizacion;
			}else{
				return 0;
			}
		}

		function crear_cotizacion_detalle($param, $cotizacion){

			$total = count($param['productos']);
			for($i=0;$i<$total;$i++){
				$datos = array("idcotizacion"=>$cotizacion,
								"idproducto"=>$param['productos'][$i],
								"unidades"=>$param['unidades'][$i],
								"descripcion"=>$param['descripciones'][$i],
								"neto"=>$param['netos'][$i],
								"afecto_iva"=>$param['afecto'][$i]
								);
				@$this->db->insert('cotizacion_detalle', $datos);
			}
		}

		function borrar_cotizacion($clave){
			$this->db->where('id', $clave);
			if($this->db->delete('cotizacion_general'))
			{
				$this->db->where('id', $clave);
				if($this->db->delete('cotizacion_detalle')){
					return true;
				}
				else{
					return false;
				}
			}else{
				return false;
			}
		}

		function banco_cotizaciones($perfil, $userid){
			
			$this->db->select('cg.*, cu.NOM_EJECUTIVO ejecutivo');
			$this->db->from('cotizacion_general cg');
			$this->db->where('cg.estado',1);
			$this->db->join('core_usuarios cu ', 'cg.idvendedor = cu.ID');
			if($perfil == 2){
				$this->db->where('cg.idvendedor', $userid);
			}else{}
			$query = $this->db->get();
			$row = $query->result_array();
			return $row;
		}

		function mostrar_cotizacion($clave){

			$this->db->select('cg.*, cu.NOM_EJECUTIVO ejecutivo');
			$this->db->from('cotizacion_general cg');
			$this->db->join('core_usuarios cu ', 'cg.idvendedor = cu.ID');
			$this->db->where('cg.id', $clave);
			$cotizacion = $this->db->get();
			$row_cot = $cotizacion->result_array();
			$encontrado = $cotizacion->num_rows();
			if($encontrado>0){
				if($cotizacion){
					$this->db->select('cd.*, ccp.nombre, ccp.descripcion descripcion_b');
					$this->db->from('cotizacion_detalle cd');
					$this->db->join('core_categorias_productos ccp', 'cd.idproducto = ccp.id', 'left');
					$this->db->where('idcotizacion', $clave);
					$this->db->order_by('cd.neto DESC');
					$detalle = $this->db->get();
					$row_det = $detalle->result_array();
					if($detalle){
							//buscar sostenedor
							$this->db->where('RBD', $row_cot[0]['rbd']);
							$query = $this->db->get('core_clientes_sep');
							$row_sostenedor = $query->result_array();
							if($query->num_rows()>0)
							{
								return array("col"=>$row_cot[0], "detalle"=>$row_det, "sostenedor"=>$row_sostenedor[0]);
							}else{
								return array("col"=>$row_cot[0], "detalle"=>$row_det);
							}

					}else{
						return array();
					}
				}else{
					return array();
				}
			}else{
				return array();
			}
		}

		function agregar_producto($param){
			$datos = array("nombre"=>$param['nombre'], "precio"=>$param['precio'], "descripcion"=>$param['descripcion'], "parent"=>$param['parent']);
			$this->db->insert('core_categorias_productos', $datos);
			$id = $this->db->insert_id();
			$producto = $this->prodcuto($id);
			return $producto;
		}

		function reporte_cotizacion($param){

			if($param['vendedor']>0){
				$this->db->where('ID', $param['vendedor']);
			}else{}
			$query = $this->db->get('core_usuarios');
			$row = $query->result_array();
			$datos = array();

			foreach($row as $r){
				array_push($datos, array("vendedor"=>$r, "detalle"=>$this->traer_detalle_cotizaciones($r['ID'], $param)));
			}

			return $datos;
		}

		function traer_detalle_cotizaciones($usuario, $param){
			$this->db->select('cg.*, cu.NOM_EJECUTIVO nombre_vendedor');
			$this->db->from('cotizacion_general cg');
			$this->db->join('core_usuarios cu', 'cg.idvendedor = cu.id');
			$this->db->where('cg.idvendedor', $usuario);
			$this->db->where('cg.estado', $param['estado']);
			$this->db->where('cg.fecha between "'.$param['desde'].'" AND "'.$param['hasta'].'"');
			$this->db->order_by('cg.fecha desc');
			$query = $this->db->get();
			return $query->result_array();
		}

		function mostrar_vendedores(){
			//$this->db->where('IDPERFIL', 2);
			$this->db->where('visible', 1);
			$query = $this->db->get('core_usuarios');
			return $query->result_array();
		}

		function modo_pago(){
			$query = $this->db->get('cotizacion_pago');
			return $query->result_array();
		}

		function estado_cotizacion(){
			$query = $this->db->get('cotizacion_estado');
			return $query->result_array();
		}

		function eliminar_cotizacion($param){
			$this->db->where('id', $param['cotizacion']);
			if($this->db->delete('cotizacion_general')){
				$this->db->where('idcotizacion', $param['cotizacion']);
				if($this->db->delete('cotizacion_detalle')){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		function aprobar_cotizacion($obj){
			//10 = aprobada
			$update = array("estado"=>10);
			$this->db->where('id', $obj['cotizacion']);
			$estado = $this->db->update('cotizacion_general', $update);
			$us = $this->usuarios->usuario_completo();
			$aprobadas = $this->banco_cotizaciones_aprobadas($us['IDPERFIL'], $us['ID']);
			if($estado){

				return array("estado"=>true, "aprobadas"=>$aprobadas);
			}else{
				return array("estado"=>false, "aprobadas"=>$aprobadas);
			}
		}

		function banco_cotizaciones_aprobadas($obj){

				$us = $this->usuarios->usuario_completo();

				if($us['IDPERFIL'] == 2){
					$us = $this->usuarios->usuario_completo();
					$this->db->where('cg.idvendedor', $us['ID']);
				}elseif($us['IDPERFIL'] == 1){

					//$this->db->where('cg.idvendedor', $obj['id']);
				}else{

				}

			$this->db->select('cg.*, cu.NOM_EJECUTIVO ejecutivo');
			$this->db->where('cg.estado', 10);
			$this->db->from('cotizacion_general cg');
			$this->db->join('core_usuarios cu ', 'cg.idvendedor = cu.ID');
			$query = $this->db->get();
			$row = $query->result_array();
			return $row;
		}

		function traer_cotizacion($obj){

			$this->db->where('id', $obj['cotizacion']);
			$query_general = $this->db->get('cotizacion_general');
			$row_general = $query_general->result_array();
			//----------------------------------------------__>
			$this->db->select('cd.*, ccp.nombre');
			$this->db->where('cd.idcotizacion', $obj['cotizacion']);
			$this->db->from('cotizacion_detalle cd');
			$this->db->join('core_categorias_productos ccp', 'cd.idproducto = ccp.id');
			$query_detalle = $this->db->get();
			$row_detalle = $query_detalle->result_array();

			$data = array("cotizacion"=>$row_general[0], "detalle"=>$row_detalle);

			return $data;
		}

		function actualizar_cotizacion($param){
			$usuario = $this->usuarios->datos_usuarios();
			$datos = array("rbd"=>$param['rbd'],
							"idvendedor"=>$usuario[0]['ID'],
							"contacto"=>$param['contacto'],
							"colegio"=>$param['colegio'],
							"direccion"=>$param['direccion'],
							"telefono"=>$param['telefono'],
							"dependencia"=>"'".$param['dependencia']."'",
							"neto"=>$param['neto'],
							"iva"=>$param['iva'],
							"total"=>$param['total_iva'],
							"modalidad_pago"=>$param['modo_pago'],
							"observaciones"=>$param['observaciones'],
							"porcentaje_cierre"=>$param['probabilidad']
							);

			$this->db->where('id', $param['idcotizacion']);
			$estado = @$this->db->update('cotizacion_general', $datos);
			$cotizacion = $param['idcotizacion'];

			if($estado){
				$this->up_cotizacion_detalle($param,$cotizacion);
				return $cotizacion;
			}else{
				return 0;
			}
		}

		function up_cotizacion_detalle($param, $cotizacion){
			$total = count($param['productos']);
			if($total>0){

				$this->db->where('idcotizacion', $cotizacion);
				$q = $this->db->delete('cotizacion_detalle');

				if($q){
					
					for($i=0;$i<$total;$i++){
						$datos = array("idcotizacion"=>$cotizacion,
										"idproducto"=>$param['productos'][$i],
										"unidades"=>$param['unidades'][$i],
										"descripcion"=>$param['descripciones'][$i],
										"neto"=>$param['netos'][$i],
										"afecto_iva"=>$param['afecto'][$i]
										);
						@$this->db->insert('cotizacion_detalle', $datos);
					}
				}

			}
		}
	}
	
?>