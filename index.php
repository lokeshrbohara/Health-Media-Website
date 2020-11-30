<?php
	session_start();

	if (!isset($_SESSION['email'])) {
		header('Location: login.php');
		exit();
	}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">>
	<title>Login With Google</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
<div class="container" style="margin-top: 100px">
	<div class="row">
		<div class="col-md-3">
			<img style="width: 80%;" src="<?php echo $_SESSION['picture'] ?>">
		</div>

		<div class="col-md-9">
			<table class="table table-hover table-bordered">
				<tbody>
					<tr>
						<td>ID</td>
						<td><?php echo $_SESSION['id'] ?></td>
					</tr>
					<tr>
						<td>First Name</td>
						<td><?php echo $_SESSION['givenName'] ?></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><?php echo $_SESSION['familyName'] ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?php echo $_SESSION['email'] ?></td>
					</tr>
					<tr>
						<td>Gender</td>
						<td><?php echo $_SESSION['gender'] ?></td>
					</tr>
				</tbody>
			</table>
		</div>
    <a href="logout.php" class="btn btn-info" role="button">Logout</a>
	

	</div>
	
</div>
<!--<embed align="center" src="OLAP exp4 501848.pdf" width="800px" height="2100px" />
-->
</body>
</html>