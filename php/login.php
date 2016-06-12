<?php
	include_once 'User.php';

	try {
		$credentials = array(
							'username' => $_POST['username'],
							'password' => $_POST['password']
						);

		header('Content-Type: application/json');
		echo json_encode(User::attemptLogin($credentials));

	} catch (Exception $e) {
		echo json_encode($e).PHP_EOL;
	}
	

?>