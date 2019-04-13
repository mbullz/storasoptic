<?php
session_start();
include('../include/config_db.php');
// get variable
$tsk = $_GET['task'];
$rid = $_GET['rid'];
$ref = $_GET['ref'];
$bar = $_GET['barang'];
$qty = $_GET['qty'];
$tdi = $_GET['tdiskon'];
$dis = $_GET['diskon'];
$sat = $_GET['satuan'];
$hsa = $_GET['hsatuan'];
$sub = $_GET['subtotal'];
// validasi data
if($tsk =='add' || $tsk == "add2") {
	if($bar=='' OR $qty <= 0 OR $sat=='' OR $hsa <= 0 OR $sub <= 0) {
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
	
	if ($tsk == "add2")
	{
		$type = $_GET['type'];
		$brand = $_GET['brand'];
		$warna = $_GET['warna'];
		$frame = $_GET['frame'];
		$kode_harga = $mysqli->real_escape_string($_GET['kode_harga']);
		$supplier = $mysqli->real_escape_string($_GET['supplier']);
		
		$mysqli->query("INSERT INTO barang VALUES(0,'',$brand,'$bar','$frame','$warna',0,$hsa,0,'$kode_harga','$supplier','',$type,NOW(),NULL,$_SESSION[user_id],NOW(),NULL,NULL)");
		$rs2 = $mysqli->query("SELECT LAST_INSERT_ID()");
		$data2 = mysqli_fetch_assoc($rs2);
		
		$bar = $data2[0];
		$tsk = "add";
	}
	
	if($tsk == 'add') {
		// cek pembelian barang
			$query_cekbrg   = "select * from dmasukbarang where product_id=$bar AND satuan_id=$sat AND noreferensi='$ref'";
			$cekbrg         = $mysqli->query($query_cekbrg) or die(mysql_error());
			$row_cekbrg     = mysqli_fetch_assoc($cekbrg);
			$total_cekbrg   = mysqli_num_rows($cekbrg);
			// save barang
			if($total_cekbrg == 0)
			{ 
				$query_ajaxsave = "insert into dmasukbarang values (0,$bar,$sat,$hsa,$qty,'$tdi','$dis','$sub','$ref')";
			}
			else
			{
				$qty_now      = $row_cekbrg['qty'] + $qty;
				$total_now    = $qty_now * $hsa;
				$query_ajaxsave = "update dmasukbarang set qty=$qty_now, subtotal='$total_now', harga=$hsa, tdiskon='$tdi', diskon='$dis' where id='$row_cekbrg[id]'";
			}
			$ajaxsave       = $mysqli->query($query_ajaxsave) or die(mysql_error());
	}else{
		$query_ajaxsave = "delete from dmasukbarang where id='$rid'";
		$ajax_save      = $mysqli->query($query_ajaxsave);
	}
}
// get masterbarang
$query_mbarang = "select a.product_id, a.kode, a.barang, b.jenis, a.color from barang a, jenisbarang b where a.brand_id = b.brand_id order by b.jenis, a.barang";
$mbarang       = $mysqli->query($query_mbarang);
$row_mbarang   = mysqli_fetch_assoc($mbarang);
$total_mbarang = mysqli_num_rows($mbarang);
// getsatuan
$query_satuan = "select satuan_id,satuan from satuan order by satuan";
$satuan       = $mysqli->query($query_satuan);
$row_satuan   = mysqli_fetch_assoc($satuan);
$total_satuan = mysqli_num_rows($satuan);
// list detail barang
$query_detbrg = "select a.id, a.qty, b.kode, b.barang, a.subtotal, a.harga, a.tdiskon, a.diskon, c.satuan, d.jenis, b.color from dmasukbarang a, barang b, satuan c, jenisbarang d where a.product_id = b.product_id AND a.satuan_id = c.satuan_id AND b.brand_id = d.brand_id AND a.noreferensi='$ref' order by a.id desc";
$detbrg       = $mysqli->query($query_detbrg);
$row_detbrg   = mysqli_fetch_assoc($detbrg);
$total_detbrg = mysqli_num_rows($detbrg);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="datatable">
        <tr>
          <th>Nama Barang</th>
          <th width="6%">Qty</th>
          <th width="10%">Satuan</th>
          <th width="10%">Price List</th>
          <th width="14%">Pot. Diskon</th>
          <th width="10%">Sub Total</th>
          <th width="8%">Pengaturan</th>
        </tr>
        <?php if($total_detbrg > 0) { $gtotal = 0; do { ?>
        <tr valign="top">
          <td><?php echo $row_detbrg['jenis'];?> - <?php echo $row_detbrg['barang'];?> - <?=$row_detbrg['color']?></td>
          <td align="center"><?php echo $row_detbrg['qty'];?></td>
          <td align="center"><?php echo $row_detbrg['satuan'];?></td>
          <td align="right"><?php echo number_format($row_detbrg['harga'],0,',','.');?></td>
          <td align="right"><?php if($row_detbrg['tdiskon']=='1') { echo $row_detbrg['diskon']." %"; }else{ echo number_format($row_detbrg['diskon'],0,',','.');}?></td>
          <td align="right"><?php echo number_format($row_detbrg['subtotal'],0,',','.'); $gtotal += $row_detbrg['subtotal'];?></td>
          <td width="10%" align="center"><a href="javascript:void(0);" onclick="manageInvoiceBeli('delete','<?php echo $row_detbrg['id'];?>');"><img src="images/close-icon.png" border="0" /> Hapus</a></td>
        </tr>
        <?php } while($row_detbrg = mysqli_fetch_assoc($detbrg)); ?>
        <tr valign="top">
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="right">Grand Total :</td>
          <td align="right">&nbsp;</td>
          <td align="right"><?php echo number_format($gtotal,0,',','.');?></td>
          <td align="center"><input type="hidden" name="total" id="total" value="<?php echo $gtotal;?>"></td>
        </tr>
        <?php } ?>
        <?php if($valid=='no') { ?>
        <tr valign="top" bgcolor="#FFFFFF">
          <td colspan="7" style="color:#F00;"><img src="images/alert.gif" hspace="5" vspace="2" border="0" align="left" /> Lengkapi barang, qty, satuan, dan harga satuan dengan benar !!!</td>
        </tr>
        <?php } ?>
        <tr valign="top">
          <td>
          	<input type="checkbox" id="checkBarangBaru" onchange="barangBaru(this.checked)" />Barang Baru
            <br />
            <div id="tableDetail1">
          <label>
            <select name="qbrg" id="qbrg" onchange="getMasterBarang(this.value, 1)">
            	<option value="">-- Search Brand --</option>
                <?php
					$rs2 = $mysqli->query("SELECT * FROM jenisbarang WHERE tipe = 1 ORDER BY jenis ASC");
					while ($data2 = mysqli_fetch_assoc($rs2))
					{
						?>
                        	<option value="<?=$data2['brand_id']?>"><?=$data2['jenis']?></option>
                    	<?php
					}
				?>
            </select>
          </label>
            <label id="divMBarang">
              <select name="barang" id="barang">
                <option value="">-- Choose Product --</option>
                <?php if($total_mbarang > 0) { do { ?>
                <option value="<?php echo $row_mbarang['product_id'];?>"><?php echo $row_mbarang['jenis'];?> - <?php echo $row_mbarang['barang'];?> - <?=$row_mbarang['color']?></option>
                <?php }while($row_mbarang = mysqli_fetch_assoc($mbarang)); } ?>
              </select>
            </label>
            </div>
            <div id="tableDetail2" style="display:none">
		<table cellspacing="0">
                	<tr>
                    	<td width="80px">
                        	Tipe
                        </td>
                        
                        <td width="20px">
                        	:
                        </td>
                        
                        <td>
							<select id="tipe2">
                    			<option value="1">FRAME</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                        	Frame
                        </td>
                        
                        <td>
                        	:
                        </td>
                        
                        <td>
                        	<select id="frame2" name="frame2">
                                <option>-- Choose Frame --</option>
                                <?php
                                    $rs3 = $mysqli->query("SELECT * FROM frame_type");
                                    while ($data3 = mysqli_fetch_assoc($rs3))
                                    {
                                        ?>
                                            <option value="<?=$data3['frame']?>"><?=$data3['frame']?></option>
                                        <?php
                                    }
                                ?>
                            </select><img src="images/plus2.png" height="20px" style="cursor:pointer;margin-left:10px;vertical-align:bottom" onclick="newItem('frame')" />
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                        	Brand
                        </td>
                        
                        <td>
                        	:
                        </td>
                        
                        <td>
                        	<select name="brand2" id="brand2">
                                <option>-- Choose Brand --</option>
                                <?php
                                    $rs2 = $mysqli->query("SELECT * FROM jenisbarang ORDER BY jenis ASC");
                                    while ($data2 = mysqli_fetch_assoc($rs2))
                                    {
                                        ?>
                                            <option value="<?=$data2['brand_id']?>"><?=$data2['jenis']?></option>
                                        <?php
                                    }
                                ?>
                            </select><img src="images/plus2.png" height="20px" style="cursor:pointer;margin-left:10px;vertical-align:bottom" onclick="newItem('brand')" />
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                        	Tipe Frame
                        </td>
                        
                        <td>
                        	:
                        </td>
                        
                        <td>
                        	<input type="text" name="barang2" id="barang2" />
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                        	Warna
                        </td>
                        
                        <td>
                        	:
                        </td>
                        
                        <td>
                        	<select id="warna2" name="warna2">
                                <option>-- Choose Color --</option>
                                <?php
                                    $rs3 = $mysqli->query("SELECT * FROM color_type ORDER BY color ASC");
                                    while ($data3 = mysqli_fetch_assoc($rs3))
                                    {
                                        ?>
                                            <option value="<?=$data3['color']?>"><?=$data3['color']?></option>
                                        <?php
                                    }
                                ?>
                            </select><img src="images/plus2.png" height="20px" style="cursor:pointer;margin-left:10px;vertical-align:bottom" onclick="newItem('color')" />
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                        	Kode Harga
                        </td>
                        
                        <td>
                        	:
                        </td>
                        
                        <td>
                        	<input type="text" name="kode_harga2" id="kode_harga2" />
                        </td>
                    </tr>
                </table>
            </div>
            </td>
          <td align="center"><label>
            <input name="qty" type="text" id="qty" size="4" maxlength="8" value="0" onchange="javascript:if(this.value &gt; 0) { this.form.subtotal.value = this.value * this.form.hsatuan.value; }else{ this.value=0;}" onfocus="javascript:if(this.value == '0') this.value=''" onblur="javascript:if(this.value == '') this.value='0'" />
          </label></td>
          <td align="center"><label>
            <select name="satuan" id="satuan">
              <option value="">Pilih Satuan</option>
              <?php if($total_satuan > 0) { do { ?>
              <option value="<?php echo $row_satuan['satuan_id'];?>"><?php echo $row_satuan['satuan'];?></option>
              <?php }while($row_satuan = mysqli_fetch_assoc($satuan)); } ?>
            </select>
          </label></td>
          <td align="center"><label>
            <input name="hsatuan" type="text" id="hsatuan" size="10" maxlength="10" value="0" onchange="javascript:if(this.value &gt; 0) { this.form.subtotal.value = this.value * this.form.qty.value; }else{ this.value=0;}" onfocus="javascript:if(this.value == '0') this.value=''" onblur="javascript:if(this.value == '') this.value='0'" />
          </label></td>
          <td align="center"><label>
            <select name="tdiskon" id="tdiskon" style="font-size:9px;" onchange="javascript:if(this.form.tdiskon.value == 1) { this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - ((this.form.hsatuan.value * this.form.qty.value * this.form.diskon.value) / 100); }else{ this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - this.value; }">
              <option value="0">Normal</option>
              <option value="1">%</option>
            </select>
          </label>
            <label>
              <input name="diskon" type="text" id="diskon" size="8" maxlength="8" value="0" onchange="javascript:if(this.form.tdiskon.value == 1) { this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - ((this.form.hsatuan.value * this.form.qty.value * this.value) / 100); }else{ this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - this.value; }" style="font-size:9px;" onfocus="javascript:if(this.value == '0') this.value=''" onblur="javascript:if(this.value == '') this.value='0'" />
          </label></td>
          <td align="center"><label>
            <input name="subtotal" type="text" id="subtotal" size="10" maxlength="10" value="0" onfocus="this.blur();" style="background:#DDD;border:solid 1px #BBB;"/>
          </label></td>
          <td width="10%" align="center"><a href="javascript:void(0);" onclick="manageInvoiceBeli('add','');"><img src="images/add.png" border="0" /> Tambah</a></td>
        </tr>
      </table>