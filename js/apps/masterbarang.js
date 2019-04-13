var base_url = $('#base_url').val();

function hapusData()
	{
		//return confirm('Lanjutkan Proses ... ?');
		
		return false;
	}

function refreshJenis() {
	var tipe = $("#tipe2").val();
	$.ajax({
		url: 'component/masterbarang/task/ajax_masterbarang.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=get_jenis&tipe=' + tipe,
		success: function(result) {
			var html = '<option value="0">- Pilih jenis -</option>';
			for (i=0; i<result.length; i++) {
				html += '<option value="' + result[i].kode + '">' + result[i].jenis + '</option>';
			}
			$("#jenis").html(html);
		}
	});
}

function generateReport()
{
	if ($("#report1").prop('checked'))
	{
		var tipe = $("#tipe1").val();
		NewWindow('component/masterbarang/task/report_masterbarang.php?mode=general_report&tipe=' + tipe,'name','720','520','yes');
	}
	else if ($("#report2").prop('checked'))
	{
		if ($("#jenis").val() <= 0) {
			alert('Pilih jenis !!!');
		} else {
			var tipe = $("#tipe2").val();
			var jenis = $("#jenis").val();
			NewWindow('component/masterbarang/task/report_masterbarang.php?mode=brand_report&tipe=' + tipe + '&jenis=' + jenis,'name','720','520','yes');
		}
	}
	else if ($("#report3").prop('checked'))
	{
		var tipe = $("#tipe3").val();
		var periode1 = $("#textPeriode1").val();
		var periode2 = $("#textPeriode2").val();
		NewWindow('component/masterbarang/task/report_masterbarang.php?mode=old_stock_report&tipe=' + tipe + '&periode1=' + periode1 + '&periode2=' + periode2,'name','720','520','yes');
	}
	else if ($("#report4").prop('checked'))
	{
		var tipe = $("#tipe4").val();
		var harga1 = $("#textHarga1").val();
		var harga2 = $("#textHarga2").val();
		NewWindow('component/masterbarang/task/report_masterbarang.php?mode=price_report&tipe=' + tipe + '&harga1=' + harga1 + '&harga2=' + harga2,'name','720','520','yes');
	}
	else if ($("#report5").prop('checked'))
	{
		var tipe = $("#tipe5").val();
		var supplier = $("#supplier").val();
		NewWindow('component/masterbarang/task/report_masterbarang.php?mode=supplier_report&tipe=' + tipe + '&supplier=' + supplier,'name','720','520','yes');
	}
	else
	{
		alert('Pilih tipe laporan !!!');
	}
}

function viewInfo(infoID)
{
	$(document).ready(function()
	{
		$('#' + infoID).toggle();					   
	})
}

