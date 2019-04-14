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

$(document).ready(function()
{
	$("#example").dataTable(
	{
		dom: 'T<"clear">lfrtip',
		tableTools:
		{
			"sSwfPath": "media/swf/copy_csv_xls_pdf.swf"
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

function deleteData(klas, user_id) {
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