<?php
	$msg="";
	include_once "config.php";
	
	session_start();
	if (isset($_SESSION['email'])) {
		header('Location: homepage.php');
		exit();
	}
	

	$loginURL = $gClient->createAuthUrl();

    if(isset($_POST["submit"]))
    {

        $email=$con->real_escape_string($_POST["email"]);
        $password=$con->real_escape_string($_POST["password"]);

        if ($email == "")
			$msg = "<div class=\"alert alert-danger\">Email ID is empty, try again.</div>";
		else if ($password == "")
			$msg = "<div class=\"alert alert-danger\">Password is empty, try again.</div>";
		else {
			$sql = $con->query("SELECT * FROM users WHERE email='$email'");
			if ($sql->num_rows > 0) {
                $data = $sql->fetch_array();
                if (password_verify($password, $data['passwordhash'])) {
                    if ($data['isEmailVerified'] == 0)
	                    $msg = "<div class=\"alert alert-danger\">Please verify your email!</div>";
                    else {
						
						$_SESSION['id']=$data['id'];
						$_SESSION['email']=$email;
						$_SESSION['isdoctor']=$data['isdoctor'];

						header('Location: homepage.php');
						exit();

	                   
                    }
                } else
	                $msg = "<div class=\"alert alert-danger\">Email ID or Password is Wrong</div>";
			} else {
				$msg = "<div class=\"alert alert-danger\">Email ID or Password is Wrong</div>";
			}
		}

    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css">

    <title>Document</title>
</head>
<body>
        <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
                <form class="login100-form flex-sb flex-w" method="post" action="login.php">
				<span class="login100-form-title p-b-53"><img src="icon.png" style="max-width:40%;"alt="Brand Logo"><p>Remedium</p></span>
                    <button onclick="myFunction(event)" class="btn-google m-b-20 googlehover">
						<img src="images/icons/icon-google.png" alt="GOOGLE">
									&nbsp;&nbsp;Sign In with Google
					</button>

					<div class="p-t-31 p-b-9" style="width:100%;">
						<span class="txt1">
							<?php if ($msg != "") echo $msg  ?>
						</span>
						
					</div>

                    <div class="p-t-31 p-b-9">
                        <span class="txt1">
                            Email Id
                        </span>
                    </div>

                    <div class="wrap-input100">
						<input class="input100" name="email" type="email" placeholder="Email Id">
                    </div>
                    
                    
					<div class="p-t-13 p-b-9 m-t-17">
						<span class="txt1">
							Password
						</span>

						<a href="http://localhost/ip/forgotpass.php" class="txt2 m-l-10">
							Forgot Password?
						</a>
					</div>
					<div class="wrap-input100">
						<input class="input100" name="password" type="password" placeholder="Password" >
					</div>

					<div class="container-login100-form-btn m-t-17">
						<input class="login100-form-btn a1" type="submit" name="submit" value="Log In">
					</div>

					<div class="w-full text-center p-t-55">
						<span class="txt2">
							Not a member?
						</span>

						<a href="http://localhost/ip/register.php" class="txt2">
							Sign up now
						</a>
					</div>
				</form>
            </div>
        </div>
<script>
	function myFunction(e) {
		
		e.preventDefault();
		window.location = "<?php echo $loginURL ?>";
	
	}
</script>
</body>
</html>