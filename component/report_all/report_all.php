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
</script>

<br />

<div class="container">
	<div class="row">
		<div class="col col-lg-4 col-md-6 col-sm-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Buku Besar</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_ledger">
						&nbsp;
						<input type="date" id="end_date_ledger" />
					</p>
					<a href="#" class="btn btn-primary" onclick="viewLedger()">View</a>
				</div>
			</div>
		</div>

		<div class="col col-lg-4 col-md-6 col-sm-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Jurnal Penerimaan Kas</h5>
					<p class="card-text">
						Periode
						<br />
						<input type="date" id="start_date_jpk">
						&nbsp;
						<input type="date" id="end_date_jpk" />
					</p>
					<a href="#" class="btn btn-primary" onclick="viewJurnalPenerimaanKas()">View</a>
				</div>
			</div>
		</div>
	</div>
</div>
