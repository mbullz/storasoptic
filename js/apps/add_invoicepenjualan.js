
function refreshCustomer(keyword) {
	$.ajax({
		url: 'component/masterkontak/task/ajax_masterkontak.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=get_customer&q=' + keyword,
		success: function(result) {
			var html = '';
			for (i=0; i<result.length; i++) {
				html += "<option value='" + result[i].user_id + "'>" + result[i].kontak + "</option>";
			}
			$("#customer").html(html);
		}
	});
}

function getDetailBarang(product_id)
{
	$.ajax({
		url: 'component/masterbarang/task/ajax_masterbarang.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=get_detail&product_id=' + product_id,
		success: function(result)
		{
			if (result.length > 0) {
				$("#frame").html(result[0].frame);
				$("#hsatuan").val(result[0].price2);
			} else {
				$("#frame").html("");
				$("#hsatuan").val("0");
			}
			
			$("#qty").val("0");
		}
	});
}

function refreshTipe() {
	var tipe = $("#tipe").val();
	
	switch (tipe)
	{
		case "1":
			$(".tableDetail1").show();
			$("#divLensa").hide();
			$("#divDetailFrame").show();
			$("#divDetailSoftlens").hide();
		break;
		
		case "2":
			$(".tableDetail1").show();
			$("#divLensa").hide();
			$("#divDetailFrame").hide();
			$("#divDetailSoftlens").show();
		break;
		
		case "3":
			$(".tableDetail1").hide();
			$("#divLensa").show();
			$("#divDetailFrame").hide();
			$("#divDetailSoftlens").hide();
		break;
		
		case "4":
			$(".tableDetail1").show();
			$("#divLensa").hide();
			$("#divDetailFrame").hide();
			$("#divDetailSoftlens").hide();
		break;

		case "5":
			$(".tableDetail1").show();
			$("#divLensa").show();
			$("#divDetailFrame").show();
			$("#divDetailSoftlens").hide();
		break
	}
	
	tipe = (tipe=="5")?"1":tipe;
	
	$.ajax({
		url: 'component/invoicepenjualan/task/ajax_invoicepenjualan.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=get_brand&tipe=' + tipe,
		success: function(result)
		{
			var html = '<option value="">-- Search Brand --</option>';
			for (i=0;i<result.length;i++)
			{
				html += '<option value="' + result[i].brand_id + '">';
				html += result[i].jenis;
				html += '</option>';
			}
			$("#qbrg").html(html);
		}
	});
}

function refreshBarang() {
	var tipe = $("#tipe").val();
	var search = $('#qbrg').val();

	tipe = (tipe == '5') ? '1' : tipe;

	$.ajax({
		url: 'component/invoicepenjualan/task/ajax_invoicepenjualan.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=get_barang&tipe=' + tipe + '&search=' + search,
		success: function(result)
		{
			var html = '<option value="">-- Choose Product --</option>';
			for (i=0; i<result.length; i++) {
				html += '<option value="' + result[i].product_id + '">';
				if (result [i].kode != '') html += result[i].kode + ' # ';
				html += result[i].type_brand + ' # ' + result[i].barang + ' # ' + result[i].color;
				html += '</option>';
			}
			$("#barang").html(html);
		}
	});
}

function setTipePembayaran(val) {
	if (val == 1) { //cash
		$("#jtempo").attr('disabled', 'disabled');
		//$("#uangMuka").attr('disabled', 'disabled');
	} else if (val == 2) { //jtempo
		$("#jtempo").removeAttr('disabled');
		//$("#uangMuka").removeAttr('disabled');
	}
}

function barangBaru(value)
{
	if (value == true)
	{
		$(".tableDetail1").hide();
		$("#frame").val("");
		$(".tableDetail2").show(1000);
	}
	else
	{
		$(".tableDetail2").hide();
		$(".tableDetail1").show(1000);
	}
}

