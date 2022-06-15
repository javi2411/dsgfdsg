<?

include "INCLUDES/insertarMensaje.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $datos = json_decode(file_get_contents('php://input'), true);
	
	
	insertarMensaje($datos);

	//$datos=['mensaje']="prueba mensaje";
    //print_r($listado);
    // mandar header json
   	header('Content-Type: application/json; charset=utf-8');

	echo json_encode($datos);
	
	
	
	
}





?>

 
