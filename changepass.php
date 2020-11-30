<?php
    $msg="";
    function redirect() {
        header('Location: login.php');
        exit();
    }

    if(isset($_GET["email"]) && isset($_GET["token"])){
        include_once "config.php";
        $email = $con->real_escape_string($_GET['email']);
        $token = $con->real_escape_string($_GET['token']);
        $sql = $con->query("SELECT id FROM users WHERE email='$email' AND token='$token' AND isEmailVerified=1");

        if($sql->num_rows > 0){
            if(isset($_POST['submit'])){
                
                include_once "config.php";
                        
                $password = $con->real_escape_string($_POST['password']);
                $cPassword = $con->real_escape_string($_POST['cPassword']);
        
        
                if ($password!="" && $password==$cPassword) {
                    $hash = password_hash($password,PASSWORD_BCRYPT);
                    $con->query("UPDATE users SET token='', passwordhash='$hash' WHERE email='$email'");
                    $msg = '<div class="alert alert-success">Password Changed Successfully!</div>';
                
                } else
                {
                    $msg = '<div class="alert alert-danger">Please check your inputs!</div>';
        
                }
                
        
            }
           
        }
        else
            redirect();
      
		
    }
    else redirect();
	
    
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
                <form class="login100-form flex-sb flex-w" method="post" action="changepass.php?email=<?php echo $email ?>&token=<?php echo $token ?>">
                <span class="login100-form-title p-b-53"><img src="icon.png" style="max-width:40%;"alt="Brand Logo"><p>Remedium</p></span>
                   

					<div class="p-t-31 p-b-9" style="width:100%;">
						<span class="txt1">
							<?php if ($msg != "") echo $msg  ?>
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

                    <div class="container-login100-form-btn m-t-17">
						<input class="login100-form-btn a1" type="submit" name="submit" value="Change Password">
					</div>

				</form>
            </div>
        </div>

</body>
</html>