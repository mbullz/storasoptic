<?php
include('include/define.php');
//----
$b  = 30;
$bp = $b * $p;
//----
$query_data  = "select c.kode, c.barang, sum(b.qty) as qty, sum(b.subtotal) as subtotal from keluarbarang a, dkeluarbarang b, barang c, kontak d where a.referensi = b.noreferensi AND c.kode = b.barang AND d.kode = a.sales";
//----
$query_all   = $query_data;
// ---
if($q_ <>'' AND $q__ <>'') {
	$q_  = $_GET['q_'];
	$q__ = $_GET['q__'];
}else{
	$q_  = $periode_bulan;
	$q__ = $periode_tahun;
}
// ---
$last_tgl = jumlah_hari($q_,$q__);
// period rekap
$awal_period  = $q__."-".$q_."-01";
$akhir_period = $q__."-".$q_."-".$last_tgl;
// ---
$query_data .= " AND a.tgl >='$awal_period' AND a.tgl <='$akhir_period'";
$query_all  .= " AND a.tgl >='$awal_period' AND a.tgl <='$akhir_period'";
/*// ----
	$query_data .= " AND a.tgl >='$q__-$q_-01' AND a.tgl <='$q__-$q_-$last_tgl'";
//---- filter data*/
if($q <>'') {
	$query_data .= " AND (d.kontak LIKE '%$q%' OR d.kode LIKE '%$q%')";
	$query_all   = $query_data;
}
//----
$query_data .= " group by c.kode,c.barang limit $b offset $bp";
$data = $mysqli->query($query_data) or die(mysql_error());
$row_data = mysqli_fetch_assoc($data);
//---
$query_all .=" group by c.kode,c.barang";
$alldata = $mysqli->query($query_all);
$totalRows_data = mysqli_num_rows($alldata);
// --
$totalPages_data = ceil($totalRows_data / $b) - 1;
?>
<div class="tablebg">
  <h1 class="hide">Rekap Sales Monthly</strong> ( Product )</h1>
  <div id="reportsearch" class="hide">
  <label>
        <select name="q_" id="q_">
          <option value="01" <?php if ($q_ =='01') { echo "selected=\"selected\"";} ?>>Jan</option>
          <option value="02" <?php if ($q_ =='02') { echo "selected=\"selected\"";} ?>>Feb</option>
          <option value="03" <?php if ($q_ =='03') { echo "selected=\"selected\"";} ?>>Mar</option>
          <option value="04" <?php if ($q_ =='04') { echo "selected=\"selected\"";} ?>>Apr</option>
          <option value="05" <?php if ($q_ =='05') { echo "selected=\"selected\"";} ?>>May</option>
          <option value="06" <?php if ($q_ =='06') { echo "selected=\"selected\"";} ?>>Jun</option>
          <option value="07" <?php if ($q_ =='07') { echo "selected=\"selected\"";} ?>>Jul</option>
          <option value="08" <?php if ($q_ =='08') { echo "selected=\"selected\"";} ?>>Aug</option>
          <option value="09" <?php if ($q_ =='09') { echo "selected=\"selected\"";} ?>>Sep</option>
          <option value="10" <?php if ($q_ =='10') { echo "selected=\"selected\"";} ?>>Okt</option>
          <option value="11" <?php if ($q_ =='11') { echo "selected=\"selected\"";} ?>>Nov</option>
          <option value="12" <?php if ($q_ =='12') { echo "selected=\"selected\"";} ?>>Des</option>
          
        </select>
    </label>
        <label>
          <select name="q__" id="q__">
            <?php for($p1=2000;$p1<=$periode_tahun;$p1++) { ?>
            <option value="<?php echo $p1;?>" <?php if($p1 == $q__) { ?>selected="selected"<?php } ?>><?php echo $p1;?></option>
            <?php } ?>
          </select>
        </label>
        <label>
          <input name="q" type="text" id="q" value="<?php echo $q;?>" size="30" onkeypress="return event.keyCode!=13;"/>
        </label>
        <label>
          <input name="Search" type="button" id="Search" value="Pencarian" onclick="window.location='index.php?component=<?php echo $_GET['component'];?>&q_=' + document.getElementById('q_').value + '&q__=' + document.getElementById('q__').value + '&q=' + document.getElementById('q').value.replace(/ /g,'+');"/>
        </label>
  </div>
  <?php //if($q <>'' AND $q_ <>'') { ?>
  <br />
  <table class="datatable-print" width="700" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td colspan="5" style="border-top:solid 1px #000;border-left:solid 1px #000;"><table width="100%" border="0" cellpadding="2" cellspacing="0" id="head-report">
      <tr>
        <td width="15%" align="center" valign="top"><img src="images/chi_logo.jpg" hspace="0" vspace="0" /></td>
        <td align="center"><strong class="titleheader">REKAP SALES MONTHLY PER PRODUCT</strong><br />
          <span style="text-transform:uppercase;font-size:13px;letter-spacing:1px;">Solusi cepat untuk masalah Bisnis &amp; usaha anda<br/>
            copyright &copy; 2013 <?php echo $GLOBALS['company_name']; ?><br />
  <br />
          </span></td>
        <td width="15%" align="center"><strong>Rekap<br />
          Penjualan per Product</strong></td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
        <td align="center">Periode : <?php genDate($awal_period);?> s/d <?php genDate($akhir_period);?></td>
        <td align="right"><?php echo $totalRows_data." Data";?></td>
      </tr>
    </table></td>
    </tr>
    <tr>
      <th width="5%" style="border-left:solid 1px #000;">No</th>
      <th width="14%">Kode</th>
      <th>Product / Barang</th>
      <th width="8%">Qty</th>
      <th width="18%">Sales</th>
    </tr>
    <?php if($totalRows_data > 0) { ?>
    <?php $no=1; do { ?>
    <tr valign="top">
      <td align="right" style="border-left:solid 1px #000;"><?php echo $no;$no++;?>.</td>
      <td align="center"><?php echo $row_data['kode'];?></td>
      <td align="left"><?php echo $row_data['barang'];?></td>
      <td align="right"><?php echo number_format($row_data['qty'],0,',','.');?></td>
      <td align="right"><?php echo number_format($row_data['subtotal'],0,',','.');?></td>
      </tr>
      <?php if($no%30==0 AND $no <> 30) { ?>
      <tr>
        <td colspan="5" class="noborder" height="25px"><br /></td>
    </tr>
      <tr>
        <td colspan="5" style="border-left:solid 1px #000;border-top:solid 1px #000;"><table width="100%" border="0" cellpadding="2" cellspacing="0" id="head-report">
      <tr>
        <td width="15%" align="center" valign="top"><img src="images/chi_logo.jpg" hspace="0" vspace="0" /></td>
        <td align="center"><strong class="titleheader">REKAP SALES MONTHLY PER PRODUCT</strong><br />
          <span style="text-transform:uppercase;font-size:13px;letter-spacing:1px;">Solusi cepat untuk masalah Bisnis &amp; usaha anda<br/>
            copyright &copy; 2013 <?php echo $GLOBALS['company_name']; ?><br />
            <br />
          </span></td>
        <td width="15%" align="center"><strong>Rekap<br />
          Penjualan per Product</strong></td>
        </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
        <td align="center">Periode : <?php genDate($awal_period);?> s/d <?php genDate($akhir_period);?></td>
        <td align="right"><?php echo $totalRows_data." Data";?></td>
      </tr>
    </table></td>
    </tr>
      <tr>
        <th style="border-left:solid 1px #000;">No</th>
        <th>Kode</th>
        <th>Product / Barang</th>
        <th>Qty</th>
        <th>Sales</th>
      </tr>
    <?php } $no++; ?>
    <?php } while ($row_data = mysqli_fetch_assoc($data)); ?>
    <?php }else{ ?>
    <tr>
      <td colspan="5" style="border-left:solid 1px #000;">Data tidak ada</td>
    </tr>
    <?php } ?>
  </table>
