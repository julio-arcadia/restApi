<?php
class Customer{
	
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
		$query = "SELECT * FROM " . $this->table_name;
		
		// Preparar Statement
		$stmt = $this->conn->prepare($query);
		// Execute Query
		$stmt->execute();
		return $stmt;
	}
	
        function create(){
    	// query para hacer el insert del contenido de record
    		$query = "INSERT INTO " . $this->table_name . " SET
                 customerID=:customerID, firstName=:firstName, lastName=:lastName, username=:username, password=:password, country=:country, region=:region, city=:city, address=:address";
 
    	// preparamos el query
    		$stmt = $this->conn->prepare($query);
 
    	// lo saneamos por seguridad
    		$this->customerID=htmlspecialchars(strip_tags($this->customerID));    
    		$this->firstName=htmlspecialchars(strip_tags($this->firstName));
    		$this->lastName=htmlspecialchars(strip_tags($this->lastName));
		$this->username=htmlspecialchars(strip_tags($this->username));
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->country=htmlspecialchars(strip_tags($this->country));
		$this->region=htmlspecialchars(strip_tags($this->region));
		$this->city=htmlspecialchars(strip_tags($this->city));
		$this->address=htmlspecialchars(strip_tags($this->address));
 
    	// enlazamos los valores
    
    		$stmt->bindParam(":customerID", $this->customerID);
    		$stmt->bindParam(":firstName", $this->firstName);
    		$stmt->bindParam(":lastName", $this->lastName);
		$stmt->bindParam(":username", $this->username);
		$stmt->bindParam(":password", $this->password);
		$stmt->bindParam(":country", $this->country);
		$stmt->bindParam(":region", $this->region);
		$stmt->bindParam(":city", $this->city);
		$stmt->bindParam(":address", $this->address);
 
    	// ejecutar
    		if($stmt->execute()){
        		return true;
   		}
 
    		return false;
     
			}
        
	}
?>
