<?php
    include_once "config.php";
  
    session_start();
    $msg='';
   
    $email=$_SESSION['email'];
    if(isset($_SESSION['email']))
    {
      if(isset($_POST["submit"]))
      {
          $reportname=$_POST['reportname'];
          $reportpara=$_POST['para'];
          $medicine=$_POST['medi'];

          $filename=$_FILES['file1']['name'];
          $filetype=$_FILES['file1']['type'];
          if($filetype==="application/pdf")
          {
            $data=file_get_contents($_FILES['file1']['tmp_name']);
            $data=addslashes($data);
            try
            {
              $email=$_SESSION['email'];
              $con->query("INSERT INTO report(reportname, reportparameter, medicine, pdf, email) VALUES ('$reportname', '$reportpara','$medicine', '$data', '$email')");
            }
            catch(Exception $e)
            {
              $msg="<div class=\"alert alert-danger\">Data not Inserted into Database! Please keep the PDF size below 16MB '.$e->getMessage().'</div>";
            }
          }
          else
          $msg="<div class=\"alert alert-danger\">Please Upload files only in pdf format!</div>";
          
          
          
  
      }
     
    }
   
    else
    {
    header('Location: login.php');
    exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="nav.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<style>
  
.wrapper-flex {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}
html {
    position: relative;
    min-height: 100%;
}
footer {
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  color: black;
  overflow: hidden;

}

</style>

</head>
<body>
        <header style="margin-bottom:50px;">
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
                    <li><a style="display:flex; white-space:nowrap; color:#f44336;" href="report.php"><i class="fa fa-book"></i>&nbsp;Reports</a></li>
                    <li><a style="display:flex; white-space:nowrap;" href="<?php if($_SESSION['isdoctor']) echo 'doctordash.php'; else echo 'appointments.php'; ?>"><i class="fa fa-id-card"></i>&nbsp;Appointments</a></li>


                    <li><a style="display:flex; white-space:nowrap;" href="logout.php"><button style="background-color: transparent; border: 1.5px solid #f2f5f7; border-radius: 2em; padding: 0.6rem 0.8rem; margin-left: 2vw; font-size: 1rem; cursor: pointer; color:white; margin-top:-10px">Logout</button></a></li>
                    <label for="toggle-btn" class="hide-menu-btn"><i class="fas fa-times"></i></label>
                </ul>
            </nav>
        </header>
  
  <h1 class="text-center">YOUR REPORTS</h1>
  <?php if($msg!='') echo $msg; ?>
  
  
  <br>
  <br>

  <div class="container" style="text-align: center">
  <div class="content" style="text-align: center">
    <div class="row">
      <div class="col-md-8" style="margin:auto;">
        <div class="card center">
          <div class="card-header">
            <h5 class="title">Upload Your Report to Database</h5>
          </div>
          <div class="card-body">
            <form  method="post" enctype="multipart/form-data" action='report.php'>
              <div class="row justify-content-around mb-2">
                <div class="column" >
                  <div class="col-md-5 pr-md-1">
                    <div>
                        <input  type="file" name="file1">
                    </div>
                  </div>
                 
                </div>
                
                <div class="col-md-5 pr-md-1">
                  <div class="form-group">
                    <label>Report Name</label>
                    <input type="text" name="reportname" class="form-control" ></input>
                  </div>
                </div>
                
                <div class="col-md-5 pr-md-1">
                  <div class="form-group">
                    <label>Report Parameter</label>
                    <input type="text" name="para" class="form-control" ></input>
                  </div>
                </div>
                
                <div class="col-md-5 pr-md-1">
                  <div class="form-group">
                    <label>Medicine Prescribed</label>
                    <input type="text" name="medi" class="form-control" ></input>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-fill btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
 
 
  <div class="wrapper-flex">
<?php

    $email=$_SESSION['email'];
    $sql = mysqli_query($con, "SELECT id, reportname FROM report where email='$email'" );
    while (($data = mysqli_fetch_array($sql))) 
    {
        $id=$data['id'];
        $rname=$data['reportname'];
?>
  
    
    <a target="_blank" class="q" href='reportviewer.php?id=<?php echo $id ?>' style="color: black">
      <br>
        <div style="text-align:center;border : 0.5px solid black; border-radius:5px; padding: 10px; margin: 5px;" >
          <h1 style="float: left; width:100%;"><?php echo $rname ?></h1>
        <img src="reporticon.png" alt="Avatar" style="width:30%;height: 30%; float: center">
            
        </div>
    </a>
  
 
<?php
    }
    
  
?>
     </div>
     <br><br>
    

<div style="clear:both; height:500px;"></div>


<footer style="text-align: center; background-color: #f2f2f2">
    <table style="margin: auto; margin-top:10px; border-spacing: 30px 0;">
      <thead>
        <th style="padding: 5px 100px; padding-top: 10px;">Patients</th>
        <th style="padding: 5px 100px; padding-top: 10px;">Doctors</th>
        <th style="padding: 5px 100px; padding-top: 10px;">Social</th>
      </thead>
      <tr>
      <td style="padding: 5px;">Report Tracker</td>

      <td style="padding: 5px;">Check Patient's Reports</td>
      <td style="padding: 5px;">Facebook</td>
    </tr>
    <tr>
      <td style="padding: 5px;">Find Doctors</td>

      <td style="padding: 5px;">Confirm Appointments</td>
      <td style="padding: 5px;">LinkedIn</td>
    </tr>
    <tr>
      <td style="padding: 5px;">Discuss With Doctors</td>

      <td style="padding: 5px;">Discuss With Patients</td>
      <td style="padding: 5px;">Instagram</td>
    </tr>
    <tr>
      <td style="padding: 5px;">Discussion Forum</td>

      <td style="padding: 5px;">Discussion Forum</td>
      <td style="padding: 5px;">Twitter</td>
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
  

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>










