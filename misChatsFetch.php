<?

include "INCLUDES/obtenerMensajesChat.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $datos = json_decode(file_get_contents('php://input'), true);
	
	
	$listado=obtenerMensajesChat($datos['nChat']);
	
	//$datos=['mensaje']="prueba mensaje";
    //print_r($listado);
    // mandar header json
   	header('Content-Type: application/json; charset=utf-8');

	echo json_encode($listado);
	//echo json_encode(array("mensaje"=>$listado));
}



/*
include "INCLUDES/comprobarUsuario.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $datos = json_decode(file_get_contents('php://input'), true);
		$listado=comprobarUsuario($datos['nombre']);
        $array=[$listado];
    //header('Content-type: text/plain ; charset=utf-8' );
    // mandar header json
   	header('Content-Type: application/json; charset=utf-8');
	echo json_encode(array("usuario"=>$array));
}*/

?>

 
