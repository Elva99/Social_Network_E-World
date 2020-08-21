<?php 
require 'config/config.php';

if (isset($_SESSION['username']))
{
  //get the user info from database
	$userloggedin=$_SESSION['username'];
  $user_info=mysqli_query($mysqli,"SELECT * FROM users WHERE username='$userloggedin'");
  $user=mysqli_fetch_array($user_info);

}
else
{
	header('Location: signinPage.php');
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
	<!-- js -->
  <!--
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

	<script src="assets/js/bootstrap.js"></script>
  -->
	<!-- css -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
  
	<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" style="z-index: 10;">
  
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <a class="navbar-brand" href="#">E-World</a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo $userloggedin;?>"><?php echo $user['first_name']." ".$user['last_name']; ?></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="include/handlers/logout.php">Logout</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
<div class="wrapper">