</div>
<div class="notesetting">
<?php if($totalRows_data > $b) { ?>
<div align="center">
<table width="80%" border="0" cellpadding="5" align="center">
            <tr>
              <td align="center" style="border:none;"><?php if ($p > 0) { // Show if not first page ?>
                  <a href="<?php echo $currentPage;?>&page=0"><img src="images/first.png" border="0"/></a>
                  <?php } // Show if not first page ?>              </td>
              <td align="center" style="border:none;"><?php if ($p > 0) { // Show if not first page ?>
                  <a href="<?php echo $currentPage;?>&page=<?php echo $p-1;?>"><img src="images/prev.png" border="0"/></a>
                  <?php } // Show if not first page ?>              </td>
              <td width="23%" align="center" style="border:none;"><select id="paging" name="paging" onchange="javascript:window.location='<?php echo $currentPage;?>&page=' + document.getElementById('paging').value" style="text-align:center;">
                <option value="0" <?php if(empty($p) or $p==0) { ?>selected="selected"<?php } ?>>Pilih Halaman</option>
                <?php for($pn=1;$pn<=$totalPages_data;$pn++) { ?>
                <option value="<?php echo $pn;?>" <?php if($p==$pn) { ?>selected="selected"<?php } ?>><?php echo $pn." dari ".$totalPages_data;?></option>
                <?php } ?>
              </select></td>
              <td align="center" style="border:none;"><?php if ($p < $totalPages_data) { // Show if not last page ?>
                  <a href="<?php echo $currentPage;?>&page=<?php echo $p+1;?>"><img src="images/next.png" border="0"/></a>
                  <?php } // Show if not last page ?>              </td>
              <td align="center" style="border:none;"><?php if ($p < $totalPages_data) { // Show if not last page ?>
                  <a href="<?php echo $currentPage;?>&page=<?php echo $totalPages_data;?>"><img src="images/last.png" border="0"/></a>
                  <?php } // Show if not last page ?>              </td>
            </tr>
        </table>
</div>
<?php } ?>
  <strong class="subtitle_a">Setting Print Document :</strong>
  <ol>
    <li>A4 Paper</li>
    <li>Landscape Format</li>
    <li>Page Setup<br />
      - Format Orientation : 100%<br />
      - Cheked Print Background<br />
      - Margin Left, Top, Right : 5.0 mm<br />
      - Margin Bottom : 4.0 mm: 
    </li>
  </ol>
  <p class="hide" align="center"><a href="javascript:window.print();"><img src="images/print.png" hspace="4" border="0"/>Print Document</a></p>
</div>
<?php //} ?>