function onLoad()
{
	$("#dialog").dialog(
	{
		autoOpen: false,
		modal: true,
		show:
		{
			effect: "drop",
			duration: 500
		},
		hide:
		{
			effect: "drop",
			duration: 500
		},
		open: function()
		{
			jQuery('.ui-widget-overlay').bind('click',function()
			{
				jQuery('#dialog').dialog('close');
			});
		},
		close: function()
		{
		},
		buttons:
		{
			Cancel: function()
			{
				$("#dialog").dialog("close");
			},
			"Go": function()
			{
				var data = $("#cabang").val();
				var i = "";
				var oTable = $("#example").dataTable();

				oTable.$('input:checked').each(function()
				{
					i = oTable.$("#hiddenNo" + $(this).val()).val();

					data += "#" + oTable.$("#data" + i).val() + "-" + $("#textQty" + i).val();
				});

				$.ajax(
				{
					url: 'component/masterbarang/task/_pindah_cabang.php',
					type: 'POST',
					data: "data=" + data,
					success: function()
					{
						alert("Sukses Memindahkan Barang Antar Cabang");

						window.location = "/" + base_url + "/index-c-masterbarang.pos";
					}
				});
			}
		}
	});

	$("#dialog3").dialog(
	{
		autoOpen: false,
		modal: true,
		show:
		{
			effect: "drop",
			duration: 500
		},
		hide:
		{
			effect: "drop",
			duration: 500
		},
		open: function()
		{
			jQuery('.ui-widget-overlay').bind('click',function()
			{
				jQuery('#dialog3').dialog('close');
			});
		},
		close: function()
		{
		},
		buttons:
		{
			"No Barcode": function()
			{
				printInvoice2();
				$("#dialog3").dialog("close");
			},
			"With Barcode": function()
			{
				printInvoice();
				$("#dialog3").dialog("close");
			}
		}
	});

	$("#dialog2").dialog(
	{
		autoOpen: false,
		modal: true,
		show:
		{
			effect: "drop",
			duration: 500
		},
		hide:
		{
			effect: "drop",
			duration: 500
		},
		open: function()
		{
			jQuery('.ui-widget-overlay').bind('click',function()
			{
				jQuery('#dialog2').dialog('close');
			});
		},
		close: function()
		{
		},
		buttons:
		{
			Cancel: function()
			{
				$("#dialog2").dialog("close");
			},
			"Go": function()
			{
				retur($("#hiddenReturProductId").val(), $("#textReturQty").val(), $("#textReturInfo").val());

				$("#dialog2").dialog("close");
			}
		}
	});
	
	$("#dialogReturSome").dialog(
	{
		autoOpen: false,
		modal: true,
		show:
		{
			effect: "drop",
			duration: 500
		},
		hide:
		{
			effect: "drop",
			duration: 500
		},
		open: function()
		{
			jQuery('.ui-widget-overlay').bind('click',function()
			{
				jQuery('#dialogReturSome').dialog('close');
			});
		},
		close: function()
		{
		},
		buttons:
		{
			Cancel: function()
			{
				$("#dialogReturSome").dialog("close");
			},
			"Go": function()
			{
				var data = $("#textReturInfo2").val();
				var i = "";
				var oTable = $("#example").dataTable();

				oTable.$('input:checked').each(function()
				{
					i = oTable.$("#hiddenNo" + $(this).val()).val();

					data += "#" + oTable.$("#data" + i).val() + "-" + $("#textReturQty2" + i).val();
				});

				$.ajax(
				{
					url: 'component/masterbarang/task/_retursome.php',
					type: 'POST',
					data: "data=" + data,
					success: function()
					{
						alert("Sukses Retur Barang");

						window.location = "/" + base_url + "/index-c-masterbarang.pos";
					}
				});
				
				$("#dialogReturSome").dialog("close");
			}
		}
	});
}

function deleteProduct()
{
	var oTable = $("#example").dataTable();
	var data = '';
	var list = '';
	var i = '';
			
	if (prompt('Kode Hapus :') == '1234')
	{
		oTable.$('input:checked').each(function()
		{
			i = oTable.$("#hiddenNo" + $(this).val()).val();

			list += '       ' + $.trim(oTable.$("#tdBrand" + i).html()) + ' # ' + $.trim(oTable.$("#tdKode" + i).html()) + ' # ' + $.trim(oTable.$("#tdColor" + i).html()) + "\n\n";
		});
		
		if (confirm("Daftar Barang yang Akan Dihapus : \n\n" + list + "Lanjutkan Proses ... ?"))
		{
			data = '';

			oTable.$('input:checked').each(function()
			{
				data += $(this).val() + "#";
			});

			$.ajax(
			{
				url: 'component/masterbarang/task/_delete_product.php',
				type: 'POST',
				data: "data=" + data,
				success: function()
				{
					alert("Sukses Menghapus Barang");

					window.location = "/" + base_url + "/index-c-masterbarang.pos";
				}
			});
		}
	}
}

function pindahCabang()
{
	var html = "<tr bgcolor='#660099'><th style='color:#FFF'>Product</th><th style='color:#FFF'>Qty</th></tr>";
	var i = "";
	var oTable = $("#example").dataTable();

	oTable.$('input:checked').each(function()
	{
		i = oTable.$("#hiddenNo" + $(this).val()).val();

		html += "<tr>" 
						+ "<td align='center'>" 
							+ oTable.$("#tdBrand" + i).html() + " # " + oTable.$("#tdKode" + i).html() + " # " + oTable.$("#tdColor" + i).html() 
						+ "</td>" 
	  
						+ "<td align='center'>" 
							+ "<input type='text' id='textQty" + i + "' size='1' value='0' onfocus='javascript:if(this.value==\"0\") this.value=\"\";' onblur='javascript:if(this.value==\"\") this.value=\"0\";' />" 
						+ "</td>" 
					+ "</tr>";
	});

	$("#dialogTableDetail").html(html);

	$("#dialog").dialog("open");
}

