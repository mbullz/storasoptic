<?php 
	include('include/config_db.php');
	session_start();
	// delete loginlog
	$mysqli->query("delete from loginlog where nik='$_SESSION[i_sesadmin]'");
	// ----
	unset($_SESSION['akses'],$_SESSION['i_sesadmin']);
	session_destroy();
	header("Location:index.php");
?>