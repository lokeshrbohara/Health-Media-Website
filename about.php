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
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
<link rel="stylesheet" type="text/css" href="nav.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&family=Dancing+Script&family=Indie+Flower&family=Maven+Pro&family=Righteous&family=Sansita+Swashed&display=swap" rel="stylesheet">
<style>
html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  margin: 8px;
}

.about-section {
  padding: 50px;
  text-align: center;
  background-color: #A9A9A9;
  color: white;
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}


@media screen and (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}
</style>
</head>
<body>
<header>
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
                    <li><a style="display:flex; white-space:nowrap; color:#f44336;" href="homepage.php"><i class="fas fa fa-home"></i>&nbsp;Home</a></li>
                    <li><a style="display:flex; white-space:nowrap;" href="doctor.php"><i class="far fa fa-user-md"></i>&nbsp;Doctors</a></li>
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

      <hr style="color: white">
<div class="about-section">
  <h1 style="font-family: 'Caveat', cursive; font-size: 55px; color: #655967">Remedium</h1>
  <p style="font-family: 'Dancing Script', cursive; font-size: 25px; color: #322D31">Remedium, is an online health website, where the aim is to provide users medical assistance, in the best and easiest way possible</p>
</div>
<br>
<h2 style="text-align:center;font-family: 'Sansita Swashed', cursive; color: #333333">Features Provided In Remedium</h2>
<br>
<div class="row">
  <div class="column">
    <div class="card" style="margin: auto">
      <img src="doctors.png" alt="Find Doctors" style="width:100%">
      <div class="container">
        <h2 style="font-family: 'Righteous', cursive;">Find Doctors</h2>
        <p style="font-family: 'Maven Pro', sans-serif;">Users can search for doctors in their desired location.</p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card" style="margin: auto">
      <img src="discuss.png" alt="Discussion Forum" style="width:100%">
      <div class="container">
        <h2 style="font-family: 'Righteous', cursive;">Discussion Forum</h2>
        <p style="font-family: 'Maven Pro', sans-serif;">One can discuss with other users and doctors in the discussion forum.</p>
      </div>
    </div>
  </div>
  
  <div class="column">
    <div class="card" style="margin: auto;">
      <img src="report.jpg" alt="Report Tracker" style="width:100%">
      <div class="container">
        <h2 style="font-family: 'Righteous', cursive;">Report Tracker</h2>
        <p style="font-family: 'Maven Pro', sans-serif;">Upload and store all your medical reports.</p>      
      </div>
    </div>
  </div>
</div>
<br><br>

  <footer style="text-align: center; background-color: #f2f2f2">
    <table style="margin: auto;">
      <thead>
        <th style="padding: 5px;padding-top: 10px;text-align: left">Patients</th>
        <th style="padding: 5px;padding-top: 10px;text-align: left">Doctors</th>
        <th style="padding: 5px;padding-top: 10px;text-align: left">Social</th>
      </thead>
      <tr>
      <td style="padding: 5px;text-align: left">Report Tracker</td>

      <td style="padding: 5px;text-align: left">Check Patient's Reports</td>
      <td style="padding: 5px;text-align: left">Facebook</td>
    </tr>
    <tr>
      <td style="padding: 5px;text-align: left">Find Doctors</td>

      <td style="padding: 5px;text-align: left">Confirm Appointments</td>
      <td style="padding: 5px;text-align: left">LinkedIn</td>
    </tr>
    <tr>
      <td style="padding: 5px;text-align: left">Discuss With Doctors</td>

      <td style="padding: 5px;text-align: left">Discuss With Patients</td>
      <td style="padding: 5px;text-align: left">Instagram</td>
    </tr>
    <tr>
      <td style="padding: 5px;text-align: left">Discussion Forum</td>

      <td style="padding: 5px;text-align: left">Discussion Forum</td>
      <td style="padding: 5px;text-align: left">Twitter</td>
    </tr>
    <tr>
      <td></td>

      <td></td>
    </tr>
    </table>
    <br><br>


   <p style="margin-bottom: 5px"> Created by Binu, Lokesh and Zenden 
    <i class="fas fa-grin-alt"></i><p>
  </footer>

</body>
</html>
