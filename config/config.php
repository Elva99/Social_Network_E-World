<?php
ob_start();  //turns on output buffering
session_start();
$timezone=date_default_timezone_set("Canada/Eastern");
//connect to database Social_Network_db
$database_host='192.168.64.2';
$database_name='Social_Network_db';
$database_user='Elva';
$database_password='paopao1999';

//create mysql object
$mysqli=mysqli_connect($database_host,$database_user,$database_password,$database_name);

//error handler
if (mysqli_connect_error())
{
    echo 'This connection failed'.mysqli1_connect_error();
	die();
}
?>