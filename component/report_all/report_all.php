<?php

?>

<script type="text/javascript">
	function viewLedger() {
		var start = $('#start_date_ledger').val();
		var end = $('#end_date_ledger').val();

		if (start == '' || end == '') return;

		window.open("reports/ledger.php?start=" + start + "&end=" + end);
	}

	function viewJurnalPenerimaanKas() {
		var start = $('#start_date_jpk').val();
		var end = $('#end_date_jpk').val();

		if (start == '' || end == '') return;

		window.open("reports/jurnal_penerimaan_kas.php?start=" + start + "&end=" + end);
	}

	function viewProfitLoss() {
		var start = $('#start_date_profit_loss').val();
		var end = $('#end_date_profit_loss').val();

		if (start == '' || end == '') return;

		window.open("reports/profit_loss.php?start=" + start + "&end=" + end);
	}

	function viewPresence() {
		var start = $('#start_date_presence').val();
		var end = $('#end_date_presence').val();

		if (start == '' || end == '') return;

		window.open("reports/presence.php?start=" + start + "&end=" + end);
	}

	function viewMutation() {
		var start = $('#start_date_mutation').val();
		var end = $('#end_date_mutation').val();

		if (start == '' || end == '') return;

		window.open("reports/mutation.php?start=" + start + "&end=" + end);
	}

	function viewInventoryValue() {
		window.open("reports/inventory_value.php");
	}

	function viewBestSellingProduct() {
		var start = $('#start_date_best_selling_product').val();
		var end = $('#end_date_best_selling_product').val();
		var tipe = $('#tipe_best_selling_product').val();
		var limit = $('#limit_best_selling_product').val();

		if (start == '' || end == '') return;

		window.open("reports/best_selling_product.php?start=" + start + "&end=" + end + "&tipe=" + tipe + "&limit=" + limit);
	}

	function viewMostValuableCustomer() {
		var start = $('#start_date_most_valuable_customer').val();
		var end = $('#end_date_most_valuable_customer').val();
		var limit = $('#limit_most_valuable_customer').val();

		if (start == '' || end == '') return;

		window.open("reports/most_valuable_customer.php?start=" + start + "&end=" + end + "&limit=" + limit);
	}

	function viewSellingBySales() {
		var start = $('#start_date_selling_by_sales').val();
		var end = $('#end_date_selling_by_sales').val();

		if (start == '' || end == '') return;

		window.open("reports/selling_by_sales.php?start=" + start + "&end=" + end);
	}
</script>

<br />

<div class="container">
	<div class="row">
		<div class="col col-lg-4 col-md-6 col-sm-12 mt-2">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Buku Besar</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_ledger" />
						&nbsp;
						<input type="date" id="end_date_ledger" />
					</p>
					<a href="#" class="btn btn-primary" onclick="viewLedger()">View</a>
				</div>
			</div>
		</div>

		<div class="col col-lg-4 col-md-6 col-sm-12 mt-2">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Jurnal Penerimaan Kas</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_jpk" />
						&nbsp;
						<input type="date" id="end_date_jpk" />
					</p>
					<a href="#" class="btn btn-primary" onclick="viewJurnalPenerimaanKas()">View</a>
				</div>
			</div>
		</div>

		<div class="col col-lg-4 col-md-6 col-sm-12 mt-2">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Laba Rugi</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_profit_loss" />
						&nbsp;
						<input type="date" id="end_date_profit_loss" />
					</p>
					<a href="#" class="btn btn-primary" onclick="viewProfitLoss()">View</a>
				</div>
			</div>
		</div>

		<div class="col col-lg-4 col-md-6 col-sm-12 mt-2">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Hutang</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_jpk" />
						&nbsp;
						<input type="date" id="end_date_jpk" />
					</p>
					<a href="#" class="btn btn-primary" onclick="viewJurnalPenerimaanKas()">View</a>
				</div>
			</div>
		</div>

		<div class="col col-lg-4 col-md-6 col-sm-12 mt-2">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Absensi</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_presence" />
						&nbsp;
						<input type="date" id="end_date_presence" />
					</p>
					<a href="#" class="btn btn-primary" onclick="viewPresence()">View</a>
				</div>
			</div>
		</div>

		<div class="col col-lg-4 col-md-6 col-sm-12 mt-2">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Mutasi Barang</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_mutation" />
						&nbsp;
						<input type="date" id="end_date_mutation" />
					</p>
					<a href="#" class="btn btn-primary" onclick="viewMutation()">View</a>
				</div>
			</div>
		</div>

		<div class="col col-lg-4 col-md-6 col-sm-12 mt-2">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Produk Terlaris</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_best_selling_product" />
						&nbsp;
						<input type="date" id="end_date_best_selling_product" />
						<div class="form-group">
							Tipe
							<select id="tipe_best_selling_product" class="mr-3">
								<option value="1">FRAME</option>
								<option value="2">SOFTLENS</option>
								<option value="3">LENSA</option>
								<option value="4">ACCESSORIES</option>
							</select>
							Show
							<input type="text" id="limit_best_selling_product" size="4" value="50" />
							entries
						</div>
					</p>
					<a href="#" class="btn btn-primary" onclick="viewBestSellingProduct()">View</a>
				</div>
			</div>
		</div>

		<div class="col col-lg-4 col-md-6 col-sm-12 mt-2">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Pembelian Customer Terbanyak</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_most_valuable_customer" />
						&nbsp;
						<input type="date" id="end_date_most_valuable_customer" />
						<div class="form-group">
							Show
							<input type="text" id="limit_most_valuable_customer" size="4" value="25" />
							entries
						</div>
					</p>
					<a href="#" class="btn btn-primary" onclick="viewMostValuableCustomer()">View</a>
				</div>
			</div>
		</div>

		<div class="col col-lg-4 col-md-6 col-sm-12 mt-2">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Penjualan Sales</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_selling_by_sales" />
						&nbsp;
						<input type="date" id="end_date_selling_by_sales" />
					</p>
					<a href="#" class="btn btn-primary" onclick="viewSellingBySales()">View</a>
				</div>
			</div>
		</div>

		<div class="col col-lg-4 col-md-6 col-sm-12 mt-2">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Nilai Persediaan Barang</h5>
					<p class="card-text">
					</p>
					<a href="#" class="btn btn-primary" onclick="viewInventoryValue()">View</a>
				</div>
			</div>
		</div>

	</div>
</div>
