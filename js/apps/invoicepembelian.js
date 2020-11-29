
function generateReport(){
    var tipe = $("#tipe").val();
	var supplier = $("#supplier").val();
    var sp = $("#startPeriode").val();
    var ep = $("#endPeriode").val();
    if (sp == '') {
        alert('Tanggal mulai harus diisi');
    } else if (ep == '') {
        alert('Tanggal selesai harus diisi');
    } else {
        var url = 'component/invoicepembelian/task/report_invoicepembelian.php';
        var data = '?mode=general_report&tipe=' + tipe + '&sp=' + sp + '&ep=' + ep + "&supplier=" + supplier;
        
        NewWindow(url + data,'name','900','600','yes');
    }
}

function getInfo(row, tr, masukbarang_id) {
	var html = '';
	$.ajax({
		url: 'component/invoicepembelian/task/ajax_invoicepembelian.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=get_info&masukbarang_id=' + masukbarang_id,
		success: function(result) {
			html += '<table width="100%" class="table table-bordered">';

			if (Object.keys(result.dmasukbarang).length > 0)
			{
				var masukbarang = result.masukbarang;
				var tipe = masukbarang.tipe;
				var grandtotal = masukbarang.grandtotal;
				var grandtotalcolspan = 5;

				// dmasukbarang
				html += '<tr>';
				html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Detail</td>';
				html += '<td>';

				html += '<table width="100%" class="table table-bordered">';
				html += '<thead>';
				html += '<tr>';
				html += '<th class="text-left">Kode</th>';
				html += '<th class="text-left">Brand</th>';
				html += '<th class="text-left">Product</th>';

				switch (tipe) {
					case '1':
						grandtotalcolspan = 7;
						html += '<th class="text-left">Frame</th>';
						html += '<th class="text-left">Color</th>';
					break;

					case '2':
						grandtotalcolspan = 8;
						html += '<th class="text-left">Minus</th>';
						html += '<th class="text-left">Color</th>';
						html += '<th class="text-left">Expiry Date</th>';
					break;

					case '3':
						grandtotalcolspan = 8;
						html += '<th class="text-left">SPH</th>';
						html += '<th class="text-left">CYL</th>';
						html += '<th class="text-left">ADD</th>';
					break;
				}

				html += '<th class="text-right">Qty</th>';
				html += '<th class="text-right">Biaya</th>';
				html += '<th class="text-right">Subtotal</th>';
				html += '</tr>';
				html += '</thead>';

				html += '<tbody>';

				for (i = 0; i < Object.keys(result.dmasukbarang).length; i++) {
					var data = result.dmasukbarang[i];

					if (data.info != '') dmasukbarang_info = data.info;

					html += '<tr>';
					html += '<td class=" ">' + data.kode + '</td>';
					html += '<td class=" ">' + data.brand_name + '</td>';
					html += '<td class=" ">' + data.barang + '</td>';

					if (tipe == 1) {
						html += '<td class=" ">' + data.frame + '</td>';
						html += '<td class=" ">' + data.color + '</td>';
					}
					else if (tipe == 2) {
						html += '<td class=" ">' + data.frame + '</td>';
						html += '<td class=" ">' + data.color + '</td>';
						html += '<td class=" ">' + data.ukuran + '</td>';
					}
					else if (tipe == 3) {
						html += '<td class=" ">' + data.frame + '</td>';
						html += '<td class=" ">' + data.color + '</td>';
						html += '<td class=" ">' + data.power_add + '</td>';
					}

					html += '<td class="text-right">' + print_number(data.qty) + '</td>';
					html += '<td class="text-right">' + print_number(data.cost) + '</td>';
					html += '<td class="text-right">' + print_number(data.subtotal) + '</td>';

					html += '</tr>';
				}

				// Grand Total
				html += '<tr>';
				html += '<td colspan="' + grandtotalcolspan + '" class="text-right"><strong>Grand Total</strong></td>';
				html += '<td class="text-right"><strong>' + print_number(grandtotal) + '</strong></td>';
				html += '</tr>';

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
			{ data: "checkbox", searchable: false, orderable: false },
			{ className: 'details-control', data: null, defaultContent: "", searchable: false, orderable: false },
			{ data: "tgl" },
			{ data: "link_referensi" },
			{ data: "supplier_name" },
			{ className: ' text-right td-nowrap ', data: "total", searchable: false },
			{ className: ' text-center ', data: "tipe_name" },
			{ className: ' text-center ', data: "edit", searchable: false, orderable: false },
		],
		createdRow: function(row, data, dataIndex) {
		},
		//data: data,
		//deferRender: true,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "component/invoicepembelian/task/ajax_invoicepembelian.php",
			"type": "GET",
			"data": function (d) {
				d.mode = "get_data";
				d.c = $('#c').val();
				d.branch_id = $('#branch_id').val();
			},
		},
		order: [
			//[2, 'desc']
		],
		//rowId: [0],
	});

	$('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var masukbarang_id = $(tr).attr("id");
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            getInfo(row, tr, masukbarang_id);
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

	$('#formdata').submit(function()
	{
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

})
