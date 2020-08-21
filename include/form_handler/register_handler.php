<?php 
//start a new session to store the variables
//session_start();
$fname=""; //first name
$lname=""; //last name
$email=""; //email address
$password=""; //password
$password2=""; //confirm password
$error_array=array(); //error message array, each error msg is put into the array
$date="";   //current time


//if the register button is pressed
if (isset($_POST['register']))
{
	//assign form variables

	//first name
	//strip for security
	$fname=strip_tags($_POST['Register_fname']);
	//ignore the space in fname
	$fname=str_replace(' ','',$fname);
	//keep only the first letter upper case
	$fname=ucfirst(strtolower($fname));
	//store the first name to session variable Register_fname
	$_SESSION['Register_fname']=$fname;

	//last name
	//strip for security
	$lname=strip_tags($_POST['Register_lname']);
	//ignore the space in fname
	$lname=str_replace(' ','',$lname);
	//keep only the first letter upper case
	$lname=ucfirst(strtolower($lname));
	//store the last name to session variable Register_lname
	$_SESSION['Register_lname']=$lname;


	//email
	//strip for security
	$email=strip_tags($_POST['email_address']);
	//ignore the space in fname
	$email=str_replace(' ','',$email);
	//keep only the first letter upper case
	$email=ucfirst(strtolower($email));
	//store the email to session variable email_address
	$_SESSION['email_address']=$email;


	//password
	//strip for security
	$password=strip_tags($_POST['password']);
	
	//password2
	//strip for security
	$password2=strip_tags($_POST['password2']);

	//date
	$date=date("Y-m-d");

	//check if email is in valid format @
	if (filter_var($email,FILTER_VALIDATE_EMAIL))
	{
		$valid_email=filter_var($email,FILTER_VALIDATE_EMAIL);
	//	check if email already exists
		$query="SELECT email FROM users WHERE email='$valid_email'";
		$email_check=mysqli_query($mysqli,$query);
		$email_row=mysqli_num_rows($email_check);
		if ($email_row>0)    {array_push($error_array,"Email already in use.<br>");}
		
	}
	else
	{
		array_push($error_array,"invalid email format.<br>");
	}

	//validate the first name and last name
	if (strlen($fname)>100)
		{array_push($error_array,"your first name must be between 1 and 100 characters.<br>");}

	if (strlen($lname)>100)
		{array_push($error_array,"your last name must be between 1 and 100 characters.<br>");}


	if ($password2!=$password)
	
	{

		array_push($error_array,"The password does not match.<br>");
	}
	else
	{
		if (preg_match('/[^A-Za-z0-9]/',$password))
		{
			array_push($error_array,"Your password can only contain English character or numbers.<br>");	
		}
	}
	if (strlen($password)>30||strlen($password)<5)
	{
		array_push($error_array,"Your password must be between 5 and 30 characters.<br>");
	}
	
}
else{array_push($error_array,"The form is not submitted.<br>");}

//store the user infomation into database
if (empty($error_array))
{

	$password=md5($password); //Encrypt password before sneding to database

	//generate username by concatenating first name and last name
	$username=strtolower($fname."_".$lname);

	$check_username_query=mysqli_query($mysqli,"SELECT username FROM users WHERE username='$username'");
	
	$i=0;
	$temp_username=$username;
	//if username exists add number to username
	while (mysqli_num_rows($check_username_query)!=0)
	{
		$i++;
		$temp_username=$username."_".$i;
		$check_username_query=mysqli_query($mysqli,"SELECT username FROM users WHERE username='$temp_username'");
	}
	$username=$temp_username;
	//default profile icture assignment
	$profile_pic="assets/images/profile_pics/defaults/cat_default.JPG";

	//insert info into database
	$insert_query="INSERT INTO users (first_name, last_name, username, email, password, register_date, profile_picture, num_post, num_like, user_closed, friends_array) VALUES ('$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')";
	$query=mysqli_query($mysqli,$insert_query);
	if ($query==true)
	{
		header('Location:registerSuccessPage.php');
	}

}
?>