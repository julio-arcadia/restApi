<?php
// headers requeridso
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Hacer include del fichero database.php y account.php
include_once '../config/database.php';
include_once '../objects/account.php';

//Instanciar la db y el objeto account
$database = new Database();
$db = $database->getConnection();

//Inicializar el objeto
$account = new account($db);

// Query account
$stmt = $account->read();
$num = $stmt->rowCount();

//revisar si encontró mas de 0
if($num>0){
	// array de account
	$account_arr=array();
	$account_arr["records"]=array();
	// cojemos el contenido de la tabla
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		// quitamos la parte de row con extract
		extract($row);
		
		$account_item=array(
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
			
			array_push($account_arr["records"], $account_item);
	}
	
	// ponemos un response code - 200 OK
	http_response_code(200);
	
	//mostramos la data de accountes en formato json
	echo json_encode($account_arr);	
	}
else {
	//codigo 404
	http_response_code(404);
	
	//Avisamos al user que no se encontró account
	echo json_encode(
		array("message" => "No se encontraron cuentas.")
		);
}	
?>