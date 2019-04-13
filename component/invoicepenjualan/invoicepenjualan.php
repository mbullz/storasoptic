<?php

global $mysqli;

$query_data = "SELECT a.keluarbarang_id, a.referensi, a.tgl, a.total, a.info, 
					b.kontak, b.user_id as customer, c.matauang, 
					(SELECT SUM(jumlah) FROM aruskas d WHERE a.keluarbarang_id = d.transaction_id AND d.tipe = 'piutang') AS 'uang_muka', 
					a.tipe_pembayaran , a.lunas, 
					a.updated_by, 
					(SELECT kontak FROM kontak WHERE user_id = a.updated_by) AS nama_karyawan, 
					(SELECT kontak FROM kontak WHERE user_id = a.sales) AS nama_sales 
				FROM keluarbarang a 
				JOIN kontak b ON b.user_id = a.client 
				JOIN matauang c ON a.matauang_id = c.matauang_id 
				ORDER BY a.tgl DESC, a.keluarbarang_id DESC ";

$data = $mysqli->query($query_data);
$totalRows_data = mysqli_num_rows($data);

?>

<script type="text/javascript" language="javascript" src="js/apps/invoicepenjualan.js"></script>

<style>
	td.details-control {
		background: url('media/images/details_open.png') no-repeat center center;
		cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('media/images/details_close.png') no-repeat center center;
	}
</style>

