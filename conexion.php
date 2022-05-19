<?php

class Conexion {

	private $localhost;
	private $user;
	private $password;
	private $database;
	private $conexion;

	function __construct() {
		$this->localhost = "127.0.0.1";
		$this->user = "root";
		$this->password = "abc";
		$this->database = "usuarios";
	}

	function conectar() {

		try {
			$this->conexion = new mysqli(
										$this->localhost,$this->user,
										$this->password,$this->database
										);

		} catch (Exception $e) {
			echo "Error: " . $e->getMessage() . "\n";
			exit();
		}
	}

	public function select($query) {
		return $this->conexion->query($query);
	}

	public function delete($sql) {
		 $this->conexion->query($sql);		
		return $this->conexion->affected_rows;
	}

	public function insertar($sql) {
		return $this->conexion->query($sql);
	}

	public function update($sql) {
		$this->conexion->query($sql);
		return $this->conexion->affected_rows;
	}
}
	


?>
