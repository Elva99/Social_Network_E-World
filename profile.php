<?php
	include("include/header.php");
	include("include/classes/User.php");
	include("include/classes/Post.php");
	if(isset($_GET['profile_username']))
	{
		//define in .htaccess profile master
		$username=$_GET['profile_username'];
		$user_details_result=mysqli_query($mysqli,"SELECT * FROM users WHERE username='$username'");
		$user_details=mysqli_fetch_array($user_details_result);
		$profile_picture=$user_details['profile_picture'];

		//count the number of friends around the comma
		$num_friends=(substr_count($user_details['friends_array'],","))-1;

	}
	//remove friend
	if(isset($_POST['remove_friend']))
	{
		$user=new User($mysqli,$userloggedin);
		$user->removeFriend($username);

	}

	//add friend
	if(isset($_POST['add_friend']))
	{
		$user=new User($mysqli,$userloggedin);
		$user->sendRequest($username);

	}

	//respond to friend request
	if(isset($_POST['respond_request']))
	{
		header("Location: requests.php");

	}
?>
	<style type="text/css">
		
		.wrapper{
			margin-left: 0px;
    		padding-left: 0px;
		}
		
		.main_column {
		    display: block;
		    width: 70%;
		    margin-left: 30%;
		    float: right;
		    min-height: 160px;
		    height: 300px;
		}
	</style>

	<div class="profile_left">
		<img src="<?php echo $profile_picture; ?>">

		<div class="profile_info">
			<p><?php echo "Posts: " . $user_details['num_post']; ?></p>
			<p><?php echo "Likes: " . $user_details['num_like']; ?></p>
			<p><?php echo "Friends: " . $num_friends; ?></p>
		</div>
		<form action="<?php echo $username?>" method="POST">
			<?php 
				//check if the user who owns the profile page  is closed
				//user who owns the profile page 
				$profile_master_obj=new User($mysqli,$username);
				if ($profile_master_obj->isClosed())
				{
					header("Location: user_closed.php");
				}

				//check the logged in user
				$login_user_obj=new User($mysqli,$userloggedin);
				//if the user logged in and the profile master is not the same person
				if ($userloggedin!=$username)
				{
					//if they are friends, set a remove friend button
					if ($login_user_obj->isFriend($username))
					{
						echo '<center><input type="submit" name="remove_friend" class="danger" value="Remove Friend"></center><br>';
					}
					//if they are not friends, but received a friend request
					else if ($login_user_obj->didReceiveFriendRequest($username))
					{
						echo '<center><input type="submit" name="respond_request" class="warning" value="Respond to Request"></center><br>';
					}
					else if ($login_user_obj->didSendFriendRequest($username))
					{
						echo '<center><input type="submit" name="" class="default" value="Request Sent"></center><br>';
					}
					else
					{
						echo '<center><input type="submit" name="add_friend" class="success" value="Add Friend"></center><br>';
					}
				}
			?>
		</form>
	</div>

	
	<div class="main_column column">
		<?php echo $username;?>

	</div>
		

	
</body>
</html>
