
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

function refreshTipe() {
	var tipe = $("#tipe").val();
	
	switch (tipe)
	{
		case "1":
			$(".tableDetail1").show();
			$("#divLensa").hide();
			$("#divDetailFrame").show();
			$("#divDetailSoftlens").hide();
			$('#trDiskon').show();
		break;
		
		case "2":
			$(".tableDetail1").show();
			$("#divLensa").hide();
			$("#divDetailFrame").hide();
			$("#divDetailSoftlens").show();
			$('#trDiskon').show();
		break;
		
		case "3":
			$(".tableDetail1").hide();
			$("#divLensa").show();
			$("#divDetailFrame").hide();
			$("#divDetailSoftlens").hide();
			$('#trDiskon').hide();
		break;
		
		case "4":
			$(".tableDetail1").show();
			$("#divLensa").hide();
			$("#divDetailFrame").hide();
			$("#divDetailSoftlens").hide();
			$('#trDiskon').show();
		break;

		case "5":
			$(".tableDetail1").show();
			$("#divLensa").show();
			$("#divDetailFrame").show();
			$("#divDetailSoftlens").hide();
			$('#trDiskon').show();
		break
	}
	
	/*
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
	*/

	refreshBarang();

	// global discount
	if (tipe == '1' || tipe == '5') $('#diskon').val($('#global_discount').val());
	else if (tipe == '2') $('#diskon').val($('#global_discount_softlens').val());
	else if (tipe == '4') $('#diskon').val($('#global_discount_accessories').val());

	calculate_subtotal2();
}

function refreshBarang() {
	var tipe = $("#tipe").val();
	var search = $('#qbrg').val();
	var mode = 'get_barang';

	tipe = (tipe == '5') ? '1' : tipe;
	mode = (tipe == '2') ? 'get_softlens' : mode;

	$.ajax({
		url: 'component/invoicepenjualan/task/ajax_invoicepenjualan.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=' + mode + '&tipe=' + tipe + '&search=' + search,
		success: function(result)
		{
			var html = '<option value="">-- Choose Product --</option>';
			for (i=0; i<result.length; i++) {
				html += '<option value="' + result[i].product_id + '">';
				html += result[i].kode + ' # ' + result[i].type_brand + ' # ' + result[i].barang + ' # ' + result[i].color;
				html += '</option>';
			}
			$("#barang").html(html);
		}
	});
}