$(document).ready(function() {

	$().ajaxStart(function() {
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function() {
		$('#loading').hide();
		$('#result').fadeIn('slow');
	});

	$('#result').click(function() {
		$(this).hide();
	});

})

$(function() {
	$('#hsatuan').number(true, 0);
	$('#subtotal').number(true, 0);
	$('#hargaLensa').number(true, 0);
	$('#uangMuka').number(true, 0);
});
	
function printInvoice() {
	var keluarbarang_id = $('#keluarbarang_id').val();
	NewWindow('include/draft_invoice_1.php?keluarbarang_id=' + keluarbarang_id,'name','720','520','yes');
}

function printKwitansi()
{
	var keluarbarang_id = $('#keluarbarang_id').val();
	NewWindow('include/draft_kwitansi.php?keluarbarang_id=' + keluarbarang_id,'name','720','520','yes');
}

function calculate_subtotal()
{
	var subtotal, diskon;
	
	subtotal = $("#qty2").val() * $("#hsatuan2").val();
	
	if ( $("#tdiskon2").val() == 1) diskon = ($("#diskon2").val()/100)*subtotal;
	else diskon = $("#diskon2").val();
	
	subtotal -= diskon;
	
	$("#subtotal2").val(subtotal);
}

function calculate_subtotal2()
{
	var subtotal, diskon;
	
	subtotal = $("#qty").val() * $("#hsatuan").val();
	
	if ( $("#tdiskon").val() == 1) diskon = ($("#diskon").val()/100)*subtotal;
	else diskon = $("#diskon").val();
	
	subtotal -= diskon;
	
	$("#subtotal").val(subtotal);
}

function formSubmit(e)
{
	if ( $("#customer").val() == "" )
	{
		alert("Customer harus dipilih");
	}
	else if ( $(".datatable tr").length <= 29 )
	{
		alert("Barang harus dimasukkan ke dalam keranjang (* Add to Cart)");
	}
	/*
	else if ($("#uangMuka").val() == '0')
	{
		alert("Jumlah Bayar/DP harus diisi");
	}
	*/
	else
	{
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: $('#add').attr('action'),
			data: $('#add').serialize(),
			success: function(data) {
				//$('#result').html(data);
				alert(data.status);
			}
		})
	}
}

function addItem()
{
	if ( $("#newitem").val() == "" )
	{
	}
	else
	{
		$("#newitem").after("&nbsp;<img src='images/loading.gif' />");
		$.ajax(
		{
			url: 'ajaxdata/add_item.php',
			type: 'POST',
			data: 'category=' + $("#hiddenType").val() + '&item=' + $("#newitem").val() + '&tipe=' + $("#tipe").val(),
			error: function(e)
			{
				alert(e.responseText);
			},
			success: function(response)
			{
				if ( $("#hiddenType").val() == "frame" )
				{
					$("#frame2").append("<option value='" + response + "'>" + response + "</option>");
					$("#frame2 option[value='" + response + "']").prop("selected","selected");
				}
				else if ( $("#hiddenType").val() == "brand" )
				{
					$("#brand2").append("<option value='" + response + "'>" + $("#newitem").val() + "</option>");
					$("#brand2 option[value='" + response + "']").prop("selected","selected");
				}
				else
				{
					$("#warna2").append("<option value='" + response + "'>" + response + "</option>");
					$("#warna2 option[value='" + response + "']").prop("selected","selected");
				}
				
				$("#dialog").dialog("close");
			}
		});
	}
}

function onLoad()
{
	$("#satuan option[value='1']").prop("selected","selected");
	
	$('.divSpecialOrderLensa').hide();
	$('.divSpecialOrderSoftlens').hide();
	
	$("#jenisLensa").autocomplete(
	{
		source: lensa
	});
	
	$("#brandLensa").autocomplete(
	{
		source: brand
	});
	
	$("#tipeLensa").autocomplete(
	{
		source: tipe
	});
	
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
			"Add": function()
			{
				addItem();
			}
		}
	});
}

function newItem(type)
{
	if (type == "frame")
	{
		var html = '<br>Frame<br>' +
		'<input type="text" id="newitem" size="30" onkeypress="javascript:if(event.keyCode == 13) addItem();">' +
		'<input type="hidden" id="hiddenType" value="' + type + '">';
		
		$("#dialog").dialog("option","title","New Frame");
		$("#dialog").html(html);
	}
	else if (type == "brand")
	{
		var html = '<br>Brand<br>' +
		'<input type="text" id="newitem" size="30" onkeypress="javascript:if(event.keyCode == 13) addItem();">' +
		'<input type="hidden" id="hiddenType" value="' + type + '">';
		
		$("#dialog").dialog("option","title","New Brand");
		$("#dialog").html(html);
	}
	else
	{
		var html = '<br>Color<br>' +
		'<input type="text" id="newitem" size="30" onkeypress="javascript:if(event.keyCode == 13) addItem();">' +
		'<input type="hidden" id="hiddenType" value="' + type + '">';
	
		$("#dialog").dialog("option","title","New Color");
		$("#dialog").html(html);
	}
	
	$("#dialog").dialog("open");
}

