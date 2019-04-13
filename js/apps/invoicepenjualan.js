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

			if (Object.keys(result[0].dkeluarbarang).length > 0)
			{
				var keluarbarang = result[0].keluarbarang;
				var lunas = keluarbarang.lunas == '1' ? '<font class="text-success">Lunas</font>' : '<font class="text-danger">Belum Lunas</font>';
				// keluarbarang
				html += '<tr>';
				html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Status</td>';
				html += '<td class="text-left">' + lunas + '</td>';
				html += '</tr>';

				if (keluarbarang.lunas == '0') {
					html += '<tr>';
					html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Piutang</td>';
					html += '<td class="text-left"><font class="text-danger">Rp ' + print_number(keluarbarang.round) + '</font>&nbsp;&nbsp;&nbsp;(Jatuh Tempo : ' + keluarbarang.ship_date + ')</td>';
					html += '</tr>';
				}

				// dkeluarbarang
				html += '<tr>';
				html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Detail</td>';
				html += '<td>';

				html += '<table border="0" width="100%" class="table">';
				html += '<thead>';
				html += '<tr>';
				html += '<th class="text-left">Kode</th>';
				html += '<th class="text-left">Barang</th>';
				html += '<th class="text-left">Edisi</th>';
				html += '<th class="text-right">Qty</th>';
				html += '<th class="text-right">Harga</th>';
				html += '<th class="text-right">Diskon</th>';
				html += '<th class="text-right">Total</th>';
				html += '</tr>';
				html += '</thead>';

				html += '<tbody>';

				for (i=0;i<Object.keys(result[0].dkeluarbarang).length;i++) {
					var data = result[0].dkeluarbarang[i];

					if (data.info != '') {
						html += '<tr class="warning"><td>&nbsp;</td><td colspan="6" class="text-left">' + data.info + '</td></tr>';
					}

					html += '<tr>';
					html += '<td class="text-left">' + data.kode + '</td>';
					html += '<td class="text-left">' + data.barang + '</td>';
					html += '<td class="text-left">' + data.spec3 + '</td>';
					html += '<td class="text-right">' + print_number(data.qty) + '</td>';
					html += '<td align="right">' + print_number(data.harga) + '</td>';
					
					html += '<td align="right">';
					if (data.tdiskon == '1') html += print_number(data.diskon) + ' %';
					else html += print_number(data.diskon);
					html += '</td>';

					html += '<td align="right">' + print_number(data['subtotal']) + '</td>';
					html += '</tr>';
				}

				html += '</tbody>';
				html += '</table>';

				html += '</td>';
				html += '</tr>';

				// payment
				html += '<tr>';
				html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Pembayaran</td>';
				html += '<td>';

				html += '<table border="0" width="100%" class="table">';
				html += '<thead>';
				html += '<tr>';
				html += '<th class="text-left">Tanggal</th>';
				html += '<th class="text-right">Jumlah</th>';
				html += '<th class="text-left">Keterangan</th>';
				html += '</tr>';
				html += '</thead>';

				html += '<tbody>';

				for (i=0;i<Object.keys(result[0].payment).length;i++) {
					var data = result[0].payment[i];

					html += '<tr>';
					html += '<td class="text-left">' + data.date + '</td>';
					html += '<td class="text-right">' + print_number(data.amount) + '</td>';
					html += '<td class="text-left">' + data.info + '</td>';
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
	$("#example").dataTable(
	{
		dom: 'B<"clear">lfrtip',
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
	});

	/*
	$('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var keluarbarang_id = $(tr).attr("keluarbarangid");
 
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
		if (title != "" && $(this).index() != 0)
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
	*/

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
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				$('#result').html(data);
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