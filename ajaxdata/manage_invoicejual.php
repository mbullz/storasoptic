<?php
session_start();
include('../include/config_db.php');
// get variable
$tsk = $_GET['task'];
$rid = $_GET['rid'];
$keluarbarang_id = $_GET['keluarbarang_id'] ?? 0;
$ref = $mysqli->real_escape_string($_GET['ref']);
$bar = $_GET['brg'] ?? 0;
$bar = $bar == '' ? 0 : $bar;
$qty = $_GET['qty'];
$tdi = $_GET['tdisc'];
$dis = $_GET['disc'];
$sat = $_GET['sat'];
$hsa = $_GET['hsat'];
$sub = $_GET['subtot'];

$sosoftlens = $_GET['sosoftlens'];

$lensa_product_id = 0;

$rSph = $_GET['rSph'];
$rCyl = $_GET['rCyl'];
$rAxis = $_GET['rAxis'];
$rAdd = $_GET['rAdd'];
$rPd = $_GET['rPd'];

$lSph = $_GET['lSph'];
$lCyl = $_GET['lCyl'];
$lAxis = $_GET['lAxis'];
$lAdd = $_GET['lAdd'];
$lPd = $_GET['lPd'];

$lensaProductId = $_GET['lensaProductId'] ?? 0;
$brandLensa = '';
$hargaLensa = $_GET['hargaLensa'] ?? 0;
$diskonLensa = $_GET['diskonLensa'] ?? 0;
$tipeLensa = '';
$jenisLensa = '';
$supplierLensa = '';
$solensa = $_GET['solensa'];
$hargaLensaSO = $_GET['hargaLensaSO'] ?? 0;
$infoLensaSO = $_GET['infoLensaSO'] ?? '';

$info = $_GET['info'] ?? '';

$frame2 = $_GET['frame2'] ?? '';
$brand2 = $_GET['brand2'] ?? '';
$warna2 = $_GET['warna2'] ?? '';
$kode_harga2 = $_GET['kode_harga2'] ?? '';
$kode_harga2 = $mysqli->real_escape_string($kode_harga2);
$tipe = $_GET['tipe'];

if ($tipe != '3' && $tipe != '5') {
	$hargaLensa = 0;
	$diskonLensa = 0;
	$hargaLensaSO = 0;
	$infoLensaSO = '';
}

