<?php
// headers 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// los includes para decodificar el jwt
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
// tomamos la data del post
$data = json_decode(file_get_contents("php://input"));
 
// tomamos el jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
 
// si el jwt no esta vacio
if($jwt){
 
    // intenta decodificar, si funciona muestra los detalles
    try {
        // decodifica
        $decoded = JWT::decode($jwt, $key, array('HS256'));
 
        // funciona
        http_response_code(200);
 
        // detalles del customer
        echo json_encode(array(
            "message" => "Acceso concedido.",
            "data" => $decoded->data
        ));
 
    }
 
    // Si la decodificación falla el jwt es invalido
catch (Exception $e){
 
    // se responde
    http_response_code(401);
 
    // se muestra el error
    echo json_encode(array(
        "message" => "Acceso denegado.",
        "error" => $e->getMessage()
    ));
}
}
// show error message if jwt is empty
 else{
 
    // set response code
    http_response_code(401);
 
    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}

?>