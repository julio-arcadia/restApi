<?php
// pedimos los headers  
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// incluimos los php de db y acc
include_once '../config/database.php';
include_once '../objects/account.php';
 
// tomamos conexión
$database = new Database();
$db = $database->getConnection();
 
// preparamos el objeto acc
$account = new Account($db);
 
// cogemos el accountID
$data = json_decode(file_get_contents("php://input"));
 
// ponemos el accountID de la acc que se va a borrar
$account->accountID = $data->accountID;
 
// hacemos el delete
if($account->delete()){
 
    // respuesta - 200 ok
    http_response_code(200);
 
    // mensaje
    echo json_encode(array("message" => "La cuenta fué borrada exitosamente."));
}
 
// cuando no se pueda borrar
else{
 
    // respuesta - 503 service unavailable
    http_response_code(503);
 
    // mensaje
    echo json_encode(array("message" => "No se pudo borrar la cuenta."));
}
?>