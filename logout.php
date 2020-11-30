<?php
	require_once "config.php";
	
	if(isset($_SESSION['access_token']))
	$gClient->revokeToken($token);
	unset($_SESSION['access_token']);
	unset($_SESSION['email']);
    session_start();
	session_destroy();
	header('Location: login.php');
	exit();
?>