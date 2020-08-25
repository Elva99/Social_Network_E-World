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
		<textarea name="post_body"></textarea>
		<input type="submit" name="postComment<?php echo $post_id; ?>" value="Post">
	</form>
	<!-- load comments-->
</body>
</html>