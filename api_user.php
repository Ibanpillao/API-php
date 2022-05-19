<?php

header("Content-Type: application/json");
include_once("Usuario.php");


$_POST = json_decode(file_get_contents('php://input'),true);

switch ($_SERVER['REQUEST_METHOD']) {

	case 'GET':
		if (!isset($_GET['id'])) {
			Usuario::getAllUsers();
		} else{
			echo Usuario::getUser($_GET['id']);
		}
		
		break;

	case 'POST':
		if (isset($_POST['nombre']) && isset($_POST['password'])) {
			$nombre = $_POST['nombre'];
			$pass = $_POST['password'];	
			$user = new Usuario($nombre, $pass);
			echo $user->createUser();		
		}
			
		break;

	case 'PATCH':
	   if (isset($_GET['id']) && isset($_GET['nombre']) && isset($_GET['password'])) {
	   		$nombre = $_GET['nombre'];
	        $pass = $_GET['password'];
	        $id = $_GET['id'];
	        Usuario::updateUser($id, $nombre, $pass);	        
	  	}

	    break;


	  case 'DELETE':
	    if (isset($_GET['id'])) {
	    	$id = $_GET['id'];
	    	Usuario::deleteUser($id);	    
	    }

	    break;
	}

?>
