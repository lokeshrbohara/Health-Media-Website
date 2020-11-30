<?php
    include_once "config.php";
    session_start();
    $msg="";
    $isDoc=$_SESSION['isdoctor'];
    
    if(!isset($_SESSION['email']) || $isDoc!=0)
    {
        header('Location: logout.php');
        exit();
    }
      
    use PHPMailer\PHPMailer\PHPMailer;

    if(isset($_POST['id']))
    {
  
        $id=$_POST['id'];
        $reason="Deleted: ".$_POST['reason'];
        
        if(empty($reason))
        {
            echo '<script id="tyru" language="javascript">';
            echo 'alert("Please specify the reason!")';
            echo '</script>';
           
        }
        else{
            $con->query("UPDATE appointments SET details='$reason', isactive=0 WHERE id='$id'");
            $sql = mysqli_query($con, "SELECT * FROM appointments where  id='$id'");
            $data = mysqli_fetch_array($sql);
            
            $d_id=$data['d_id'];
            $s = mysqli_query($con, "SELECT * FROM doctors where id='$d_id'");   
            $datad = mysqli_fetch_array($s);
            include_once "PHPMailer/PHPMailer.php";

            require_once "PHPMailer/PHPMailer.php";
            require_once "PHPMailer/SMTP.php";
            require_once "PHPMailer/Exception.php";
            $demail=$datad['email'];
            $mail = new PHPMailer();
            //SMTP Settings
            include_once "smtp.php";
            
            //Email Settings
            $mail->isHTML(true);
            $mail->setFrom($demail);
            $mail->addAddress($demail);
            $mail->Subject =  "Appointment Cancelled!";
            $date=$data['date'];
            $uemail=$data['email'];
            $dname=$datad['name'];
            $rsn=$_POST['reason'];
            $mail->Body = "
                Hello Dr. $dname,<br>Your Appointment dated: $date With Email : $uemail, has been canceled for the following reason(s):<br><br>
                
                Reason : $rsn;
            ";

            if ($mail->send())
                $msg = "<div class=\"alert alert-success\">Mail Sent! Please Follow the Link sent on your Mail!</div>";
            else
                $msg = "<div class=\"alert alert-danger\">Something wrong happened! Please try again!</div>" ;
        
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
        font-family: 'lato', sans-serif;
        }

        .col {
        position: relative;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        min-width: 0;
        }
        .container {
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
        padding-left: 10px;
        padding-right: 10px;
        }

        h2 {
        font-size: 26px;
        margin: 20px 0;
        text-align: center;
        }
        h2 small {
        font-size: 0.5em;
        }

        .responsive-table li {
        border-radius: 3px;
        padding: 25px 30px;
        display: flex;
        justify-content: space-between;
        margin-bottom: 25px;
        }
        .responsive-table .table-header {
        background-color: #95A5A6;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        }
        .responsive-table .table-row {
        background-color: #ffffff;
        box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.1);
        }
        .responsive-table .col-1 {
        flex-basis:15%;
        }
        .responsive-table .col-2 {
        flex-basis: 21%;
        }
        .responsive-table .col-3 {
        flex-basis: 10%;
        }
        .responsive-table .col-4 {
        flex-basis: 8%;
        }
        .responsive-table .col-5 {
        flex-basis: 14%;
        }
       
        .responsive-table .col-7 {
        flex-basis: 11%;
        }
        .responsive-table .col-8 {
        flex-basis: 10%;
        }
        .responsive-table .col-9 {
        flex-basis: 11%;
        }
        @media screen and (max-width: 767px) {
        .responsive-table .table-header {
            display: none;
        }
        .responsive-table li {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            
        }
        .responsive-table .col {
            flex-basis: 100%;
            word-break:unset !important;
        }
        .responsive-table .col {
            display: flex;
            padding: 10px 0;
        }
        .responsive-table .col:before {
            color: #6C7A89;
            padding-right: 10px;
            content: attr(data-label);
            
            text-align: right;
        }
        }


    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">

    <link rel="stylesheet" type="text/css" href="discussion.css">
    <link rel="stylesheet" type="text/css" href="nav.css">

    <title>Appointments</title>
</head>
<body>
<header style="height: 15%; margin-bottom:50px;">
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
		<li><a style="display:flex; white-space:nowrap;" href="predictor.php"><i class="fa fa-thermometer-half"></i>&nbsp;Check Up</a></li>
		<li><a style="display:flex; white-space:nowrap;" href="about.php"><i class="fab fa fa-info-circle"></i>&nbsp;About Us</a></li>
		<li><a style="display:flex; white-space:nowrap;" href="report.php"><i class="fa fa-book"></i>&nbsp;Reports</a></li>
		<li><a style="display:flex; white-space:nowrap; color:#f44336;" href="appointments.php"><i class="fa fa-id-card"></i>&nbsp;Appointments</a></li>

		<li><a style="display:flex; white-space:nowrap;" href="logout.php"><button style="background-color: transparent; border: 1.5px solid #f2f5f7; border-radius: 2em; padding: 0.6rem 0.8rem; margin-left: 2vw; font-size: 1rem; cursor: pointer; color:white; margin-top:-10px">Logout</button></a></li>
		<label for="toggle-btn" class="hide-menu-btn"><i class="fas fa-times"></i></label>
	</ul>
	</nav>
</header>
<?php if ($msg != "") echo $msg  ?>

<div class="container" style="margin-top:-20px;">
  <h2>Your Appointments</h2>
  <ul class="responsive-table">
    <li class="table-header">
      <div class="col col-1" style="display: flex; align-items: center; justify-content: center; padding:5px;">Dr. Name</div>
      <div class="col col-2" style="display: flex; align-items: center; justify-content: center; padding:5px; word-break:break-all;">Email ID</div>
      <div class="col col-3" style="display: flex; align-items: center; justify-content: center; padding:5px;">Dr. Image</div>
      <div class="col col-4" style="display: flex; align-items: center; justify-content: center; padding:5px;">Location</div>
      <div class="col col-5" style="display: flex; align-items: center; justify-content: center; padding:5px;">Details</div>
      <div class="col col-7" style="display: flex; align-items: center; justify-content: center; padding:5px;">Date and Time</div>
      <div class="col col-8" style="display: flex; align-items: center; justify-content: center; padding:5px;">Delete</div>
      <div class="col col-9" style="display: flex; align-items: center; justify-content: center; padding:5px;">Reason</div>
    </li>
    <div id="appointmentstable">
    <?php
    $email=$_SESSION['email'];
    $sql = mysqli_query($con, "SELECT * FROM appointments where email='$email' and isactive=1");
    while (($data = mysqli_fetch_array($sql))) 
    {
        $d_id=$data['d_id'];
        $s = mysqli_query($con, "SELECT * FROM doctors where id='$d_id'");   
        $datad = mysqli_fetch_array($s)
    ?>

    <li class="table-row">
      <div class="col col-1" style="display: flex; align-items: center; justify-content: center; " data-label="Name"><?php echo $datad['name'] ?></div>
      <div class="col col-2" style="display: flex; align-items: center; justify-content: center; white-space:normal; word-break: break-all;" data-label="Email"><?php echo $datad['email'] ?></div>
      <div class="col col-3" style="display: flex; align-items: center; justify-content: center; max-width:25%;" data-label="Image"><?php echo '<img style="height:90%; width:90%; border-radius: 10px;" src="data:image/jpeg;base64,'.base64_encode( $datad['image'] ).'"/>' ?></div>
      <div class="col col-4" style="display: flex; align-items: center; justify-content: center; " data-label="Location"><?php echo $datad['location'] ?></div>
      <div class="col col-5" style="display: flex; align-items: center; justify-content: center; white-space:normal;" data-label="Details"><?php echo $data['details'] ?></div>
      <div class="col col-7" style="display: flex; align-items: center; justify-content: center; white-space:normal;" data-label="Date and Time"><?php echo $data['date'] ?></div>
      <div class="col col-8" style="display: flex; align-items: center; justify-content: center;" data-label="Delete"><button id="btn<?php echo $data['id'] ?>" onclick="deleteapp(<?php echo $data['id']?>)">Delete</button></div>
      <div class="col col-9" style="display: flex; align-items: center; justify-content: center;" data-label="Reason"><input style="width:-webkit-fill-available;" id="reason<?php echo $data['id'] ?>" type="text" placeholder="Reason"></div>
    </li>


    <?php
    }


    ?>

  </ul>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script>

    function deleteapp(id){

        if($("#reason"+id).val()===""){
            alert("Please specify the Reason");
        }
        else if(confirm("You are deleting your Appointment.")) {
            var rsn = $("#reason"+id).val();
            
            $("#btn"+id).attr("disabled", true);
            $.ajax({
                url : 'appointments.php',
                type : "POST",
                data : {id: id, reason: rsn},
                success : function(data) {
                    console.log(data);
                    $('#appointmentstable').replaceWith($('#appointmentstable',data));
                }
                
            });
        }
    }



</script>
</body>
</html>