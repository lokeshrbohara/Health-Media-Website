<?php

//$_SESSION['email']="lokeshramdevbohara999@gmail.com";
session_start();
if(!isset($_SESSION['email']))
{
	header("location: login.php");
	exit();
}
include_once "config.php";
$email=$_SESSION['email'];
use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['submitapp']))
{
	$iddoc=$_POST['docid'];
	$date_field = strftime('%Y-%m-%dT%H:%M:%S', strtotime($_POST['appdate']));
	$details=$_POST['appadd'];

	$s = mysqli_query($con, "SELECT * FROM doctors where id='$iddoc'");   
	$datad = mysqli_fetch_array($s);
	$demail=$datad['email'];


	$con->query("INSERT INTO appointments(d_id, email, date, details) VALUES('$iddoc','$email','$date_field','$details')");

	include_once "PHPMailer/PHPMailer.php";

	require_once "PHPMailer/PHPMailer.php";
	require_once "PHPMailer/SMTP.php";
	require_once "PHPMailer/Exception.php";
	$mail = new PHPMailer();
	//SMTP Settings
	include_once "smtp.php";
	
	//Email Settings
	$mail->isHTML(true);
	$mail->setFrom($demail);
	$mail->addAddress($demail);
	$mail->Subject =  "New Appointment Booked!";
	$date=$date_field;
	$uemail=$email;
	$dname=$datad['name'];
	$rsn=$details;
	$mail->Body = "
		Hello Dr. $dname,<br>a New Appointment has been booked for date: $date With Email : $uemail, with the following deatil(s):<br><br>
		
		Details : $rsn;
	";

	if ($mail->send())
	{
		echo '<script language="javascript">';
		echo 'alert("Appointment Booked Successfully")';
		echo '</script>';
	}
	else
	{
		echo '<script language="javascript">';
		echo 'alert("Appointment Not Booked, Please try again!")';
		echo '</script>';
	}


	

}

?>
<!doctype html>
<html lang="en">
  <head>
  		<title>Doctors</title>
	    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="doctor.css">

		<link rel="stylesheet" type="text/css" href="nav.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
		<link rel="stylesheet" type="text/css" href="discussion.css">
		<style type="text/css">
	    	

	    </style>	
  </head>
  <body>
  	
  <header style="height: 15%;">
	<div class="brand-logo" style="display:-webkit-box;">

		<a href="#"><img src="icon.png" style="max-width:80%;"alt="Brand Logo"></a>
		<div style="font-size: 30px;font-family: 'Lobster', cursive; margin-inline-start: 20px;">
		Remedium
		</div>

	</div>

	<input type="checkbox" id="toggle-btn">
	<label for="toggle-btn" class="show-menu-btn"><i class="fas fa-bars"></i></label>

	<nav>
	<ul class="navigation">
		<li><a style="display:flex; white-space:nowrap;" href="homepage.php"><i class="fas fa fa-home"></i>&nbsp;Home</a></li>
		<li><a style="display:flex; white-space:nowrap; color:#f44336;" href="doctor.php"><i class="far fa fa-user-md"></i>&nbsp;Doctors</a></li>
		<li><a style="display:flex; white-space:nowrap;" href="discussion.php"><i class="fas fa fa-comments"></i>&nbsp;Lets Discuss</a></li>
		<li><a style="display:flex; white-space:nowrap;" href="predictor.php"><i class="fa fa-thermometer-half"></i>&nbsp;Check Up</a></li>
		<li><a style="display:flex; white-space:nowrap;" href="about.php"><i class="fab fa fa-info-circle"></i>&nbsp;About Us</a></li>
		<li><a style="display:flex; white-space:nowrap;" href="report.php"><i class="fa fa-book"></i>&nbsp;Reports</a></li>
		<li><a style="display:flex; white-space:nowrap;" href="<?php if($_SESSION['isdoctor']) echo 'doctordash.php'; else echo 'appointments.php'; ?>"><i class="fa fa-id-card"></i>&nbsp;Appointments</a></li>

		<li><a style="display:flex; white-space:nowrap;" href="logout.php"><button style="background-color: transparent; border: 1.5px solid #f2f5f7; border-radius: 2em; padding: 0.6rem 0.8rem; margin-left: 2vw; font-size: 1rem; cursor: pointer; color:white; margin-top:-10px">Logout</button></a></li>
		<label for="toggle-btn" class="hide-menu-btn"><i class="fas fa-times"></i></label>
	</ul>
	</nav>
</header>
<br>
<br>
  
