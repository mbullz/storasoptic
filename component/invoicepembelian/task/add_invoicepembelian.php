<?php include('include/define.php');?>
<?php
// get supplier
$query_jkontak = "select a.kontak, a.kode, b.jenis from kontak a, jeniskontak b where a.jenis = b.kode AND b.klasifikasi ='supplier' AND a.aktif='1' order by b.jenis, a.kontak";
$jkontak       = $mysqli->query($query_jkontak);
$row_jkontak   = mysqli_fetch_assoc($jkontak);
$total_jkontak = mysqli_num_rows($jkontak);
// get mata uang
$query_muang   = "select kode, matauang from matauang order by matauang";
$muang         = $mysqli->query($query_muang);
$row_muang     = mysqli_fetch_assoc($muang);
$total_muang   = mysqli_num_rows($muang);
// get masterbarang
$query_mbarang = "select a.product_id, a.kode, a.barang, b.jenis, a.color from barang a, jenisbarang b where a.brand_id = b.brand_id order by b.jenis, a.barang";
$mbarang       = $mysqli->query($query_mbarang);
$row_mbarang   = mysqli_fetch_assoc($mbarang);
$total_mbarang = mysqli_num_rows($mbarang);
// getsatuan
$query_satuan = "select satuan_id,satuan from satuan order by satuan";
$satuan       = $mysqli->query($query_satuan);
$row_satuan   = mysqli_fetch_assoc($satuan);
$total_satuan = mysqli_num_rows($satuan);
?>

<script type="text/javascript" language="javascript">

function refreshSupplier(keyword) {
    $.ajax({
        url: 'component/masterkontak/task/ajax_masterkontak.php',
        type: 'GET',
        dataType: 'json',
        data: 'mode=get_supplier&q=' + keyword,
        success: function(result) {
            var html = '<option value="">-- Choose Supplier --</option>';
            for (i=0; i<result.length; i++) {
                html += "<option value='" + result[i].kode + "'>" + result[i].kontak + "</option>";
            }
            $("#supplier").html(html);
        }
    });
}

function setTipePembayaran(val)
{
    if (val == 1) //cash
	{ 
        $("#jtempo").attr('disabled', 'disabled');
		$("#uangMuka").attr('disabled', 'disabled');
    }
	else if (val == 2) //jtempo
	{
        $("#jtempo").removeAttr('disabled');
		$("#uangMuka").removeAttr('disabled');
    }
}

function barangBaru(value)
{
	if (value == true)
	{
		$("#tableDetail1").hide();
		$("#tableDetail2").show(1000,"swing");
	}
	else
	{
		$("#tableDetail2").hide();
		$("#tableDetail1").show(1000,"swing");
	}
}

function formSubmit()
{
	if ( $("#supplier").val() == "" )
	{
		alert("Supplier harus dipilih");
	}
	else if ( $(".datatable tr").length <= 8 )
	{
		alert("Detail Transaksi harus diisi");
	}
	else
	{
		$("#add").submit();
	}
}

function onLoad()
{
	$("#satuan option[value='1']").prop("selected","selected");
	
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

/*
$(document).ready(function()
{
	$().ajaxStart(function() {
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function() {
		$('#loading').hide();
		$('#result').fadeIn('slow');
	});

	$('#add').submit(function() {
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
  
	$('#result').click(function()
	{
		$(this).hide();
	});
});
*/

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
</script>
<style type="text/css">
#result{ 
	background-color: #F0FFED;
	border: 1px solid #215800;
	padding: 10px;
	width: 400px;
	margin-bottom: 20px;
	position:absolute;
	z-index:4;
	margin-left:30%;
}
a.close {
	float:right;
}
table, input, textarea, button {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
}
table ul {
	padding:0;
	margin:0;
}
table ul li {
	padding-left:20px;
	list-style:none;	
}
</style>
<link type="text/css" rel="stylesheet" href="css/jquery.wysiwyg.css" />
<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<h1>Pembelian Baru</h1>
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="add" id="add">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">No. PO *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="middle"><label>
        <input name="invoice" type="text" id="invoice" value="PO-<?php echo date("His");?>" size="10" maxlength="10">
      </label>
        <label>
          <select name="matauang" id="matauang">
            <option value="">Pilih Mata Uang</option>
            <?php if($total_muang > 0) { do { ?>
            <option value="<?php echo $row_muang['kode'];?>" <?php if($row_muang['kode']=='IDR') { ?>selected="selected"<?php } ?>><?php echo $row_muang['matauang'];?></option>
            <?php }while($row_muang = mysqli_fetch_assoc($muang)); } ?>
          </select>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top">Tanggal *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="tgl" type="text" class="calendar" id="tgl" value="<?php echo date("Y-m-d");?>" size="10" maxlength="10"/>
      </label></td>
    </tr>
    <tr>
        <td align="right" valign="top">Pembayaran *</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <select id="tipePembayaran" name="tipePembayaran" onchange="setTipePembayaran(this.value);">
                <option value="1">Cash</option>
                <option value="2">Jatuh Tempo</option>
            </select>
            <label>
                <input name="jtempo" type="text" class="calendar" id="jtempo" value="<?php echo date("Y-m-d");?>" size="10" maxlength="10" disabled="disabled" />
            </label>
        </td>
    </tr>
    <tr>
      <td align="right" valign="top">Supplier *</td>
      <td align="center" valign="top">:</td>
      <td valign="top">
          <input type="text" placeholder="Cari Supplier" maxlength="15" size="15" onchange="refreshSupplier(this.value);" />
          <label>
        <select name="supplier" id="supplier">
        </select>
      </label></td>
    </tr>
    <tr valign="top">
      <td align="right">Detail Transaksi *</td>
      <td align="center">:</td>
      <td>
      <div id="divManageInvoice">
