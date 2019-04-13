<?php
$awal  = $_GET['awal'];
$tenor = $_GET['tenor'];
// --- get end

$akhir = strtotime ( "+".$tenor." month" , strtotime ( $awal ) ) ;
$akhir = date ( 'Y-m' , $akhir );
?>
<input name="akhir" type="text" id="akhir" size="8" maxlength="5" readonly="readonly" value="<?php echo $akhir;?>"/>