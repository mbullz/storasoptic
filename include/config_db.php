<?php
error_reporting(E_ALL);
date_default_timezone_set("Asia/Jakarta");

// define variable connection
$host      = "localhost";
//$port    = "5432";
$dbname    = "optic";
$user      = "root";
$password  = "";
// ----
//$c_value = "host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$password;
// connect db
$mysqli = mysqli_connect($host,$user,$password, $dbname);

if(!$mysqli)
{
	die("Failed to connect database, contact your administrator system !!!");
}

// define variable config
$base_url = "";

$company_name = '';
$company_address = '';

$rs = $mysqli->query("SELECT * FROM config WHERE config LIKE 'company_name'");
if ($data = mysqli_fetch_assoc($rs))
{
	$company_name = $data['value'];
	$company_address .= $data['value'] . "<br>";
}

$rs = $mysqli->query("SELECT * FROM config WHERE config LIKE 'company_address'");
if ($data = mysqli_fetch_assoc($rs))
{
	$company_address .= $data['value'] . "<br>";
}

$rs = $mysqli->query("SELECT * FROM config WHERE config LIKE 'company_telephone'");
if ($data = mysqli_fetch_assoc($rs))
{
	$company_address .= $data['value'];
}

$rs = $mysqli->query("SELECT * FROM config WHERE config LIKE 'base_url'");
if ($data = mysqli_fetch_assoc($rs))
{
	$base_url = $data['value'];
}

?>