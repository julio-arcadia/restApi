<?php
class Client{
	
	// Conexión a la db y nombre de la tabla
	private $conn;
	private $table_name = "customer";
	
	// Propiedades de customer
	private $customerID;
	private $firstName;
	private $lastName;
	private $username;
	private $password;
	private $country;
	private $region;
	private $city;
	private $address;
	
	// constructor con $db como conexion a la db
	public function __contruct($db){
		$this->conn = $db;
	}


	// read customer
	function read(){
		//query all
		$query = "SELECT";
	}
	
         function create(){
 
    // query para hacer el insert del contenido de record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                customerNumber=:customerNumber, description=:description, customerID=:customerID";
 
    // preparamos el query
    $stmt = $this->conn->prepare($query);
 
    // lo saneamos por seguridad
    $this->customerNumber=htmlspecialchars(strip_tags($this->customerNumber));    
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->customerID=htmlspecialchars(strip_tags($this->customerID));    
 
    // enlazamos los valores
    
    $stmt->bindParam(":customerNumber", $this->customerNumber);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":customerID", $this->customerID);
 
    // ejecutar
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
        
	}
?>