<table width="100%" border="0" cellspacing="0" cellpadding="2" class="datatable">
        <tr>
          <th>Nama Barang</th>
          <th width="6%">Qty</th>
          <th width="10%">Satuan</th>
          <th width="10%">Price List</th>
          <th width="14%">Pot. Diskon</th>
          <th width="10%">Sub Total</th>
          <th width="8%">Pengaturan</th>
        </tr>
        <tr valign="top">
          <td>
          	<input type="checkbox" id="checkBarangBaru" onchange="barangBaru(this.checked)" />Barang Baru
            <br />
            <div id="tableDetail1">
          <label>
            <select name="qbrg" id="qbrg" onchange="getMasterBarang(this.value, 1)">
            	<option value="">-- Search Brand --</option>
                <?php
					$rs2 = $mysqli->query("SELECT * FROM jenisbarang WHERE tipe = 1 ORDER BY jenis ASC");
					while ($data2 = mysqli_fetch_assoc($rs2))
					{
						?>
                        	<option value="<?=$data2['brand_id']?>"><?=$data2['jenis']?></option>
                    	<?php
					}
				?>
            </select>
          </label>
            <label id="divMBarang">
              <select name="barang" id="barang">
                <option value="">-- Choose Product --</option>
                <?php if($total_mbarang > 0) { do { ?>
                <option value="<?php echo $row_mbarang['product_id'];?>"><?php echo $row_mbarang['jenis'];?> - <?php echo $row_mbarang['barang'];?> - <?=$row_mbarang['color']?></option>
                <?php }while($row_mbarang = mysqli_fetch_assoc($mbarang)); } ?>
              </select>
            </label>
            </div>
            <div id="tableDetail2" style="display:none">
		<table cellspacing="0">
                	<tr>
                    	<td width="80px">
                        	Tipe
                        </td>
                        
                        <td width="20px">
                        	:
                        </td>
                        
                        <td>
							<select id="tipe2">
                    			<option value="1">FRAME</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                        	Frame
                        </td>
                        
                        <td>
                        	:
                        </td>
                        
                        <td>
                        	<select id="frame2" name="frame2">
                                <option>-- Choose Frame --</option>
                                <?php
                                    $rs3 = $mysqli->query("SELECT * FROM frame_type");
                                    while ($data3 = mysqli_fetch_assoc($rs3))
                                    {
                                        ?>
                                            <option value="<?=$data3['frame']?>"><?=$data3['frame']?></option>
                                        <?php
                                    }
                                ?>
                            </select><img src="images/plus2.png" height="20px" style="cursor:pointer;margin-left:10px;vertical-align:bottom" onclick="newItem('frame')" />
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                        	Brand
                        </td>
                        
                        <td>
                        	:
                        </td>
                        
                        <td>
                        	<select name="brand2" id="brand2">
                                <option>-- Choose Brand --</option>
                                <?php
                                    $rs2 = $mysqli->query("SELECT * FROM jenisbarang ORDER BY jenis ASC");
                                    while ($data2 = mysqli_fetch_assoc($rs2))
                                    {
                                        ?>
                                            <option value="<?=$data2['brand_id']?>"><?=$data2['jenis']?></option>
                                        <?php
                                    }
                                ?>
                            </select><img src="images/plus2.png" height="20px" style="cursor:pointer;margin-left:10px;vertical-align:bottom" onclick="newItem('brand')" />
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                        	Tipe Frame
                        </td>
                        
                        <td>
                        	:
                        </td>
                        
                        <td>
                        	<input type="text" name="barang2" id="barang2" />
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                        	Warna
                        </td>
                        
                        <td>
                        	:
                        </td>
                        
                        <td>
                        	<select id="warna2" name="warna2">
                                <option>-- Choose Color --</option>
                                <?php
                                    $rs3 = $mysqli->query("SELECT * FROM color_type ORDER BY color ASC");
                                    while ($data3 = mysqli_fetch_assoc($rs3))
                                    {
                                        ?>
                                            <option value="<?=$data3['color']?>"><?=$data3['color']?></option>
                                        <?php
                                    }
                                ?>
                            </select><img src="images/plus2.png" height="20px" style="cursor:pointer;margin-left:10px;vertical-align:bottom" onclick="newItem('color')" />
                        </td>
                    </tr>
                    
                    <tr>
                    	<td>
                        	Kode Harga
                        </td>
                        
                        <td>
                        	:
                        </td>
                        
                        <td>
                        	<input type="text" name="kode_harga2" id="kode_harga2" />
                        </td>
                    </tr>
                </table>
            </div>
            </td>
          <td align="center"><label>
            <input name="qty" type="text" id="qty" size="4" maxlength="8" value="0" onchange="javascript:if(this.value &gt; 0) { this.form.subtotal.value = this.value * this.form.hsatuan.value; }else{ this.value=0;}" onfocus="javascript:if(this.value == '0') this.value=''" onblur="javascript:if(this.value == '') this.value='0'" />
          </label></td>
          <td align="center"><label>
            <select name="satuan" id="satuan">
              <option value="">Pilih Satuan</option>
              <?php if($total_satuan > 0) { do { ?>
              <option value="<?php echo $row_satuan['satuan_id'];?>"><?php echo $row_satuan['satuan'];?></option>
              <?php }while($row_satuan = mysqli_fetch_assoc($satuan)); } ?>
            </select>
          </label></td>
          <td align="center"><label>
            <input name="hsatuan" type="text" id="hsatuan" size="10" maxlength="10" value="0" onchange="javascript:if(this.value &gt; 0) { this.form.subtotal.value = this.value * this.form.qty.value; }else{ this.value=0;}" onfocus="javascript:if(this.value == '0') this.value=''" onblur="javascript:if(this.value == '') this.value='0'" />
          </label></td>
          <td align="center"><label>
            <select name="tdiskon" id="tdiskon" style="font-size:9px;" onchange="javascript:if(this.form.tdiskon.value == 1) { this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - ((this.form.hsatuan.value * this.form.qty.value * this.form.diskon.value) / 100); }else{ this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - this.value; }">
              <option value="0">Normal</option>
              <option value="1">%</option>
            </select>
          </label>
            <label>
              <input name="diskon" type="text" id="diskon" size="8" maxlength="8" value="0" onchange="javascript:if(this.form.tdiskon.value == 1) { this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - ((this.form.hsatuan.value * this.form.qty.value * this.value) / 100); }else{ this.form.subtotal.value = (this.form.hsatuan.value * this.form.qty.value) - this.value; }" style="font-size:9px;" onfocus="javascript:if(this.value == '0') this.value=''" onblur="javascript:if(this.value == '') this.value='0'" />
            </label></td>
          <td align="center"><label>
            <input name="subtotal" type="text" id="subtotal" size="10" maxlength="10" value="0" onfocus="this.blur();" style="background:#DDD;border:solid 1px #BBB;"/>
          </label></td>
          <td width="10%" align="center"><a href="javascript:void(0);" onclick="manageInvoiceBeli('add','');"><img src="images/add.png" border="0" /> Tambah</a></td>
        </tr>
      </table>
      </div>
      </td>
    </tr>
    <tr valign="top">
      <td align="right">Info</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="info" id="info" rows="2" style="width:90%"></textarea>
      </label></td>
    </tr>
    <tr>
        <td align="right">Uang Muka</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="uangMuka" id="uangMuka" size="20" maxlength="20" />
        </td>
    </tr>
    <tr>
      <td><em>*diisi</em></td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="82%"><label>
        <input name="Save" type="button" id="Save" value="Simpan" onclick="formSubmit()">
      </label>
        <label>
        <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
      </label></td>
    </tr>
  </table>
</form>

<div id="dialog">
</div>

<script>
	refreshSupplier('');
	onLoad();
	setTipePembayaran(1);
</script>