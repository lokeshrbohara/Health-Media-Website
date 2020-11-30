<?php
    include_once "config.php";
    if(isset($_GET['id']))
    $id=$_GET['id'];

    $sql = "SELECT * from doctors where id='$id'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    //$img='<embed align="center" src="data:application/pdf;base64,'.base64_encode( $row['pdf'] ).'" />';
    header('Content-Type:application/pdf');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
</head>
<body>
<?php 
//echo $img;
echo $row['documents']; 
?>

</body>
</html>


