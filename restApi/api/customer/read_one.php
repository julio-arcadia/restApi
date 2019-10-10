 <?php 
 //headers
 header("Access-Control-Allow-Origin: *");
 header("Acces-Control-Allow-Headers: access");
 header("Acces-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

//Incluir objetos y base de Datos
include_once '../config/database.php';
include_once '../objects/customer.php';
// Obtenemos Conexion
$database = new Database();
$db = $database->getConnection();
// Instanciamos el objeto CUSTOMER 
$customer = new Customer($db);
// Definimos el ID del customer que queremos leer
$customer->id = isset($_GET['id']) ? $_GET['id'] : die();
// Leer los detalles del producto para editarlos
$customer->readOne();
if($customer->name!=null){
	//crear Array
	$customer_arr = array(
		"customerID" => $customer->customerID,
		"firstName" => $customer->firstName,
		"lastName" => $customer->lastName,
		"username" => $customer->username,
		"password" => $customer->password,
		"country" => $customer->country,
		"region" => $customer->region,
		"city" => $customer->city,
		"address" => $customer->address
	);
	 // set codigo respuesta - 200 OK
    http_response_code(200);
 
    // lo hacemos formato JSON
    echo json_encode($customer_arr);

} else {
	http_response_code(404);
	
	echo json_encode(array("message" => "El cliente no existe"));
	
}


