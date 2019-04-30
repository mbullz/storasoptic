function generateReport(){
    var sp = $("#startPeriode").val();
    var ep = $("#endPeriode").val();
    var url = "";
    var data = "";
    
    if (sp == '') {
        alert('Tanggal mulai harus diisi');
    } else if (ep == '') {
        alert('Tanggal selesai harus diisi');
    }
    
    if ($("#tipe1").prop('checked') == true) {
        var tipe = $("#tipe").val();
        data = '?mode=1&tipe=' + tipe + '&sp=' + sp + '&ep=' + ep;
    } else if ($("#tipe2").prop('checked') == true) {
        var order = $("#urutanPenjualan").val();
        data = '?mode=2&order=' + order + '&sp=' + sp + '&ep=' + ep;
    }
	else if ($("#tipe3").prop('checked') == true)
	{
        data = '?mode=3&sp=' + sp + '&ep=' + ep;
    }
	else {
        return ;
    }
	
	url = 'component/invoicepenjualan/task/report_invoicepenjualan.php';
    
    NewWindow(url + data,'name','900','600','yes');
}

function getInfo(row, tr, keluarbarang_id) {
	var html = '';
	$.ajax({
		url: 'component/invoicepenjualan/task/ajax_invoicepenjualan.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=get_info&keluarbarang_id=' + keluarbarang_id,
		success: function(result) {
			html += '<table width="100%" class="table table-bordered">';

			if (Object.keys(result.dkeluarbarang).length > 0)
			{
				var keluarbarang = result.keluarbarang;
				var lunas = keluarbarang.lunas == '1' ? '<font class="text-success">Lunas</font>' : '<font class="text-danger">Belum Lunas</font>';
				// keluarbarang
				html += '<tr>';
				html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Status</td>';
				html += '<td class="text-left">' + lunas + '</td>';
				html += '</tr>';

				/*
				if (keluarbarang.lunas == '0') {
					html += '<tr>';
					html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Piutang</td>';
					html += '<td class="text-left"><font class="text-danger">Rp ' + print_number(keluarbarang.round) + '</font>&nbsp;&nbsp;&nbsp;(Jatuh Tempo : ' + keluarbarang.ship_date + ')</td>';
					html += '</tr>';
				}
				*/

				// dkeluarbarang
				html += '<tr>';
				html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Detail</td>';
				html += '<td>';

				html += '<table width="100%" class="table table-bordered">';
				html += '<thead>';
				html += '<tr>';
				html += '<th class="text-left">Barang</th>';
				html += '<th class="text-right">Qty</th>';
				html += '<th class="text-right">Harga</th>';
				html += '<th class="text-right">Diskon</th>';
				html += '<th class="text-right">Subtotal</th>';
				html += '</tr>';
				html += '</thead>';

				html += '<tbody>';

				for (i=0;i<Object.keys(result.dkeluarbarang).length;i++) {
					var data = result.dkeluarbarang[i];

					if (data.tipe != 3) {
						var subtotal = data.harga * data.qty;
						if (data.tdiskon == '1') subtotal -= (subtotal * (data.diskon / 100));
						else subtotal -= data.diskon;

						var product = '';
						if (data.tipe == 1 || data.tipe == 5) {
							product += '<span class="badge badge-primary" style="font-size:11px;">Frame</span><br />';
							product += data.kode + ' # ' + data.brand_name + ' # ' + data.barang + '<br />';
							product += 'Frame: ' + data.frame + '<br />';
							product += 'Color: ' + data.color;
						}
						else if (data.tipe == 2) {
							product += '<span class="badge badge-primary" style="font-size:11px;">Softlens</span><br />';
							product += data.kode + ' # ' + data.brand_name + ' # ' + data.barang + '<br />';
							product += 'Minus: ' + data.frame + '<br />';
							product += 'Color: ' + data.color;
						}
						else if (data.tipe == 4) {
							product += '<span class="badge badge-primary" style="font-size:11px;">Accessories</span><br />';
							product += data.kode + ' # ' + data.brand_name + ' # ' + data.barang + '<br />';
							product += 'Keterangan 1: ' + data.frame + '<br />';
							product += 'Keterangan 2: ' + data.color;
						}

						html += '<tr>';
						html += '<td class="text-left">' + product + '</td>';
						html += '<td class="text-right">' + print_number(data.qty) + '</td>';
						html += '<td align="right">' + print_number(data.harga) + '</td>';
						
						html += '<td align="right">';
						if (data.tdiskon == '1') html += print_number(data.diskon) + ' %';
						else html += print_number(data.diskon);
						html += '</td>';

						html += '<td align="right">' + print_number(subtotal) + '</td>';

						html += '</tr>';
					}

					if (data.tipe == 3 || data.tipe == 5) {
						var subtotal = data.harga_lensa * 2;
						if (data.tdiskon == '1') subtotal -= (subtotal * (data.diskon / 100));
						else subtotal -= data.diskon;

						var product = '';
						product += '<span class="badge badge-primary" style="font-size:11px;">Lensa</span><br />';
						product += data.lensa_kode + ' # ' + data.lensa_brand_name + ' # ' + data.lensa_barang + '<br />';
						product += '<table width="100%" class="table table-bordered">';
						product += '<thead>';
						product += '<tr>';
						product += '<th class="text-left"></th>';
						product += '<th class="text-center">SPH</th>';
						product += '<th class="text-center">CYL</th>';
						product += '<th class="text-center">AXIS</th>';
						product += '<th class="text-center">ADD</th>';
						product += '<th class="text-center">PD</th>';
						product += '</tr>';
						product += '</thead>';

						product += '<tbody>';

						product += '<tr>';
						product += '<td>Left</td>';
						product += '<td class="text-center">' + data.lSph + '</td>';
						product += '<td class="text-center">' + data.lCyl + '</td>';
						product += '<td class="text-center">' + data.lAxis + '</td>';
						product += '<td class="text-center">' + data.lAdd + '</td>';
						product += '<td class="text-center">' + data.lPd + '</td>';
						product += '</tr>';

						product += '<tr>';
						product += '<td>Right</td>';
						product += '<td class="text-center">' + data.rSph + '</td>';
						product += '<td class="text-center">' + data.rCyl + '</td>';
						product += '<td class="text-center">' + data.rAxis + '</td>';
						product += '<td class="text-center">' + data.rAdd + '</td>';
						product += '<td class="text-center">' + data.rPd + '</td>';
						product += '</tr>';

						product += '</tbody>';
						product += '</table>';

						product += '<button type="button">Gagal Potong Kiri</button>&nbsp;';
						product += '<button type="button">Gagal Potong Kanan</button>';

						html += '<tr>';
						html += '<td class="text-left">' + product + '</td>';
						html += '<td class="text-right">2</td>';
						html += '<td align="right">' + print_number(data.harga_lensa) + '</td>';
						
						html += '<td align="right">';
						if (data.tdiskon == '1') html += print_number(data.diskon) + ' %';
						else html += print_number(data.diskon);
						html += '</td>';

						html += '<td align="right">' + print_number(subtotal) + '</td>';

						html += '</tr>';
					}
				}

				// ppn
				var ppn = parseInt(keluarbarang.ppn);
				var total = parseInt(keluarbarang.total);
				if (ppn > 0) {
					html += '<tr>';
					html += '<td colspan="4" class="text-right">PPN ' + ppn + '%</td>';
					html += '<td class="text-right">' + print_number(Math.round(total/((100+ppn)/100))) + '</td>';
					html += '</tr>';
				}

				// Grand Total
				html += '<tr>';
				html += '<td colspan="4" class="text-right"><strong>Grand Total</strong></td>';
				html += '<td class="text-right"><strong>' + print_number(keluarbarang.total) + '</strong></td>';
				html += '</tr>';

				html += '</tbody>';
				html += '</table>';

				html += '</td>';
				html += '</tr>';

				// payment
				html += '<tr>';
				html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Pembayaran</td>';
				html += '<td>';

				html += '<table width="50%" class="table table-bordered">';
				html += '<thead>';
				html += '<tr>';
				html += '<th class="text-center">Tanggal</th>';
				html += '<th class="text-right">Jumlah</th>';
				html += '<th class="text-left">Keterangan</th>';
				html += '</tr>';
				html += '</thead>';

				html += '<tbody>';

				for (i=0;i<Object.keys(result.payments).length;i++) {
					var data = result.payments[i];

					html += '<tr>';
					html += '<td class="text-center">' + data.tgl + '</td>';
					html += '<td class="text-right">' + print_number(data.jumlah) + '</td>';
					html += '<td class="text-left">';
					html += '<span class="badge badge-primary" style="font-size:11px;">' + data.pembayaran + '</span> ';
					html += data.info
					html += '</td>';
					html += '</tr>';
				}

				html += '</tbody>';
				html += '</table>';

				html += '</td>';
				html += '</tr>';
			}

			html += '</table>';
			//alert(Object.keys(result[0].empty).length);
		},
		complete: function()
		{
			row.child( html ).show();
           	tr.addClass('shown');
		}
	});
}