function getDetailBarang(product_id)
{
	var tipe = $("#tipe").val();
	if (tipe == '2') {
		getDetailSoftlens();
		return;
	}

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

function refreshLensa() {
	var search = $('#searchLensa').val();

	$.ajax({
		url: 'component/invoicepenjualan/task/ajax_invoicepenjualan.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=get_lensa&search=' + search,
		success: function(result)
		{
			var html = '<option value="">-- Pilih Lensa --</option>';
			for (i=0; i<result.length; i++) {
				var value = result[i].kode + ' # ' + result[i].jenis + ' # ' + result[i].barang;

				html += '<option value="' + value + '">';
				html += value;
				html += '</option>';
			}
			$("#lensa").html(html);
		}
	});
}

function getDetailLensa()
{
	var value = $('#lensa').val();
	value = value.split(' # ');
	var kode = value[0];
	var jenis = value[1];
	var barang = value[2];
	var rSph = $("#rSph").val();
	var rCyl = $("#rCyl").val();
	var rAdd = $("#rAdd").val();
	var lSph = $("#lSph").val();
	var lCyl = $("#lCyl").val();
	var lAdd = $("#lAdd").val();

	$.ajax({
		url: 'component/masterbarang/task/ajax_masterbarang.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=get_detail_lensa&kode=' + kode + '&jenis=' + jenis + '&barang=' + barang + '&rSph=' + rSph + '&rCyl=' + rCyl + '&rAdd=' + rAdd + '&lSph=' + lSph + '&lCyl=' + lCyl + '&lAdd=' + lAdd,
		success: function(result)
		{
			if (result.length > 0) {
				$("#labelStockLensaLeft").html('Stock : ' + result[0].qtyL);
				$("#labelStockLensaRight").html('Stock : ' + result[0].qtyR);
				$("#hargaLensa").val(result[0].price2);
				$('#lensa_product_id').val(result[0].product_id);
			}
			else {
				$("#labelStockLensaLeft").html('Stock : 0');
				$("#labelStockLensaRight").html('Stock : 0');
				$("#hargaLensa").val("0");
				$('#lensa_product_id').val('0');
			}
		},
		complete: function() {
			calculate_subtotal2();
		},
	});
}

function getDetailSoftlens()
{
	var value = $('#barang option:selected').text();
	value = value.split(' # ');
	var kode = value[0];
	var jenis = value[1];
	var barang = value[2];
	var color = value[3];
	var minus = $("#softlensMinus").val();

	$.ajax({
		url: 'component/masterbarang/task/ajax_masterbarang.php',
		type: 'GET',
		dataType: 'json',
		data: 'mode=get_detail_softlens&kode=' + kode + '&jenis=' + jenis + '&barang=' + barang + '&color=' + color + '&minus=' + minus,
		success: function(result)
		{
			if (result.length > 0) {
				$("#labelStockSoftlens").html('Stock : ' + result[0].qty);
				$("#hsatuan").val(result[0].price2);
				$('#softlens_product_id').val(result[0].product_id);
			}
			else {
				$("#labelStockSoftlens").html('Stock : 0');
				$("#hsatuan").val("0");
				$('#softlens_product_id').val('0');
			}
		},
		complete: function() {
			calculate_subtotal2();
		},
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
	$('#hargaLensaSO').number(true, 0);
	$('#uangMuka').number(true, 0);
	$('#grand_total').number(true, 0);

	if ($('#branch_id').val() == 0) {
		alert('Pilih cabang terlebih dahulu sebelum menambahkan data');
	}
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

function calculate_subtotal2()
{
	var subtotal = 0;
	var subtotal_lensa = 0;
	var diskon = 0;
	var diskon_lensa = 0;
	var total_promo = 0;
	var tipe = $('#tipe').val();

	if (tipe != '3') {
		subtotal = $("#qty").val() * $("#hsatuan").val();

		if ( $("#tdiskon").val() == 1) diskon = ($("#diskon").val()/100)*subtotal;
		else diskon = $("#diskon").val();

		subtotal -= diskon;

		if (tipe == '1') {
			var promo = parseInt($('#promo_frame').val());
			total_promo += parseInt($('#promo_frame').val());
			var promo_persen = $('#promo_persen_frame').val();
		}
		else if (tipe == '2') {
			var promo = parseInt($('#promo_softlens').val());
			total_promo += parseInt($('#promo_softlens').val());
			var promo_persen = $('#promo_persen_softlens').val();
		}
		else if (tipe == '4') {
			var promo = parseInt($('#promo_accessories').val());
			total_promo += parseInt($('#promo_accessories').val());
			var promo_persen = $('#promo_persen_accessories').val();
		}
		else if (tipe == '5') {
			var promo = parseInt($('#promo_frame').val());
			total_promo += parseInt($('#promo_frame').val());
			var promo_persen = $('#promo_persen_frame').val();
		}

		subtotal -= parseInt(promo);

		var promo_persen_list = promo_persen.split(",");
		promo_persen_list.forEach(function (item) {
			var promo = parseInt(parseInt(item)/100 * subtotal);
			total_promo += promo;
			subtotal -= promo;
		});
	}

	if (tipe == '3' || tipe == '5') {
		if ( $("#checkSOLensa").is(":checked") == true)
		{
			subtotal_lensa += ($("#hargaLensaSO").val() * 2);
		}
		else
		{
			subtotal_lensa += ($("#hargaLensa").val() * 2);

			if ( $("#tdiskonlensa").val() == 1) diskonlensa = ($("#diskonlensa").val()/100) * subtotal_lensa;
			else diskonlensa = $("#diskonlensa").val();

			subtotal_lensa -= diskonlensa;
		}

		var promo = parseInt($('#promo_lensa').val());
		total_promo += parseInt($('#promo_lensa').val());

		subtotal_lensa -= parseInt(promo);

		var promo_persen = $('#promo_persen_lensa').val();
		var promo_persen_list = promo_persen.split(",");
		promo_persen_list.forEach(function (item) {
			var promo = parseInt(parseInt(item)/100 * subtotal_lensa);
			total_promo += promo;
			subtotal_lensa -= promo;
		});
	}

	//potongan bpjs
	var bpjs_promo_discount = 0;
	if ($('#bpjs_promo_enabled').val() == '1') {
		bpjs_promo_discount = parseInt($('#bpjs_promo').val());
		total_promo += bpjs_promo_discount;
	}
	
	$('#promo').val(total_promo);
	$("#subtotal").val(parseInt(subtotal) + parseInt(subtotal_lensa) - parseInt(bpjs_promo_discount));
}

function calculate_grandtotal()
{
	var total, ppn;

	total = parseInt($('#total').val());
	ppn = $('#ppn').val();

	if (ppn == '') ppn = 0;

	ppn = parseInt(ppn);
	
	ppn = (ppn/100) * total;
	
	total += ppn;
	
	$("#grand_total").val(total);
}

function formSubmit(e)
{
	if ( $("#customer").val() == "" )
	{
		alert("Customer harus dipilih");
	}
	else if ( $('#cart_is_valid').val() == null || $('#cart_is_valid').val() == undefined || $('#cart_is_valid').val() == 0 )
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

function onLoad()
{
	$("#satuan option[value='1']").prop("selected","selected");
	
	$('.divSpecialOrderLensa').hide();
	$('.divSpecialOrderSoftlens').hide();
	
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
	var promo = $('#promo').val();
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
	
	var lensa_product_id = $('#lensa_product_id').val();
	var hargaLensa = $("#hargaLensa").val();
	var diskonLensa = $('#diskonlensa').val();
	var info = $("#detailInfo").val();

	var solensa = $("#checkSOLensa").is(":checked") == true ? '1' : '0';
	var hargaLensaSO = $("#hargaLensaSO").val();
	var infoLensaSO = $("#infoSOLensa").val();

	if (tipe == '2') bar = $('#softlens_product_id').val();
		
	var queryString = "task=" + tsk + 
				"&rid=" + xid + 
				"&tipe=" + tipe + 
				"&keluarbarang_id=" + keluarbarang_id + 
				"&ref=" + ref + 
				"&brg=" + bar + 
				"&qty=" + qty + 
				"&sat=" + sat + 
				"&hsat=" + hsa + 
				"&promo=" + promo + 
				"&subtot=" + xsu + 
				"&tdisc=" + tdi + 
				"&disc=" + dis + 
				"&sosoftlens=" + sosoftlens + 
				"&soinfo=" + soinfo + 
				
				"&rSph=" + rSph +
				"&rCyl=" + rCyl +
				"&rAxis=" + (rAxis*100) +
				"&rAdd=" + rAdd +
				"&rPd=" + rPd +
				
				"&lSph=" + lSph +
				"&lCyl=" + lCyl +
				"&lAxis=" + (lAxis*100) +
				"&lAdd=" + lAdd +
				"&lPd=" + lPd + 

				"&lensaProductId=" + lensa_product_id +
				"&hargaLensa=" + hargaLensa +
				"&diskonLensa=" + diskonLensa +
				"&info=" + info +
				"&solensa=" + solensa +
				"&hargaLensaSO=" + hargaLensaSO +
				"&infoLensaSO=" + infoLensaSO;

	$.ajax(
	{
		url: 'ajaxdata/manage_invoicejual.php',
		type: 'POST',
		data: queryString,
		success: function(result)
		{
			$("#divManageInvoice").html(result);
		},
		complete: function() {
			resetField();
			calculate_grandtotal();
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

	calculate_subtotal2();
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
	//$('#diskon').val('0');
	$('#promo').val('0');
	$('#subtotal').val('0');

	$('#hargaLensa').val('0');
	$('#hargaLensaSO').val('0');
	$('#searchLensa').val('');
	refreshLensa();
}
