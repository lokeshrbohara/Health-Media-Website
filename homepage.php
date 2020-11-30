<?php


    session_start();
    if(!isset($_SESSION['email']))
    {
        header('Location: login.php');
        exit();
    }
    
    include 'config.php';
    $q1 = "select * from report_symptoms";
    $q2 = "select * from drugs";

    $query1 = mysqli_query($con,$q1);
    $query2 = mysqli_query($con,$q2);
    $dataPoints1 = array();
    while($row = mysqli_fetch_array($query1)) {
        $dataPoints1[] = array(
            "label" => $row['s_name'],
            "y" => $row['s_count'],
      
        );
    }

    $dataPoints2 = array();
    while($res = mysqli_fetch_array($query2)) {
        $dataPoints2[] = array(
            "label" =>  $res['d_name'],
            "y" => $res['d_count'],
        );
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Homepage</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
        <link rel="stylesheet" type="text/css" href="homepage.css">
        <link rel="stylesheet" type="text/css" href="nav.css">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    

    <script>
    window.onload = function () {
     
    var chart = new CanvasJS.Chart("chartContainer1", {
        animationEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        title: {
            text: "Symptoms / Diseases"
        },
        axisY: {
            title: "Number of times mentioned in report"
        },
        data: [{
            type: "column",
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
     

    var chart1 = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        title:{
            text: "Drugs / Medicines"
        },
        subtitles: [{
            text: "Based on number of times mentioned in reports"
        }],
        data: [{
            type: "pie",
            showInLegend: "true",
            legendText: "{label}",
            indexLabelFontSize: 16,
            yValueFormatString: "##0",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart1.render();
     
    }
    </script> 
    </head>

    <body style="background: #f2f2f2">
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
    <br>
        <div style="margin-top: 120px">
        <div id="chartContainer1" style="height: 370px; width: 70%; margin: auto" ></div>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <br><br>

    <div id="chartContainer2" style="height: 370px; width: 70%; margin: auto"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </div>
    <br><br>


    
    </body>
    </html>