<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mod_bodega extends CI_Model
{
	public function datos_producto($param)
	{
		$query = $this->db->query("select * from bodega_productos where codigo = '".$param['codigo']."'");
		$row = $query->result_array();

		return $row;
	}

	public function inserto_producto($codigo)
	{

		$vec = array("codigo"=>$codigo, "mes"=>date("m"), "estado"=>1, "year"=>date('Y'));
		if($this->db->insert('bodega_inventario', $vec))
			{return true;}
			else
				{return false;}
	}

	public function ultimos_ingresos()
	{
		$data = $this->db->query("SELECT BP.*, count(BI.codigo) as cantidad FROM bodega_inventario BI INNER JOIN bodega_productos BP ON BI.codigo = BP.codigo WHERE mes = '".date('m')."' GROUP BY BP.codigo limit 10");
		return $row = $data->result_array();

	}

	public function productos()
	{
		$data = $this->db->query("SELECT * FROM bodega_productos ORDER BY decripcion");
		return $row = $data->result_array();
	}

}
?>