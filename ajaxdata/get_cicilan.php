<?php
$jumlah = $_GET['jumlah'];
$tenor  = $_GET['tenor'];
$bunga  = ($_GET['bunga'] / 100) * $jumlah;
// ---
$jtenor = ($jumlah / $tenor) + $bunga;
?>
<input name="cicilan" type="text" id="cicilan" onkeypress="return isNumberKey(event)" value="<?php echo round($jtenor,0);?>" size="10" maxlength="10"/>