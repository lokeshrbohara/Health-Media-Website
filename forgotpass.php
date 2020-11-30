<?php
    $msg="";
    session_start();
    if(isset($_SESSION["email"])){
        header('Location: index.php');
        exit();
        
    }
    use PHPMailer\PHPMailer\PHPMailer;
    if(isset($_POST['submit']))
    {
        include_once "config.php";

        $email=$con->real_escape_string($_POST['email']);

        if ($email == "")
			$msg = "Please check your inputs!";
		else {
			$sql = $con->query("SELECT id FROM users WHERE email='$email'");
			if ($sql->num_rows !=1) {
				$msg = "<div class=\"alert alert-primary\">You are not registered! <br> Please <a href='http://localhost/ip/register.php'>Register</a></div>";
			} else {
				$token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
				$token = str_shuffle($token);
				$token = substr($token, 0, 10);


				$con->query("UPDATE users SET token='$token' WHERE email='$email'");

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
                $mail->addAddress($email);
                $mail->Subject =  "Password change link!";
                $mail->Body = "
                    Please click on the link below:<br><br>
                    
                    <a href='http://localhost/ip/changepass.php?email=$email&token=$token'>Click Here</a>
                ";

                if ($mail->send())
                    $msg = "<div class=\"alert alert-success\">Mail Sent! Please Follow the Link sent on your Mail!</div>";
                else
                    $msg = "<div class=\"alert alert-danger\">Something wrong happened! Please try again!</div>" ;
			}
        }
        
    }
?>
<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Forgot Password</title>
</head>
<body>
    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-6 col-md-offset-3" align="center">
                <?php if($msg!="") echo $msg . "<br><br>"; ?>
                <form method="post" action="forgotpass.php">
					<input class="form-control" name="email" type="email" placeholder="Email"><br>
					<input class="btn btn-primary" name="submit" type="submit" value="Send Mail"><br>
				</form>
            </div>
        </div>
    </div>
</body>
</html>
-->

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
                <form class="login100-form flex-sb flex-w" method="post" action="forgotpass.php">
				<span class="login100-form-title p-b-53"><img src="icon.png" style="max-width:40%;"alt="Brand Logo"><p>Remedium</p></span>
                   

					<div class="p-t-31 p-b-9" style="width:100%;">
						<span class="txt1">
							<?php if ($msg != "") echo $msg  ?>
						</span>
						
					</div>

                    <div class="p-t-31 p-b-9">
                        <span class="txt1">
                            Email Id of the Account that you want to Recover
                        </span>
                    </div>

                    <div class="wrap-input100">
						<input class="input100" name="email" type="email" placeholder="Email Id">
                    </div>

                    <div class="container-login100-form-btn m-t-17">
						<input class="login100-form-btn a1" type="submit" name="submit" value="Send Mail">
					</div>

				</form>
            </div>
        </div>

</body>
</html>