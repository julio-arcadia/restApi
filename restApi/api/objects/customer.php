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
	function delete(){
		// Delete Query
		$query = "DELETE FROM " . $this->table_name . " WHERE customerID = ?";
		// Prepare Query
		$stmt  = $this->conn->prepare($query);
		// saneamos por seguridad
		$this->customerID=htmlspecialchars(strip_tags($this->customerID));
		// bind id of record to delete
    		$stmt->bindParam(1, $this->customerID);
		// execute query
    		if($stmt->execute()){
        		return true;
    		}
    		return false;
	}
	function search($keywords){
		// Query para Seleccionar todo
		$query = "SELECT * FROM " . $this->table_name . " c WHERE 
		c.customerID LIKE ? OR c.firstName LIKE ? OR c.lastName LIKE ? OR c.username LIKE ?  
		OR c.country LIKE ? OR c.region LIKE ? OR c.city LIKE ? OR c.address LIKE ?";
		//Preparar Statement
		$stmt = $this->conn->prepare($query);
		// Saneamos
		$keywords=htmlspecialchars(strip_tags($keywords));
    		$keywords = "%{$keywords}%";
		// Bind los parametors
		$stmt->bindParam(1, $keywords);
   		$stmt->bindParam(2, $keywords);
    		$stmt->bindParam(3, $keywords);
		$stmt->bindParam(4, $keywords);
    		$stmt->bindParam(5, $keywords);
    		$stmt->bindParam(6, $keywords);
		$stmt->bindParam(7, $keywords);
    		$stmt->bindParam(8, $keywords);
   		// execute query
    		$stmt->execute();
		return $stmt;
	}
	
	// read pero con paginación
public function readPaging($from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT
                *
            FROM
                " . $this->table_name . "
                
            LIMIT ?, ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}

// count para la paginación
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

	
}
?>
