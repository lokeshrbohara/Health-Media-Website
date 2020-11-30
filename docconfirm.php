<?php
	function redirect() {
		header('Location: docreg.php');
		exit();
	}

	if (!isset($_GET['email']) || !isset($_GET['token'])) {
		redirect();
	} else {
		include_once "config.php";

		$email = $con->real_escape_string($_GET['email']);
		$token = $con->real_escape_string($_GET['token']);

		$sql = $con->query("SELECT id FROM doctors WHERE email='$email' AND token='$token' AND isEmailVerified=0");

		if ($sql->num_rows > 0) {
			$id=$sql->fetch_assoc();
			$con->query("UPDATE doctors SET isEmailVerified=1, token='' WHERE email='$email'");
			
			echo 'Your email has been verified! After verification of your documents you will receive an email confirming your registration!';
		} else
			redirect();
	}
?>