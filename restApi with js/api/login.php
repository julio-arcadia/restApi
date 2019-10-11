<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
// Archivos necesarios para la conexión con la Base de Datos
include_once 'config/database.php';
include_once 'objects/customer.php';

// Hacemos conexion con la BBDD
$database = new Database();
$db = $database->getConnection();
 
// Insatanciamos el objeto Customer
$customer = new Customer($db);
 
// Chekeamos la existencia del Customer
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// Seteamos los valores de las propiedades
$customer->username = $data->username;
$username_exists = $customer->usernameExists();

// generate json web token
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
 
// check if email exists and if password is correct
if($username_exists && password_verify($data->password, $customer->password)){
 
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
		   "password" => $customer->password,
		   "country" => $customer->country,
		   "region" => $customer->region,
		   "city" => $customer->city,
		   "address" => $customer->address
       )
    );
 
    // set response code
    http_response_code(200);
 
    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message" => "Login Satisfactorio.",
                "jwt" => $jwt
            )
        );
 
} else{
	// Login FALLIDO
	http_response_code(401);
	echo json_encode(array("message"=> "Login FALLIDO"));
	
}

?>