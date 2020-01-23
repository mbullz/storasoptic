<?php
session_start();
include('../include/config_db.php');
require '../models/Barang.php';
require '../models/JenisBarang.php';
require '../models/DBHelper.php';

$db = new DBHelper($mysqli);

	function sphFormat($value) {
		if ($value == 0) return '000';
		else if ($value < 100 && $value > 0) return '0' . $value;
		else if ($value < 0 && $value > -100) return '-0' . $value*-1;
		else return $value;
	}

// get variable
$branch_id = $_SESSION['branch_id'];
$user_id = $_SESSION['user_id'];

$tsk = $_POST['task'];
$rid = $_POST['rid'];
$keluarbarang_id = $_POST['keluarbarang_id'] ?? 0;
$ref = $mysqli->real_escape_string($_POST['ref']);
$bar = $_POST['brg'] ?? 0;
$bar = $bar == '' ? 0 : $bar;
$qty = $_POST['qty'];
$tdi = $_POST['tdisc'];
$dis = $_POST['disc'];
$sat = $_POST['sat'];
$hsa = $_POST['hsat'];
$promo = $_POST['promo'];
$sub = $_POST['subtot'];

$sosoftlens = $_POST['sosoftlens'];

$lensa_product_id = 0;

$rSph = $_POST['rSph'];
$rCyl = $_POST['rCyl'];
$rAxis = $_POST['rAxis'];
$rAdd = $_POST['rAdd'];
$rPd = $_POST['rPd'];

$lSph = $_POST['lSph'];
$lCyl = $_POST['lCyl'];
$lAxis = $_POST['lAxis'];
$lAdd = $_POST['lAdd'];
$lPd = $_POST['lPd'];

$lensaProductId = $_POST['lensaProductId'] ?? 0;
$brandLensa = '';
$hargaLensa = $_POST['hargaLensa'] ?? 0;
$diskonLensa = $_POST['diskonLensa'] ?? 0;
$tipeLensa = '';
$jenisLensa = '';
$supplierLensa = '';
$solensa = $_POST['solensa'];
$hargaLensaSO = $_POST['hargaLensaSO'] ?? 0;
$infoLensaSO = $_POST['infoLensaSO'] ?? '';

$info = $_POST['info'] ?? '';

$frame2 = $_POST['frame2'] ?? '';
$brand2 = $_POST['brand2'] ?? '';
$warna2 = $_POST['warna2'] ?? '';
$kode_harga2 = $_POST['kode_harga2'] ?? '';
$kode_harga2 = $mysqli->real_escape_string($kode_harga2);
$tipe = $_POST['tipe'];

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
					$lensa = new Barang();
					$lensa->setProductId($lensaProductId);
					$lensa = $db->getBarang($lensa);
					$lensa->setTipe(3);
					$lensa->setBranchId($_SESSION['branch_id']);
				}

				if ($special_order == '0')
				{	
					// check lensa if already exists or not in table barang

					//left
					$lensa->setProductId(null);
					$lensa->setFrame($lSph);
					$lensa->setColor($lCyl);
					$lensa->setPowerAdd($lAdd);
					
					$result = $db->getBarang($lensa);

					if ($result != null) {
						$lensa_product_id_left = $result->getProductId();
					}
					else
					{
						$lensa->setQty(0);
						$lensa->setTglMasukAkhir(date('Y-m-d'));
						$lensa->setTglKeluarAkhir('NULL');
						$lensa->setCreatedUserId($_SESSION['user_id']);
						$lensa->setCreatedDate('NOW()');
						$lensa->setLastUpdateUserId($_SESSION['user_id']);
						$lensa->setLastUpdateDate('NOW()');

						$result = $db->insertBarang($lensa);

						$lensa_product_id_left = $result->id;
					}

					//right
					$lensa->setProductId(null);
					$lensa->setFrame($rSph);
					$lensa->setColor($rCyl);
					$lensa->setPowerAdd($rAdd);
					
					$result = $db->getBarang($lensa);

					if ($result != null)
					{
						$lensa_product_id_right = $result->getProductId();
					}
					else
					{
						$lensa->setQty(0);
						$lensa->setTglMasukAkhir(date('Y-m-d'));
						$lensa->setTglKeluarAkhir('NULL');
						$lensa->setCreatedUserId($_SESSION['user_id']);
						$lensa->setCreatedDate('NOW()');
						$lensa->setLastUpdateUserId($_SESSION['user_id']);
						$lensa->setLastUpdateDate('NOW()');

						$result = $db->insertBarang($lensa);

						$lensa_product_id_right = $result->id;
					}
				}
				else // if special_order true
				{
					$lensa_product_id_left = 0;
					$hargaLensa = $hargaLensaSO;
					$diskonLensa = 0;
				}
			}
			
			$query_ajaxsave = "INSERT INTO dkeluarbarang(keluarbarang_id, product_id, satuan_id, harga, qty, tdiskon, diskon, subtotal, lensa, rSph, rCyl, rAxis, rAdd, rPd, lSph, lCyl, lAxis, lAdd, lPd, tipe, harga_lensa, diskon_lensa, special_order, special_order_done, info, info_special_order) VALUES(
				$keluarbarang_id, $bar, $sat, $hsa, 
				$qty, '$tdi', $dis, $sub, 
				'$lensa_product_id_left', 
				$rSph, $rCyl, $rAxis, $rAdd, $rPd, 
				$lSph, $lCyl, $lAxis, $lAdd, $lPd, 
				$tipe, $hargaLensa, $diskonLensa, '$special_order', '0', '$info', '$infoLensaSO')";
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
		$dkeluarbarang_id = $mysqli->insert_id;

		if ($promo > 0) {
			$promo_id = 0;
			$promo_name = 'PROMO';
			$category = $tipe == 5 ? '1, 3' : $tipe;
			$rs = $mysqli->query("SELECT * FROM promo WHERE branch_id IN (0, $branch_id) AND NOW() BETWEEN start_date AND end_date AND category IN (0, $category)");
			if ($data = $rs->fetch_assoc()) {
				$promo_id = $data['id'];
				$promo_name = $data['name'];
			}

			$mysqli->query("INSERT INTO keluarbarang_discount(promo_id, keluarbarang_id, dkeluarbarang_id, discount, description, updated_by, updated_at) VALUES($promo_id, $keluarbarang_id, $dkeluarbarang_id, $promo, '$promo_name', $user_id, NOW())");
		}

	}else{
		$query_ajaxsave = "delete from dkeluarbarang where id='$rid'";
		$ajax_save      = $mysqli->query($query_ajaxsave);
	}
}

