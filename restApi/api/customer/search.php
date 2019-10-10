<?php
// headers requeridos
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// incluimos phps core, database y customer
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// Instanciamos una db y un cust
$database = new Database();
$db = $database->getConnection();
 
// inicializamos el bust
$customer = new Customer($db);
 
// cojemos la palabra clave "s"
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
 
// query customer
$stmt = $customer->search($keywords);
$num = $stmt->rowCount();
 
// hay mas de 0?
if($num>0){
 
    // customer array
    $customers_arr=array();
    $customers_arr["records"]=array();
 
    // cojemos el contenido de la tabla
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        // dejamos solo la $var
        extract($row);
               
        $customer_item=array(
                        "customerID" => $customerID,
			"firstName" => $firstName,
			"lastName" => $lastName,
			"username" => $username,			
			"country" => $country,
			"region" => $region,
			"city" => $city,
			"address" => $address
        );
 
        array_push($customers_arr["records"], $customer_item);
    }
 
    // respondemos - 200 OK
    http_response_code(200);
 
    // y mostramos la data
    echo json_encode($customers_arr);
}
 
else{
    // si no funciona - 404 Not found
    http_response_code(404);
 
    // decimos
    echo json_encode(
        array("message" => "No se encontraron clientes.")
    );
}
?>