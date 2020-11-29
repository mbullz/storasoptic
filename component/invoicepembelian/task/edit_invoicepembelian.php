<?php

global $mysqli, $c, $t, $branch_id;

$branch_filter = '';
if ($branch_id != 0) {
	$branch_filter = " AND a.branch_id = $branch_id ";
}

$id = $_GET['id'] ?? 0;

$query = "SELECT a.masukbarang_id, a.referensi, a.tgl, 
			b.kontak AS supplier_name, 
			( 
				SELECT dt2.tipe 
				FROM dmasukbarang dt1 
				JOIN barang dt2 ON dt1.product_id = dt2.product_id 
				WHERE dt1.masukbarang_id = a.masukbarang_id 
				ORDER BY dt1.id ASC 
				LIMIT 0,1 
			) AS tipe 
		FROM masukbarang a 
		JOIN kontak b ON a.supplier = b.user_id 
		WHERE masukbarang_id = $id 
		$branch_filter ";

$rs = $mysqli->query($query);
$data = $rs->fetch_assoc();

$masukbarang_id = $data['masukbarang_id'];
$referensi = $data['referensi'];
$tgl = $data['tgl'];
$supplier_name = $data['supplier_name'];
$tipe = $data['tipe'];

?>

<script type="text/javascript" language="javascript" src="js/number_format.js"></script>
<script type="text/javascript" language="javascript" src="js/apps/edit_invoicepembelian.js"></script>

<h1>Edit Pembelian</h1>

<form name="form-edit" action="component/<?=$c?>/p_<?=$c?>.php?p=<?=$t?>" method="POST">
	<input type="hidden" name="masukbarang_id" value="<?=$masukbarang_id?>" />

	<div class="row mt-3">
		<div class="col-sm-2 text-right text-secondary">
			No. PO
		</div>
		<div class="col-sm-4 font-weight-bold">
			<?=$referensi?>
		</div>
		<div class="col-sm-2 text-right text-secondary">
			Tanggal
		</div>
		<div class="col-sm-4 font-weight-bold">
			<?=$tgl?>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-sm-2 text-right text-secondary">
			Supplier
		</div>
		<div class="col-sm-4 font-weight-bold">
			<?=$supplier_name?>
		</div>
	</div>

	<div class="row mt-3 mb-3">
		<div class="col-sm-2 text-right text-secondary">
			Detail
		</div>
		<div class="col-sm-4 font-weight-bold">
			
		</div>
	</div>

	<table class="table">
		<thead>
			<tr>
				<th scope="col">No.</th>
				<th scope="col">Kode</th>
				<th scope="col">Brand</th>
				<th scope="col">Product</th>

				<?php
					switch ($tipe) {
						case 1:
							?>
								<th scope="col">Frame</th>
								<th scope="col">Color</th>
							<?php
						break;

						case 2:
							?>
								<th scope="col">Minus</th>
								<th scope="col">Color</th>
								<th scope="col">Expiry Date</th>
							<?php
						break;

						case 3:
							?>
								<th scope="col">SPH</th>
								<th scope="col">CYL</th>
								<th scope="col">ADD</th>
							<?php
						break;
					}
				?>

				<th scope="col">Harga Jual</th>
				<th scope="col">Harga Beli</th>
				<th scope="col">Qty</th>
				<th scope="col">Subtotal</th>
			</tr>
		</thead>

		<tbody>
			<?php
				$query = "SELECT 
							a.id, a.product_id, a.harga AS cost, a.qty, a.subtotal, 
							b.kode, b.barang, b.frame, b.color, b.power_add, b.price2 AS price, b.ukuran, 
							c.jenis AS brand_name 
						FROM dmasukbarang a 
						JOIN barang b ON a.product_id = b.product_id 
						JOIN jenisbarang c ON b.brand_id = c.brand_id 
						WHERE a.masukbarang_id = $masukbarang_id 
						ORDER BY c.jenis ASC, b.kode ASC, b.barang ASC, b.frame ASC, b.color ASC, b.power_add ASC, b.ukuran ASC ";

				$rs = $mysqli->query($query);
			?>
			
			<?php
				$i = 0;
				$grandtotal = 0;
			?>
			<?php while ($data = $rs->fetch_assoc()): ?>
				<?php
					$i++;
					$id = $data['id'];
					$grandtotal += $data['subtotal'];
				?>
				
				<tr>
					<td scope="row"><?=$i?></td>
					<td><?=$data['kode']?></td>
					<td><?=$data['brand_name']?></td>
					<td><?=$data['barang']?></td>
					<td><?=$data['frame']?></td>
					<td><?=$data['color']?></td>

					<?php
						switch ($tipe) {
							case 2:
								?>
									<td><?=$data['ukuran']?></td>
								<?php
							break;

							case 3:
								?>
									<td><?=$data['power_add']?></td>
								<?php
							break;
						}
					?>

					<td><?=number_format($data['price'], 0)?></td>

					<td>
						<input type="hidden" name="id[]" value="<?=$id?>" />
						<input type="hidden" name="product_id[]" value="<?=$data['product_id']?>" />
						<input type="hidden" name="qty[]" value="<?=$data['qty']?>" />
						<input type="number" name="cost[]" onkeyup="costChange(this.value, <?=$id?>)" style="width: 100px;" value="<?=$data['cost']?>" />
					</td>
					
					<td id="qty-<?=$id?>"><?=$data['qty']?></td>
					<td id="subtotal-<?=$id?>"><?=number_format($data['subtotal'], 0)?></td>
				</tr>

			<?php endwhile; ?>
		</tbody>
	</table>

	<div class="row mt-3">
		<div class="col-sm-2 text-right text-secondary">
			Grand Total
		</div>
		<div id="grandtotal" class="col-sm-4 font-weight-bold">
			<?=number_format($grandtotal, 0)?>
		</div>
	</div>

	<div class="row mt-3 mb-3">
		<div class="col-sm-2">
			
		</div>
		<div class="col-sm-4">
			<input type="submit" name="button-update" value="Update" class="btn btn-success btn-sm mr-1" />
			<input type="reset" name="button-cancel" onclick="javascript:history.go(-1);" value="Cancel" class="btn btn-danger btn-sm" />
		</div>
	</div>
	
</form>
