
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
				var dkeluarbarang_info = '';

				// dkeluarbarang
				html += '<tr>';
				html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Detail</td>';
				html += '<td>';

				html += '<table width="100%" class="table table-bordered">';
				html += '<thead>';
				html += '<tr>';
				html += '<th class="text-left">Barang</th>';
				html += '<th class="text-right">Qty</th>';
				html += '</tr>';
				html += '</thead>';

				html += '<tbody>';

				var totalBeforePpn = 0;
				for (i=0;i<Object.keys(result.dkeluarbarang).length;i++) {
					var data = result.dkeluarbarang[i];

					if (data.info != '') dkeluarbarang_info = data.info;

					if (data.tipe != 3) {
						var subtotal = data.harga * data.qty;
						if (data.tdiskon == '1') subtotal -= (subtotal * (data.diskon / 100));
						else subtotal -= data.diskon;

						totalBeforePpn += parseInt(subtotal);

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

						html += '</tr>';
					}

					if (data.tipe == 3 || data.tipe == 5) {
						var subtotal = data.harga_lensa * 2;
						subtotal -= (subtotal * (data.diskon_lensa / 100));

						totalBeforePpn += parseInt(subtotal);

						var product = '';

						product += '<span class="badge badge-primary" style="font-size:11px;">Lensa</span><br />';
						product += data.lensa_kode + ' # ' + data.lensa_brand_name + ' # ' + data.lensa_barang + '<br />';

						if (data.special_order == '1')
							product += nl2br(data.info_special_order) + '<br />';

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
						product += '<td>Right</td>';
						product += '<td class="text-center">' + data.rSph + '</td>';
						product += '<td class="text-center">' + data.rCyl + '</td>';
						product += '<td class="text-center">' + data.rAxis + '</td>';
						product += '<td class="text-center">' + data.rAdd + '</td>';
						product += '<td class="text-center">' + data.rPd + '</td>';
						product += '</tr>';

						product += '<tr>';
						product += '<td>Left</td>';
						product += '<td class="text-center">' + data.lSph + '</td>';
						product += '<td class="text-center">' + data.lCyl + '</td>';
						product += '<td class="text-center">' + data.lAxis + '</td>';
						product += '<td class="text-center">' + data.lAdd + '</td>';
						product += '<td class="text-center">' + data.lPd + '</td>';
						product += '</tr>';

						product += '</tbody>';
						product += '</table>';

						html += '<tr>';
						html += '<td class="text-left">' + product + '</td>';
						html += '<td class="text-right">2</td>';

						html += '</tr>';
					}
				}

				html += '</tbody>';
				html += '</table>';

				html += '</td>';
				html += '</tr>';

				//info
				html += '<tr>';
				html += '<td width="10%" style="vertical-align:middle;" class="text-center text-secondary">Keterangan</td>';
				html += '<td class="text-left">' + nl2br(dkeluarbarang_info) + '</td>';
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

function updateStatus(keluarbarang_order_id) {
	var c = confirm('Are you sure?');

	if (c) {
		$.ajax({
			url: 'component/penjualanorder/p_penjualanorder.php',
			type: 'POST',
			data: 'keluarbarang_order_id=' + keluarbarang_order_id,
			success: function(result) {
				$('#result').html(result);
			},
		});
	}
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
			{ className: '', data: [5] },
			{ className: ' text-center ', data: [6], orderable: false },
		],
		createdRow: function(row, data, dataIndex) {
			if (data[7] == 1) {
				$(row).addClass(' status-order ');
			}
			else if (data[7] == 2) {
				$(row).addClass(' status-ready ');
			}
		},
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
