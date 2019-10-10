<?php
// ponemos los headers para hacer el post
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// incluimos los phps de db y customer
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// nos conectamos
$database = new Database();
$db = $database->getConnection();
 
// preparamos el objeto cust
$customer = new Customer($db);
 
// cojemos el id del cust que vamos a editar
$data = json_decode(file_get_contents("php://input"));
 
// colocamos la customerID a editar
$customer->customerID = $data->customerID;
 
// designamos los valores de las propiedades de customer

    $customer->firstName = $data->firstName;
    $customer->lastName = $data->lastName;
    $customer->username = $data->username;
    $customer->password = $data->password;
    $customer->country = $data->country;
    $customer->region = $data->region;
    $customer->city = $data->city;
    $customer->address = $data->address;
    
 
// hacemos update del customer
if($customer->update()){
 
    // funcionó - 200 ok
    http_response_code(200);
 
    // y el mensaje
    echo json_encode(array("message" => "La cuenta fué modificada exitosamente."));
}
 
// Cuando no se puede modificar
else{
 
    // respuesta - 503 service unavailable
    http_response_code(503);
 
    // se escribe
    echo json_encode(array("message" => "No se puede modificar la cuenta."));
}
?>