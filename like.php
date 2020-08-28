<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<style type="text/css">
		body{
			background-color: #fff;
			font-family: sans-serif;
		}

		form{
			position:absolute; 
			top:0;
		}
	</style>
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

		//get the id of post where the comment belongs to
		if (isset($_GET['post_id']))
		{
			$post_id=$_GET['post_id'];
			
		}

		$mysqli_likes=mysqli_query($mysqli,"SELECT likes, added_by FROM posts WHERE id='$post_id'");
		$row=mysqli_fetch_array($mysqli_likes);
		
		$total_likes=$row['likes'];
		//user be liked
		$user_liked=$row['added_by'];
		$user_details_query=mysqli_query($mysqli,"SELECT * FROM users WHERE username='$user_liked'");
		$user_liked_row=mysqli_fetch_array($user_details_query);
		$total_user_liked=$user_liked_row['num_like'];

		//like button
		if(isset($_POST['like_button']))
		{
			$total_likes++;
			$total_user_liked++;
			//update likes for this post in table posts
			$update_post_likes=mysqli_query($mysqli,"UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
			//insert into likes table
			$insert_like=mysqli_query($mysqli,"INSERT INTO likes (username, post_id) VALUES ('$userloggedin', '$post_id')");
			//update num_like in users table
			$update_user_num_like=mysqli_query($mysqli,"UPDATE users SET num_like='$total_user_liked' WHERE username='$user_liked'");

		}

		//unlike buton
		if(isset($_POST['unlike_button']))
		{
			$total_likes--;
			$total_user_liked--;
			//update likes for this post in table posts
			$update_post_likes=mysqli_query($mysqli,"UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
			//insert into likes table
			$insert_like=mysqli_query($mysqli,"DELETE FROM likes WHERE username='$userloggedin' AND post_id='$post_id'");
			//update num_like in users table
			$update_user_num_like=mysqli_query($mysqli,"UPDATE users SET num_like='$total_user_liked' WHERE username='$user_liked'");

		}
		//check for previous likes for the user logged in for a specific post
		$check_query=mysqli_query($mysqli,"SELECT * FROM likes WHERE username='$userloggedin' AND post_id='$post_id'");
		$num_rows=mysqli_num_rows($check_query);

		if($num_rows>0)
		{
			//unlike button
			echo '<form action = "like.php?post_id=' . $post_id . '" method= "POST" >
					<input type="submit" class="comment_like" name="unlike_button" value="unlike">
					<div class="like_value">
						'.$total_likes.' Likes
					</div>
				</form>';
		}
		else
		{
			echo '<form action = "like.php?post_id=' . $post_id . '" method= "POST">
					<input type="submit" class="comment_like" name="like_button" value="like">
					<div class="like_value">
						'.$total_likes.' Likes
					</div>
				</form>';
		}


	?>
</body>
</html>