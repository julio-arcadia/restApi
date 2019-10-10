<?php
// los hearders requeridos
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// incluimos los php de db y account
include_once '../config/database.php';
include_once '../objects/account.php';
 
// tomamos la conexion
$database = new Database();
$db = $database->getConnection();
 
// nuevo objeto account
$account = new Account($db);
 
// ajustamos la propiedad accountID en el record para hacer el read
$account->accountID = isset($_GET['accountID']) ? $_GET['accountID'] : die();
 
// leer los datos de la cuenta que vamos a editar
$account->readOne();
 
if($account->accountNumber!=null){
    // creamos el array
    $account_arr = array(
        "accountID" =>  $account->accountID,
        "accountNumber" => $account->accountNumber,
        "description" => $account->description,        
        "customerID" => $account->customerID
 
    );
 
    //   code de respuesta - 200 OK
    http_response_code(200);
 
    // en formato json
    echo json_encode($account_arr);
}
 
else{
    // respuesta en caso de que no haya numero de acc - 404 Not found
    http_response_code(404);
 
    // decir al usuario que la cuenta no existe
    echo json_encode(array("message" => "La cuenta no existe"));
}
?>


