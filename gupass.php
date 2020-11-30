<?php
    $msg="";
    session_start();

    if(isset($_SESSION['email']))
	{
        header('Location: homepage.php');
        exit();
	}
    if(isset($_GET["email"]) && isset($_GET["token"])){
        include_once "config.php";
        $email = $con->real_escape_string($_GET['email']);
        $token = $con->real_escape_string($_GET['token']);
        $sql = $con->query("SELECT id FROM users WHERE email='$email' AND token='$token' AND isEmailVerified=0");

        if($sql->num_rows > 0){
            if(isset($_POST['submit']))
            {
                $password=$con->real_escape_string($_POST['password']);
                $cPassword=$con->real_escape_string($_POST['cPassword']);
                $location=$con->real_escape_string($_POST['location']);
                $contactno=$con->real_escape_string($_POST['contactno']);

                
                if ($password == "")
                    $msg = "<div class=\"alert alert-danger\">Password is required, try again.</div>";
                else if(strlen($password)<5)
                    $msg = "<div class=\"alert alert-danger\">Password should be atleast 5 characters long!</div>";
                else if ($password != $cPassword)
                    $msg = "<div class=\"alert alert-danger\">Password and Confirm Password should be same, try again.</div>";
                else if(!preg_match("/^[0-9]*$/",$contactno) || strlen($contactno)!=10)
                    $msg = "<div class=\"alert alert-danger\">Contact Number Invalid!</div>";
                else if(!preg_match("/^[a-zA-Z ]*$/",$location) || strlen($location)<2)
                    $msg = "<div class=\"alert alert-danger\">Invalid Location Field!</div>";
                
                else {

                        $id = $sql->fetch_assoc();
                        $q=$id['id'];
                        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                        $con->query("UPDATE users SET passwordhash='$hashedPassword', isEmailVerified=1, token='', location='$location', contact='$contactno' WHERE id='$q'");
                        
                        $_SESSION['id'] = $q;
                        $_SESSION['email']=$email;
                        header('Location: homepage.php');
                        exit();
                    }
                
                
            }
        }
        else{
            header('Location: login.php');
            exit();
        }
       
    }
    else 
    {
        header('Location: tp.html');
        exit();
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
                <form class="login100-form flex-sb flex-w" method="post" action="gupass.php?email=<?php echo $email ?>&token=<?php echo $token ?>">
                <span class="login100-form-title p-b-53"><img src="icon.png" style="max-width:30%;"alt="Brand Logo"><p>Remedium</p></span>

					<div class="p-b-9" style="width:100%;">
						<span class="txt1">
                            <p>Please Provide the below Information for Registering You in our Database!</p>
							<?php if ($msg != "") echo $msg; ?>
						</span>
						
                    </div>

					<div class="p-t-13 p-b-9 m-t-17">
						<span class="txt1">
							Password
						</span>

					</div>
					<div class="wrap-input100">
						<input class="input100" minlength="5" name="password" type="password" placeholder="Password">
                    </div>
                    
                    <div class="p-t-13 p-b-9 m-t-17">
						<span class="txt1">
							Confirm Password
						</span>

					</div>
					<div class="wrap-input100">
						<input class="input100" minlength="5" name="cPassword" type="password" placeholder="Confirm Password">
                    </div>
                    
                    <div class="p-t-13 p-b-9 m-t-17">
						<span class="txt1">
                            Contact Number
						</span>

					</div>
					<div class="wrap-input100">
						<input class="input100" name="contactno" type="tel" minlength="10" maxlength="10" pattern="[0-9]{10}" placeholder="Contact Number">
                    </div>
                    
                    <div class="p-t-13 p-b-9 m-t-17">
						<span class="txt1">
							Location
						</span>

					</div>
					<div class="wrap-input100">
                        <input class="input100" minlength="1" name="location" type="text" placeholder="Location" >
                    </div>
                    
					<div class="container-login100-form-btn m-t-17">
						<input class="login100-form-btn a1" type="submit" name="submit" value="Sign Up">
					</div>

					
				</form>
            </div>
        </div>

</body>
</html>