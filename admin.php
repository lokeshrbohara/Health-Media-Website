<?php
    include_once "config.php";

    session_start();
   

    if (!isset($_SESSION['email']) && $_SESSION['isAdmin']!=1) {
        header('Location: adminlogin.php');
        exit();
    }

    
    $aemail=$_SESSION['email'];
    $sql = $con->query("SELECT * FROM admin WHERE email='$aemail'");
	if ($sql->num_rows <= 0) {
        
            header('Location: adminlogin.php');
            exit();
        
    }
    

    if(isset($_POST['id']))
    {
        $id=$_POST['id'];
        $con->query("UPDATE doctors set isVerified=1 where id='$id'");
        $sql = mysqli_query($con, "SELECT * FROM doctors where isEmailVerified=1 and isVerified=1 and id='$id'");
        if($data = mysqli_fetch_array($sql))
        $con->query("INSERT INTO users(name,email,passwordhash,isEmailVerified,token,location,contact,isdoctor) VALUES ('".$data['name']."', '".$data['email']."', '".$data['passwordhash']."', 1, '','".$data['location']."','".$data['contact']."',1)");

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
        flex-basis: 5%;
        }
        .responsive-table .col-2 {
        flex-basis: 15%;
        }
        .responsive-table .col-3 {
        flex-basis: 10%;
        }
        .responsive-table .col-4 {
        flex-basis: 22%;
        }
        .responsive-table .col-5 {
        flex-basis: 10%;
        }
        .responsive-table .col-6 {
        flex-basis: 10%;
        }
        .responsive-table .col-7 {
        flex-basis: 10%;
        }
        .responsive-table .col-8 {
        flex-basis: 10%;
        }
        .responsive-table .col-9 {
        flex-basis: 8%;
        }
        @media all and (max-width: 767px) {
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
            flex-basis: 50%;
            text-align: right;
        }
        }

    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Admin Dashboard</title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a href="#" class="navbar-brand"><img src="icon.png" style="max-width:10%;"alt="Brand Logo"> Remedium Admin</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div style="justify-content: flex-end;" class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav">
            <a href="http://localhost/ip/admin.php" class="nav-item nav-link active">Unverified</a>
            <a href="http://localhost/ip/verifieddoc.php" class="nav-item nav-link">Verified</a>
            <a href="http://localhost/ip/logout.php" class="nav-item nav-link">Logout</a>

        </div>
        
    </div>
</nav>  
<div style="margin-top:50px;" class="container">
  <h2>Unverified Doctors</h2>
  <ul class="responsive-table">
    <li class="table-header">
      <div class="col col-1" style="display: flex; align-items: center; justify-content: center; padding:5px;">Id</div>
      <div class="col col-2" style="display: flex; align-items: center; justify-content: center; padding:5px;">Name</div>
      <div class="col col-3" style="display: flex; align-items: center; justify-content: center; padding:5px;">Image</div>
      <div class="col col-4" style="display: flex; align-items: center; justify-content: center; padding:5px;">Email ID</div>
      <div class="col col-5" style="display: flex; align-items: center; justify-content: center; padding:5px;">Location</div>
      <div class="col col-6" style="display: flex; align-items: center; justify-content: center; padding:5px;">Degree</div>
      <div class="col col-7" style="display: flex; align-items: center; justify-content: center; padding:5px;">Speciality</div>
      <div class="col col-8" style="display: flex; align-items: center; justify-content: center; padding:5px;">Documents</div>
      <div class="col col-9" style="display: flex; align-items: center; justify-content: center; padding:5px;">Verify</div>
    </li>
    
    <?php

    $sql = mysqli_query($con, "SELECT * FROM doctors where isEmailVerified=1 and isVerified=0");
    while (($data = mysqli_fetch_array($sql))) 
    {
        $id=$data['id'];
    ?>

    <li class="table-row">
      <div class="col col-1" style="display: flex; align-items: center; justify-content: center; word-break: break-all;" data-label="Id"><?php echo $id ?></div>
      <div class="col col-2" style="display: flex; align-items: center; justify-content: center; white-space:normal;" data-label="Name"><?php echo $data['name'] ?></div>
      <div class="col col-3" style="display: flex; align-items: center; justify-content: center;" data-label="Image"><?php echo '<img style="height:90%; width:90%; border-radius: 10px;" src="data:image/jpeg;base64,'.base64_encode( $data['image'] ).'"/>' ?></div>
      <div class="col col-4" style="display: flex; align-items: center; justify-content: center; word-break: break-all;" data-label="Email ID"><?php echo $data['email'] ?></div>
      <div class="col col-5" style="display: flex; align-items: center; justify-content: center; white-space:normal;" data-label="Location"><?php echo $data['location'] ?></div>
      <div class="col col-6" style="display: flex; align-items: center; justify-content: center; white-space:normal;" data-label="Degree"><?php echo $data['degree'] ?></div>
      <div class="col col-7" style="display: flex; align-items: center; justify-content: center; white-space:normal;" data-label="Speciality"><?php echo $data['speciality'] ?></div>
      <div class="col col-8" style="display: flex; align-items: center; justify-content: center;" data-label="Documents"><button onclick="location.href='docviewer.php?id=<?php echo $data['id']?>';">Document</button></div>
      <div class="col col-9" style="display: flex; align-items: center; justify-content: center;" data-label="Verify"><button id="btn<?php echo $data['id'] ?>" onclick="verify(<?php echo $data['id']?>)">Verify</button></div>
    </li>


    <?php
    }


    ?>

  </ul>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script>

    function verify(id){
        if (confirm("You are Setting the Status of Doctor as Verified.")) {

            $("#btn"+id).attr("disabled", true);
            $.ajax({
                url : 'admin.php',
                type : "POST",
                data : ({id: id}),
                success : function(data) {
                
                    console.log(data);
                }
                
            });
        }
    }

</script>
</body>
</html>