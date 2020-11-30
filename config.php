<?php
    //session_start();
    $con = new mysqli('localhost','root','','ipproject');
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("Your Id");
	$gClient->setClientSecret("Your Secret");
	$gClient->setApplicationName("Health Media");
    $gClient->setRedirectUri("http://localhost/ip/g-callback.php");
    $gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

?>