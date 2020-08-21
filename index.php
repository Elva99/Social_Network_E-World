<?php
include("include/header.php");
include("include/classes/User.php");
include("include/classes/Post.php");

if (isset($_POST['post']))
{
	//post a blog
	$post=new Post($mysqli,$userloggedin);
	$post->submitPost($_POST['post_text'],'none');
	//after submission, refresh the index page
	header("Location: index.php");
	

}
?>
	<!--two classes here-->
	<div class="column user_details"> 
		<a href="<?php echo $userloggedin;?>"><img src="<?php echo $user['profile_picture'];?>"></a>
	
		<div class="user_details_left_right">
			<a href="<?php echo $userloggedin;?>"><?php echo $user['first_name']." ".$user['last_name'];?></a>
			<br>
			<?php echo "Posts: ".$user['num_post']."<br>";?>

		</div>
		
	</div>

	<div class="main_column column">
		<form class="post_form" action="index.php" method="POST">
			<textarea name="post_text" id="post_text" placeholder="Share something here..."></textarea>
			<input type="submit" name="post" id="post_button" value="Post">
			<hr>
		</form>

		<?php
			$post=new Post($mysqli,$userloggedin);
			$post->loadPostsFriends();
		?>

	</div>



</body>
</html>