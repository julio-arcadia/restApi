<?php
// HEADERS
header("Acces-Control-Allow-Origin: *");
header("Content-Type: aplication/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conexion Base de Datos
include_once '../config/database.php';

// Instancia del objeto CUSTOMER
include_once '../objects/customer.php';

$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);

// get posted data 
$data = json_decode(file_get_contents("php://input"));

 // Set los valores de las propiedades de CUSTOMER    
    $customer->firstName = $data->firstName;
    $customer->lastName = $data->lastName;
    $customer->username = $data->username;
    $customer->password = $data->password;
    $customer->country = $data->country;
    $customer->region = $data->region;
    $customer->city = $data->city;
    $customer->address = $data->address;

// Nos aseguramos de que los datos no estan vacios
if (!empty($data->firstName) &&
    !empty($data->lastName) &&
    !empty($data->username) &&
    !empty($data->password) &&
    !empty($data->country) &&
    !empty($data->region) &&
    !empty($data->city) &&
    !empty($data->address) && 
    $customer->create()
   ){
    
     // si es efectivo respondemos
    http_response_code(200);
 
    // y escribimos
    echo json_encode(array("message" => "El cliente fue creado satisfactoriamente."));
    
   }
     else{ 
      //Si no se pudo crear, avisamos al usuario
      // set response code - 503 service unavailable
        http_response_code(503);
        // Avisamos al usuario
        echo json_encode(array("message" => "No se pudo crear al cliente."));
    }

?>
