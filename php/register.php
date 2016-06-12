<?php
	include_once 'User.php';

	try {
		$regInfo = array(
							'username' => $_POST['username'],
							'password' => $_POST['password'],
							'email' => $_POST['email'],
							'name' => $_POST['name']
						);
		
		header('Content-Type: application/json');
		echo json_encode(User::registerUser($regInfo));

	} catch (Exception $e) {
		echo json_encode($e).PHP_EOL;
	}

?>