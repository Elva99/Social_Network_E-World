<?php
//OOP. create a user object
class Post{
	private $user_obj;
	private $con;

	public function __construct($con,$user)
	{
		$this->con=$con;
		$this->user_obj=new User($con,$user);
	}

	public function submitPost($body,$user_to)
	{
		$body=strip_tags($body);  //remove html tags
		$body=mysqli_real_escape_string($this->con, $body);//escape special characters

		$body=str_replace('\r\n', "\n", $body); //replace ENTER with a new line
		$body=nl2br($body);//replace new line with a html line break br
		$check_empty=preg_replace('/\s+/','',$body);   //delete all the spaces

		//if the post is not empty
		if ($check_empty!="")
		{

			//current time
			$date_added=date("Y-m-d H:i:s");
			//get username
			$added_by=$this->user_obj->getUsername();

			//if user is on own profile, user_to is 'none'
			if ($user_to==$added_by)
			{
				$user_to="none";
			}

			//insert post into database table posts
			$query=mysqli_query($this->con,"INSERT INTO posts (body,added_by,user_to,date_added,user_closed,deleted,likes) VALUES (
				'$body','$added_by','$user_to','$date_added','no','no','0')");
			//return the id of the post in the db
			$returned_id=mysqli_insert_id($this->con);

			//insert notification

			//update added_by number of post
			$num_post=$this->user_obj->getNumpost();
			$num_post++;
			$update_num_post_query=mysqli_query($this->con,"UPDATE users SET num_post='$num_post' WHERE username='$added_by'");

		}
	}

		public function loadPostsFriends(){
			$str="";  //string to return
			$data=mysqli_query($this->con,"SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

			while($row=mysqli_fetch_array($data))
			{
				$id=$row['id'];
				$body=$row['body'];
				$added_by=$row['added_by'];
				$date_time=$row['date_added'];

				//prepare user_to so it can be included even if not posted to a user
				if ($row['user_to']=="none")
				{
					$user_to="";
				}
				else
				{
					$user_to_obj=new User($this->con,$row['user_to']);
					$user_to_name=$user_to_obj->getFirstAndLastName();
					$user_to="to <a href=>'". $row['user_to']."'>".$user_to_name."</a>";
				}

				//check of user who posted, has their account closed
				$added_by_obj=new User($this->con,$added_by);
				if (!($added_by_obj->isClosed()))
				{
					//check if the user who added the post is the fiend of the user logged in
					if ($this->user_obj->isFriend($added_by))
					{
						$user_details_query=mysqli_query($this->con,"SELECT first_name,last_name,profile_picture FROM users
							WHERE username='$added_by'");
						$user_row=mysqli_fetch_array($user_details_query);
						$first_name=$user_row['first_name'];
						$last_name=$user_row['last_name'];
						$profile_pic=$user_row['profile_picture'];


						?>
						<script type="text/javascript">
							function toggle<?php echo $id; ?>()
							{
								//where the person clicked, if it is a link, do not show the comment window
								var target=$(event.target);
								if(!target.is("a"))
								{
									var element=document.getElementById("toggleComment<?php echo $id; ?>");
									if (element.style.display == "block")
									{
										element.style.display = "none";
									}
									else
									{
										//alert(element.style.display);
										element.style.display = "block";
										//alert(element.style.display);
										//document.write(1+1);
									}
								}
							}
						</script>
						<?
						$comment_check=mysqli_query($this->con,"SELECT * FROM comments WHERE post_id=$id");
						$comment_check_num=mysqli_num_rows($comment_check);
						//Timeframe
						$date_time_now=date("Y-m-d H:i:s");
						$start_date=new DateTime($date_time);  //time of post
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
						$str ="<div class='status_post' onClick='javascript:toggle$id()'>
									<div class='post_profile_pic'>
										<img src='$profile_pic'>
									</div>
									<div class='posted_by' style='color: #ACACAC;'>
										<a href='$added_by'> $first_name $last_name</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;
										$time_message
									</div>
									<div id='post_body'>
										$body
										<br>
									</div>
									<br>

									<div class='newsFeedPostOptions'>
										Comments($comment_check_num)&nbsp;&nbsp;&nbsp;&nbsp;
										<iframe src='like.php?post_id=$id' id='like_frame' scrolling='no' method='POST'></iframe>
									</div>
								</div>
								<div class='post_comment' id='toggleComment$id' style='display: none;'>
									<iframe src='comment_frame.php?post_id=$id' id='comment_iframe'></iframe>
								</div>
								<hr>";

						echo $str;
					}
				
				}

			}
		}

	
}
?>