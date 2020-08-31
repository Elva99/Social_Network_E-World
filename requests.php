<?php
	include("include/header.php");
	include("include/classes/User.php");
	include("include/classes/Post.php");
?>
<style type="text/css">
	input#accept_button
	 {
    	background-color: #65db84;
   	    border: 1px solid green;
    	border-radius: 3px;
    }
    input#ignore_button 
    {
    	background-color: #f28385;
    	border: 1px solid #8a0a0c;
    	border-radius: 3px;
	}

</style>
<div class="main_column column" id="main_column">
	<h4>Friend Requests</h4>
	<?php
		//check all the friend requests for userlogged in
		$query=mysqli_query($mysqli,"SELECT * FROM friend_requests WHERE user_to='$userloggedin'");
		//no friend requests
		if (mysqli_num_rows($query)==0)
		{
			echo "You have no friend requests at this time.";
		}
		else
		{	//print out friend requests
			while($row=mysqli_fetch_array($query))
			{
				$user_from=$row['user_from'];
				$user_from_obj=new User($mysqli,$user_from);
				$user_from_obj=new User($mysqli,$user_from);

				echo $user_from_obj->getFirstAndLastName() . " sent you a friend request.";
				$user_from_friends_array=$user_from_obj->getFriendsArray();

				//accept the friend request
				if (isset($_POST['accept_request' . $user_from]))
				{
					//add user_from to user_to friend list
					$user_to_add_friend_query=mysqli_query($mysqli,"UPDATE users SET friends_array=CONCAT(friends_array,'$user_from,')
					 	WHERE username='$userloggedin'");
					//add user_to to user_from friend list
					$user_from_add_friend_query=mysqli_query($mysqli,"UPDATE users SET friends_array=CONCAT(friends_array,'$userloggedin,')
					 	WHERE username='$user_from'");

					//delete friend request in the table friend requests
					$delete_request_query=mysqli_query($mysqli,"DELETE FROM friend_requests WHERE user_to='$userloggedin' AND user_from='$user_from'");
					echo "You are now friends!";
					//refresh the page
					//header("Location: requests.php");
				}
				if (isset($_POST['ignore_request' . $user_from]))
				{
					//delete friend request in the table friend requests
					$delete_request_query=mysqli_query($mysqli,"DELETE FROM friend_requests WHERE user_to='$userloggedin' AND user_from='$user_from'");
					echo "Request ignored!";
					//refresh the page
					//header("Location: requests.php");
				}

				?>
				<form action="requests.php" method="POST">
					<input type="submit" name="accept_request<?php echo $user_from; ?>" id="accept_button" value="accept">
					<input type="submit" name="ignore_request<?php echo $user_from; ?>" id="ignore_button" value="ignore">
				</form>
				<?php
				
			}
		}
	?>

	
</div>