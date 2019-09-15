<?php include('include/define.php'); ?>

<script type="text/javascript">
function refreshJenis()
{
    var tipe = $("#tipe2").val();
    $.ajax({
        url: 'component/masterbarang/task/ajax_masterbarang.php',
        type: 'GET',
        dataType: 'json',
        data: 'mode=get_jenis&tipe=' + tipe,
        success: function(result) {
            var html = '<option value="0">-- Choose Brand --</option>';
            for (i=0; i<result.length; i++) {
                html += '<option value="' + result[i].brand_id + '">' + result[i].jenis + '</option>';
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
		//var frame = $("#frame1").val();
		var frame = '%';
        NewWindow('component/report_masterbarang/task/report_masterbarang.php?mode=general_report&tipe=' + tipe + '&frame=' + frame,'name','900','600','yes');
    }
	else if ($("#report2").prop('checked'))
	{
        if ($("#jenis").val() <= 0) {
            alert('Pilih jenis !!!');
        } else {
            var tipe = $("#tipe2").val();
            var brand_id = $("#jenis").val();
            NewWindow('component/report_masterbarang/task/report_masterbarang.php?mode=brand_report&tipe=' + tipe + '&brand_id=' + brand_id,'name','900','600','yes');
        }
    }
	else if ($("#report3").prop('checked'))
	{
        var tipe = $("#tipe3").val();
		var periode1 = $("#textPeriode1").val();
		var periode2 = $("#textPeriode2").val();
        NewWindow('component/report_masterbarang/task/report_masterbarang.php?mode=old_stock_report&tipe=' + tipe + '&periode1=' + periode1 + '&periode2=' + periode2,'name','900','600','yes');
    }
	else if ($("#report4").prop('checked'))
	{
        var tipe = $("#tipe4").val();
		var harga1 = $("#textHarga1").val();
		var harga2 = $("#textHarga2").val();
        NewWindow('component/report_masterbarang/task/report_masterbarang.php?mode=price_report&tipe=' + tipe + '&harga1=' + harga1 + '&harga2=' + harga2,'name','900','600','yes');
    }
	else if ($("#report5").prop('checked'))
	{
        var tipe = $("#tipe5").val();
		var supplier = $("#supplier").val();
        NewWindow('component/report_masterbarang/task/report_masterbarang.php?mode=supplier_report&tipe=' + tipe + '&supplier=' + supplier,'name','900','600','yes');
    }
	else if ($("#report6").prop('checked'))
	{
        var tipe = $("#tipe6").val();
		var periode1 = $("#textPeriode61").val();
		var periode2 = $("#textPeriode62").val();
        NewWindow('component/report_masterbarang/task/report_masterbarang.php?mode=import_report&tipe=' + tipe + '&periode1=' + periode1 + '&periode2=' + periode2,'name','900','600','yes');
    }
    else if ($("#report7").prop('checked'))
    {
        var periode1 = $("#textPeriode71").val();
        var periode2 = $("#textPeriode72").val();
        NewWindow('component/report_masterbarang/task/report_masterbarang.php?mode=laporan_umum_cabang&periode1=' + periode1 + '&periode2=' + periode2,'name','900','600','yes');
    }
    else if ($("#report8").prop('checked'))
    {
        if ($("#cabang").val() <= 0)
        {
            alert('Pilih Cabang !!!');
        }
        else
        {
            var user_id = $("#cabang").val();
            var periode1 = $("#textPeriode81").val();
            var periode2 = $("#textPeriode82").val();
            NewWindow('component/report_masterbarang/task/report_masterbarang.php?mode=laporan_detail_cabang&user_id=' + user_id + '&periode1=' + periode1 + '&periode2=' + periode2,'name','900','600','yes');
        }
    }
	else
	{
        alert('Pilih tipe laporan !!!');
    }
}

$(function()
{
	refreshJenis();
});
</script>

<br />
<hr size="1" color="#FF0000" />
<br />

<div style="border:solid 1px #999999;padding:15px;background-color:#FFD">
Cetak Laporan:<br>
<label><input type="radio" name="laporan" id="report1" />Laporan Stok Barang</label>&nbsp;&nbsp;
<select id="tipe1">
	<option value="1">Frame</option>
    <option value="2">Softlens</option>
    <option value="4">Accessories</option>
</select>

<br>

<label><input type="radio" name="laporan" id="report2" />Laporan Per Brand</label>&nbsp;&nbsp;
<select id="tipe2" onchange="refreshJenis();">
  <option value="1">Frame</option>
  <option value="2">Softlens</option>
  <option value="4">Accessories</option>
</select>
<select id="jenis">
</select><br>

<label><input type="radio" name="laporan" id="report3" />Laporan Stok Barang Lama</label>&nbsp;&nbsp;
<select id="tipe3">
  <option value="1">Frame</option>
  <option value="2">Softlens</option>
  <option value="4">Accessories</option>
</select>
<label>Periode </label>
<input type="text" class="calendar" id="textPeriode1" name="textPeriode1" />
<label>-</label>
<input type="text" class="calendar" id="textPeriode2" name="textPeriode2" />
<br>

<label><input type="radio" name="laporan" id="report4" />Laporan Per Harga Modal</label>&nbsp;&nbsp;
<select id="tipe4">
    <option value="1">Frame</option>
	<option value="2">Softlens</option>
  	<option value="4">Accessories</option>
</select>
<label>Harga </label>
<input type="text" id="textHarga1" name="textHarga1" />
<label>-</label>
<input type="text" id="textHarga2" name="textHarga2" />
<br>

<label><input type="radio" name="laporan" id="report5" />Laporan Per Supplier</label>&nbsp;&nbsp;
<select id="tipe5">
    <option value="1">Frame</option>
    <option value="2">Softlens</option>
  	<option value="4">Accessories</option>
</select>
<label>
    Supplier :
</label>
<select id="supplier">
    <option value="">All</option>
</select>
<br>

<label><input type="radio" name="laporan" id="report7" />Laporan Cabang</label>
<label>Periode </label>
<input type="text" class="calendar" id="textPeriode71" />
<label>-</label>
<input type="text" class="calendar" id="textPeriode72" />
<br>

<label><input type="radio" name="laporan" id="report8" />Laporan Detail Cabang</label>
<select id="cabang">
    <option value="0">-- Choose Cabang --</option>
</select>
<label>Periode </label>
<input type="text" class="calendar" id="textPeriode81" />
<label>-</label>
<input type="text" class="calendar" id="textPeriode82" />
<br>

<label><input type="radio" name="laporan" id="report9" />Laporan Aktivitas Barang</label>
<select id="tipe9">
    <option value="0">All</option>
   	<option value="1">Masuk</option>
    <option value="2">Keluar</option>
</select>
<label>Periode </label>
<input type="text" class="calendar" id="textPeriode91" />
<label>-</label>
<input type="text" class="calendar" id="textPeriode92" />
<br>

<input type="button" value="Tampilkan Laporan" onclick="generateReport();" />
</div>