<?php
include('../include/config_db.php');
// get variable
$tsk = $_GET['task'];
$rid = $_GET['rid'];
$kon = $_GET['kontak'];
$bar = $_GET['barang'];
$qty = $_GET['qty'];
$per = $_GET['periode'];
$sat = $_GET['satuan'];
$hsa = $_GET['hsatuan'];
$sub = $_GET['subtotal'];
// validasi data
if($tsk =='add') {
	if($per=='' OR $kon=='' OR $bar=='' OR $qty <= 0 OR $sat=='' OR $hsa <= 0 OR $sub <= 0) {
		$valid = 'no';	
	}else{
		$valid = 'yes';
	}
}else if($tsk=='delete') {
	if($rid=='') {
		$valid = 'no';	
	}else{
		$valid = 'yes';
	}
}
// proses save
if($valid=='yes') {
	if($tsk == 'add') {
		// cek pembelian barang
			$query_cekbrg   = "select * from targetpm_d where barang='$bar' AND satuan='$sat' AND periode='$per' AND kontak='$kon'";
			$cekbrg         = $mysqli->query($query_cekbrg) or die(mysql_error());
			$row_cekbrg     = mysqli_fetch_assoc($cekbrg);
			$total_cekbrg   = mysqli_num_rows($cekbrg);
			// save barang
			if($total_cekbrg == 0) { 
				$query_ajaxsave = "insert into  targetpm_d (barang,satuan,harga,qty,periode,subtotal,kontak) values ('$bar','$sat','$hsa','$qty','$per','$sub','$kon')";
			}else{
				$qty_now      = $row_cekbrg['qty'] + $qty;
				$total_now    = $qty_now * $hsa;
				$query_ajaxsave = "update targetpm_d set qty='$qty_now', subtotal='$total_now', harga='$hsa' where id='$row_cekbrg[id]'";
			}
			$ajaxsave       = $mysqli->query($query_ajaxsave) or die(mysql_error());
	}else{
		$query_ajaxsave = "delete from targetpm_d where id='$rid'";
		$ajax_save      = $mysqli->query($query_ajaxsave);
	}
}
// get masterbarang
$query_mbarang = "select a.kode, a.barang, b.jenis from barang a, jenisbarang b where a.jenis = b.kode order by b.jenis, a.barang";
$mbarang       = $mysqli->query($query_mbarang);
$row_mbarang   = mysqli_fetch_assoc($mbarang);
$total_mbarang = mysqli_num_rows($mbarang);
// getsatuan
$query_satuan = "select kode,satuan from satuan order by satuan";
$satuan       = $mysqli->query($query_satuan);
$row_satuan   = mysqli_fetch_assoc($satuan);
$total_satuan = mysqli_num_rows($satuan);
// list detail barang
$query_detbrg = "select a.id, a.qty, b.kode, b.barang, a.subtotal, a.harga, c.satuan, d.jenis from targetpm_d a, barang b, satuan c, jenisbarang d where a.barang = b.kode AND a.satuan = c.kode AND b.jenis = d.kode AND a.periode='$per' AND a.kontak='$kon' order by a.id desc";
$detbrg       = $mysqli->query($query_detbrg);
$row_detbrg   = mysqli_fetch_assoc($detbrg);
$total_detbrg = mysqli_num_rows($detbrg);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="datatable">
        <tr>
          <th>Nama Barang</th>
          <th width="6%">Qty</th>
          <th width="10%">Satuan</th>
          <th width="10%">Harga Satuan</th>
          <th width="10%">Sub Total</th>
          <th width="8%">Pengaturan</th>
        </tr>
        <?php if($total_detbrg > 0) { $gtotal = 0; do { ?>
        <tr valign="top">
          <td><?php echo $row_detbrg['jenis'];?> -  <?php echo $row_detbrg['barang'];?></td>
          <td align="center"><?php echo $row_detbrg['qty'];?></td>
          <td align="center"><?php echo $row_detbrg['satuan'];?></td>
          <td align="right"><?php echo number_format($row_detbrg['harga'],0,',','.');?></td>
          <td align="right"><?php echo number_format($row_detbrg['subtotal'],0,',','.'); $gtotal += $row_detbrg['subtotal'];?></td>
          <td align="center"><a href="javascript:void(0);" onclick="manageTargetJual('delete','<?php echo $row_detbrg['id'];?>');"><img src="images/close-icon.png" border="0" /> Hapus</a></td>
        </tr>
        <?php } while($row_detbrg = mysqli_fetch_assoc($detbrg)); ?>
        <tr valign="top">
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right">Target Total :</td>
          <td align="right"><?php echo number_format($gtotal,0,',','.');?></td>
          <td align="center"><input type="hidden" name="target" id="target" value="<?php echo $gtotal;?>"></td>
        </tr>
        <?php } ?>
        <?php if($valid=='no') { ?>
        <tr valign="top" bgcolor="#FFFFFF">
          <td colspan="6" style="color:#F00;"><img src="images/alert.gif" hspace="5" vspace="2" border="0" align="left" /> Lengkapi barang, qty, satuan, dan harga satuan dengan benar !!!</td>
        </tr>
        <?php } ?>
        <tr valign="top">
          <td><label>
            <input name="qbrg" type="text" id="qbrg" size="16" maxlength="30" placeholder="Cari Master Barang ..." onchange="getMasterBarang(this.value);"/>
          </label>
            <label id="divMBarang">
              <select name="barang" id="barang">
                <option value="">Pilih Master Barang</option>
                <?php if($total_mbarang > 0) { do { ?>
                <option value="<?php echo $row_mbarang['kode'];?>"><?php echo $row_mbarang['jenis'];?> - <?php echo $row_mbarang['barang'];?></option>
                <?php }while($row_mbarang = mysqli_fetch_assoc($mbarang)); } ?>
              </select>
            </label></td>
          <td align="center"><label>
            <input name="qty" type="text" id="qty" size="6" maxlength="8" value="0" onchange="javascript:if(this.value &gt; 0) { this.form.subtotal.value = this.value * this.form.hsatuan.value; }else{ this.value=0;}"/>
          </label></td>
          <td align="center"><label>
            <select name="satuan" id="satuan">
              <option value="">Pilih Satuan</option>
              <?php if($total_satuan > 0) { do { ?>
              <option value="<?php echo $row_satuan['kode'];?>"><?php echo $row_satuan['satuan'];?></option>
              <?php }while($row_satuan = mysqli_fetch_assoc($satuan)); } ?>
            </select>
          </label></td>
          <td align="center"><label>
            <input name="hsatuan" type="text" id="hsatuan" size="10" maxlength="10" value="0" onchange="javascript:if(this.value &gt; 0) { this.form.subtotal.value = this.value * this.form.qty.value; }else{ this.value=0;}"/>
          </label></td>
          <td align="center"><label>
            <input name="subtotal" type="text" id="subtotal" size="10" maxlength="10" value="0" onfocus="this.blur();" style="background:#DDD;border:solid 1px #BBB;"/>
          </label></td>
          <td align="center"><a href="javascript:void(0);" onclick="manageTargetJual('add','');"><img src="images/add.png" border="0" /> Tambah</a></td>
        </tr>
      </table>