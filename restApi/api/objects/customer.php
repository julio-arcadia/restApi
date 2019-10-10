<?php
class Customer{
	
	// Conexión a la db y nombre de la tabla
	private $conn;
	private $table_name = "customer";
	
	// Propiedades de customer
	public $customerID;
	public $firstName;
	public $lastName;
	public $username;
	public $password;
	public $country;
	public $region;
	public $city;
	public $address;
	
	// constructor con $db como conexion a la db
	public function __construct($db){
		$this->conn = $db;
	}

	// read customer
	function read(){
		//query all
		$query = "SELECT * FROM " . $this->table_name ;
		
		//preparar el statement 
		$stmt = $this->conn->prepare($query);
		
		//ejecutarla
		$stmt->execute();
		
		return $stmt;
	}
	
	function readOne(){
 
    		// query para leer uno solo de los record
    		$query = "SELECT
                	*
           	FROM     " . $this->table_name . "               
           	WHERE
                customerID = ?
            	LIMIT
                0,1";
 
    		// preparar el query statement
    		$stmt = $this->conn->prepare( $query );
 
    		// enlazar la customerID de la customer al que vamos a hacer el update
    		$stmt->bindParam(1, $this->customerID);
 
    		// ejecutar
    		$stmt->execute();
 
	    	// tomar el row 
    		$row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    		// ponerle los valores a las propiedades del objeto 
    		$this->customerID = $row['customerID'];    
    		$this->firstName = $row['firstName'];    
    		$this->lastName = $row['lastName'];
    		$this->username = $row['username'];
    		$this->password = $row['password'];
    		$this->country = $row['country'];
    		$this->region = $row['region'];
    		$this->city = $row['city'];
    		$this->address = $row['address'];
	}

	
        function create(){
    	// query para hacer el insert del contenido de record
    		$query = "INSERT INTO " . $this->table_name . " SET
                 firstName=:firstName, lastName=:lastName, username=:username, password=:password, country=:country, region=:region, city=:city, address=:address";
 
    	// preparamos el query
    		$stmt = $this->conn->prepare($query);
 
    	// lo saneamos por seguridad    		    
    		$this->firstName=htmlspecialchars(strip_tags($this->firstName));
    		$this->lastName=htmlspecialchars(strip_tags($this->lastName));
		$this->username=htmlspecialchars(strip_tags($this->username));
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->country=htmlspecialchars(strip_tags($this->country));
		$this->region=htmlspecialchars(strip_tags($this->region));
		$this->city=htmlspecialchars(strip_tags($this->city));
		$this->address=htmlspecialchars(strip_tags($this->address));
 
    	// enlazamos los valores        		
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
	
	function update(){
 
    		// query para update
    		$query = "UPDATE
                	" . $this->table_name . "
           	 SET 	    	
                	firstName=:firstName,
                	lastName=:lastName,
                	username=:username,
                	password=:password,
                	country=:country,
                	region=:region,
                	city=:city,
                	address=:address                
            	WHERE
                	customerID = :customerID";
 
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
 
    		// Enlazamos los nuevos valores 
    
                $stmt->bindParam(":customerID", $this->customerID);
    		$stmt->bindParam(":firstName", $this->firstName);
    		$stmt->bindParam(":lastName", $this->lastName);
		$stmt->bindParam(":username", $this->username);
		$stmt->bindParam(":password", $this->password);
		$stmt->bindParam(":country", $this->country);
		$stmt->bindParam(":region", $this->region);
		$stmt->bindParam(":city", $this->city);
		$stmt->bindParam(":address", $this->address);
 
    		// execute the query
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
		$query = "SELECT c.customerID, c.firstName, c.lastName, c.username,  
                c.country, c.region, c.city, c.address FROM " . $this->table_name . " c WHERE 
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
	//Comprobamos si el username existe en la BBDD
	function usernameExist(){
		// Query para comprobar si username existe
		$query = "SELECT * FROM " . $this->table_name ." WHERE username = ? LIMIT 0,1";
		//Preparamos la query
		$stmt = $this->conn->prepare($query);
		// saneamos
		$this->username=htmlspecialchars(strip_tags($this->username));
		//Hacemos BindParam a los atributos
		$stmt->bindParam(1,$this->username);
		// ejecutamos query
		$stmt->execute();
		//Obtenemos el numero de filas
		$num = $stmt->rowCount();
		// Si existe el username, asignamos los valores a las propiedades del objeto para el fácil acceso y uso php sessions
		if($num>0){
			//Obtenemos los valores guardados
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			// Asignamos los valores a las propiedades
			$this->customerID = $row["customerID"];
			$this->firstName = $row["firstName"];
			$this->lastName = $row["lastName"];
			$this->username = $row["username"];
			$this->password = $row["password"];
			$this->country = $row["country"];
			$this->region = $row["region"];
			$this->city = $row["city"];
			$this->address = $row["address"];

			//retorna TRUE porque el username existe en la BBDD
		}
			//Retorna FALSE si el mail no existe en la BBDD
			return false;
	}
	
}
?>
