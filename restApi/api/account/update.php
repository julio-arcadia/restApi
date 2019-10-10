<?php
// ponemos los headers para hacer el post
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// incluimos los phps de db y account
include_once '../config/database.php';
include_once '../objects/account.php';
 
// nos conectamos
$database = new Database();
$db = $database->getConnection();
 
// preparamos el objeto acc
$account = new Account($db);
 
// get id of account to be edited
$data = json_decode(file_get_contents("php://input"));
 
// colocamos la accountID a editar
$account->accountID = $data->accountID;
 
// designamos los valores de las propiedades de account

$account->accountNumber = $data->accountNumber;	
$account->description = $data->description;
$account->customerID = $data->customerID;
 
// hacemos update del account
if($account->update()){
 
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