// list detail barang
$query_detbrg = "SELECT 
					a.*, 
					b.kode, b.barang, b.color, b.frame, 
					c.satuan, d.jenis, e.discount AS promo 
				FROM dkeluarbarang a 
				LEFT JOIN barang b ON a.product_id = b.product_id 
				LEFT JOIN satuan c ON a.satuan_id = c.satuan_id 
				LEFT JOIN jenisbarang d ON d.brand_id = b.brand_id 
				LEFT JOIN keluarbarang_discount e ON a.id = e.dkeluarbarang_id 
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
                        <?=$row_detbrg['kode']?> # <?=$row_detbrg['jenis']?> # <?=$row_detbrg['barang']?> # <?=$row_detbrg['color']?>
                    <?php
				}
				else
				{
					echo "LENSA " . $lensa;
				}

				if ($row_detbrg['info'] != '') {
					echo '<br /><u>KETERANGAN</u><br />' . nl2br($row_detbrg['info']);
				}
			?>
			
			<br />
			
			<?php
				if ($row_detbrg['tipe'] == 3 || $row_detbrg['tipe'] == 5)
				{
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
								<td align="center"><?=sphFormat($row_detbrg['rSph'])?></td>
								<td align="center"><?=sphFormat($row_detbrg['rCyl'])?></td>
								<td align="center"><?php echo $row_detbrg['rAxis']/100; ?></td>
								<td align="center"><?=sphFormat($row_detbrg['rAdd'])?></td>
								<td align="center"><?php echo $row_detbrg['rPd']; ?></td>
							</tr>
							<tr>
								<td>Left</td>
								<td align="center"><?=sphFormat($row_detbrg['lSph'])?></td>
								<td align="center"><?=sphFormat($row_detbrg['lCyl'])?></td>
								<td align="center"><?php echo $row_detbrg['lAxis']/100; ?></td>
								<td align="center"><?=sphFormat($row_detbrg['lAdd'])?></td>
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
					echo "<br />LENSA : " . $lensa;
				}

				if ($row_detbrg['special_order'] == '1' && $row_detbrg['info_special_order'] != '' && ($row_detbrg['tipe'] == 3 || $row_detbrg['tipe'] == 5)) {
					echo '<br /><u>KETERANGAN SO</u><br />' . nl2br($row_detbrg['info_special_order']);
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
			
			if ($row_detbrg['promo'] != NULL)
				echo '<br />+' . number_format($row_detbrg['promo'], 0);
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