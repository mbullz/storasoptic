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

function getInfo(row, tr, product_id) {
	row.child('').show();
	tr.addClass('shown');
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
        var product_id = $(tr).attr("id");
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            getInfo(row, tr, product_id);
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