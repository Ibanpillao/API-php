<?php

include('conexion.php');

$bd = new Conexion();
$bd->conectar();

/********************************
CLASE USUARIO
********************************/
class Usuario {

	private $nombre;
	private $pass;

	public function __construct($nombre, $pass) {
		$this->nombre = $nombre;
		$this->pass = $pass;
	}
	
	/********************************
	CREAR USER
	********************************/
	public function createUser() {

		global $bd;

		$sql = "insert into users(nombre,password) 
				values('$this->nombre', '$this->pass')";

		if( $bd->insertar($sql) == 0) {
			echo "No se pudo insertar";
		} else {
			$data = [
						"id" => self::selectMaxId(),
						"nombre" => $this->nombre, 
						"password" => $this->pass
					];
					
			return json_encode($data);
		}
		
	}

	/********************************
	SELECCIONAR ALL USERS
	********************************/	
	 public static function getAllUsers() {
		global $bd;
	    $sql = 'select * from users';
	    $res = $bd->select($sql);
	    $data = [];
	
	    while ($fila = mysqli_fetch_assoc($res)) {
	   	 $data[] = $fila;
	    }
	
	   echo json_encode($data, JSON_PRETTY_PRINT);
		
	}

	/********************************
	SELECCIONAR 1 USER
	********************************/
	 public static function getUser($id) {
		global $bd;
		
	 	$sql = "SELECT *
		        FROM users
		        WHERE id = $id";
		            
       		$res = $bd->select($sql);
       		
		    if ( mysqli_num_rows($res)== 1) {
		        $data = mysqli_fetch_assoc($res);
		        return json_encode($data);
		    } else echo "El usuario no existe\n";
	}
	
	/********************************
	BORRAR USUARIO
	********************************/
	public static function deleteUser($id) {
		global $bd;

		if (self::getUser($id) != null) {
			$user = json_decode(self::getUser($id));
			$user->status = "deleted";		
			$user->fecha_deleted = date('d/m/Y');
		}
		
		$sql = "DELETE FROM users WHERE id = $id";
		
		if( $bd->delete($sql) == 0) {
        	echo "No se pudo borrar\n";
		} else {
			echo json_encode($user);
		}
		
	}

    /********************************
    ACTUALIZAR USUARIO
    ********************************/
	public static function updateUser($id, $nombre, $pass) {
		global $bd;

		$sql = "    update users
			        set nombre = '$nombre',  password = '$pass'
		            where id = $id";
		if ( $bd->update($sql) == 0 ) {
	 		echo "El id del usuario no existe";
		} else echo self::getUser($id);		
	}

	/********************************
	SELECCIONAR ID
	********************************/
	private function selectMaxId() {
		global $bd;

		$sql = "select max(id) as 'id' from users";
		$res = $bd->select($sql);
		$data = mysqli_fetch_assoc($res);
		return $data['id'];
	}	
}

?>
