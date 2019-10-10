<?php

// pedimos los headers  
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// incluimos los php de db y cust
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// tomamos conexión
$database = new Database();
$db = $database->getConnection();
 
// preparamos el objeto cust
$customer = new Customer($db);
 
// cogemos el customerID
$data = json_decode(file_get_contents("php://input"));
 
// ponemos el customerID del cust que se va a borrar
$customer->customerID = $data->customerID;
 
// hacemos el delete
if($customer->delete()){
 
    // respuesta - 200 ok
    http_response_code(200);
 
    // mensaje
    echo json_encode(array("message" => "El cliente fué borrado exitosamente."));
}
 
// cuando no se pueda borrar
else{
 
    // respuesta - 503 service unavailable
    http_response_code(503);
 
    // mensaje
    echo json_encode(array("message" => "No se pudo borrar el cliente."));
}
?>
