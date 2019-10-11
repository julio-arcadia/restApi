<?php
class Account{
	
	// Conexión a la db y nombre de la tabla
	private $conn;
	private $table_name = "account";
	
	// Propiedades de account
        public $accountID;
	public $accountNumber;	
	public $description;
	public $customerID;
	
	// constructor con $db como conexion a la db
	public function __construct($db){
		$this->conn = $db;
	}


	// read account
	function read(){
		//query all
		$query = "SELECT
				*
				FROM
				account
					LEFT JOIN
					customer ON account.customerID = customer.customerID;";
		
		//preparar el statement 
		$stmt = $this->conn->prepare($query);
		
		//ejecutarla
		$stmt->execute();
		
		return $stmt;
	}
        
	// create account
        function create(){
 
    // query para hacer el insert del contenido de record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                accountNumber=:accountNumber, description=:description, customerID=:customerID";
 
    // preparamos el query
    $stmt = $this->conn->prepare($query);
 
    // lo saneamos por seguridad
    $this->accountNumber=htmlspecialchars(strip_tags($this->accountNumber));    
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->customerID=htmlspecialchars(strip_tags($this->customerID));    
 
    // enlazamos los valores
    
    $stmt->bindParam(":accountNumber", $this->accountNumber);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":customerID", $this->customerID);
 
    // ejecutar
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// Esto para cuando lea el formulario de actualización
function readOne(){
 
    // query para leer uno solo de los record
    $query = "SELECT
                *
           FROM     " . $this->table_name . " 
              
           WHERE
                customerID = ?
           ";
 
    // preparar el query statement
    $stmt = $this->conn->prepare( $query );
 
    // enlazar la accountID de la account al que vamos a hacer el update
    $stmt->bindParam(1, $this->customerID);
 
    // ejecutar
    $stmt->execute();
 
    // tomar el row 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // ponerle los valores a las propiedades del objeto 
    $this->customerID = $row['customerID'];
    $this->accountNumber = $row['accountNumber'];    
    $this->description = $row['description'];    
    
}

// update la account
function update(){
 
    // query para update
    $query = "UPDATE
                " . $this->table_name . "
            SET
                accountNumber=:accountNumber,
                description=:description,
                customerID=:customerID
            WHERE
                accountID = :accountID";
 
    // preparamos el query
    $stmt = $this->conn->prepare($query);
 
    // lo saneamos por seguridad
    
    $this->accountNumber=htmlspecialchars(strip_tags($this->accountNumber));    
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->customerID=htmlspecialchars(strip_tags($this->customerID)); 
    $this->accountID=htmlspecialchars(strip_tags($this->accountID));
 
    // Enlazamos los nuevos valores 
    
    $stmt->bindParam(":accountNumber", $this->accountNumber);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":customerID", $this->customerID);
    $stmt->bindParam(":accountID", $this->accountID);
 
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// delete la account
function delete(){
 
    // query para delete
    $query = "DELETE FROM " . $this->table_name . " WHERE accountID = ?";
 
    // prepararlo
    $stmt = $this->conn->prepare($query);
 
    // sanearlo
    $this->accountID=htmlspecialchars(strip_tags($this->accountID));
 
    // enlazarlo al record
    $stmt->bindParam(1, $this->accountID);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

}	
?>