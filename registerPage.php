
<?php  require 'config/config.php';
		include('include/form_handler/register_handler.php');
?>






<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="css/style.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>Registration Page</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Register</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form action="registerPage.php" method="POST">
                        	<?php if (in_array("your first name must be between 1 and 100 characters.<br>", $error_array))
                                				echo "<center>your first name must be between 1 and 100 characters.<br></center>";
                                	?>
                            <div class="form-group row">
                                <label for="Register_fname" class="col-md-4 col-form-label text-md-right">First Name</label>
                                <div class="col-md-6">
                                	
                                    <input type="text" id="Register_fname" class="form-control" name="Register_fname" 
                                    value="<?php if (isset($_SESSION['Register_fname'])) {echo $_SESSION['Register_fname'];}?>"
                                    required autofocus>
                                </div>
                            </div>
                            <?php if (in_array("your last name must be between 1 and 100 characters.<br>", $error_array))
                                				echo "<center>your last name must be between 1 and 100 characters.<br></center>";
                                	?>
                            <div class="form-group row">
                                <label for="Register_lname" class="col-md-4 col-form-label text-md-right">Last Name</label>
                                <div class="col-md-6">                          
                                    <input type="text" id="Register_lname" class="form-control" name="Register_lname" 
									value="<?php if (isset($_SESSION['Register_lname'])) {echo $_SESSION['Register_lname'];}?>"
                                    required autofocus>
                                </div>
                            </div>


                            <?php 	if (in_array("invalid email format.<br>",$error_array)) {echo "<center>invalid email format.<br></center>";}
                            		else if (in_array("Email already in use.<br>", $error_array)) {echo "<center>Email already in use.<br></center>";}?>
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">Email Address</label>
                                <div class="col-md-6">                             
                                    <input type="email" id="email_address" class="form-control" name="email_address" 
                                    value="<?php if (isset($_SESSION['email_address'])) {echo $_SESSION['email_address'];}?>"
                                    required autofocus>
                                </div>
                            </div>
                            
                            	<?php if (in_array("The password does not match.<br>", $error_array))
                            				{echo "<center>The password does not match.<br></center>";}
                            		  else if (in_array("Your password can only contain English character or numbers.<br>",$error_array))
                            		  		{echo "<center>Your password can only contain English character or numbers.<br></center>";}
                            		  else if (in_array("Your password must be between 5 and 30 characters.<br>",$error_array))
                            		  		{echo "<center>Your password must be between 5 and 30 characters.<br></center>";}
                            	?>
                            
                            <div class="form-group row">
                            	
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password2" required>
                                </div>
                            </div>

                            <!--
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" name="register">
                                    Register
                                </button>
                                <!--
                                <a href="#" class="btn btn-link">
                                    Forgot Your Password?
                                </a>
                                -->
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>

</body>
</html>