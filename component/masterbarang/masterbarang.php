<?php

	global $mysqli;
	global $branch_id;

	require('include/define.php');

	$tipe = $_POST['tipe'] ?? 1;
	$emptyStock = $_POST['emptyStock'] ?? 0;

	$stock_filter = '';
	if ($emptyStock == 1) {
		$stock_filter = ' AND a.qty <= 0 ';
	}
	else {
		$stock_filter = ' AND a.qty > 0 ';
	}

	$branch_filter = '';
	if ($branch_id != 0) {
	    $branch_filter = " AND a.branch_id = $branch_id ";
	}

$query_data  = "SELECT a.*, b.jenis 
				FROM barang a 
				JOIN jenisbarang b ON b.brand_id = a.brand_id 
				WHERE a.tipe = $tipe 
				$stock_filter 
				$branch_filter 
				ORDER BY b.jenis ASC, a.barang ASC ";

$data = $mysqli->query($query_data);

$totalRows_data = mysqli_num_rows($data);

$row_header = array(
	array('INFO', 'BRAND', 'KODE', 'BARANG', 'FRAME', 'WARNA', 'QTY', ''),
	array('INFO', 'BRAND', 'KODE', 'BARANG', 'MINUS', 'WARNA', 'QTY', ''),
	array('INFO', 'BRAND', 'KODE', 'BARANG', 'MINUS', 'SILINDER', 'QTY', ''),
	array('INFO', 'BRAND', 'KODE', 'BARANG', 'KET 1', 'KET 2', 'QTY', ''),
);

?>

<script type="text/javascript">
	var data = [];

	<?php
		$rs = $mysqli->query($query_data);
		while ($data = $rs->fetch_assoc()) {
			$product_id = $data['product_id'];
			$brand = htmlspecialchars($data['jenis'], ENT_QUOTES);
			$kode = htmlspecialchars($data['kode'], ENT_QUOTES);
			$barang = htmlspecialchars($data['barang'], ENT_QUOTES);
			$frame = htmlspecialchars($data['frame'], ENT_QUOTES);
			$color = htmlspecialchars($data['color'], ENT_QUOTES);
			$qty = $data['qty'];

			if ($tipe == 3) {
				$frame = $frame / 100;
				$color = $color / 100;
			}

			$checkbox = '<input name="data[]" type="checkbox" value="'.$product_id.'" />';

			$edit = '';
			if (strstr($_SESSION['akses'], "edit_".$c)) {
				$edit = '<a href="index.php?component='.$c.'&task=edit&id='.$product_id.'" title="Edit Data"><img src="images/edit_icon.png" width="16px" height="16px" /></a>';
			}

			?>
				data.push([
					<?=$product_id?>,
					'<?=$checkbox?>',
					'',
					'<?=$brand?>',
					'<?=$kode?>',
					'<?=$barang?>',
					'<?=$frame?>',
					'<?=$color?>',
					'<?=$qty?>',
					'<?=$edit?>',
				]);
			<?php
		}
	?>
</script>
<script type="text/javascript" language="javascript" src="js/apps/masterbarang.js"></script>

<style>
	td.details-control {
	    background: url('media/images/details_open.png') no-repeat center center;
	    cursor: pointer;
	}
	tr.shown td.details-control {
	    background: url('media/images/details_close.png') no-repeat center center;
	}

	.th {
		color: #660099;
		text-align: center;
	}
</style>

<input type="hidden" id="totalRows_data" value="<?=$totalRows_data?>" />

<h1>Master Barang</h1>

<div>
	<?php
		if(strstr($_SESSION['akses'],"add_".$c))
		{
			?>
				<img src="images/add2.png" height="64px" title="Input Barang Baru" style="cursor:pointer;" onclick="javascript:window.location='index-c-masterbarang-t-add-k-importcsv.pos';" />
			<?php
		}
	?>
	<!--<a href="export_xls.php?tabel=barang" class="action-button animate green" title="Export Data XLS">Export Data</a>-->
</div>

<div style="clear:both;margin-top:10px;">
	<form method="post" id="formTipe">
		<div class="btn-group btn-group-toggle">
			<label class="btn btn-primary btn-sm <?=($emptyStock == 0 ? 'active' : '')?>">
				<input type="radio" name="emptyStock" autocomplete="off" value="0" <?=($emptyStock == 0 ? 'checked' : '')?> onclick="javascript:document.forms['formTipe'].submit();"> Stok Tersedia
			</label>
			
			<label class="btn btn-primary btn-sm <?=($emptyStock == 1 ? 'active' : '')?>">
				<input type="radio" name="emptyStock" autocomplete="off" value="1" <?=($emptyStock == 1 ? 'checked' : '')?> onclick="javascript:document.forms['formTipe'].submit();"> Stok Kosong
			</label>
		</div>
		<br /><br />

		Tipe : 
		<select name="tipe" id="tipe" onchange="document.forms['formTipe'].submit();">
			<option value="1" <?php echo ($tipe == 1) ? 'selected' : '' ?>>Frame</option>
            <option value="2" <?php echo ($tipe == 2) ? 'selected' : '' ?>>Softlens</option>
            <option value="3" <?php echo ($tipe == 3) ? 'selected' : '' ?>>Lensa</option>
            <option value="4" <?php echo ($tipe == 4) ? 'selected' : '' ?>>Accessories</option>
		</select>
	</form>
	<br />
