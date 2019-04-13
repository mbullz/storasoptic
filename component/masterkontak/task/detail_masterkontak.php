<?php
$id = $_GET['id'];
include('include/define.php');
if($klas=='supplier') {
	// query beli
	$query_data = "select a.tgl, a.referensi, d.jenis, c.barang, b.qty, b.harga, b.tdiskon, b.diskon, b.subtotal, e.satuan, f.kontak, g.matauang from masukbarang a, dmasukbarang b, barang c, jenisbarang d, satuan e, kontak f, matauang g where a.supplier='$id' AND a.referensi = b.noreferensi AND b.barang = c.kode AND c.jenis = d.kode AND b.satuan = e.kode AND f.kode = a.supplier AND g.kode = a.matauang";
}else{
	// query jual
	$query_data  = "select a.tgl, a.referensi, d.jenis, c.barang, b.qty, b.harga, b.tdiskon, b.diskon, b.subtotal, e.satuan, f.kontak, g.matauang from keluarbarang a, dkeluarbarang b, barang c, jenisbarang d, satuan e, kontak f, matauang g";
	if($klas=='customer') {
		$query_data .=" where a.client='$id' AND f.kode = a.client";
	}else{
		$query_data .=" where a.sales='$id' AND f.kode = a.sales";
	}
	$query_data .=" AND a.referensi = b.noreferensi AND b.barang = c.kode AND c.jenis = d.kode AND b.satuan = e.kode AND g.kode = a.matauang";
}
$query_all   = $query_data;
// ----
/*if($q <>'') {
	$query_data .= " AND (a.kode LIKE '%$q%' OR a.kontak LIKE '%$q%' OR a.alamat LIKE '%$q%' OR a.info LIKE '%$q%' OR b.jenis LIKE '%$q%' OR a.kperson LIKE '%$q%' OR a.pinbb LIKE '%$q%')";	
	$query_all  .= " AND (a.kode LIKE '%$q%' OR a.kontak LIKE '%$q%' OR a.alamat LIKE '%$q%' OR a.info LIKE '%$q%' OR b.jenis LIKE '%$q%' OR a.kperson LIKE '%$q%' OR a.pinbb LIKE '%$q%')";
}*/
//----
$query_data .= " order by a.tgl desc limit $b offset $bp";
$data = $mysqli->query($query_data) or die(mysql_error());
$row_data = mysqli_fetch_assoc($data);
//---
$alldata = $mysqli->query($query_all);
$totalRows_data = mysqli_num_rows($alldata);
// --
$totalPages_data = ceil($totalRows_data / $b) - 1;
?>
<div class="tablebg">
  <h1><?php if($klas=='supplier') { ?>Pembelian<?php }else{ ?>Penjualan<?php } ?> <?php echo $row_data['kontak'];?></h1>
  <span><a href="javascript:window.print();"><img src="images/print.png" border="0"/>&nbsp;Print</a></span>
  <table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <th width="12%">Tanggal</th>
      <th width="14%">No.</th>
      <th>Deskripsi Barang</th>
      <th width="10%">Qty</th>
      <th width="12%">Harga Satuan</th>
      <th width="12%">Diskon</th>
      <th width="12%">Subtotal</th>
    </tr>
    <?php if($totalRows_data > 0) { ?>
    <?php $no=0; do { ?>
      <tr valign="top">
        <td align="center"><?php genDate($row_data['tgl']);?></td>
        <td align="center"><a href="include/draft_<?php if($klas=='supplier') { ?>po<?php }else{ ?>invoice<?php } ?>.php?referensi=<?php echo $row_data['referensi'];?>" onclick="NewWindow(this.href,'name','720','520','yes');return false" title="Draft Invoice <?php echo $row_data['referensi'];?>"><?php echo $row_data['referensi'];?></a></td>
        <td align="left"><?php echo $row_data['jenis'];?> - <?php echo $row_data['barang'];?></td>
        <td align="right"><?php echo $row_data['qty'];?> <?php echo $row_data['satuan'];?></td>
        <td align="right"><?php echo number_format($row_data['harga'],0,',','.');?></td>
        <td align="center"><?php if($row_data['tdiskon']==0) { echo number_format($row_data['diskon'],0,',','.'); }else{ echo $row_data['diskon']." %"; } ?></td>
        <td align="right"><?php echo number_format($row_data['subtotal'],0,',','.');?> <?php echo $row_data['matauang'];?></td>
      </tr>
      <?php } while ($row_data = mysqli_fetch_assoc($data)); ?>
    <?php }else{ ?>
    <tr>
      <td colspan="8">Data tidak ada</td>
    </tr>
    <?php } ?>
    <?php if($totalRows_data > $b) { ?>
    <tr>
      <td colspan="8"><table width="10%" border="0" align="left" cellpadding="5">
            <tr>
              <td align="center" style="border:none;"><?php if ($p > 0) { // Show if not first page ?>
                  <a href="<?php echo str_replace(".pos","",$currentPage);?>-p-0.pos"><img src="images/first.png" border="0"/></a>
                  <?php } // Show if not first page ?>              </td>
              <td align="center" style="border:none;"><?php if ($p > 0) { // Show if not first page ?>
                  <a href="<?php echo str_replace(".pos","",$currentPage);?>-p-<?php echo $p-1;?>.pos"><img src="images/prev.png" border="0"/></a>
                  <?php } // Show if not first page ?>              </td>
              <td width="23%" align="center" style="border:none;"><select id="paging" name="paging" onchange="javascript:window.location='<?php echo str_replace(".pos","",$currentPage);?>-p-' + document.getElementById('paging').value + '.pos';" style="text-align:center;">
                <option value="0" <?php if(empty($p) or $p==0) { ?>selected="selected"<?php } ?>>Pilih Halaman</option>
                <?php for($pn=1;$pn<=$totalPages_data;$pn++) { ?>
                <option value="<?php echo $pn;?>" <?php if($p==$pn) { ?>selected="selected"<?php } ?>><?php echo $pn." dari ".$totalPages_data;?></option>
                <?php } ?>
              </select></td>
              <td align="center" style="border:none;"><?php if ($p < $totalPages_data) { // Show if not last page ?>
                  <a href="<?php echo str_replace(".pos","",$currentPage);?>-p-<?php echo $p+1;?>.pos"><img src="images/next.png" border="0"/></a>
                  <?php } // Show if not last page ?>              </td>
              <td align="center" style="border:none;"><?php if ($p < $totalPages_data) { // Show if not last page ?>
                  <a href="<?php echo str_replace(".pos","",$currentPage);?>-p-<?php echo $totalPages_data;?>.pos"><img src="images/last.png" border="0"/></a>
                  <?php } // Show if not last page ?>              </td>
            </tr>
      </table></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="8" align="right"><span style="border-bottom:double #333333;padding:2px;"><?php echo $totalRows_data." Data";?></span> </td>
    </tr>
  </table>
  </div>
</form>