function manageInvoiceJual(t, v)
{
	var tsk = t;
	var xid = v;
	
	var tipe = $("#tipe").val();
	
	var keluarbarang_id = $('#keluarbarang_id').val();
	var ref = $("#invoice").val();
	var bar = $("#barang").val();
	var qty = $("#qty").val();
	var sat = $("#satuan").val();
	var hsa = $("#hsatuan").val();
	var tdi = $("#tdiskon").val();
	var dis = $("#diskon").val();
	var xsu = $("#subtotal").val();
	
	var sosoftlens = $("#checkSOLensa").is(":checked")==true?'1':'0';
	var soinfo = $("#textSOSoftlens").val();
	
	var rSph = $("#rSph").val();
	var rCyl = $("#rCyl").val();
	var rAxis = $("#rAxis").val();
	var rAdd = $("#rAdd").val();
	var rPd = $("#rPd").val();
			
	var lSph = $("#lSph").val();
	var lCyl = $("#lCyl").val();
	var lAxis = $("#lAxis").val();
	var lAdd = $("#lAdd").val();
	var lPd = $("#lPd").val();
	
	var brandLensa = $("#brandLensa").val();
	var hargaLensa = $("#hargaLensa").val();
	var tipeLensa = $("#tipeLensa").val();
	var jenisLensa = $("#jenisLensa").val();
	var supplierLensa = $("#supplierLensa").val();
	var infoLensa = $("#infoLensa").val();
	var solensa = $("#checkSOLensa").is(":checked")==true?'1':'0';
		
	var queryString = "task=" + tsk + 
				"&rid=" + xid + 
				"&tipe=" + tipe + 
				"&keluarbarang_id=" + keluarbarang_id + 
				"&ref=" + ref + 
				"&brg=" + bar + 
				"&qty=" + qty + 
				"&sat=" + sat + 
				"&hsat=" + hsa + 
				"&subtot=" + xsu + 
				"&tdisc=" + tdi + 
				"&disc=" + dis + 
				"&sosoftlens=" + sosoftlens + 
				"&soinfo=" + soinfo + 
				"&rSph=" + (rSph*100) +
				"&rCyl=" + (rCyl*100) +
				"&rAxis=" + (rAxis*100) +
				"&rAdd=" + (rAdd*100) +
				"&rPd=" + rPd +
				"&lSph=" + (lSph*100) +
				"&lCyl=" + (lCyl*100) +
				"&lAxis=" + (lAxis*100) +
				"&lAdd=" + (lAdd*100) +
				"&lPd=" + lPd + 
				"&brandLensa=" + brandLensa +
				"&hargaLensa=" + hargaLensa +
				"&tipeLensa=" + tipeLensa +
				"&jenisLensa=" + jenisLensa +
				"&supplierLensa=" + supplierLensa +
				"&infoLensa=" + infoLensa +
				"&solensa=" + solensa;

	$.ajax(
	{
		url: 'ajaxdata/manage_invoicejual.php',
		type: 'GET',
		data: queryString,
		success: function(result)
		{
			$("#divManageInvoice").html(result);
		},
		complete: function() {
			//resetField();
		},
	});
}

function specialOrderLensa()
{
	if ( $("#checkSOLensa").is(":checked") == true)
	{
		$(".divSpecialOrderLensa").show();
	}
	else
	{
		$(".divSpecialOrderLensa").hide();
	}
}

function specialOrderSoftlens()
{
	if ( $("#checkSOSoftlens").is(":checked") == true)
	{
		$(".divSpecialOrderSoftlens").show();
	}
	else
	{
		$(".divSpecialOrderSoftlens").hide();
	}
}

function resetField()
{
	$('#qbrg').val('');
	refreshBarang();

	$('#barang option').eq(0).prop('selected', true);
	$('#qty').val('0');
	$('#hsatuan').val('0');
	$('#diskon').val('0');
	$('#subtotal').val('0');

	$('#hargaLensa').val('0');
	$('#brandLensa').val('');
}
