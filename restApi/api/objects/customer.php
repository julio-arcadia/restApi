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
							
	}
?>