<div class="container-login100" style="background-color:#f2f2f2;">
	<div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33" style="width:80%;">
        <span class="login100-form-title p-b-53">Search Doctors</span>

		<form action="doctor.php" method="post">
			
			<div  class="PKhmud tzVsfd F9PbJd IJRrpb"  style="width: 40%;">
				
				<input type="text" name="speciality" style="overflow:auto; border:none; width:-webkit-fill-available;" placeholder="Speciality" />
			
			</div>
			<div  class="PKhmud tzVsfd F9PbJd IJRrpb" style="width: 40%; float:right;">
				
				<input type="text" name="location" style="overflow:auto; border:none; width:-webkit-fill-available;" placeholder="Location" />
			
			</div>
			<br>
			<div class="container-login100-form-btn m-t-17">
				<input class="login100-form-btn a1" type="submit" name="submit" value="Find">
			</div>
			
        </form>
        

	</div>
</div>
<br>
<br>
<div class="container mt-2">
			
	<div class="row">
		<?php

			
			

			if(isset($_POST['submit']))
			{
				$location=$_POST['location'];
				$speciality=$_POST['speciality'];

				$sql = mysqli_query($con, "SELECT * FROM doctors where isEmailVerified=1 and isVerified=1 and location like '%$location%' and speciality like '%$speciality%'");
				
				while($data = mysqli_fetch_array($sql)) 
				{
					
					$id=$data['id'];
					?>
							
				
							<div class="col-md-3 col-sm-6">
								<div class="card card-block">
							
									<img class="wert" src="data:image/jpeg;base64,<?php $p = base64_encode( $data['image'] ); echo $p;?>" alt="Doctor Photo">
									<h5 style="margin:auto;" class="card-title mt-3 mb-3">Dr. <?php echo $data['name']; ?></h5>
									<p style="margin:auto; width:90%; text-align:center;" class="card-text">Degree: <?php echo $data['degree']; ?><br>Speciality:  <?php echo $data['speciality']; ?><br>Location:  <?php echo $data['location']; ?><br> </p> 
									<div style="margin:auto;">
										<button onclick="location.href='docviewer.php?id=<?php echo $data['id']?>';" style="margin-left: 5px; margin-right: 5px; margin-bottom: 5px; padding: revert; border-radius: 5px;">Document</button>
										<button style="margin-left: 5px; margin-right: 5px; margin-bottom: 5px; padding: revert; border-radius: 5px;" onclick="modaldisplay(<?php echo $data['id']; ?>)" id="myBtn<?php echo $data['id']; ?>">Appointment</button>
									</div>
								</div>
							</div>
							
						
					

								
					
					<?php
					
				}
			}





		?>
	</div>
					
</div>

<div class="modal" id="myModal">
				
</div>
<br>
<br>
<script id="ty111" type="text/html">
	<div class="modal-content">
		
		<!-- Modal Header -->
		<div class="modal-header">
		<span class="close">&times;</span>
		<h2 style="margin-top: 20px; margin-left: 20px;">Book An Appointment</h4>
		</div>


		
		
		<form action="doctor.php" method="post">
		<!-- Modal body -->
		<div class="modal-body">
		
			<div  class="PKhmud tzVsfd F9PbJd IJRrpb" style="width: 80%;">
				<input style="border:none; width:-webkit-fill-available;" name="appdate" type="datetime-local" min="<?php echo strftime('%Y-%m-%dT%H:%M'); ?>">
			</div>
			<div  class="PKhmud tzVsfd F9PbJd IJRrpb" style="width: 80%;">
			<span>
				<input type="text" style="border:none; overflow:auto; margin-top:auto; width:-webkit-fill-available;" name="appadd" placeholder="Anything else you wish to Add..." />
			</span>

			</div>

		</div>
		
		<!-- Modal footer -->
		<div class="modal-footer">
			<input type="hidden" name="docid" id="setid" value="<?php echo $data['id']; ?>">
			<input class="login100-form-btn a1" type="submit" name="submitapp" value="Book">

		</div>
		</form>
	</div>

	


</script>


<script>

	function modaldisplay(ids){

        document.getElementById("myModal").innerHTML = document.getElementById("ty111").innerHTML;
		document.getElementById("setid").value=ids;


		// Get the modal
		var modal = document.getElementById("myModal");

		// Get the button that opens the modal
		var btn = document.getElementById("myBtn"+ids);

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks the button, open the modal 
	
		modal.style.display = "block";
		

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		modal.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
		}
	}
</script>

</body> 
</html> 