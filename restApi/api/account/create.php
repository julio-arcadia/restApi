<?php
//headers requeridos
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// cojemos la conexión a la db
include_once '../config/database.php';
 
// instanciamos el objeto account
include_once '../objects/account.php';
 
$database = new Database();
$db = $database->getConnection();
 
$account = new Account($db);
 
// cojemos la data a postear
$data = json_decode(file_get_contents("php://input"));
 
// aseguramos que la data no está vacia
if(	
	!empty($data->accountNumber) &&
	!empty($data->description) &&
	!empty($data->customerID)
	){
    
	//ponemos la data de las propiedades del account
	
	$account->accountNumber = $data->accountNumber;	
	$account->description = $data->description;
	$account->customerID = $data->customerID;
        
        //cramos la account
         if($account->create()){
 
        // respondemos con - 201, creada
        http_response_code(201);
 
        // y decimos
        echo json_encode(array("message" => "La cuenta fué registrada satisfactoriamente"));
    }
 
    // Si no se puede crear la cuenta 
    else{
 
        // respondemos - 503, servicio no disponible
        http_response_code(503);
 
        // y decimos
        echo json_encode(array("message" => "No se pudo registrar la cuenta"));
    }
}
 
// cuando la data está incompleta
else{
 
    // resondemos con - 400 bad request
    http_response_code(400);
 
    // y decimos
    echo json_encode(array("message" => "No se pudo registrar la cuenta, los datos están incompletos."));
}
?>
	