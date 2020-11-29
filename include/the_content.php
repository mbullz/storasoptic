<?php

	if (!$_SESSION['is_admin']) return;

	global $mysqli, $branch_id;

	$periode = isset($_POST['periode']) ? $_POST['periode'] : date("Y-m-d");

	$hariini      = date("Y-m");
	$j_hari       = jumlah_hari(date("m"), date("Y"));

	$branch_filter = '';
	if ($branch_id != 0) {
		$branch_filter = " AND a.branch_id = $branch_id ";
	}

?>

<script type="text/javascript">
/*
$.FusionCharts.config.extend({
	swfPath: '',
	product: 'v3',
	width: '1280'
});
*/
	$(document).ready(function()
	{
		$("#example").dataTable(
		{
			dom: 'T<"clear">lfrtip',
			tableTools:
			{
				"sSwfPath": "media/swf/copy_csv_xls_pdf.swf"
			}
		});
	});
</script>
<style>
/*
#fusioncharts {
	border:solid 1px red;
	overflow:scroll;
}
*/
</style>

<h1>Dashboard</h1>

<div class="card-deck mb-3 mt-3">
	<?php
		$query = "SELECT COUNT(a.referensi) AS transaction_count, IFNULL(SUM(dt1.qty_sum), 0) AS qty_sum 
				FROM masukbarang a 
				JOIN 
				( 
					SELECT masukbarang_id, SUM(qty) AS qty_sum 
					FROM dmasukbarang 
					GROUP BY masukbarang_id 
				) AS dt1 ON a.masukbarang_id = dt1.masukbarang_id 
				WHERE tgl = CURRENT_DATE 
				$branch_filter ";
		$rs = $mysqli->query($query);
		$data = $rs->fetch_assoc();
		$purchase_transaction_count = $data['transaction_count'];
		$purchase_qty_sum = $data['qty_sum'];
	?>
	<div class="card text-white bg-primary">
		<div class="card-body">
			<h5 class="card-title text-center">
				<i class="fa fa-truck pr-1" aria-hidden="true"></i>
				Pembelian
			</h5>
			<p class="card-text">
				<label class="font-weight-bolder pr-1" style="font-size: 16px;"><?=$purchase_transaction_count?></label> Transaksi
				<br />
				<label class="font-weight-bolder pr-1" style="font-size: 16px;"><?=$purchase_qty_sum?></label> Qty
			</p>
		</div>
	</div>

	<?php
		$query = "SELECT COUNT(referensi) AS transaction_count, SUM(total) AS total_sum 
				FROM keluarbarang a 
				WHERE referensi != '' 
				AND tgl = CURRENT_DATE 
				$branch_filter ";
		$rs = $mysqli->query($query);
		$data = $rs->fetch_assoc();
		$sales_transaction_count = $data['transaction_count'];
		$sales_total_sum = number_format($data['total_sum'], 0, '.', ',');
	?>
	<div class="card text-white bg-success">
		<div class="card-body">
			<h5 class="card-title text-center">
				<i class="fa fa-shopping-cart pr-1" aria-hidden="true"></i>
				Penjualan
			</h5>
			<p class="card-text">
				<label class="font-weight-bolder pr-1" style="font-size: 16px;"><?=$sales_transaction_count?></label> Transaksi
				<br />
				<label class="font-weight-bolder pr-1" style="font-size: 16px;"><?=$sales_total_sum?></label> Rupiah
			</p>
		</div>
	</div>

	<?php
		$query = "SELECT COUNT(*) AS customer_count 
				FROM kontak a 
				WHERE jenis = 'C001' 
				AND mulai = CURRENT_DATE 
				AND aktif = '1' 
				$branch_filter ";
		$rs = $mysqli->query($query);
		$data = $rs->fetch_assoc();
		$customer_count = $data['customer_count'];
	?>
	<div class="card text-white bg-warning">
		<div class="card-body">
			<h5 class="card-title text-center">
				<i class="fa fa-user pr-1" aria-hidden="true"></i>
				Customer
			</h5>
			<p class="card-text">
				<label class="font-weight-bolder pr-1" style="font-size: 16px;"><?=$customer_count?></label> Customer Baru
			</p>
		</div>
	</div>

	<?php
		$query = "SELECT COUNT(*) AS transaction_count, SUM(jumlah) AS jumlah_sum 
				FROM aruskas a 
				WHERE tgl = CURRENT_DATE 
				AND tipe = 'operasional' 
				$branch_filter ";
		$rs = $mysqli->query($query);
		$data = $rs->fetch_assoc();
		$cost_transaction_count = $data['transaction_count'];
		$cost_jumlah_sum = number_format($data['jumlah_sum'], 0, '.', ',');
	?>
	<div class="card text-white bg-danger">
		<div class="card-body">
			<h5 class="card-title text-center">
				<i class="fa fa-tag pr-1" aria-hidden="true"></i>
				Biaya Operasional
			</h5>
			<p class="card-text">
				<label class="font-weight-bolder pr-1" style="font-size: 16px;"><?=$cost_transaction_count?></label> Transaksi
				<br />
				<label class="font-weight-bolder pr-1" style="font-size: 16px;"><?=$cost_jumlah_sum?></label> Rupiah
			</p>
		</div>
	</div>
</div>
