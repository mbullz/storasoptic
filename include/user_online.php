<?php
// get user online
$query_uonline = "select nik from loginlog where nik <> '$_SESSION[i_sesadmin]'";
$uonline       = $mysqli->query($query_uonline);
$total_uonline = mysqli_num_rows($uonline);
?>
<a href="index.php?component=useronline" title="<?php echo $total_uonline;?> User Online"><img src="images/status_online.png" /> <?php echo $total_uonline;?></a>