</div>

<form id="formdata" name="formdata" method="post" action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=mdelete">
  <div class="tablebg">
	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead>
			<tr>
				<th width="1%" class="th">
					<!--
                    <input type="checkbox" name="checkbox" value="checkbox" onclick="checkAll(this.checked)" />
                    <font color="#660099" id="totalChecked">(0)</font>
                	-->
				</th>
				<th width="1%" class="th"><?=$row_header[$tipe-1][0]?></th>
				<th class="th"><?=$row_header[$tipe-1][1]?></th>
				<th class="th"><?=$row_header[$tipe-1][2]?></th>
				<th class="th"><?=$row_header[$tipe-1][3]?></th>
				<th class="th"><?=$row_header[$tipe-1][4]?></th>
				<th class="th"><?=$row_header[$tipe-1][5]?></th>
				<th class="th"><?=$row_header[$tipe-1][6]?></th>
				<th width="1%">&nbsp;</th>
			</tr>
		</thead>
        
        <tfoot>
			<tr>
				<th></th>
				<th></th>
				<th><?=$row_header[$tipe-1][1]?></th>
				<th><?=$row_header[$tipe-1][2]?></th>
				<th><?=$row_header[$tipe-1][3]?></th>
				<th><?=$row_header[$tipe-1][4]?></th>
				<th><?=$row_header[$tipe-1][5]?></th>
				<th></th>
				<th></th>
			</tr>
		</tfoot>
		
		<tbody>
		</tbody>
	</table>
	
	<img src="images/arrow_ltr.png" />&nbsp;&nbsp;
	<?php
		if(strstr($_SESSION['akses'],"delete_".$c))
		{
			?>
				<!--<input name="D_ALL" type="submit" id="D_ALL" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#609;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="javascript:if(prompt('Kode Hapus :') == '1234') return confirm('Lanjutkan Proses ... ?'); else return false;"/>-->
				<input type="button" value="Hapus Sekaligus" title="Hapus Sekaligus Data ( Cek )" style="background:#609;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="deleteProduct()"/>
			<?php
		}
	?>

	<!--
	<input type="button" value="Pindah Cabang" style="background:#609;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="pindahCabang()" />
	<input type="button" value="Retur" style="background:#609;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="returSome()" />
	<input type="button" value="Print Label" style="background:#609;padding:5px;color:#FFFFFF;border:none;cursor:pointer;" onclick="openDialogPrintInvoice()" />
	-->

  </div>
</form>

<div id="dialog">
	<table width="100%" id="dialogTableDetail">
	</table>

	<table width="100%">
		<tr>
			<td>
				Cabang
			</td>
			
			<td>
				:
			</td>
			
			<td>
				<select id="cabang">
					<option>-- Pilih Cabang --</option>
					<?php
					  $rs2 = $mysqli->query("SELECT * FROM kontak WHERE jenis LIKE 'B001' ORDER BY kontak ASC");
					  while ($data2 = mysqli_fetch_assoc($rs2))
					  {
						?>
						  <option value="<?=$data2['user_id']?>"><?=$data2['kontak']?></option>
						<?php
					  }
					?>
				</select>
			</td>
		</tr>
	</table>	
</div>

<div id="dialog2">
	<table border="0" cellpadding="2" cellspacing="0">
		<tr>
			<td>
				Info
			</td>

			<td>
				:
			</td>

			<td>
				<textarea id="textReturInfo"></textarea>
			</td>
		</tr>

		<tr>
			<td>
				Qty
			</td>

			<td>
				:
			</td>

			<td>
				<input type="text" id="textReturQty" size="1" onfocus="javascript:if(this.value=='0')this.value='';" onblur="javascript:if(this.value=='')this.value='0';" />
			</td>
		</tr>
	</table>

	<input type="hidden" id="hiddenReturProductId" value="">
</div>

<div id="dialog3">
	<h2>Print Label</h2>
</div>

<div id="dialogReturSome">
	<table width="100%" id="dialogTableDetail2">
	</table>

	<table width="100%">
		<tr>
			<td>
				Info
			</td>
			
			<td>
				:
			</td>
			
			<td>
				<textarea id="textReturInfo2"></textarea>
			</td>
		</tr>
	</table>	
</div>

<script>
	refreshJenis();
	onLoad();
</script>