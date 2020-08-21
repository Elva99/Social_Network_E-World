<?php 
	$signin_error_array=array();
	if (isset($_POST['sign_in']))
	{
		//session_start();
		//get the user input valid email from sign in form
		$email=filter_var($_POST['sign_in_email'],FILTER_VALIDATE_EMAIL);
		
		//store the email into session
		$_SESSION['sign_in_email']=$email;
		//get the user input password from sign in form
		$password=md5($_POST['sign_in_password']);
		//select the row from database
		$select_query="SELECT * FROM users WHERE email='$email' AND password='$password'";
		$result_query=mysqli_query($mysqli,$select_query);
		$user_num=mysqli_num_rows($result_query);
		//if the user exists in the database
		if ($user_num==1)
		{
			$user_info=mysqli_fetch_array($result_query);
			
			//change the user closed to no
			$check_closed_query="SELECT * FROM users WHERE email='$email' AND user_closed='yes'";
			$user_open=mysqli_query($mysqli,$check_closed_query);
			if (mysqli_num_rows($user_open)==1)
			{
				$change_user_status_query="UPDATE users SET user_closed='no' WHERE email='$email'";
				mysqli_query($mysqli,$change_user_status_query);
			}
			//store the username into session 
			$_SESSION['username']=$user_info['username'];
			header('Location:index.php');
		}
		else
		{
			
			array_push($signin_error_array, "Email or password was not correct.");
		}

	}
	


    ?>