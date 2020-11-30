<?php
  include_once "config.php";
  session_start();
  if(!isset($_SESSION['email']))
    {
        header('Location: login.php');
        exit();
    }
  $email=$_SESSION['email'];
  $msg="";
  if(isset($_POST["ask"]))
  {
      $heading=$con->real_escape_string($_POST['heading']);
      $description=$con->real_escape_string($_POST['description']);
      $con->query("INSERT INTO questions(email,heading,description,posttime) VALUES ('$email', '$heading','$description',now())");

  }
  
?>
<!DOCTYPE html>
<head>
      <link rel="stylesheet" type="text/css" href="homepage.css">
      <link rel="stylesheet" type="text/css" href="nav.css">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="discussion.css">
    <title>Discussion</title>
    <style>
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
<body style="background-color: #f2f2f2;">
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
              <li><a style="display:flex; white-space:nowrap; color:#f44336;" href="discussion.php"><i class="fas fa fa-comments"></i>&nbsp;Lets Discuss</a></li>
              <li><a style="display:flex; white-space:nowrap;" href="predictor.php"><i class="fa fa-thermometer-half"></i>&nbsp;Check Up</a></li>
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
        <span class="login100-form-title p-b-53">Discussion Forum</span>
            <form method="post" action="discussion.php">

            <div style="display:flex;">

                <div  class="PKhmud tzVsfd F9PbJd IJRrpb" style="width: 80%;">
                  <span>
                    <input type="text" style="border:none; overflow:auto; margin-top:auto; width:-webkit-fill-available;" name="ttosearch" placeholder="Search for your Question" />
                  </span>

                </div>
                <input class="login100-form-btn a1" style="margin-top: 7px; margin-left: 50px;" type="submit" name="search" value="Search">

            </div>
            <br><br>
            </form>
            <input class="login100-form-btn a1" type="submit" onclick="addnewq()" value="Ask a Question" style="width: 65%; margin: auto;padding: 5px">
    
            <br>
            <div id="ty98" style="margin-left:auto; margin-right:auto;">
            </div>
            <br>
            <br>
            <div style="width:80%;">
            <?php 
              if(isset($_POST["search"]))
              {
                  $id=array();
                  $text=$con->real_escape_string($_POST['ttosearch']);
                  $sql=$con->query("SELECT * from questions WHERE heading LIKE'%$text%'");
                  while(($data = mysqli_fetch_array($sql)))
                  {
                    array_push($id,$data['id']);
                    ?> 
                    <a target="_blank" class="q" href='discuss.php?id=<?php echo $data["id"] ?>'>
                    <div  class="PKhmud tzVsfd F9PbJd IJRrpb" style="width: 100%;">
                      <h6 style="color:#333333;"><?php 
                        $q=$data['email'];
                        $w=$con->query("SELECT * from users WHERE email='$q'");
                        $t = mysqli_fetch_array($w);
                        echo $t['name']; ?></h6><p style="color:grey;"><?php echo $data['posttime'] ?><p>
                      <h2 style="color: black"><?php echo $data['heading'] ?></h2>
                      <p style="color: black"><?php echo $data['description'] ?></p>
                    </div>
                    </a>
                    <?php
                  }
                  $text=$con->real_escape_string($_POST['ttosearch']);
                  $sql=$con->query("SELECT * from questions WHERE description LIKE'%".$text."%'");
                  while(($data = mysqli_fetch_array($sql)))
                  {
                    if(!in_array( $data['id'] ,$id )){
                    ?> 
                    <a target="_blank" class="q" href='discuss.php?id=<?php echo $data["id"] ?>'>
                    <div  class="PKhmud tzVsfd F9PbJd IJRrpb" style="width: 100%;">
                      <h6 style="color:grey;"><?php 
                        $q=$data['email'];
                        $w=$con->query("SELECT * from users WHERE email='$q'");
                        $t = mysqli_fetch_array($w);
                        echo $t['name']; ?></h6><p style="color:grey;"><?php echo $data['posttime'] ?><p>
                      <h2><?php echo $data['heading'] ?></h2>
                      <p><?php echo $data['description'] ?></p>
                    </div>
                    </a>
                    <?php
                    }
                  }
            
            
              }
		        ?>

	</div>
  
</div>
<script type="text/javascript">
  function addnewq()
  {
      
      document.getElementById("ty98").innerHTML=document.getElementById("ty99").innerHTML;
  }
</script>
<script id="ty99" type="text/html">

  <hr><br><br>

      <div style="margin-left:auto; margin-right:auto; width:80%">
          <div class="card-header">
            <h5 class="title" style="color: black;font-size: 25px">Ask Your Question</h5>
          </div>
          <div class="card-body">
            <form  method="post" enctype="multipart/form-data" action='discussion.php'>
              <div class="col">
               
                <br>
                  <div>
                    <label tyle="color: black">Question Heading</label><br><br>
                    <textarea type="text" name="heading" style="width: -webkit-fill-available;" class="PKhmud tzVsfd F9PbJd IJRrpb" placeholder="Keep the heading short and crisp"></textarea>
                  </div>
                
                <br>
                  <div>
                    <label style="color: black">Question Description</label><br><br>
                    <textarea type="text" name="description" style="width: -webkit-fill-available; margin-botton: 5px; height: 200px" class="PKhmud tzVsfd F9PbJd IJRrpb" placeholder="Give a detailed description"></textarea>
                  </div>
                
                
              </div>
              <br>
              <div class="card-footer" style="margin-left: 10%; margin-right: 10%">
                <button type="submit" name="ask" class="login100-form-btn a1">Post</button>
              </div>
            </form>
          </div>
      </div>
  
</script>
<script>
var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("navbar").style.top = "0";
  } else {
    document.getElementById("navbar").style.top = "-100px";
  }
  prevScrollpos = currentScrollPos;
}
</script>



</body>
</html>