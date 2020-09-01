<?php
include("../../config/config.php");
include("../classes/User.php");
include("../classes/Post.php");

$limit=10;   //Number ofo posts to be loaded

$posts=new Post($mysqli,$_REQUEST['userloggedin']);
$posts->loadPostsFriends($_REQUEST,$limit);
?>