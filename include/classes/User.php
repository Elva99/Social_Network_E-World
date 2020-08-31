<?php
//OOP. create a user object
class User{
	private $user;
	private $con;

	public function __construct($con,$user)
	{
		$this->con=$con;
		$user_details_query=mysqli_query($con,"SELECT * FROM users WHERE username='$user'");
		$this->user=mysqli_fetch_array($user_details_query);
	}

	public function getUsername()
	{
		return $this->user['username'];
	}

	public function getNumpost()
	{
		return $this->user['num_post'];
	}
	
	public function getFirstAndLastName()
	{
		$username=$this->user['username'];
		$query=mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$username'");
		$row=mysqli_fetch_array($query);
		return $row['first_name']." ".$row['last_name'];
	}

	public function getFriendsArray()
	{
		return $this->user['friends_array'];
	}

	public function getProfilePicture()
	{
		return $this->user['profile_picture'];
	}

	public function isClosed()
	{
		$username=$this->user['username'];
		$query=mysqli_query($this->con,"SELECT user_closed FROM users WHERE username='$username'");
		$row=mysqli_fetch_array($query);

		if ($row['user_closed']=='yes')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function isFriend($username_to_check)
	{
		$usernameComma=",".$username_to_check.",";

		if (strstr($this->user['friends_array'],$usernameComma) || $username_to_check==$this->user['username'])
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//check if this user received the request from $user_from
	public function didReceiveFriendRequest($user_from)
	{
		$user_to=$this->user['username'];
		$check_request_query=mysqli_query($this->con,"SELECT * FROM friend_requests WHERE user_from='$user_from' AND user_to='$user_to'");
		$check_request_num=mysqli_num_rows($check_request_query);
		if ($check_request_num>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//check if this user sent the request to $user_to
	public function didSendFriendRequest($user_to)
	{
		$user_from=$this->user['username'];
		$check_request_query=mysqli_query($this->con,"SELECT * FROM friend_requests WHERE user_from='$user_from' AND user_to='$user_to'");
		$check_request_num=mysqli_num_rows($check_request_query);
		if ($check_request_num>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//remove friends
	public function removeFriend($user_to_remove)
	{
		$loggedin_user=$this->user['username'];

		//remove the friend from the loggedin user friend list
		$userloggedin_friend_array=$this->user['friends_array'];
		$userloggedin_new_friend_array=str_replace($user_to_remove . ",", "", $userloggedin_friend_array);
		mysqli_query($this->con,"UPDATE users SET friends_array='$userloggedin_new_friend_array' WHERE username='$loggedin_user'");

		//remove the loggedin user from $user_to_remove friend list
		$query=mysqli_query($this->con,"SELECT friends_array FROM users WHERE username='$user_to_remove'");
		$row=mysqli_fetch_array($query);
		$friend_array=$row['friends_array'];
		$new_friend_array=str_replace($loggedin_user . ",", "", $friend_array);
		mysqli_query($this->con,"UPDATE users SET friends_array='$new_friend_array' WHERE username='$user_to_remove'");

	}

	public function sendRequest($user_to)
	{
		$loggedin_user=$this->user['username'];
		mysqli_query($this->con,"INSERT INTO friend_requests (user_from, user_to) VALUES ('$loggedin_user', '$user_to')");
	}


}
?>