// validasi data
if($tsk =='add' || $tsk == "add2") {
	if($tipe == '1' && ($bar == '' || $qty <= 0 || $sat == '' || $hsa <= 0 || $sub <= 0))
	{
		$valid = 'no';	
	}
	else if($tipe == '2' && ($qty <= 0 || $sat == '' || $hsa <= 0 || $sub <= 0))
	{
		$valid = 'no';	
	}
	else if($tipe == '3' && $lensaProductId == 0 && $solensa == '0')
	{
		$valid = 'no';	
	}
	else if($tipe == '4' && ($bar == '' || $qty <= 0 || $sat == '' || $hsa <= 0 || $sub <= 0))
	{
		$valid = 'no';	
	}
	else if($tipe == '5' && ($bar == '' || $qty <= 0 || $sat == '' || $hsa <= 0 || $sub <= 0))
	{
		$valid = 'no';
	}
	else if($tipe =='5' && $lensaProductId == 0 && $solensa == '0')
		$valid = 'no';
	else
	{
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
if($valid=='yes')
{
	if ($tsk == "add2")
	{
		$mysqli->query("INSERT INTO barang VALUES(0,'',$brand2,'$bar','$frame2','$warna2',$qty,0,$hsa,'','','',$tipe,NOW(),NULL,$_SESSION[user_id],NOW(),NULL,NULL)");
		$rs2 = $mysqli->query("SELECT LAST_INSERT_ID()");
		$data2 = mysqli_fetch_assoc($rs2);
		
		$fra = $frame2;
		$bar = $data2[0];
		$tsk = "add";
	}
	
	if($tsk == 'add')
	{
		$data_dkeluarbarang = null;

		// check if product is already exists in dkeluarbarang
		if ($bar != 0)
		{
			$query_cekbrg = "SELECT * FROM dkeluarbarang WHERE product_id = $bar AND satuan_id = $sat AND keluarbarang_id = $keluarbarang_id ";
			$cekbrg = $mysqli->query($query_cekbrg);
			$data_dkeluarbarang = $cekbrg->fetch_assoc();
		}
		
		// not exists
		if($data_dkeluarbarang == null)
		{
			$special_order = $tipe=='2'?$sosoftlens:$solensa;
			
			$lensa_product_id_left = 0;
			// add lensa to table barang
			if ($tipe == 3 || $tipe == 5)
			{
				if ($special_order == '0') {
					$rs = $mysqli->query("SELECT * FROM barang WHERE product_id = $lensaProductId");
					$data = $rs->fetch_assoc();
					$lensaKode = $data['kode'];
					$lensaBrandId = $data['brand_id'];
					$lensaBarang = $data['barang'];
					$lensaPrice = $data['price'];
					$lensaPrice2 = $data['price2'];
				}

				if ($special_order == '0')
				{	
					// check lensa if already exists or not in table barang
					//left
					$rs2 = $mysqli->query("SELECT * FROM barang WHERE tipe = 3 AND branch_id = $_SESSION[branch_id] AND kode = '$lensaKode' AND brand_id = $lensaBrandId AND barang = '$lensaBarang' AND frame = '$lSph' AND color = '$lCyl'");
					if ($data2 = mysqli_fetch_assoc($rs2))
					{
						$lensa_product_id_left = $data2['product_id'];
					}
					else
					{
						$mysqli->query("INSERT INTO barang(kode, brand_id, barang, frame, color, qty, price, price2, kode_harga, info, ukuran, tipe, tgl_masuk_akhir, branch_id, created_user_id, created_date) VALUES(
							'$lensaKode', $lensaBrandId, '$lensaBarang', '$lSph', '$lCyl', 
							0, $lensaPrice, $lensaPrice2, '', '', '', 
							3, NOW(), $_SESSION[branch_id], $_SESSION[user_id], NOW())");

						$lensa_product_id_left = $mysqli->insert_id;
					}

					//right
					$rs2 = $mysqli->query("SELECT * FROM barang WHERE tipe = 3 AND branch_id = $_SESSION[branch_id] AND kode = '$lensaKode' AND brand_id = $lensaBrandId AND barang = '$lensaBarang' AND frame = '$rSph' AND color = '$rCyl'");
					if ($data2 = mysqli_fetch_assoc($rs2))
					{
						$lensa_product_id_right = $data2['product_id'];
					}
					else
					{
						$mysqli->query("INSERT INTO barang(kode, brand_id, barang, frame, color, qty, price, price2, kode_harga, info, ukuran, tipe, tgl_masuk_akhir, branch_id, created_user_id, created_date) VALUES(
							'$lensaKode', $lensaBrandId, '$lensaBarang', '$rSph', '$rCyl', 
							0, $lensaPrice, $lensaPrice2, '', '', '', 
							3, NOW(), $_SESSION[branch_id], $_SESSION[user_id], NOW())");

						$lensa_product_id_right = $mysqli->insert_id;
					}
				}
				else // if special_order true
				{
					$lensa_product_id_left = 0;
					$hargaLensa = $hargaLensaSO;
					$diskonLensa = 0;
					$info = $infoLensaSO;
				}
			}
			
			$query_ajaxsave = "INSERT INTO dkeluarbarang(keluarbarang_id, product_id, satuan_id, harga, qty, tdiskon, diskon, subtotal, lensa, rSph, rCyl, rAxis, rAdd, rPd, lSph, lCyl, lAxis, lAdd, lPd, tipe, harga_lensa, diskon_lensa, special_order, special_order_done, info) VALUES(
				$keluarbarang_id, $bar, $sat, $hsa, 
				$qty, '$tdi', $dis, $sub, 
				'$lensa_product_id_left', 
				$rSph, $rCyl, $rAxis, $rAdd, $rPd, 
				$lSph, $lCyl, $lAxis, $lAdd, $lPd, 
				$tipe, $hargaLensa, $diskonLensa, '$special_order', '0', '$info')";
		}
		else
		{
			$qty_now      = $row_cekbrg['qty'] + $qty;
			$total_now    = $qty_now * $sub;
			$query_ajaxsave = "UPDATE dkeluarbarang set "
					. "qty=$qty_now,"
					. "subtotal='$total_now',"
					. "harga=$hsa,"
					. "tdiskon='$tdi',"
					. "diskon='$dis',"
					. "rSph=$rSph,"
					. "rCyl=$rCyl,"
					. "rAxis=$rAxis,"
					. "rAdd=$rAdd,"
					. "rPd=$rPd,"
					. "lSph=$lSph,"
					. "lCyl=$lCyl,"
					. "lAxis=$lAxis,"
					. "lAdd=$lAdd,"
					. "lPd=$lPd "
					. "where id='$row_cekbrg[id]'";
		}
		$ajaxsave       = $mysqli->query($query_ajaxsave);
	}else{
		$query_ajaxsave = "delete from dkeluarbarang where id='$rid'";
		$ajax_save      = $mysqli->query($query_ajaxsave);
	}
}

// list detail barang
$query_detbrg = "SELECT 
					a.*, 
					b.kode, b.barang, b.color, b.frame, 
					c.satuan, d.jenis 
				FROM dkeluarbarang a 
				LEFT JOIN barang b ON a.product_id = b.product_id 
				LEFT JOIN satuan c ON a.satuan_id = c.satuan_id 
				LEFT JOIN jenisbarang d ON d.brand_id = b.brand_id 
				WHERE a.keluarbarang_id = $keluarbarang_id 
				ORDER BY a.id ASC ";
$detbrg = $mysqli->query($query_detbrg);
$total_detbrg = mysqli_num_rows($detbrg);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="datatable">
	<tr>
		<th>Nama Barang</th>
		<th width="6%">Qty</th>
		<th width="10%">Satuan</th>
		<th width="10%">Harga</th>
		<th width="14%">Diskon</th>
		<th width="10%">Sub Total</th>
		<th width="8%">Pengaturan</th>
	</tr>
    
	<?php 
		$cart_is_valid = 0;
		$gtotal = 0;
		while($row_detbrg = mysqli_fetch_assoc($detbrg)) {
			$cart_is_valid = 1;
			$gtotal += $row_detbrg['subtotal'];

			if ($row_detbrg['tipe'] == 3 || $row_detbrg['tipe'] == 5)
			{
				if ($row_detbrg['special_order'] == '0') {
					$rs2 = $mysqli->query("SELECT * FROM barang WHERE product_id = $row_detbrg[lensa]");
					$data2 = mysqli_fetch_assoc($rs2);
					$lensa = $data2['barang'];
				}
				else if ($row_detbrg['special_order'] == '1') {
					$lensa = 'SO';
				}
			}
	?>

	<tr valign="top">
		<td>
			<?php
				if ($row_detbrg['tipe'] != 3)
				{
					?>
                    	<?php
							if ($row_detbrg['kode'] != '') echo $row_detbrg['kode'] . ' # ';
						?>
                        <?=$row_detbrg['jenis']?> #  <?=$row_detbrg['barang']?> # <?=$row_detbrg['color']?>
                    <?php
				}
				else
				{
					echo "LENSA " . $lensa;
				}
			?>
			
			<br />
			
			<?php
				if ($row_detbrg['tipe'] == 3 || $row_detbrg['tipe'] == 5)
				{
					if ($row_detbrg['special_order'] == '1') {
						echo $row_detbrg['info'];
					}

					?>
						<table rules="all" border="1">
							<tr>
								<td width="15%">&nbsp;</td>
								<td width="13%" align="center">SpH</td>
								<td width="13%" align="center">Cyl</td>
								<td width="13%" align="center">Axis</td>
								<td width="13%" align="center">Add</td>
								<td width="13%" align="center">PD</td>
							</tr>
							<tr>
								<td>Right</td>
								<td align="center"><?php echo $row_detbrg['rSph']/100; ?></td>
								<td align="center"><?php echo $row_detbrg['rCyl']/100; ?></td>
								<td align="center"><?php echo $row_detbrg['rAxis']/100; ?></td>
								<td align="center"><?php echo $row_detbrg['rAdd']/100; ?></td>
								<td align="center"><?php echo $row_detbrg['rPd']; ?></td>
							</tr>
							<tr>
								<td>Left</td>
								<td align="center"><?php echo $row_detbrg['lSph']/100; ?></td>
								<td align="center"><?php echo $row_detbrg['lCyl']/100; ?></td>
								<td align="center"><?php echo $row_detbrg['lAxis']/100; ?></td>
								<td align="center"><?php echo $row_detbrg['lAdd']/100; ?></td>
								<td align="center"><?php echo $row_detbrg['lPd']; ?></td>
							</tr>
						</table>
					<?php
				}
			?>

			<?php
		  		if ($row_detbrg['tipe'] == 5 || $row_detbrg['tipe'] == 1)
				{
					echo "FRAME : " . $row_detbrg['frame'];
				}
				
				if ($row_detbrg['tipe'] == 5)
				{
					echo " - LENSA : " . $lensa;
				}
			?>
			
			<br />
      </td>
      
      <td align="center">
      	<?=$row_detbrg['tipe'] == 3 ? '1' : $row_detbrg['qty']?>
      </td>

      <td align="center">
      	<?php echo $row_detbrg['satuan'];?>
      </td>

      <td align="right">
      	<?php
        	if ($row_detbrg['tipe'] != 3) echo number_format($row_detbrg['harga'], 0, ',', '.');
			else echo number_format($row_detbrg['harga_lensa'], 0, ',', '.');
			
			if ($row_detbrg['tipe'] == 5) {
				if ($row_detbrg['special_order'] == '0')
					echo '<br>+ ' . number_format($row_detbrg['harga_lensa']*2, 0, ',', '.') . '(' . $row_detbrg['diskon_lensa'] . ' %)';
				else if ($row_detbrg['special_order'] == '1')
					echo '<br>+ ' . number_format($row_detbrg['harga_lensa']*2, 0, ',', '.') . '(' . $row_detbrg['diskon_lensa'] . ' %)';
			}
		?>
      </td>

	<td align="right">
		<?php
			if ($row_detbrg['tipe'] != 3) {
				if ($row_detbrg['tdiskon'] == '1')
					echo $row_detbrg['diskon']." %";
				else
					echo number_format($row_detbrg['diskon'],0,',','.');
			}
			else
				echo $row_detbrg['diskon_lensa'] . " %";
			
		?>
	</td>
      
      <td align="right">
	  	<?=number_format($row_detbrg['subtotal'], 0, ',', '.')?>
      </td>

      <td align="center"><a href="javascript:void(0);" onclick="manageInvoiceJual('delete','<?php echo $row_detbrg['id'];?>');"><img src="images/close-icon.png" border="0" /> Hapus</a></td>
    </tr>
    
    <?php } ?>

    <input type="hidden" name="total" id="total" value="<?php echo $gtotal;?>">
    <input type="hidden" name="cart_is_valid" id="cart_is_valid" value="<?=$cart_is_valid?>" />

    <?php if($valid=='no') { ?>
    <tr valign="top" bgcolor="#FFFFFF">
      <td colspan="7" style="color:#F00;"><img src="images/alert.gif" hspace="5" vspace="2" border="0" align="left" /> Lengkapi semua field/isian dengan benar !!!</td>
    </tr>
    <?php
    }
?>
</table>