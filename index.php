<?php
error_reporting(0);
include 'helper/config.php';
$ru = $_SESSION['userid'];
echo $ru;
$conn->query("delete from otp where userid = '$ru'");
session_start();

if (!isset($_SESSION['username'])) {  
	header('Location: login.php');
}
?>


<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Credit Card Fraud Detection</title>

	<!-- Load all static files -->
	<link rel="stylesheet" type="text/css" href="assets/BS/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
	<style>
		.container {
			background: url(assets/bg.png) no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;

		}
	</style>


</head>

<body class="container">
	<!-- Navbar included -->
	<?php
	$usertype = $_SESSION['usertype'];

	if ($usertype == "admin") {
		include 'helper/navbar.php';
	} else {
		include 'helper/navbar_no.php';
	}
	?>
	<!-- Config included -->
	<?php include 'helper/config.php' ?>

	<!-- Let's do something more -->
	<?php include 'dashboard.php' ?>
</body>
<footer>
	<!-- All the Javascript will be load here... -->
	<script type="text/javascript" src="assets/JS/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="assets/JS/main.js"></script>
	<script type="text/javascript" src="assets/BS/js/bootstrap.min.js"></script>
</footer>

</html>