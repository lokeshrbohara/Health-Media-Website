<?php
    $msg="";
    $emailerr="";
    session_start();
    if(isset($_SESSION["email"])){
        header('Location: index.php');
        exit();
        
    }
    use PHPMailer\PHPMailer\PHPMailer;
    if(isset($_POST['submit']))
    {
        include_once "config.php";

        $name=$con->real_escape_string($_POST['name']);
        $email=$con->real_escape_string($_POST['email']);
        $password=$con->real_escape_string($_POST['password']);
        $cPassword=$con->real_escape_string($_POST['cPassword']);
        $location=$con->real_escape_string($_POST['location']);
        $contactno=$con->real_escape_string($_POST['contactno']);

        
        if ($name == "")
            $msg = "<div class=\"alert alert-danger\">Name is required, try again.</div>";
        else if(!preg_match("/^[a-zA-Z ]*$/",$name)) 
            $msg = "<div class=\"alert alert-danger\">Only letters and white space allowed for Name</div>"; 
        else if ($email == "")
            $msg = "<div class=\"alert alert-danger\">Email ID is required, try again.</div>";
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $msg = "<div class=\"alert alert-danger\">Invalid email format</div>";
        else if ($password == "")
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


			$sql = $con->query("SELECT id FROM users WHERE email='$email'");
			if ($sql->num_rows > 0) {
				$msg = "<div class=\"alert alert-danger\">Email already exists in the database!</div>";
			} else {
				$token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
				$token = str_shuffle($token);
				$token = substr($token, 0, 10);

				$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

				$con->query("INSERT INTO users(name,email,passwordhash,isEmailVerified,token,location,contact) VALUES ('$name', '$email', '$hashedPassword', 0, '$token','$location','$contactno')");

                include_once "PHPMailer/PHPMailer.php";

                require_once "PHPMailer/PHPMailer.php";
                require_once "PHPMailer/SMTP.php";
                require_once "PHPMailer/Exception.php";

                $mail = new PHPMailer();
                
                //SMTP Settings
                include_once "smtp.php";
        
                //Email Settings
                $mail->isHTML(true);
                $mail->setFrom($email);
                $mail->addAddress($email, $name);
                $mail->Subject =  "Please verify email!";
                $mail->Body = "
                    Please click on the link below:<br><br>
                    
                    <a href='http://localhost/ip/confirm.php?email=$email&token=$token'>Click Here</a>
                ";

                if ($mail->send())
                    $msg = "<div class=\"alert alert-success\">You have been registered! Please verify your email!</div>";
                else
                    $msg = "<div class=\"alert alert-danger\">Something wrong happened! Please try again!</div>" ;
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
                <form class="login100-form flex-sb flex-w" method="post" action="register.php">
                    <span class="login100-form-title p-b-53"> Health Media</span>

					<div class="p-t-31 p-b-9" style="width:100%;">
						<span class="txt1">
							<?php if ($msg != "") echo $msg  ?>
						</span>
						
                    </div>

                    <div class="p-t-17 p-b-9">
                        <span class="txt1">
                            Name
                        </span>
                    </div>

                    <div class="wrap-input100">
						<input class="input100" minlength="3" name="name" placeholder="Name">
                    </div>

                    <div class="p-t-17 p-b-9 m-t-17">
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
                        <input class="input100" minlength="2" name="location" type="text" placeholder="Location" >
                    </div>
                    
					<div class="container-login100-form-btn m-t-17">
						<input class="login100-form-btn a1" type="submit" name="submit" value="Sign Up">
					</div>

					
				</form>
            </div>
        </div>

</body>
</html>