$(document).ready(function()
{
	var table = $("#example").DataTable(
	{
		dom: 'B<"clear">lfrtip',
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        columns: [
			{ data: [1], orderable: false },
			{ className: 'details-control', data: [2], orderable: false },
			{ data: [3] },
			{ data: [4] },
			{ data: [5] },
			{ className: ' text-right td-nowrap ', data: [6] },
			{ className: ' text-center ', data: [7] },
		],
		data: data,
		deferRender: true,
		order: [
			//[2, 'desc']
		],
		rowId: [0],
	});

	$('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var keluarbarang_id = $(tr).attr("id");
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            getInfo(row, tr, keluarbarang_id);
            //row.child( html ).show();
            //tr.addClass('shown');
        }
	});

	// Setup - add a text input to each footer cell
	$('#example tfoot th').each( function ()
	{
		var title = $('#example tfoot th').eq( $(this).index() ).text();
		title = $.trim(title);
		if (title != "")
			$(this).html( '<input type="text" placeholder="' + title + '" style="width:100%;padding:3px;box-sizing:border-box;" />' );
	} );
	
	// Apply the search
	table.columns().eq( 0 ).each( function ( colIdx )
	{
		$( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function ()
		{
			table
				.column( colIdx )
				.search( this.value )
				.draw();
		} );
	} );

	$().ajaxStart(function() {
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function() {
		$('#loading').hide();
		$('#result').fadeIn('slow');
	});

	$('#formdata').submit(function() {
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				alert(data.message);
				location.reload();
			}
		})
		return false;
	});
  $('#result').click(function(){
  $(this).hide();
  });
})
// --- show / hide info
function viewInfo(infoID) {
	$(document).ready(function() {
		$('#' + infoID).toggle();					   
	})
}