<?php
session_start();
include('config_db.php');
include('function.php');
$ref = $_GET['referensi'];
// get order
$query_gorder = "SELECT a.referensi, a.tgl, a.info, a.sales, 
					(SELECT SUM(subtotal) FROM dmasukbarang WHERE noreferensi LIKE '$ref') AS total, 
					b.kontak, b.kperson, b.alamat, b.notlp, b.notlp2, b.hp, c.matauang 
				FROM masukbarang a 
				JOIN kontak b ON b.user_id = a.supplier 
				JOIN matauang c ON c.kode = a.matauang 
				WHERE a.referensi LIKE '$ref'";
$gorder       = $mysqli->query($query_gorder);
$row_gorder   = mysqli_fetch_assoc($gorder);
// list detail barang
$query_detbrg = "SELECT a.id, a.qty, a.subtotal, a.harga, a.tdiskon, a.diskon, 
					b.kode, b.barang, b.color, c.satuan_id as sid, c.satuan, d.jenis 
				FROM dmasukbarang a 
				JOIN barang b ON b.product_id = a.product_id 
				JOIN satuan c ON c.satuan_id = a.satuan_id 
				JOIN jenisbarang d ON d.brand_id = b.brand_id 
				WHERE a.noreferensi LIKE '$ref' 
				ORDER BY a.id ASC";
$detbrg       = $mysqli->query($query_detbrg)  or die(mysql_error());
$row_detbrg   = mysqli_fetch_assoc($detbrg);
$total_detbrg = mysqli_num_rows($detbrg);
// get sales / kary
$query_gkary = "select kontak from kontak where kode='$row_gorder[sales]'";
$gkary       = $mysqli->query($query_gkary);
$row_gkary   = mysqli_fetch_assoc($gkary);
?>
<style type="text/css" media="all">
body {
	margin:1px;
	padding:0;
	font-family:tahoma;
	color:#000;
}
#divInvoice {
	border:solid 1px #030303;
	
}
#divInvoice tr td {
	font-size:10px;
}
.garisbawah {
	border-bottom:solid 1px #000;	
}
#divOrder {
	border:solid 1px #999;	
}
#divOrder tr th {
	font-size:11px;
	font-weight:bold;
	background:#CCC;
}
</style>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="4" id="divInvoice">
  <tr>
    <td width="25%" align="right">&nbsp;</td>
    <td width="2%" align="center">&nbsp;</td>
    <td align="right"><strong>No. Invoice / Tanggal</strong></td>
    <td width="2%" align="center">:</td>
    <td width="20%" align="center" class="garisbawah"><?php echo $ref;?> / 
    <?php genDate($row_gorder['tgl']);?></td>
  </tr>
  <tr>
    <td><strong>Supplier</strong></td>
    <td align="center"><strong>:</strong></td>
    <td><?php echo $row_gorder['kontak'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Alamat</strong></td>
    <td align="center"><strong>:</strong></td>
    <td><?php echo $row_gorder['alamat'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Kontak Person</strong></td>
    <td align="center"><strong>:</strong></td>
    <td><?php echo $row_gorder['kperson'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>No. Tlp / Handphone</strong></td>
    <td align="center"><strong>:</strong></td>
    <td><?php echo $row_gorder['notlp'];?> - <?php echo $row_gorder['notlp2'];?> / <?php echo $row_gorder['hp'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="5" id="divOrder">
      <tr>
        <th width="4%">No</th>
        <th>Deskripsi Barang</th>
        <th width="12%">Qty</th>
        <th width="12%">Harga</th>
        <th width="12%">Diskon</th>
        <th width="18%">Subtotal</th>
      </tr>
      <?php $no = 1; do { ?>
      <tr valign="top">
        <td align="right" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;"><?php echo $no;$no++;?>.</td>
        <td style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;"><?php echo $row_detbrg['jenis'];?> # <?php echo $row_detbrg['barang'];?> # <?=$row_detbrg['color']?></td>
        <td align="center" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;"><?php echo $row_detbrg['qty'];?> <?php echo $row_detbrg['satuan'];?></td>
        <td align="right" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;"><?php echo number_format($row_detbrg['harga'],0,',','.');?></td>
        <td align="center" style="border-right:solid 1px #DDD;border-bottom:solid 1px #DDD;"><?php if($row_detbrg['tdiskon']==0) { echo number_format($row_detbrg['diskon'],0,',','.'); }else{ echo $row_detbrg['diskon']." %"; } ?></td>
        <td align="right" style="border-bottom:solid 1px #DDD;"><?php echo number_format($row_detbrg['subtotal'],0,',','.');?> <?php echo $row_gorder['matauang'];?></td>
      </tr>
      <?php }while($row_detbrg = mysqli_fetch_assoc($detbrg)); ?>
      <tr>
        <th>&nbsp;</th>
        <th colspan="4" align="right">Grand Total :</th>
        <td align="right" style="border-bottom:solid 1px #DDD;"><?php echo number_format($row_gorder['total'],0,',','.');?> <?php echo $row_gorder['matauang'];?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right"><strong>Terbilang </strong></td>
    <td align="center">:</td>
    <td align="center" class="garisbawah"><i><?php echo terBilang($row_gorder['total']);?> <?php echo $row_gorder['matauang'];?></i></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right"><strong> </strong></td>
    <td align="center"><strong> </strong></td>
    <td align="center"> </td>
  </tr>
</table>
</body>