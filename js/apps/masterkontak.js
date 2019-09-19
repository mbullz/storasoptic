function generateReport()
{
    var sp = $("#startPeriode").val();
    var ep = $("#endPeriode").val();
    var url = "component/masterkontak/task/report_masterkontak.php";
    var data = "";
    
    if (sp == '')
	{
        alert('Tanggal mulai harus diisi');
    }
	else if (ep == '')
	{
        alert('Tanggal selesai harus diisi');
    }
    
	if ($("#customer1").prop('checked') == true)
	{
        var user_id = $("#user_id").val();
        data = '?mode=customer1&user_id=' + user_id + '&sp=' + sp + '&ep=' + ep;
    }
	else if ($("#supplier1").prop('checked') == true)
	{
        var user_id = $("#user_id").val();
        data = '?mode=supplier1&user_id=' + user_id + '&sp=' + sp + '&ep=' + ep;
    }
	else if ($("#karyawan1").prop('checked') == true)
	{
        var user_id = $("#user_id").val();
        data = '?mode=karyawan1&user_id=' + user_id + '&sp=' + sp + '&ep=' + ep;
    }
	else if ($("#cabang1").prop('checked') == true)
	{
        data = '?mode=cabang1&sp=' + sp + '&ep=' + ep;
    }
	else if ($("#cabang2").prop('checked') == true)
	{
        var user_id = $("#user_id").val();
        data = '?mode=cabang2&user_id=' + user_id + '&sp=' + sp + '&ep=' + ep;
    }
	else
	{
        return ;
    }
    
    NewWindow(url + data,'name','900','600','yes');
}

function generateReport2(klas, mode, id)
{
    var url = "component/masterkontak/task/report_masterkontak.php";
    var data = "";

    switch (klas) {
    	case 'customer':
    		data = '?mode=customer1&user_id=' + id;
    	break;
    }
    
    NewWindow(url + data, 'name', '900', '600', 'yes');
}

function getInfoCustomer(row, tr, user_id) {
	var html = '';

	$.ajax({
		url: 'component/masterkontak/task/ajax_masterkontak.php',
		type: 'GET',
		dataType: 'json',
		data: { mode: 'get_info_customer', user_id: user_id },
		success: function(result) {
			html += '<table width="100%" class="table table-bordered">';

			/*
			var keluarbarang = result.keluarbarang;
			var lunas = keluarbarang.lunas == '1' ? '<font class="text-success">Lunas</font>' : '<font class="text-danger">Belum Lunas</font>';
			var dkeluarbarang_info = '';

			// keluarbarang
			html += '<tr>';
			html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Status</td>';
			html += '<td class="text-left">' + lunas + '</td>';
			html += '</tr>';
			*/

			// stockbarang
			html += 	'<tr>';
			html += 		'<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Pembelian</td>';
			html += 		'<td>';

			html += 			'<table class="table table-bordered" style="width: 50%;">';
			html += 				'<thead>';
			html += 					'<tr>';
			html += 						'<th class="text-center">Tanggal</th>';
			html += 						'<th class="text-center">Invoice</th>';
			html += 						'<th class="text-center">Grand Total</th>';
			html += 						'<th class="text-center">Status</th>';
			html += 					'</tr>';
			html += 				'</thead>';

			html += 				'<tbody>';

			for (i=0; i<Object.keys(result.keluarbarang).length; i++) {
				var data = result.keluarbarang[i];
				var status_lunas = (data.lunas == '1') ? 'Lunas' : 'Belum Lunas';

				html += 				'<tr>';
				html += 					'<td class="text-center">' + data.tgl + '</td>';
				html += 					'<td class="text-center"><a href="include/draft_invoice_1.php?keluarbarang_id=' + data.keluarbarang_id + '" target="_blank">' + data.referensi + '</a></td>';
				html += 					'<td class="text-right">' + print_number(data.total) + '</td>';
				html += 					'<td class="text-center">' + status_lunas + '</td>';
				html += 				'</tr>';
			}

			html += 				'</tbody>';
			html += 			'</table>';

			html += 		'</td>';
			html += 	'</tr>';

			/*
			//info
			html += '<tr>';
			html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Keterangan</td>';
			html += '<td class="text-left">' + nl2br(dkeluarbarang_info) + '</td>';
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
			*/

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
			{ className: 'details-control', data: [1], orderable: false },
			{ data: [2] },
			{ data: [3] },
			{ data: [4] },
			{ data: [5] },
			{ className: 'text-center', data: [6], orderable: false },
		],
		data: data,
		deferRender: true,
		order: [
			[1, 'asc']
		],
		rowId: [0],
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

	$('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var user_id = $(tr).attr("id");
        var klasifikasi = $('#klas').val();
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            if (klasifikasi == 'customer') getInfoCustomer(row, tr, user_id);
            //row.child( html ).show();
            //tr.addClass('shown');
        }
	});
	
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

// --- show / hide kontak
function viewKontak(infoID) {
	$(document).ready(function() {
		$('#' + infoID).toggle();					   
	})
}

function deleteData(user_id) {
	var klas = $('#klas').val();
	var c = confirm('Apakah anda yakin ingin menghapus data ini ?');

	if (c) {
		$.ajax({
			type: 'POST',
			url: 'component/masterkontak/p_masterkontak.php?p=delete',
			data: 'klas=' + klas + '&id=' + user_id,
			success: function(data) {
				$('#result').html(data);
			},
		});
	}
}