function returSome()
{
	var html = "<tr bgcolor='#660099'><th style='color:#FFF'>Product</th><th style='color:#FFF'>Qty</th></tr>";
	var i = "";
	var oTable = $("#example").dataTable();

	oTable.$('input:checked').each(function()
	{
		i = oTable.$("#hiddenNo" + $(this).val()).val();

		html += "<tr>" 
						+ "<td align='center'>" 
							+ oTable.$("#tdBrand" + i).html() + " # " + oTable.$("#tdKode" + i).html() + " # " + oTable.$("#tdColor" + i).html() 
						+ "</td>" 
	  
						+ "<td align='center'>" 
							+ "<input type='text' id='textReturQty2" + i + "' size='1' value='0' onfocus='javascript:if(this.value==\"0\") this.value=\"\";' onblur='javascript:if(this.value==\"\") this.value=\"0\";' />" 
						+ "</td>" 
					+ "</tr>";
	});

	$("#dialogTableDetail2").html(html);

	$("#dialogReturSome").dialog("open");
}

function openDialogRetur(product_id)
{
	$("#textReturInfo").val("");
	$("#textReturQty").val("0");
	$("#hiddenReturProductId").val(product_id);

	$("#dialog2").dialog("open");
}

function retur(product_id, qty, info)
{
	if (qty != null && qty != 0 && qty != "")
	{
		$.ajax(
		{
			url: 'component/masterbarang/task/_retur.php',
			type: 'POST',
			data: "product_id=" + product_id + "&qty=" + qty + "&info=" + info,
			success: function()
			{
				alert("Sukses Melakukan Retur");

				window.location = "/" + base_url + "/index-c-masterbarang.pos";
			}
		});
	}
}

function openDialogPrintInvoice()
{
	$("#dialog3").dialog("open");
}

function printInvoice()
{
	var data = "";
	var i = "";
	var company_name = $('#company_name').val();
	var oTable = $("#example").dataTable();

	oTable.$('input:checked').each(function()
	{
		i = oTable.$("#hiddenNo" + $(this).val()).val();

		data += oTable.$("#hiddenProductId" + i).val() + ";" + oTable.$("#tdBrand" + i).html() + ";" + oTable.$("#tdKode" + i).html() + ";" + oTable.$("#tdPrice" + i).html() + ";" + oTable.$("#tdKodeHarga" + i).html() + ";";
	});
	
	sessionStorage.setItem('data', data);
	sessionStorage.setItem('company_name', company_name);
	NewWindow('include/draft_barcode2.php','name','640','550','yes');
}

function printInvoice2()
{
	var data = "";
	var i = "";
	var company_name = $('#company_name').val();
	var oTable = $("#example").dataTable();

	oTable.$('input:checked').each(function()
	{
		i = oTable.$("#hiddenNo" + $(this).val()).val();

		data += oTable.$("#hiddenProductId" + i).val() + ";" + oTable.$("#tdBrand" + i).html() + ";" + oTable.$("#tdKode" + i).html() + ";" + oTable.$("#tdPrice" + i).html() + ";" + oTable.$("#tdKodeHarga" + i).html() + ";";
	});
	
	sessionStorage.setItem('data', data);
	sessionStorage.setItem('company_name', company_name);
	NewWindow('include/draft_barcode2b.php','name','640','550','yes');
}

function checkAll(value)
{
	var oTable = $("#example").dataTable();
	var totalRows_data = $('#totalRows_data').val();
	
	if(value)
	{
		for (i=0; i<totalRows_data; i++)
		{
			oTable.$("#data" + i).prop("checked","checked");
		}
	}
	else
	{
		for (i=0; i<totalRows_data; i++)
		{
			oTable.$("#data" + i).prop("checked","");
		}
	}
	
	countChecked();
}

function countChecked()
{
	var oTable = $("#example").dataTable();
	$("#totalChecked").html("(" + oTable.$('input:checked').size() + ")");
}

$(document).ready(function()
{	
	var table = $("#example").DataTable(
	{
		dom: 'T<"clear">lfrtip',
		tableTools:
		{
			"sSwfPath": "media/swf/copy_csv_xls_pdf.swf"
		},
		"footerCallback": function ( row, data, start, end, display )
		{
			var api = this.api(), data;
 
			// Remove the formatting to get integer data for summation
			var intVal = function ( i ) {
				return typeof i === 'string' ?
					i.replace(/[\$,]/g, '')*1 :
					typeof i === 'number' ?
						i : 0;
			};
 
			// Total over all pages
			total = api
				.column( 6 )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				} );
 
			// Total over this page
			pageTotal = api
				.column( 6, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0 );
 
			// Update footer
			$( api.column( 6 ).footer() ).html( pageTotal + ' of ' + total );
		}
	});
	
	// Setup - add a text input to each footer cell
	$('#example tfoot th').each( function ()
	{
		var title = $('#example tfoot th').eq( $(this).index() ).text();
		title = $.trim(title);
		if (title != "" && $(this).index() != 6)
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

	table.$('input:checkbox').click(function()
	{
		countChecked();
	});
});
	