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
		<!--
		<div class="posts_area"></div>
		<img id="#loading" src="assets/images/icons/loading_icon.gif">
	</div>

<script type="text/javascript">
	var userloggedin='<?php echo $userloggedin; ?>';
	$(document).ready(function()
	{
		$('#loading').show();

		//Original ajax request for loading first posts
		$.ajax({
			url: "include/handlers/ajax_load_posts.php",
			type: "POST",
			data: "page=1&userloggedin="+userloggedin,
			cache:false,

			success: function(data){
				$('#loading').hide();
				$('.posts_area').html(data);
			}
		})
	});

	$(window).scroll(function()
	{
		var height=$('.post_area').height();   //div containing posts
		var scroll_top=$(this).scrollTop();
		var page=$('.post_area').find('.nextPage').val();
		var noMorePosts=$('.post_area').find('.noMorePosts').val();

		//reach the bottom of the page, load more posts
		if ((document.body.scrollHeight==document.body.scrollTop+window.innerHeight)&&noMorePosts=='false')
		{
			$('#loading').show();
			var ajaxReq=$.ajax({
			url: "include/handlers/ajax_load_posts.php",
			type: "POST",
			data: "page="+page+"+userloggedin"+userloggedin,
			cache:false,

			success: function(response){
				$('.post_area').find('.nextPage').remove();  //remove current .nextPage
				$('.post_area').find('.noMorePosts').remove();//remove current .nextPage
				$('#loading').hide();
				$('.posts_area').html(data);
			}
		});

				return false;
		}
	});
</script>
-->
</body>
</html>