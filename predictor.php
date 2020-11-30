<?php

	session_start();
    if(!isset($_SESSION['email']))
    {
        header('Location: login.php');
        exit();
    }

?>
<!DOCTYPE html> 
<html> 
<head> 
	<title>Disease Predictor</title> 
	<link rel="stylesheet" type="text/css" href="nav.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
	<link rel="stylesheet" type="text/css" href="discussion.css">
	


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
			<li><a style="display:flex; white-space:nowrap;" href="doctor.php"><i class="far fa fa-user-md"></i>&nbsp;Doctors</a></li>
			<li><a style="display:flex; white-space:nowrap;" href="discussion.php"><i class="fas fa fa-comments"></i>&nbsp;Lets Discuss</a></li>
			<li><a style="display:flex; white-space:nowrap; color:#f44336;" href="predictor.php"><i class="fa fa-thermometer-half"></i>&nbsp;Check Up</a></li>
			<li><a style="display:flex; white-space:nowrap;" href="about.php"><i class="fab fa fa-info-circle"></i>&nbsp;About Us</a></li>
			<li><a style="display:flex; white-space:nowrap;" href="report.php"><i class="fa fa-book"></i>&nbsp;Reports</a></li>
			<li><a style="display:flex; white-space:nowrap;" href="<?php if($_SESSION['isdoctor']) echo 'doctordash.php'; else echo 'appointments.php'; ?>"><i class="fa fa-id-card"></i>&nbsp;Appointments</a></li>

			<li><a style="display:flex; white-space:nowrap;" href="logout.php"><button style="background-color: transparent; border: 1.5px solid #f2f5f7; border-radius: 2em; padding: 0.6rem 0.8rem; margin-left: 2vw; font-size: 1rem; cursor: pointer; color:white; margin-top:-10px">Logout</button></a></li>
			<label for="toggle-btn" class="hide-menu-btn"><i class="fas fa-times"></i></label>
		</ul>
	</nav>
</header>


<div class="container-login100" style="background-color:#f2f2f2;">
	<div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33" style="width:80%;">
        <span class="login100-form-title p-b-53">Disease Predictor</span>

		<div class="pr">

			<div  class="PKhmud tzVsfd F9PbJd IJRrpb" style="width:-webkit-fill-available;">
				<div id="listdiv">
				</div>

				<input type="text" onkeyup="ac(this.value)" style="overflow:auto; border:none; width:-webkit-fill-available;" placeholder="Search the Symptoms" />
				<br><br>
				<!-- On keyup calls the function everytime a key is released -->
				<select style="width: 100%;border:none; overflow:auto;" onchange="listclick(event)" multiple id="selectlist"> 
				<!-- This data list will be edited through javascript	 -->
				</select> 
				<br><br>
			</div>
			<br>
			<div class="container-login100-form-btn m-t-17">
				<input class="login100-form-btn a1" onclick="predict()" type="submit" value="Predict">
			</div>
			
        </div>
        <div id="po89">
        </div>

	</div>
</div>
<script src="predictfinal.js"></script>
</body> 
</html> 
