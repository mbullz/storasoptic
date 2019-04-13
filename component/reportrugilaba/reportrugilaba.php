<?php
include('include/define.php');
//----
if(empty($q)) {
	$q = date("Y");	
}
?>
<div class="tablebg">
  <h1 class="hide">Rekap Rugi Laba</h1>
  <div id="reportsearch" class="hide">
    <label>
  <select name="q" id="q">
            <?php for($p1=2000;$p1<=$periode_tahun;$p1++) { ?>
            <option value="<?php echo $p1;?>" <?php if($p1 == $q) { ?>selected="selected"<?php } ?>><?php echo $p1;?></option>
            <?php } ?>
          </select>
        </label>
    <label>
    <input name="Search" type="button" id="Search" value="Pencarian" onclick="window.location='index-c-<?php echo $_GET['component'];?>-q-' + document.getElementById('q').value + '.pos';"/>
        </label>
  </div>
  <?php if($q <>'') { ?>
  <br />
  <table class="datatable-print" width="700" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td colspan="6" style="border-top:solid 1px #000;border-left:solid 1px #000;"><table width="100%" border="0" cellpadding="2" cellspacing="0" id="head-report">
      <tr>
        <td width="15%" align="center" valign="top"><img src="images/chi_logo.jpg" hspace="0" vspace="0" /></td>
        <td align="center"><strong class="titleheader">REKAP RUGI LABA PERUSAHAAN</strong><br />
          <span style="text-transform:uppercase;font-size:13px;letter-spacing:1px;">Solusi cepat untuk masalah Bisnis &amp; usaha anda<br/>
            copyright &copy; 2013 <?php echo $GLOBALS['company_name']; ?><br />
  <br />
          </span></td>
        <td width="15%" align="center"><strong>Rekap<br />
          Rugilaba</strong></td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
        <td align="center">Tahun : <?php echo $q;?></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
    <tr>
      <th width="5%" style="border-left:solid 1px #000;">No</th>
      <th width="18%">Bulan</th>
      <th width="18%">Penjualan</th>
      <th width="18%">Pemb.  Hutang</th>
      <th width="18%">B. Operasional</th>
      <th width="18%">Saldo</th>
    </tr>
    <?php $r_jual = 0; $r_bayar = 0; $r_oprs = 0; $r_saldo = 0; for($ib=1;$ib<=12;$ib++) { ?>
    <?php
	$c_per = $q."-";
	if($ib < 10) {
		$c_per .="0";	
	}
	$c_per .=$ib;
	// get penjualan
	$query_jual   = "select sum(jumlah) as tjual from aruskas where tipe='piutang' AND tgl LIKE '%%$c_per%%'";
	$jual         = $mysqli->query($query_jual);
	$row_jual     = mysqli_fetch_assoc($jual);
	// get pemb.hutang
	$query_hutang = "select sum(jumlah) as tbayar from aruskas where tipe='hutang' AND tgl LIKE '%%$c_per%%'";
	$hutang       = $mysqli->query($query_hutang);
	$row_hutang   = mysqli_fetch_assoc($hutang);
	// get operasional
	$query_oprs   = "select sum(jumlah) as toprs from aruskas where tipe='operasional' AND tgl LIKE '%%$c_per%%'";
	$oprs         = $mysqli->query($query_oprs);
	$row_oprs     = mysqli_fetch_assoc($oprs);
	// ---
	$saldo        = intval($row_jual['tjual'] - ($row_hutang['tbayar'] + $row_oprs['toprs']));
	$r_saldo += $saldo;
	?>
    <tr valign="top">
      <td align="right" style="border-left:solid 1px #000;"><?php echo $ib;?>.</td>
      <td align="center"><?php $per = $q."-".$ib."-01"; genPeriod($per);?></td>
      <td align="right"><?php echo number_format(intval($row_jual['tjual']),0,',','.'); $r_jual += intval($row_jual['tjual']);?></td>
      <td align="right"><?php echo number_format(intval($row_hutang['tbayar']),0,',','.'); $r_bayar += intval($row_hutang['tbayar']);?></td>
      <td align="right"><?php echo number_format(intval($row_oprs['oprs']),0,',','.'); $r_oprs += intval($row_oprs['oprs']);?></td>
      <td align="right"><?php if($saldo >= 0) { echo number_format($saldo,0,',','.'); }else{ echo "( ".number_format(str_replace("-","",$saldo),0,',','.')." )"; }?></td>
      </tr>
      <?php } ?>
      <tr valign="top">
      <td align="right" style="border-left:solid 1px #000;">&nbsp;</td>
      <td align="right"><strong>Total :</strong></td>
      <td align="right"><?php echo number_format($r_jual,0,',','.');?></td>
      <td align="right"><?php echo number_format($r_bayar,0,',','.');?></td>
      <td align="right"><?php echo number_format($r_oprs,0,',','.');?></td>
      <td align="right"><?php if($r_saldo >= 0) { echo number_format($r_saldo,0,',','.'); }else{ echo "( ".number_format(str_replace("-","",$r_saldo),0,',','.')." )"; }?></td>
    </tr>
  </table>
</div>
<div class="notesetting">
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
<?php } ?>