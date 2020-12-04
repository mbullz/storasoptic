
$(function() {

    var table = $("#example").DataTable(
    {
        dom: 'B<"clear">lfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        columns: [
            { data: "tgl" },
            { data: "referensi" },
            { data: "customer_name" },
            { className: ' text-right td-nowrap ', data: "jumlah", searchable: false },
            { data: "info", orderable: false },
            { className: ' text-center ', data: "link_kwitansi", orderable: false },
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "component/kwitansi/task/ajax_kwitansi.php",
            "type": "GET",
            "data": function (d) {
                d.mode = "get_data";
                d.c = $('#c').val();
                d.branch_id = $('#branch_id').val();
            },
        },
        order: [],
    });

    // Setup - add a text input to each footer cell
	$('#example tfoot th').each( function ()
	{
		var title = $('#example tfoot th').eq( $(this).index() ).text();
		title = $.trim(title);
		if (title != "")
			$(this).html( '<input type="text" placeholder="' + title + '" style="width:100%;padding:3px;box-sizing:border-box;" />' );
	});
	
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
	});

});