<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
	<h1>Data Penjualan</h1>
	
	<?php if(strstr($_SESSION['akses'],"add_".$c)) { ?><a href="index-c-<?php echo $c;?>-t-add.pos"><img src="images/add.png" border="0"/>&nbsp;Tambah Data</a><?php } ?>
		  
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
	  <tr>
		<th width="2%" align="center"><label><input type="checkbox" name="checkbox" value="checkbox" onclick="if(this.checked) { for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=true;}}else{ for (i=0;i<<?php echo $totalRows_data;?>;i++){document.getElementById('data'+i).checked=false;}}"/></label></th>
		<th width="12%" align="center"><font color="#0000CC">TANGGAL</font></th>
		<th width="12%" align="center"><font color="#0000CC">NO. INV</font></th>
		<th width="16%" align="center"><font color="#0000CC">CUSTOMER</font></th>
		<th width="12%" align="center"><font color="#0000CC">TOTAL</font></th>
		<th align="center"><font color="#0000CC">INFO</font></th>
		<!--<th width="8%">Pengaturan</th>-->
	  </tr>
	  </thead>
		<tbody>
	  <?php $doneList = array(); $no=0; 
	  while ($row_data = mysqli_fetch_assoc($data)) { ?>
	  <?php
		// list detail barang
		$query_detbrg = "SELECT 
				a.id, a.qty, b.product_id, b.kode, b.barang, b.color, a.subtotal, a.harga, c.satuan_id as sid, c.satuan, d.jenis 
			FROM dkeluarbarang a 
			JOIN barang b on b.product_id = a.product_id 
			JOIN satuan c on c.satuan_id = a.satuan_id 
			JOIN jenisbarang d on d.brand_id = b.brand_id 
			WHERE a.keluarbarang_id = $row_data[keluarbarang_id] 
			ORDER BY a.id DESC ";

		$detbrg       = $mysqli->query($query_detbrg);
		$row_detbrg   = mysqli_fetch_assoc($detbrg);
		$total_detbrg = mysqli_num_rows($detbrg);
	  ?>
	  <tr valign="top">
		<td align="center">
			<input name="data[]" type="checkbox" id="data<?php echo $no;$no++;?>" value="<?php echo $row_data['referensi'];?>" />
		</td>
		<td align="center">
			<?php genDate($row_data['tgl']);?>
		</td>
		<td align="center">
			<a href="include/draft_invoice_1.php?keluarbarang_id=<?=$row_data['keluarbarang_id']?>" onclick="NewWindow(this.href,'name','720','520','yes'); return false;" title="Invoice <?=$row_data['referensi']?>">
				<?=$row_data['referensi']?>
			</a>
		</td>
		<td align="left">
			<?php echo $row_data['kontak'];?>
		</td>
		<td align="right">
			<?php if ($row_data['lunas'] == "1") echo "<img src='images/done.png' /> "; ?><?php echo number_format($row_data['total'],0,',','.');?> <?php echo $row_data['matauang'];?>
		</td>
		<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$row_data['info']?>
		<small style="float:right;"><img id="stat-<?php echo $row_data['referensi']; ?>" src="images/done.png" style="display:none" /> [ <a href="javascript:void(0);" onclick="viewInfo('info_<?php echo $row_data['referensi'];?>');">Lihat Info</a> ]</small>
		<table width="100%" border="0" cellpadding="2" cellspacing="0" id="info_<?php echo $row_data['referensi'];?>" style="display:none;">
		  <tr>
			<th width="185">Barang</th>
			<th valign="top" width="75">Qty</th>
			<th valign="top" width="100">Terkirim</th>
		  </tr>
		  <?php $done = true; do { ?>
		  <?php
		  //kirim barang
		$query_terbrg = "SELECT sum(qty) as kirim FROM kirimbarang WHERE keluarbarang_id = $row_data[keluarbarang_id] AND product_id = $row_detbrg[product_id] AND satuan_id = $row_detbrg[sid]";
		$terbrg       = $mysqli->query($query_terbrg);
		$row_terbrg   = mysqli_fetch_assoc($terbrg);
		//retur barang
		$query_retur  = "SELECT SUM(qty) AS retur FROM kirimbarang_r WHERE keluarbarang_id = $row_data[keluarbarang_id] AND product_id = $row_detbrg[product_id] AND satuan_id = $row_detbrg[sid]";
		$retur        = $mysqli->query($query_retur);
		$row_retur    = mysqli_fetch_assoc($retur);
		// ---
		$kirim        = intval($row_terbrg['kirim'] - $row_retur['retur']);
		  ?>
		  <tr>
			<td valign="top">
				<?php
					if ($row_detbrg['kode'] != "") echo $row_detbrg['kode'] . " # ";
				?><?php echo $row_detbrg['jenis']; ?> # <?php echo $row_detbrg['barang'];?> # <?=$row_detbrg['color']?>
				<?php if($row_detbrg['qty'] > $kirim) { $done = false; ?>
				<a href="index.php?component=<?php echo $c;?>&task=barangkeluar&id=<?php echo $row_detbrg['id'];?>" title="Input Barang Keluar">
					<img src="images/delivery.png" border="0" />
				</a>
				<?php }else{ ?>
				<img src="images/done.png" />
				<?php } ?>
				<?php if($kirim > 0) { ?>
				<a href="index-c-<?php echo $c;?>-t-barangreturkeluar-<?php echo $row_detbrg['id'];?>.pos" title="Retur Pengiriman Barang">
					<img src="images/trash.png" width="16" height="16" border="0" />
				</a>
				<?php } ?>
				<?php
					$rs3 = $mysqli->query("SELECT * FROM kirimbarang_r WHERE keluarbarang_id = $row_data[keluarbarang_id] AND product_id=$row_detbrg[product_id] ORDER BY id ASC");
					$r = 1;
					while ($data3 = mysqli_fetch_assoc($rs3))
					{
						?>
							<br />
							Retur <?=$r?> 
							<?php
								if ($data3['processed'] == "true")
								{
									?>
										<img src="images/done.png" />
									<?php
								}
								else
								{
									?>
										<img src="images/alert.gif" />
									<?php
								}
							?>
						<?php
						$r++;
					}
				?>
			</td>
			<td align="center" valign="top"><?php echo $row_detbrg['qty'];?> <?php echo $row_detbrg['satuan'];?></td>
			<td align="right" valign="top"><?php echo number_format($kirim,0,',','.');?> <?php echo $row_detbrg['satuan'];?></td>
			</tr>
		  <?php 
			}while($row_detbrg = mysqli_fetch_assoc($detbrg)); 
			if ($done) {
				array_push($doneList, $row_data['referensi']);
			}
		  ?>
			<tr>
				<td colspan="3" bgcolor="#DDDDDD">
					Karyawan : <?=$row_data['nama_karyawan']?>
				</td>
			</tr>
		</table></td>
		<!--<td align="center"><?php if(strstr($_SESSION['akses'],"edit_".$c)) { ?><a href="index.php?component=<?php echo $c;?>&amp;task=edit&amp;id=<?php echo $row_data['referensi'];?>" title="Edit Data"><img src="images/edit-icon.png" border="0" />Edit</a><?php } ?></td>-->
		</tr>
	  <?php } ?>
		</tbody>
	</table>
	
	  <?php if(strstr($_SESSION['akses'],"delete_".$c)) { ?>
		  <img src="images/arrow_ltr.png" />&nbsp;&nbsp;
		  <label>
		  <input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#006699;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="javascript:if(prompt('Kode Hapus :') == '1234') return confirm('Lanjutkan Proses ... ?'); else return false;"/>
		</label>
		<!--<a href="export_xls.php?tabel=keluarbarang" title="Export Data XLS"><img src="images/_xls.png" width="20" height="20" border="0" align="right" /></a>-->
	  <?php } ?>
	  
	  <br /><br />
	  
	  <div>
				Periode: 
				<span>
					<input type="text" class="calendar" placeholder="Tanggal Mulai" name="startPeriode" id="startPeriode" size="20" />
				</span>
				s/d 
				<span>
					<input type="text" class="calendar" placeholder="Tanggal Selesai" name="endPeriode" id="endPeriode" size="20" />
				</span><br>
				
				<label>
					<input type="radio" name="report" id="tipe1" />
					Laporan Data Penjualan:
				</label>
				<select id="tipe">
					<option value="1">Frame</option>
					<option value="2">Softlens</option>
					<option value="3">Lensa</option>
					<option value="4">Accessories</option>
				</select><br>
				
				<label>
					<input type="radio" name="report" id="tipe2" />
					Performance Selling:
				</label>
				<select id="urutanPenjualan">
					<option value="desc">Terbaik</option>
					<option value="asc">Terendah</option>
				</select>
				<br>
				
				<label>
					<input type="radio" name="report" id="tipe3" />
					Laporan Omset
				</label>
				<br>
				
			  <input type="button" value="Cetak" onclick="generateReport();" />
		  </div>
  </div>
</form>

<?php if (count($doneList) > 0) { ?>
<script type="text/javascript">
	<?php foreach($doneList as $lst) { ?>
	$("#stat-<?php echo $lst; ?>").show();
	<?php } ?>
</script>
<?php } ?>