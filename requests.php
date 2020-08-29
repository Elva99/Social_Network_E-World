<?php
	include("include/header.php");
	include("include/classes/User.php");
	include("include/classes/Post.php");
?>
<div class="main_column column" id="main_column">
	<h4>Friend Requests</h4>
	<?php
		//check all the friend requests for userlogged in
		$query=mysqli_query($mysqli,"SELECT * FROM friend_requests WHERE user_to='$userloggedin'");
		if (mysqli_num_rows($query)==0)
		{
			echo "You have no friend requests at this time.";
		}
		else
		{
			while($row=mysqli_fetch_array($query))
			{
				$user_from=$row['user_from'];
				$user_from_obj=new User($mysqli,$user_from);

				echo $user_from_obj->getFirstAndLastName() . "sent you a friend request.";
				
			}
		}
	?>
</div>