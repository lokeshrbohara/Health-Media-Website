<?php
	require_once "config.php";
	session_start();
	if(isset($_SESSION['email']))
	{
		header('Location: homepage.php');
		exit();
	}
	if(!isset($_GET['code']) && (!isset($_SESSION['access_token'])))
	{
		header('Location: login.php');
		exit();
	}
	if (isset($_SESSION['access_token']))
		$gClient->setAccessToken($_SESSION['access_token']);
	else if (isset($_GET['code'])) 
	{
		$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
		$_SESSION['access_token'] = $token;
	}

	$oAuth = new Google_Service_Oauth2($gClient);
	$userData = $oAuth->userinfo_v2_me->get();

	$_SESSION['id'] = $userData['id'];
	//$_SESSION['email'] = $userData['email'];
	$_SESSION['gender'] = $userData['gender'];
	$_SESSION['picture'] = $userData['picture'];
	$_SESSION['familyName'] = $userData['familyName'];
	$_SESSION['givenName'] = $userData['givenName'];

	$name=$con->real_escape_string($userData['givenName'].' '.$userData['familyName']);
    $email=$con->real_escape_string($userData['email']);
        

	$sql = $con->query("Select id , token from users where email='$email'");
	if($sql->num_rows > 0)
	{
		$id = $sql->fetch_assoc();
		
		$_SESSION['id'] = $id['id'];

		if($id['token']!='')
		{
			$token=$id['token'];
			header('Location: gupass.php?email='.$email.'&token='.$token);
			exit();
		}
		else
		{
			$_SESSION['email'] = $userData['email'];
			header('Location: homepage.php');
			exit();
		}
	
	}
	else
	{
		$token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
		$token = str_shuffle($token);
		$token = substr($token, 0, 10);
		$token = $con->real_escape_string($token);

		$sql = $con->query("Insert into users(name,email,isEmailVerified,token) values('$name','$email',0,'$token')");
		header('Location: gupass.php?email='.$email.'&token='.$token);
        exit();
	}

	
?>