<?php
// headers requeridos
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// incluimos los ficheros de pertinentes
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// utilities
$utilities = new Utilities();
 
// instanciamos
$database = new Database();
$db = $database->getConnection();
 
// inicializamos el cust
$customer = new Customer($db);
 
// query customer
$stmt = $customer->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
 
// si hay mas de 0 en records
if($num>0){
 
    // customers array
    $customers_arr=array();
    $customers_arr["records"]=array();
    $customers_arr["paging"]=array();
 
    // cojemos el contenido de la tabla
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // dejamos las $var
        extract($row);
 
        $customer_item=array(
                        "customerID" => $customerID,
			"firstName" => $firstName,
			"lastName" => $lastName,
			"username" => $username,
			"password" => $password,
			"country" => $country,
			"region" => $region,
			"city" => $city,
			"address" => $address
        );
 
        array_push($customers_arr["records"], $customer_item);
    }
 
 
    // incluimos la paginación
    $total_rows=$customer->count();
    $page_url="{$home_url}customer/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $customers_arr["paging"]=$paging;
 
    // respondemos ok - 200 OK
    http_response_code(200);
 
    // en formato json
    echo json_encode($customers_arr);
}
 
else{
 
    // respodenmos no - 404 Not found
    http_response_code(404);
 
    // y el cust no existe
    echo json_encode(
        array("message" => "Clientes no encontrados.")
    );
}
?>