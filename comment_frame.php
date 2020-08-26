<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<?php 
		require 'config/config.php';
		include("include/classes/User.php");
		include("include/classes/Post.php");

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
	<script type="text/javascript">
		function toggle(){
			var element=document.getElementById("comment_section");
			//if the block is open, close it
			if (element.style.display == "block")
			{
				element.style.display = "none";
			}
			else
			{	
				//if the block is closed, open it
				element.style.display = "block";
			}
		}
	</script>

	<?php
		//get the id of post where the comment belongs to
		if (isset($_GET['post_id']))
		{
			$post_id=$_GET['post_id'];
		}
		$user_query=mysqli_query($mysqli,"SELECT added_by, user_to FROM posts WHERE id='$post_id'");
		$row=mysqli_fetch_array($user_query);
		$posted_to=$row['added_by'];

		//insert the new comment into database table comments
		if (isset($_POST['postComment'.$post_id]))
		{
			$post_body=$_POST['post_body'];
			$post_body=mysqli_escape_string($mysqli,$post_body);
			$date_time_now=date("Y-m-d H:i:s");
			$insert_post=mysqli_query($mysqli,"INSERT INTO comments (post_body,posted_by,posted_to,
		date_added,removed,post_id) VALUES ('$post_body','$userloggedin','$posted_to','$date_time_now','no','$post_id')");
			echo "<p>Comment Posted.</p>";

		}
	?>
	<!--post comment form-->
	<form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" 
		name="postComment<?php echo $post_id; ?>" method="POST">
		<textarea name="post_body" id="comment_textarea" placeholder="post your comment here..."></textarea>
		<input type="submit" id="comment_submit_button" name="postComment<?php echo $post_id; ?>" value="Post">
	</form>
	<!-- load comments-->

	<?php
		$get_comments=mysqli_query($mysqli,"SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id ASC");
		$count=mysqli_num_rows($get_comments);
		if ($count!=0)
		{
			while($comment=mysqli_fetch_array($get_comments))
			{
				$comment_body=$comment['post_body'];
				$posted_by=$comment['posted_by'];
				$posted_to=$comment['posted_to'];
				$date_added=$comment['date_added'];
				$removed=$comment['removed'];

				//Timeframe
				$date_time_now=date("Y-m-d H:i:s");
				$start_date=new DateTime($date_added);  //time of post
				$end_date=new DateTime($date_time_now);  //current time
				$interval=$start_date->diff($end_date);  //difference between dates
				if ($interval->y>=1)  //year diff
				{
					if ($interval==1)
					{
						$time_message=$interval->y." year ago";  //1 year ago
					}
					else
					{
						$time_message=$interval->y." years ago";  //1+ year ago
					}

				}
				else if ($interval->m>=1)
				{
					if ($interval->d == 0)
					{
						$days=" ago";
					}
					else if ($interval->d ==1)
					{
						$days= $interval->d . " day ago";
					}
					else
					{
						$days= $interval->d . " days ago";
					}

					if ($intercal->m==1)
					{
						$time_message=$interval->m . "month" . $days;
					}
					else
					{
						$time_message=$interval->m . "months" . $days;
					}
				}
				else if ($interval->d>=1 )
				{
					if ($interval->d ==1)
					{
						$time_message="Yesterday";
					}
					else
					{
						$time_message= $interval->d . " days ago";
					}
				}
				else if($interval->h>=1)
				{
					if ($interval->h ==1)
					{
						$time_message=$interval->h . " hour ago";
					}
					else
					{
						$time_message= $interval->h . " hours ago";
					}
				}
				else if ($interval->i>=1)
				{
					if ($interval->i==1)
					{
						$time_message=$interval->i . " minute ago";
					}
					else
					{
						$time_message=$interval->i . " minutes ago";
					}
				}
				else
				{
					if ($interval->s<30)
					{
						$time_message="Just now";
					}
					else
					{
						$time_message=$interval->s . " seconds ago";
					}
				}
				$user_obj=new User($mysqli,$posted_by);
				?>
				<!-- post each comment-->
				<div class="comment_section">	
					<a href="<?php echo $posted_by; ?>" target="_parent"><img src="<?php echo $user_obj->getProfilePicture(); ?>"
						title="<?php echo $posted_by; ?>" style="float: left;" height="30px"></a>
					<a href="<?php echo $posted_by; ?>" target="_parent"><b><?php echo $user_obj->getFirstAndLastName();?></b></a>
					&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $time_message."<br>".$comment_body; ?>
					<hr>
				</div>
				<?php

			}
		}
		else
		{
			echo "<center>No comment to show.</center>";
		}
	?>
		
</body>
</html>