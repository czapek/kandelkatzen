<?php

/**
 * Configuration for database connection
 *
 */

$host       = "192.168.2.129:3307";
$username   = "cat";
$password   = "MaunzeDong";
$dbname     = "catDb";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET lc_time_names='de_DE',NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
			  
function getRealIpAddr()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
	  $ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
	  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
	  $ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}