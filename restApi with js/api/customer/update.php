<?php
// ponemos los headers para hacer el post
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// incluimos los phps de db, customer y las del jwt
include_once '../config/database.php';
include_once '../objects/customer.php';
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
// nos conectamos
$database = new Database();
$db = $database->getConnection();
 
// preparamos el objeto cust
$customer = new Customer($db);
 
// tomamos el id del cust que vamos a editar
$data = json_decode(file_get_contents("php://input"));

// el jwt
$jwt=isset($data->jwt) ? $data->jwt : "";
 
// si no está vacio
if($jwt){
 
    // intenta decodificar, mostrar los datos
    try {
 
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
 
       // designamos los valores de las propiedades de customer
        $customer->customerID = $data->customerID;
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
    // regeneramos el token
   $token = array(
   "iss" => $iss,
   "aud" => $aud,
   "iat" => $iat,
   "nbf" => $nbf,
   "data" => array(
       "customerID" => $customer->customerID,
       "firstName" => $customer->firstName,
       "lastName" => $customer->lastName,
       "username" => $customer->username,
       "country" => $customer->country,
       "region" => $customer->region,
       "city" => $customer->city,
       "address" => $customer->address            
   )
);
$jwt = JWT::encode($token, $key);
 
// respuesta
http_response_code(200);
 
// en formato json
echo json_encode(
        array(
            "message" => "El cliente fué modificado exitosamente.",
            "jwt" => $jwt
        )
    );
}
// Cuando no se puede modificar
else{
 
    // respuesta - 503 service unavailable
    http_response_code(503);
 
    // se escribe
    echo json_encode(array ( "message" => "No se puede modificar la cuenta.", "jwt" => $jwt,  "customerID" => $customer->customerID,
       "firstName" => $customer->firstName,
       "lastName" => $customer->lastName,
       "username" => $customer->username,
       "country" => $customer->country,
       "region" => $customer->region,
       "city" => $customer->city,
       "address" => $customer->address ));
} 
        
    }
    

// Decode falla, jwt invalido
catch (Exception $e){
 
    // respuesta
    http_response_code(401);
 
    // mensaje
    echo json_encode(array(
        "message" => "La decodificación ha fallado. Acceso Denegado.",
        "error" => $e->getMessage()
    ));
}
}

// error si el jwt esta vacio
else{
 
    // respuesta
    http_response_code(401);
 
    // mensaje
    echo json_encode(array("message" => "El jwt está vacio. Acceso denegado."));
}
    


?>