<?php
    require 'config/config.php';
    include('include/form_handler/signin_handler.php');
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

    <title>Sign In Page</title>
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
                    <a class="nav-link" href="#">Sign In</a>
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
                    <div class="card-header">Sign In</div>
                    <div class="card-body">
                        <form action="signinPage.php" method="POST">
                        	<?php
                                if (in_array("Email or password was not correct.",$signin_error_array))
                                {
                                    echo "<center>Email or password was not correct.</center><br>";
                                }
                            ?>
                            <div class="form-group row">
                                <label for="sign_in_email" class="col-md-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                	
                                    <input type="text" id="sign_in_email" class="form-control" name="sign_in_email" 
                                    value="<?php if (isset($_SESSION['sign_in_email'])) {echo $_SESSION['sign_in_email'];}?>"
                                    required autofocus>
                                </div>
                            </div>
                            
                           
                            
                            	
                
                            <div class="form-group row">
                            	
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="sign_in_password" class="form-control" name="sign_in_password" required>
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
                                <button type="submit" class="btn btn-primary" name="sign_in">
                                    Sign In
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