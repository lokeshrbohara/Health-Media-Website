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

        $name=$con->real_escape_string($_POST['name']);
        $email=$con->real_escape_string($_POST['email']);
        $password=$con->real_escape_string($_POST['password']);
        $cPassword=$con->real_escape_string($_POST['cPassword']);
        $location=$con->real_escape_string($_POST['location']);
        $contactno=$con->real_escape_string($_POST['contactno']);
        $degree=$con->real_escape_string($_POST['degree']);
        $speciality=$con->real_escape_string($_POST['speciality']);
        
    
        $phototype=$_FILES['photo']['type'];
        $photo=file_get_contents($_FILES['photo']['tmp_name']);
        $photo=addslashes($photo);

        $doctype=$_FILES['documents']['type'];
        $documents=file_get_contents($_FILES['documents']['tmp_name']);
        $documents=addslashes($documents);

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
        else if ($degree=="")
            $msg = "<div class=\"alert alert-danger\">Please mention your Degree.</div>"; 
        else if ($speciality=="")
            $msg = "<div class=\"alert alert-danger\">Please mention your speciality.</div>";  
        else if (!$photo)
            $msg = "<div class=\"alert alert-danger\">Photo is required, try again.</div>";
        else if (!in_array($phototype, ['image/jpg','image/jpeg','image/png']))
            $msg = "<div class=\"alert alert-danger\">Photo type should be of jpeg, jpg or png only, try again.</div>";
        else if (!$documents)
            $msg = "<div class=\"alert alert-danger\">Document are required, try again.</div>";
        else if ($doctype!=='application/pdf')
            $msg = "<div class=\"alert alert-danger\">Document should be in pdf format, try again.</div>";
        
        
		else {


			$sql = $con->query("SELECT id FROM doctors WHERE email='$email'");
			if ($sql->num_rows > 0) {
				$msg = "<div class=\"alert alert-danger\">Email already exists in the database!</div>";
            } 
            $s = $con->query("SELECT id FROM users WHERE email='$email'");
			if ($s->num_rows > 0) {
				$msg = "<div class=\"alert alert-danger\">Same Email Id used for User Registration cannot be used for Doctor Registration!</div>";
			} else {
				$token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
				$token = str_shuffle($token);
				$token = substr($token, 0, 10);

				$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

				$con->query("INSERT INTO doctors(name,email,passwordhash,isEmailVerified,token,location,contact,degree,speciality,image,documents) VALUES ('$name', '$email', '$hashedPassword', 0, '$token','$location','$contactno','$degree','$speciality','$photo','$documents')");

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
                    
                    <a href='http://localhost/ip/docconfirm.php?email=$email&token=$token'>Click Here</a>
                ";

                if ($mail->send())
                    $msg = "<div class=\"alert alert-success\">Registration process initiated! Please verify your email!</div>";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Doctor Registration</title>
</head>
<body>
        <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33">
                <form class="login100-form flex-sb flex-w" enctype="multipart/form-data" method="post" action="docreg.php">
				<span class="login100-form-title p-b-53"><img src="icon.png" style="max-width:40%;"alt="Brand Logo"><p>Remedium</p></span>
                    <span class="login100-form-title p-b-53">Doctor Registration</span>


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
						<input class="input100" minlength="3" required name="name" placeholder="Name">
                    </div>

                    <div class="p-t-17 p-b-9 m-t-17">
                        <span class="txt1">
                            Email Id
                        </span>
                    </div>

                    <div class="wrap-input100">
						<input class="input100" required name="email"  type="email" placeholder="Email Id">
                    </div>
                    
                    
					<div class="p-t-13 p-b-9 m-t-17">
						<span class="txt1">
							Password
						</span>

					</div>
					<div class="wrap-input100">
						<input class="input100" minlength="5" required name="password"  type="password" placeholder="Password">
                    </div>
                    
                    <div class="p-t-13 p-b-9 m-t-17">
						<span class="txt1">
							Confirm Password
						</span>

					</div>
					<div class="wrap-input100">
						<input class="input100" minlength="5" required name="cPassword"  type="password" placeholder="Confirm Password">
                    </div>
                    
                    <div class="p-t-13 p-b-9 m-t-17">
						<span class="txt1">
                            Contact Number
						</span>

					</div>
					<div class="wrap-input100">
						<input class="input100" required name="contactno" type="tel"  minlength="10" maxlength="10" pattern="[0-9]{10}" placeholder="Contact Number">
                    </div>
                    
                    <div class="p-t-13 p-b-9 m-t-17">
						<span class="txt1">
							Location
						</span>

					</div>
					<div class="wrap-input100">
                        <input class="input100" minlength="2"  required name="location" type="text" placeholder="Location" >
                    </div>

                    <div class="p-t-17 p-b-9 m-t-17">
                        <span class="txt1">
                            Degree
                        </span>
                    </div>

                    <div class="wrap-input100">
						<input class="input100" minlength="2" required name="degree" type="text" placeholder="Degree">
                    </div>
                    
                    <div class="p-t-17 p-b-9 m-t-17">
                        <span class="txt1">
                            Speciality
                        </span>
                    </div>

                    <div class="wrap-input100">
						<input class="input100" minlength="2" required name="speciality" type="text" placeholder="Speciality">
                    </div>

                    <div class="p-t-17 p-b-9 m-t-17">
                        <span class="txt1">
                            Upload Recent Photograph
                        </span>
                    </div>

                    <div class="wrap-input100">
                        <input  required onchange="previewFile()" class="input100 m-t-17" name="photo" type="file">
                        
                        <div style="display: flex; align-items: center; justify-content: center;" class="form-group">
                            <img src="" id="89"> 
                        </div>
              
                    </div>
                    <div class="p-t-17 p-b-9 m-t-17">
                        <span class="txt1">
                            Upload Required Documents in PDF Format
                        </span>
                    </div>

                    <div class="wrap-input100">
						<input required class="input100 m-t-17" name="documents" type="file" >
                    </div>

					<div class="container-login100-form-btn m-t-17">
						<input class="login100-form-btn a1" type="submit" name="submit" value="Sign Up">
					</div>

				</form>
            </div>
        </div>
<script>
    function previewFile(){
    var preview = document.getElementById('89'); //selects the query named img
    var file    = document.querySelector('input[type=file]').files[0]; //sames as here
    var reader  = new FileReader();
 
    reader.onloadend = function () {
        preview.style.height="auto";
        preview.style.width="80%";
        preview.src = reader.result;
    }
 
    if (file) {
        reader.readAsDataURL(file); //reads the data as a URL
    } else {
        preview.src = "";
    }
   }
</script>
</body>
</html>