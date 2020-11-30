<?php
    include_once "config.php";
    session_start();
    if(!isset($_SESSION['email']))
    {
        header('Location: login.php');
        exit();
    }
    $email=$_SESSION['email'];
    if(isset($_GET['id']))
    {
        $id=$_GET['id'];
        if(isset($_POST["answer"]))
        {
            $answer=$con->real_escape_string($_POST['answer']);
            $sql = mysqli_query($con, "SELECT * FROM users where  email='$email'");
            $data = mysqli_fetch_array($sql);
            $isdoc = $data['isdoctor'];
            $con->query("INSERT INTO answers(disid,answer,ctime,email,isdoctor) VALUES ('$id', '$answer', now(),'$email','$isdoc')");

        }
    }
    else{
        header("location:login.php");
        exit();
    }
    
    if(isset($_POST['email']) && isset($_POST['id']))
    {
        $i=$_POST['id'];
        $e=$_POST['email'];
        $sql=$con->query("SELECT * from upvotes WHERE aid='$i' AND email='$e'");
        if($sql->num_rows>0)
        {
            $con->query("UPDATE answers set votes=votes-1 where id='$i'");
            $con->query("DELETE FROM upvotes where aid='$i' AND email='$email'");
            
          
        }
        else
        {
            $con->query("UPDATE answers set votes=votes+1 where id='$i'");
            $con->query("INSERT INTO upvotes(email,aid) VALUES ('$e', '$i')");
           
           
        }
    }
?>
<!DOCTYPE html> 
<html> 
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
        overflow: auto;

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

<div class="container-login100" style="background-color:#f2f2f2">
	<div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33" style="width:80%;">


			<div  class="PKhmud tzVsfd F9PbJd IJRrpb" style="width: -webkit-fill-available;">
                <?php
                    if(isset($_GET['id']))
                    {
                        $id=$_GET['id'];
                        ?>
                        <h5  style="color:grey;"><?php 
                            
                            $w=$con->query("SELECT * from questions WHERE id='$id'");
                            $t = mysqli_fetch_array($w);
                            $pemail=$t['email'];
                            $sql=$con->query("SELECT * from users WHERE email='$pemail'");
                            $p = mysqli_fetch_array($sql);
                            echo $p['name']; ?></h5><p style="color:grey;"><?php echo $t['posttime'] ?><p>
                        <h1 style="color: black"><?php echo $t['heading'] ?></h1>
                        <p style="color: black"><?php echo $t['description'] ?></p>
                        <?php
                    }
                    
                ?>
                <div>
                    <div style="margin-top: 20px;"  class="card-footer">
                        <button type="submit"  name="ask" onclick="addc()" class="login100-form-btn a1" style="width:70%;font-size: 18px; padding: 5px" class="btn btn-primary">Add Your Answer</button>
                    </div><br>
                    <hr>

                    <div id="yu90"></div>
                </div>
                <br>
                <div id="io98">
                <?php
                if(isset($_GET['id']))
                {
                    $id=$_GET['id'];
                    $sql=$con->query("SELECT * from answers WHERE disid='$id' ORDER BY votes DESC, isdoctor DESC");
                    while($data = mysqli_fetch_array($sql))
                    {
                        ?>
                        <div style="display:inline-block; width: -webkit-fill-available; margin:10px;">
                            <?php if($data['isdoctor']==1)
                            {
                                ?>
                            <div style="display: flex; align-items: center; justify-content: center;width:10%; height:100px; float:left;">
                            <i class="fa fa-user-md fa-lg" style="color:#636363;font-size: 15px"><p style="color: black;margin-top: 4.5px;font-size: 10px;font-weight: bold">Dr.</p> </i>    
                            </div>
                            <?php 
                            }
                            else
                            {
                                ?>
                                <div style="display: flex; align-items: center; justify-content: center;width:10%; height:100px; float:left;">
                                
                                </div>
                                <?php
                            }
                            ?>
                            <div style="display:inline-grid;">

                                
                            

                            <br>
                            <button class="fa fa-thumbs-up fa-2x" style="border: none; background: transparent; color:<?php 
                            $id= $data['id'];
                            
                            $o=$con->query("SELECT * from upvotes WHERE aid='$id' AND email='$email'");
                            if($o->num_rows>0) echo "#FFDF00";
                            else echo "black";?>;" id="btn<?php echo $data['id'] ?>" onclick="vote(<?php echo $data['id'] ?>,'<?php echo $email; ?>',<?php echo $data['disid'] ?>)"></button>
                           
                    
                            <p id="a<?php echo $data['id'] ?>" style="margin:auto;color: black"><?php echo $data['votes'] ?></p>
                            </div>
                            <div  class="PKhmud tzVsfd F9PbJd IJRrpb" style="width:80%; float:right;">

                                <p style="color:grey; margin:unset;"><?php 
                            
                                $temail=$data['email'];
                                $s=$con->query("SELECT * from users WHERE email='$temail'");
                                $p = mysqli_fetch_array($s);
                                echo $p['name']; ?>&nbsp;<?php echo $data['ctime'] ?><p>


                                <p style="margin:unset; font-size:16px;color:black"><?php echo $data['answer'] ?></p>
                            </div> 
                        </div> 
                        <br>
                    <?php
                    }
                                       
                }
               
                ?>
                </div>
			</div>
			
        

	</div>
</div>

<script id="ty100" type="text/html">
    <form method="post"> 
    <div style="display: flex; margin-bottom: 15px;">
    
        <div  class="PKhmud tzVsfd F9PbJd IJRrpb" style="width: 80%;">

            <input id="io99" type="text" style="overflow: scroll;color: black; border: 0.5px grey solid; border:none; padding: 10px;width: 80%" name="answer" placeholder="Type Your Answer" />

        </div>
        <input id="io100" class="login100-form-btn a1" onclick="postc(<?php echo $_GET['id'] ?>)" style="margin-top: 25px; height: 40px; width: 25%;padding: 5px" type="submit" name="csubmit" value="Post">


    </div>
    </form>

    <div style="height:5px" class="card-footer">
    </div>
</script>

<script type="text/javascript">
    function addc()
    {
        
        document.getElementById("yu90").innerHTML = document.getElementById("ty100").innerHTML;
    }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script type="text/javascript">

    function vote(id,email,disid){
        $("#btn"+id).attr("disabled", true);
        console.log(email);
        $.ajax({
            url : 'discuss.php?id='+disid,
            type : "POST",
            data : ({id: id, email: email}),
            success : function(data) {
                $("#a"+id).replaceWith($("#a"+id,data));
                $("#btn"+id).replaceWith($("#btn"+id,data));
                console.log(data);
            },
            complete:function(data) {
                $("#btn"+id).attr("disabled", false);

            }
        });
        
    }

    function postc(disid)
    {
        answer=$("#io99").val();
        $("#io100").attr("disabled", true);
        console.log(answer);
        if(answer!="")
        {
            $.ajax({
            url : 'discuss.php?id='+disid,
            type : "POST",
            data : ({answer: answer}),
            success : function(data) {
                $("#io98").replaceWith($("#io98",data));
               
            },
            complete:function(data) {
                $("#io100").attr("disabled", false);
                $("#io99").val('');

            }
        });

        }
    }
</script>

<div style="clear:both; height:500px;"></div>


</body> 
</html> 
