
$(function() {

	var table = $("#example").DataTable(
	{
		dom: 'B<"clear">lfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
		columns: [
			{ data: [1] },
			{ data: [2] },
			{ className: ' text-center ', data: [3] },
			{ className: ' text-center align-middle ', data: [4], orderable: false },
			{ className: ' text-center td-nowrap ', data: [5], orderable: false },
		],
		data: data,
		deferRender: true,
		order: [],
		rowId: [0],
	});

});