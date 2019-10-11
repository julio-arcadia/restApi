<?php
class Database{
	
	//Especificamos las credenciales de nuestra db
	private $host = "localhost";
	private $db_name = "api_db";
	private $username = "root";
	private $password = "";
	public $conn;
	
	// Tomamos la conexión a la db
	public function getConnection(){
	$this->conn = null;
	
		try {
		$this->conn = new PDO("mysql:host=" .  $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
		$this->conn->exec("set names utf8");
		}catch(PDOException $exception){
			echo "Error de conexión: " . $exception->getMessage();
		}
		return $this->conn;
	}
		
}
?>