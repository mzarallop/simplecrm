<?php 

if(isset($_POST['anexo'])&&$_POST['anexo']>0){

$inicio = $_POST['inicio'];
$termino = $_POST['termino'];
$anexo = $_POST['anexo'];

$query = "select * from cdr where src='".$anexo."' AND calldate between '".$inicio."' and '".$termino."'  order by calldate";

$c = mysql_connect('localhost', 'root', '2015');
mysql_select_db('asteriskcdrdb');
$q = mysql_query($query) or die(mysql_error());

$data = array();
while ($r = mysql_fetch_array($q, MYSQL_ASSOC)) {
	array_push($data, $r);
}

echo json_encode($data);

}else{
	echo json_encode(array("error"=>'No se recibieron los parametros adecuados', "datos"=>$_POST));
}